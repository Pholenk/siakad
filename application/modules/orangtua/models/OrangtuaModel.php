<?php

/**
* 
*/
class OrangtuaModel extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * @inherit doc
	 */
	public function browse()
	{
		$this->db->select('orangtua.nama, orangtua.email, orangtua.telepon, mahasiswa.nama as mahasiswa')->from('orangtua');
		$this->db->join('mahasiswa','mahasiswa.nim = orangtua.nim');
		$query = $this->db->get();
		
		return $query->result();
	}

	/**
	 * @inherit doc
	 */
	public function read($nim)
	{
		$this->db->select('*')->from('orangtua');
		$this->db->where('nim', $nim);
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * @inherit doc
	 */
	public function edit($nim, $orangtuaData)
	{
		$this->db->where('nim', $nim);
		return($this->db->update('orangtua', $orangtuaData) ? TRUE : FALSE);
	}

	/**
	 * @inherit doc
	 */
	public function add($orangtuaData)
	{
		return ($this->db->insert('orangtua', $orangtuaData) ? TRUE : FALSE);
	}

	/**
	 * @inherit doc
	 */
	public function delete($nim)
	{
		return($this->db->delete('orangtua',array('nim'=> $nim)) ? TRUE : FALSE);
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
		// return $query->num_rows();
	}
}