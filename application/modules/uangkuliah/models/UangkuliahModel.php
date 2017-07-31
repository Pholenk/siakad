<?php

/**
* 
*/
class UangkuliahModel extends CI_Model
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
		$this->db->select('*')->from('uangkuliah');
		$this->db->where('uangkuliah.deleted_at is Null');
		$query = $this->db->get();
		
		return $query->result();
	}

	/**
	 * @inherit doc
	 */
	public function read($id_uangkuliah)
	{
		$this->db->select('*')->from('uangkuliah');
		$this->db->where('deleted_at is Null');
		$this->db->where('id_uangkuliah', $id_uangkuliah);
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * @inherit doc
	 */
	public function edit($id_uangkuliah, $uangkuliahData, $tenggatData)
	{
		$this->db->where('id_uangkuliah', $id_uangkuliah);
		return($this->db->update('uangkuliah', $uangkuliahData) ? TRUE : FALSE);
	}

	/**
	 * @inherit doc
	 */
	public function add($uangkuliahData)
	{
		return ($this->db->insert('uangkuliah', $uangkuliahData) ? TRUE : FALSE);
	}

	/**
	 * @inherit doc
	 */
	public function delete($id_uangkuliah)
	{
		$this->db->where('id_uangkuliah', $id_uangkuliah);
		return($this->db->update('uangkuliah',array('deleted_at' => mdate('%Y-%m-%d', now()))) ? TRUE : FALSE);
	}

	/**
	 * check the existence of data
	 * @param string table
	 * @param mixed data
	 * @return bool
	 */
	public function dataExists($table, $data)
	{
		$this->db->where('deleted_at is Null');
		$query = $this->db->get_where($table, $data);
		$queryStats = ($query->num_rows() > 0 ? 1 : 0);
		return $queryStats;
		// return $query->num_rows();
	}
}