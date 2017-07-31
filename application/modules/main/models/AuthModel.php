<?php

/**
* 
*/
class AuthModel extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * @inherit doc
	 */
	public function login($username, $password)
	{
		$this->db->select('job')->from('users');
		$this->db->where(array('username'=>$username, 'password'=>$password));
		$query = $this->db->get();
		return $query->result();
	}

	public function browse_mahasiswa()
	{
		$query = $this->db->get('mahasiswa');
		return $query->result();
	}
}