<?php

/**
* 
*/
class MatakuliahModel extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * @inherit doc
	 */
	public function browse($name='')
	{
		if (empty($name))
		{
			$this->db->where('deleted_at is Null');
			$query = $this->db->get('matakuliah');
		}
		else
		{
			$this->db->select('*')->from('matakuliah');
			$this->db->where('deleted_at is Null');
			$this->db->like('nama', $name);

			$query = $this->db->get();
		}
		
		return $query->result();
	}

	/**
	 * @inherit doc
	 */
	public function read($id_matakuliah)
	{
		$this->db->select('*')->from('matakuliah');
		$this->db->where('deleted_at is Null');
		$this->db->where('id_matakuliah', $id_matakuliah);
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * @inherit doc
	 */
	public function edit($id_matakuliah, $matakuliahData)
	{
		$this->db->where('id_matakuliah', $id_matakuliah);
		return($this->db->update('matakuliah', $matakuliahData) ? TRUE : FALSE);
	}

	/**
	 * @inherit doc
	 */
	public function add($matakuliahData)
	{
		return ($this->db->insert('matakuliah', $matakuliahData) ? TRUE : FALSE);
	}

	/**
	 * @inherit doc
	 */
	public function delete($id_matakuliah)
	{
		$this->db->where('id_matakuliah', $id_matakuliah);
		return($this->db->update('matakuliah',array('deleted_at' => mdate('%Y-%m-%d', now()))) ? TRUE : FALSE);
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