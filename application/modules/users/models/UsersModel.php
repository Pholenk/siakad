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

	/**
	 * @inherit doc
	 */
	public function browse($name='')
	{
		if (empty($name))
		{
			$this->db->where("users.job != 'Mahasiswa'");
			$this->db->where("users.job != 'Dosen'");
			$query = $this->db->get('users');
		}
		else
		{
			$this->db->select('*')->from('users');
			$this->db->like('fullname', $name);

			$query = $this->db->get();
		}
		
		return $query->result();
	}

	/**
	 * @inherit doc
	 */
	public function read($username)
	{
		$this->db->select('*')->from('users');
		$this->db->where('username', $username);
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * @inherit doc
	 */
	public function edit($id, $userData)
	{
		$this->db->where('username', $id);
		return($this->db->update('users', $userData) ? TRUE : FALSE);
	}

	/**
	 * @inherit doc
	 */
	public function add($userData)
	{
		return ($this->db->insert('users', $userData) ? TRUE : FALSE);
	}

	/**
	 * @inherit doc
	 */
	public function delete($username)
	{
		return($this->db->delete('users',array('username' => $username)) ? TRUE : FALSE);
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