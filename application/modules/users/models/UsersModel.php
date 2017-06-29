<?php

/**
* 
*/
class UsersModel extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function browse($job='')
	{
		if (empty($job))
		{
			$query = $this->db->get('users');
		}
		else
		{
			$this->db->select('*')->from('users');
			$this->db->where('users.job = '.$job);

			$query = $this->db->get();
		}
			return $query->result();
	}
}