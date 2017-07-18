<?php

/**
* 
*/
class DosenModel extends CI_Model
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
			$query = $this->db->get('dosen');
		}
		else
		{
			$this->db->select('*')->from('dosen');
			$this->db->where('deleted_at is Null');
			$this->db->like('nama', $name);

			$query = $this->db->get();
		}
		
		return $query->result();
	}

	/**
	 * @inherit doc
	 */
	public function read($id_dosen)
	{
		$this->db->select('*')->from('dosen');
		$this->db->where('deleted_at is Null');
		$this->db->where('id_dosen', $id_dosen);
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * @inherit doc
	 */
	public function edit($id_dosen, $dosenData)
	{
		$this->db->where('id_dosen', $id_dosen);
		return($this->db->update('dosen', $dosenData) ? TRUE : FALSE);
	}

	/**
	 * @inherit doc
	 */
	public function add($dosenData)
	{
		return ($this->db->insert('dosen', $dosenData) ? TRUE : FALSE);
	}

	/**
	 * @inherit doc
	 */
	public function delete($id_dosen)
	{
		$this->db->where('id_dosen', $id_dosen);
		return($this->db->update('dosen',array('deleted_at' => mdate('%Y-%m-%d', now()))) ? TRUE : FALSE);
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