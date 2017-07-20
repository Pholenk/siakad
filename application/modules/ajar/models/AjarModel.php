<?php

/**
* 
*/
class AjarModel extends CI_Model
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
			$this->db->select('ajar.id_ajar,ajar.id_dosen,dosen.nama as nama_dosen,ajar.id_matakuliah,matakuliah.nama as nama_matakuliah,ajar.kelas')
			->from('ajar');
			$this->db->join('dosen', 'ajar.id_dosen = dosen.id_dosen');
			$this->db->join('matakuliah', 'ajar.id_matakuliah = matakuliah.id_matakuliah');
			$query = $this->db->get();
		}
		else
		{
			$this->db->select('*')->from('ajar');
			$this->db->where('deleted_at is Null');
			$this->db->like('nama', $name);

			$query = $this->db->get();
		}
		
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
	public function edit($id_ajar, $ajarData)
	{
		$this->db->where('id_ajar', $id_ajar);
		return($this->db->update('ajar', $ajarData) ? TRUE : FALSE);
	}

	/**
	 * @inherit doc
	 */
	public function add($ajarData)
	{
		return ($this->db->insert('ajar', $ajarData) ? TRUE : FALSE);
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
		$this->db->where('deleted_at is Null');
		$query = $this->db->get_where($table, $data);
		$queryStats = ($query->num_rows() > 0 ? 1 : 0);
		return $queryStats;
		// return $query->num_rows();
	}
}