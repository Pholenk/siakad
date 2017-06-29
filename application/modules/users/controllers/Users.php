<?php

class Users extends MX_Controller
{
	// declared variable
	private $_access;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('UsersModel');
		$this->load->module('auth');
		$this->_access = $this->session->job;
	}

	public function index()
	{
		($this->_access === 'baak' ? $this->browse() : redirect(base_url()));
	}

	/**
	 * browse
	 */
	public function browse()
	{
		if ($this->_access === 'baak')
		{
			$data = array(
				'users' =>  $this->UsersModel->browse(),
			);
			$this->_show('browse', $data);
		}		
		else
		{
			echo "!LOGIN";
		}
		
	}

	/**
	 * read
	 */
	public function read($id)
	{
		if ($this->_access === 'baak')
		{
			$userData = $this->UsersModel->read($id);
		}
		else
		{
			echo "!LOGIN";
		}
		
	}

	/**
	 * edit
	 */
	public function edit($id)
	{
		if ($this->_access === 'baak')
		{
			// $userData = $this->UsersModel->read($id);
			echo 'edit';
		}
		else
		{
			echo "!LOGIN";
		}
	}

	/**
	 * add
	 */
	public function add()
	{
		if ($this->_access === 'baak')
		{
			// $userData = $this->UsersModel->read($id);
			echo "add";
		}
		else
		{
			echo "!LOGIN";
		}
	}

	/**
	 * delete
	 */
	public function delete($id)
	{
		if ($this->_access === 'baak')
		{
			// $userData = $this->UsersModel->read($id);
			echo "delete";
		}
		else
		{
			echo "!LOGIN";
		}
	}

	/**
	 * show
	 */
	private function _show($page='', $data='')
	{
		$this->load->view('head');
		$this->load->view('navbar');
		$this->load->view('sidebar');
		$this->load->view($page, $data);
		$this->load->view('foot');
	}
}