<?php

/**
* 
*/
class KhsModel extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * retrieve all data belongs to single jurusan and semester from mahasiswa table
	 * @param string jurusan 
	 * @param string semester
	 * @return mixed
	 */
	public function browse_mahasiswa($id_jurusan, $semester)
	{
		return $this->db->get_where('mahasiswa', array('id_jurusan' => $id_jurusan, 'semester' => $semester))->result();
	}

	/**
	 * retrieve all data jurusan from jurusan table
	 * @return mixed
	 */
	public function browse_jurusan()
	{
		return $this->db->get('jurusan')->result();
	}

	/**
	 * retrieve all data belongs to single nim from mahasiswa table
	 * @param string nim
	 * @return mixed
	 */
	public function selfData($nim)
	{
		$this->db->select('mahasiswa.nim, mahasiswa.id_jurusan, jurusan.nama as jurusan, mahasiswa.nama, mahasiswa.kelas, mahasiswa.semester')->from('mahasiswa');
		$this->db->join('jurusan', 'mahasiswa.id_jurusan = jurusan.id_jurusan');
		$this->db->where('mahasiswa.nim', $nim);
		$dataDiri = $this->db->get();
		return $dataDiri->result();
	}

	/**
	 * count all score belongs to a nim and an id_ajar from nilai_lain table
	 * @param string nim
	 * @param string id_ajar
	 * @return float nilai
	 */
	private function nilaiLain($nim,$id_ajar)
	{
		$nilai = 0;
		$this->db->select('sum(nilai_lain.nilai) as nilai')->from('nilai_lain');
		$this->db->where('nilai_lain.id_ajar',$id_ajar);
		$this->db->where('nilai_lain.nim',$nim);
		$nilai_lain = $this->db->get();
		foreach ($nilai_lain->result() as $hasil) {
			$nilai = $hasil->nilai;
		}
		return $nilai;
	}

	/**
	 * retrive max number of pengambilan from an id_ajar in nilai_lain table
	 * @param string id_ajar
	 * @return integer result
	 */
	private function maxPengambilan($id_ajar)
	{
		$result = 0;
		$this->db->select_max('nilai_lain.pengambilan')->from('nilai_lain');
		$this->db->where('nilai_lain.id_ajar', $id_ajar);
		$pengambilan = $this->db->get();
		foreach ($pengambilan->result() as $hasil) {
			$result = $hasil->pengambilan;
		}
		return $result;
	}

	/**
	 * count all score belongs to a nim and an id_ajar from nilai_uts table
	 * @param string nim
	 * @param string id_ajar
	 * @return float nilai
	 */
	private function nilaiUTS($nim,$id_ajar)
	{
		$nilai = 0;
		$this->db->select('nilai_uts.nilai')->from('nilai_uts');
		$this->db->where('nilai_uts.id_ajar',$id_ajar);
		$this->db->where('nilai_uts.nim',$nim);
		$nilai_uts = $this->db->get();
		foreach ($nilai_uts->result() as $hasil) {
			$nilai = $hasil->nilai;
		}
		return $nilai;
	}

	/**
	 * count all score belongs to a nim and an id_ajar from nilai_uas table
	 * @param string nim
	 * @param string id_ajar
	 * @return float nilai
	 */
	private function nilaiUAS($nim,$id_ajar)
	{
		$nilai = 0;
		$this->db->select('nilai_uas.nilai')->from('nilai_uas');
		$this->db->where('nilai_uas.id_ajar',$id_ajar);
		$this->db->where('nilai_uas.nim',$nim);
		$nilai_uas = $this->db->get();
		foreach ($nilai_uas->result() as $hasil) {
			$nilai = $hasil->nilai;
		}
		return $nilai;
	}

	/**
	 * retrieve all matakuliah on a semester from ajar table and matakuliah table
	 * @param string semester
	 * @return mixed
	 */
	public function data_matakuliah($semester, $kelas)
	{
		$this->db->select('ajar.id_ajar, matakuliah.id_matakuliah, matakuliah.nama, matakuliah.sks, matakuliah.semester')->from('ajar');
		$this->db->join('matakuliah', 'matakuliah.id_matakuliah = ajar.id_matakuliah');
		$this->db->where('matakuliah.semester', $semester);
		$this->db->like('ajar.kelas', $kelas);
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * count all data as total score for an id_ajar that belongs to a nim
	 * @param string nim
	 * @param string id_ajar
	 */
	public function nilai_matakuliah($nim, $id_ajar)
	{
		$lain = 0;

		if (!empty($this->nilaiLain($nim,$id_ajar)) || !empty($this->maxPengambilan($id_ajar)))
		{
			$lain = $this->nilaiLain($nim,$id_ajar) / $this->maxPengambilan($id_ajar);
		}
		
		$total_nilai = ($lain * 0.2) + ($this->nilaiUTS($nim,$id_ajar) * 0.4) + ($this->nilaiUAS($nim,$id_ajar) * 0.4);
		return $total_nilai;
	}

	/**
	 * convert total score become letter
	 * @param int nilai
	 * @return mixed
	 */
	public function konversi_nilai($nilai)
	{
		$hasilKonversi = array();
		
		if ($nilai > 79.90  && $nilai <= 100) {
			return array("A",4,"Sangat Istimewa");
		}
		else if ($nilai > 74.90 && $nilai <= 79.90) {
			return array("AB",3.5,"Istimewa");
		}
		else if ($nilai > 64.90 && $nilai <= 74.90) {
			return array("B",3,"Baik");
		}
		else if ($nilai > 59.90 && $nilai <= 64.90) {
			return array("BC",2.5,"Cukup Baik");
		}
		else if ($nilai > 49.90 && $nilai <= 59.90) {
			return array("C",2,"Cukup");
		}
		else if ($nilai > 39.90 && $nilai <= 49.90) {
			return array("D",1,"Kurang");
		}
		else{
			return array("E",0,"Gagal");
		}
	}
}