<?php

/**
* 
*/
class MahasiswaModel extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * @inherit doc
	 */
	public function browse($kelas='')
	{
		if (empty($kelas))
		{
			$this->db->where('deleted_at is Null');
			$query = $this->db->get('mahasiswa');
		}
		else
		{
			$this->db->select('*')->from('mahasiswa');
			$this->db->where('deleted_at is Null');
			$this->db->where('kelas', $kelas);

			$query = $this->db->get();
		}
		
		return $query->result();
	}

	/**
	 * @inherit doc
	 */
	public function read($nim)
	{
		$this->db->select('*')->from('mahasiswa');
		$this->db->where('mahasiswa.deleted_at is Null');
		$this->db->where('mahasiswa.nim', $nim);
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * @inherit doc
	 */
	public function edit($nim, $mahasiswaData)
	{
		$this->db->where('nim', $nim);
		return($this->db->update('mahasiswa', $mahasiswaData) ? TRUE : FALSE);
	}

	/**
	 * @inherit doc
	 */
	public function add($mahasiswaData)
	{
		return ($this->db->insert('mahasiswa', $mahasiswaData) ? TRUE : FALSE);
	}

	/**
	 * @inherit doc
	 */
	public function delete($nim)
	{
		$this->db->where('nim', $nim);
		return($this->db->update('mahasiswa',array('deleted_at' => mdate('%Y-%m-%d', now()))) ? TRUE : FALSE);
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