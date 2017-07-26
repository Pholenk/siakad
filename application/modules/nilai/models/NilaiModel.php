<?php

/**
* 
*/
class NilaiModel extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * @inherit doc
	 */
	public function browse($id_ajar, $table, $kelas, $option = '')
	{
		if ($table === 'nilai_lain') {
			$this->db->select($table.'.nim,'.$table.'.pengambilan,'.$table.'.nilai');
			$this->db->order_by($table.'.pengambilan','ASC');
			$this->db->from($table);
			$this->db->join('mahasiswa', 'mahasiswa.nim = '.$table.'.nim');
			$this->db->where('mahasiswa.kelas',$kelas);
			$this->db->where($table.'.id_ajar',$id_ajar);
			(empty($option) ? '' : $this->db->where($table.'.pengambilan',$option));
		}
		else {
			$this->db->select($table.'.nim,'.$table.'.nilai');
			$this->db->from($table);
			$this->db->join('mahasiswa', 'mahasiswa.nim = '.$table.'.nim');
			$this->db->where('mahasiswa.kelas',$kelas);
			$this->db->where($table.'.id_ajar',$id_ajar);
		}
		$query = $this->db->get();
		
		return $query->result();
	}

	/**
	 * @inherit doc
	 */
	public function read($id_ajar)
	{
		$this->db->select('*')->from('ajar');
		$this->db->where('id_ajar', $id_ajar);
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * @inherit doc
	 */
	public function edit($id_ajar, $nilaiData)
	{
		$this->db->where('id_ajar', $id_ajar);
		return($this->db->update('ajar', $nilaiData) ? TRUE : FALSE);
	}

	/**
	 * @inherit doc
	 */
	public function add($table, $nilaiData)
	{
		return ($this->db->insert($table, $nilaiData) ? TRUE : FALSE);
	}

	/**
	 * @inherit doc
	 */
	public function delete($id_ajar)
	{
		$this->db->where('id_ajar', $id_ajar);
		return($this->db->update('ajar',array('deleted_at' => mdate('%Y-%m-%d', now()))) ? TRUE : FALSE);
	}

	/**
	 * check the existence of data
	 * @param string table
	 * @param mixed data
	 * @return bool
	 */
	public function dataExists($table, $data)
	{
		$query = $this->db->get_where($table, $data);
		$queryStats = ($query->num_rows() > 0 ? 1 : 0);
		return $queryStats;
		// // return $query->num_rows();
	}

	/**
	 * retrieve value pengambilan from nilai_lain
	 * @param string kelas
	 * @return mixed pengambilan
	 */
	public function getPengambilan($id_ajar, $kelas)
	{
		$this->db->select('nilai_lain.pengambilan')->from('nilai_lain');
		$this->db->join('mahasiswa','nilai_lain.nim = mahasiswa.nim');
		$this->db->where('mahasiswa.kelas', $kelas);
		$this->db->where('nilai_lain.id_ajar', $id_ajar);
		$this->db->group_by('nilai_lain.pengambilan');
		$pengambilan = $this->db->get();
		return $pengambilan->result();
	}

	/**
	 * retrieve max value of pengambilan from nilai_lain
	 * @param string id_ajar
	 * @param string kelas
	 * @return int ambil
	 */
	public function maxPengambilan($id_ajar, $kelas)
	{
		$ambil = 0;
		$this->db->select_max('nilai_lain.pengambilan')->from('nilai_lain');
		$this->db->join('mahasiswa','nilai_lain.nim = mahasiswa.nim');
		$this->db->where('mahasiswa.kelas', $kelas);
		$this->db->where('nilai_lain.id_ajar', $id_ajar);
		$this->db->group_by('nilai_lain.pengambilan');
		$pengambilan = $this->db->get();
		foreach ($pengambilan->result() as $hasil){
			$ambil = $hasil->pengambilan;
		}
		return $ambil;
	}
}