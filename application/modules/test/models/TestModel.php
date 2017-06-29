<?php

/**
* 
*/
class TestModel extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function test($jenis='')
	{
		if (empty($jenis))
		{
			$query = $this->db->get('Relationship');
		}
		else
		{
			$this->db->select('id_mhs,ida,jenis,nilai')->from('Relationship');
			$this->db->where('Relationship.jenis = '.$jenis);

			$query = $this->db->get();
		}
			return $query->result();
	}
	public function browse_mahasiswa()
	{
		$query = $this->db->get('mahasiswa');
		return $query->result();
	}
}