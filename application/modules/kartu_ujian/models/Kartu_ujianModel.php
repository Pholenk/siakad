<?php

/**
* 
*/
class Kartu_ujianModel extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * retrieve all jurusan from presistence storage
	 * @return mixed
	 */
	public function browse_jurusan()
	{
		return $this->db->get('jurusan')->result();
	}

	/**
	 * retrieve all matakuliah from single jurusan and semester presistence storage
	 * @param string id_jurusan
	 * @param string semester
	 * @return mixed
	 */
	public function browse_matakuliah($id_jurusan, $semester)
	{
		$this->db->where('matakuliah.id_jurusan', $id_jurusan);
		$this->db->where('matakuliah.semester', $semester);
		return $this->db->get('matakuliah')->result();
	}

	/**
	 * retrieve all kelas in single jurusan and single semester
	 * @param string id_jurusan
	 * @param string semester
	 * @return mixed
	 */
	public function browse_kelas($id_jurusan, $semester)
	{
		$this->db->select('mahasiswa.kelas')->from('mahasiswa');
		$this->db->where('mahasiswa.id_jurusan', $id_jurusan);
		$this->db->where('mahasiswa.semester', $semester);
		$this->db->group_by('mahasiswa.kelas');
		return $this->db->get()->result();
	}

	/**
	 * retrieve group of mahasiswa divide by half total from single kelas and semester and jurusan
	 * @param string id_jurusan
	 * @param string semester
	 * @param string kelas
	 * @param string type
	 * @return mixed
	 */
	public function browse_mahasiswa($id_jurusan, $semester, $kelas, $type)
	{
		$limit = $this->_limiter($id_jurusan, $semester, $kelas);
		$this->db->select('mahasiswa.nim, mahasiswa.nama, mahasiswa.kelas, jurusan.nama as jurusan')->from('mahasiswa');
		$this->db->join('jurusan','mahasiswa.id_jurusan = jurusan.id_jurusan');
		$this->db->where('mahasiswa.id_jurusan', $id_jurusan);
		$this->db->where('mahasiswa.semester', $semester);
		$this->db->where('mahasiswa.kelas', $kelas);
		$this->db->order_by('mahasiswa.nim', $type);
		$this->db->limit($limit);
		return $this->db->get()->result();
	}

	/**
	 * count half total mahasiswa in single id_jurusan and semester and kelas
	 * @param string id_jurusan
	 * @param string semester
	 * @param string kelas
	 * @return int limiter
	 */
	function _limiter($id_jurusan, $semester, $kelas)
	{
		$total = $this->db->count_all('mahasiswa', array('id_jurusan' => $id_jurusan, 'semester' => $semester, 'kelas' => $kelas));
		$limiter = ($total > 0 ? $total / 2 : 0 );
		return intval($limiter);
	}

	/**
	 * retrieve total payment from single nim and semester
	 * @param string nim
	 * @param string type
	 * @param string semester
	 * @return int total
	 */
	private function _totalPayment($nim, $type, $semester = '')
	{
		$total = 0;
		if($type === 'uangkuliah'){
			$table = 'det_bayar_semester';
			$this->db->where($table.'.semester', $semester);
		}
		else{
			$table = 'det_bayar_spi';
		}
		$this->db->select_sum($table.'.nominal')->from($table);
		$this->db->join('pembayaran', $table.'.id_bayar = pembayaran.id_bayar');
		$this->db->join('mahasiswa', 'pembayaran.nim = mahasiswa.nim');
		$this->db->where('mahasiswa.nim',$nim);
		foreach ($this->db->get()->result() as $payment)
		{
			$total = $payment->nominal;
		}

		return $total;
	}

	/**
	 * retrieve total bill from single nim and type
	 * @param string nim
	 * @param string type
	 * @return int total
	 */
	private function _totalBill($nim, $type)
	{
		$total = 0;
		if($type === 'uangkuliah'){
			$table = 'uangkuliah';
			$this->db->select($table.'.nominal')->from($table);
			$this->db->join('mahasiswa', $table.'.id_uangkuliah = mahasiswa.id_uangkuliah');
		}
		else{
			$this->db->select('mahasiswa.spi as nominal')->from('mahasiswa');
		}
		$this->db->where('mahasiswa.nim',$nim);
		foreach ($this->db->get()->result() as $bill)
		{
			$total = $bill->nominal;
		}

		return $total;
	}

	/**
	 * grant or revoke decided from difference of payment and bill from single nim and semester in type
	 * @param string nim
	 * @param string type
	 * @param string semester
	 * @param string ujian
	 * @return bool total
	 */
	public function grant_cetak($nim, $type, $semester, $ujian)
	{
		$_access = false;
		$paymentUKT = $this->_totalPayment($nim, $type, $semester);
		$paymentSPI = $this->_totalPayment($nim, $type);

		if($ujian === 'TENGAH_SEMESTER')
		{
			$billUKT = $this->_totalBill($nim,$type) / 2;
			$billSPI = $this->_totalBill($nim,$type) / 2;
		}
		else
		{
			$billUKT = $this->_totalBill($nim,$type);
			$billSPI = $this->_totalBill($nim,$type);
		}

		if ($paymentUKT >= $billUKT && $paymentSPI >= $billSPI)
		{
			$_access = TRUE;
		}

		return $_access;
	}
}