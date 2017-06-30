<?php

/**
* 
*/
class JurusanModel extends CI_Model
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
			$query = $this->db->get('jurusan');
		}
		else
		{
			$this->db->select('*')->from('jurusan');
			$this->db->like('nama', $name);

			$query = $this->db->get();
		}
		
		return $query->result();
	}

	/**
	 * @inherit doc
	 */
	public function read($id_jurusan)
	{
		$this->db->select('*')->from('jurusan');
		$this->db->where('id_jurusan', $id_jurusan);
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * @inherit doc
	 */
	public function edit($id_jurusan, $jurusanData)
	{
		$this->db->where('id_jurusan', $id_jurusan);
		return($this->db->update('jurusan', $jurusanData) ? TRUE : FALSE);
	}

	/**
	 * @inherit doc
	 */
	public function add($jurusanData)
	{
		return ($this->db->insert('jurusan', $jurusanData) ? TRUE : FALSE);
	}

	/**
	 * @inherit doc
	 */
	public function delete($id_jurusan)
	{
		return($this->db->delete('jurusan',array('id_jurusan' => $id_jurusan)) ? TRUE : FALSE);
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