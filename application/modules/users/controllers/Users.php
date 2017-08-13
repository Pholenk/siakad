<?php

class Users extends MX_Controller
{
	// declared variable
	private $_access;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('UsersModel');
		$this->_access = $this->session->job;
	}

	public function index()
	{
		if ($this->_access === 'BAAK')
		{
			$data = array(
				'users' =>  $this->_browse(),
			);
			$this->_show('browse', $data);
		}		
		else
		{
			echo "!LOGIN";
			//redirect(base_url('/auth/logout'));
		}
	}

	/**
	 * browse
	 * show list of users
	 * @return mixed
	 */
	function _browse()
	{
		if ($this->_access === 'BAAK')
		{
			return ($this->UsersModel->browse());
		}
		else
		{
			echo "!LOGIN";
		}
		
	}

	/**
	 * read
	 * read data from single username user
	 * @param string username
	 * @return mixed
	 */
	public function read($username)
	{
		if ($this->_access === 'BAAK')
		{
			$userData = $this->UsersModel->read($username);
			foreach ($userData as $data)
			{
				echo "
				<div class='modal-header'>
				<h1 class='modal-title'>Edit User</h1>
				</div>
				<div id='error_form_user'></div>
				<form class='form-horizontal' method='post' id='edit_form_user'>
				<div class='modal-body'>
				<div class='form-group'>
				<label class='col-xs-4 control-label'>Username</label>
				<label class='col-xs-4 control-label' id='username_edit'>".$data->username."</label>
				</div>
				<div class='form-group'>
				<label class='col-xs-4 control-label'>Nama</label>
				<div class='col-xs-7'>
				<input name='fullname' id='fullname_edit' type='text' class='form-control' value='".$data->fullname."' required>
				</div>
				</div>
				<div class='form-group'>
				<label class='col-xs-4 control-label'>Password</label>
				<div class='col-xs-7'>
				<div class='input-group'>
				<div class='input-group-btn'>
				<button type='button' class='btn btn-info' id='show_password'><i class='fa fa-eye-slash' id='show_password_icon'></i></button>
				</div>
				<input name='password' type='password' class='form-control' id='password_add' value='".$data->password."' required>
				</div>
				</div>
				</div>
				<div class='form-group'>
				<label class='col-xs-4 control-label'>Pekerjaan</label>
				<div class='col-xs-7'>
				<select name='job' class='form-control' id='job_edit' required>
				<option ".($data->job === 'BAAK' ?  "selected = 'selected'" : "").">BAAK</option>
				<option ".($data->job === 'Keuangan' ?  "selected = 'selected'" : "").">Keuangan</option>
				<option ".($data->job === 'Dosen' ?  "selected = 'selected'" : "").">Dosen</option>
				<option ".($data->job === 'Mahasiswa' ?  "selected = 'selected'" : "").">Mahasiswa</option>
				</select>
				</div>
				</div>
				</div>
				<div class='modal-footer'>
				<div class='col-xs-6'>
				<button class='btn btn-success' type='submit' id='save_edit_user'><i class='fa fa-save'></i> Save</button>
				</div>
				<div class='col-xs-6 push-left'>
				<button class='btn btn-danger push-left' type='button' data-dismiss='modal'><i class='fa fa-times'></i> Cancel</button>
				</div>
				</div>
				</form>";
			}
		}
		else
		{
			echo "!LOGIN";
		}
		
	}

	/**
	 * edit 
	 * edit data from a single username of user
	 * @param string username
	 * @return string
	 */
	public function edit($username)
	{
		if ($this->_access === 'BAAK')
		{
			if ($this->UsersModel->dataExists('users', array('username' => $username)) === 1)
			{
				$userData = array(
					'password' => $this->input->post('password'),
					'fullname' => $this->input->post('fullname'),
					'job' => $this->input->post('job'),
				);
				echo ($this->_edit($username, $userData));
			}
		}
		else
		{
			echo "!LOGIN";
		}
	}

	/**
	 * edit data of user and save it into the persistence storage
	 * this function can be used by another module such as dosen module or mahasiswa module
	 * @param string username
	 * @param string data
	 * @return string
	 */
	function _edit($username, $data)
	{
		$status = "FALSE";
		
		if ($this->_access === 'BAAK')
		{
			if ($this->UsersModel->dataExists('users', array('username' => $username)) === 1)
			{
				$status = ($this->UsersModel->edit($username, $data) === TRUE ? 'TRUE' : 'FALSE');
			}
			else
			{
				$status = "ERROR";
			}
		}
		else
		{
			$status = "!LOGIN";
		}
		return $status;
	}

	/**
	 * add front-end
	 * show the front-end when direct accessed by user
	 * @param string username
	 * @return mixed
	 */
	public function add()
	{
		if ($this->_access === 'BAAK')
		{
			if (empty($this->input->post('username')))
			{
				echo "
					<div class='modal-header'>
					<h1 class='modal-title'>Add User</h1>
					</div>
					<div id='error_form_user'></div>
					<form class='form-horizontal' method='post' id='add_form_user'>
					<div class='modal-body'>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Username</label>
					<div class='col-xs-7'>
					<input name='username' id='username_add' type='text' class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Nama</label>
					<div class='col-xs-7'>
					<input name='fullname' id='fullname_add' type='text' class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Password</label>
					<div class='col-xs-7'>
					<div class='input-group'>
					<div class='input-group-btn'>
					<button type='button' class='btn btn-info' id='show_password'><i class='fa fa-eye-slash' id='show_password_icon'></i></button>
					</div>
					<input name='password' type='password' class='form-control' id='password_add' required>
					</div>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Pekerjaan</label>
					<div class='col-xs-7'>
					<select name='job' class='form-control' id='job_add' required>
					<option>BAAK</option>
					<option>Keuangan</option>
					</select>
					</div>
					</div>
					</div>
					<div class='modal-footer'>
					<div class='col-xs-6'>
					<button class='btn btn-success' type='submit' id='save_add_user'><i class='fa fa-save'></i> Save</button>
					</div>
					<div class='col-xs-6 push-left'>
					<button class='btn btn-danger push-left' type='button' data-dismiss='modal'><i class='fa fa-times'></i> Cancel</button>
					</div>
					</div>
					</form>";
			}
			else
			{				
				$userData = array(
					'username' => $this->input->post('username'),
					'fullname' => $this->input->post('fullname'),
					'password' => $this->input->post('password'),
					'job' => $this->input->post('job'),
				);
				echo $this->_add($userData);
			}
		}
		else
		{
			echo "!LOGIN";
		}
	}

	/**
	 * inserting new data of user into the persistence storage
	 * this function can be used by another module such as dosen module or mahasiswa module
	 * @param string data
	 * @return string
	 */
	function _add($data)
	{
		$status = "FALSE";

		if ($this->UsersModel->dataExists('users', array('username' => $data['username'])) === 0)
		{
			$status = ($this->UsersModel->add($data) === TRUE ? 'TRUE' : 'FALSE');
		}
		else
		{
			$status = "ERROR";
		}
		return $status;
	}

	/**
	 * delete
	 * delete user data by username
	 * @param string username
	 */
	public function delete($username)
	{
		if ($this->_access === 'BAAK')
		{
			if ($this->UsersModel->dataExists('users', array('username' => $username)) === 1)
			{
				echo ($this->UsersModel->delete($username) === TRUE ? 'TRUE' : 'FALSE');
			}
			else
			{
				echo "ERROR";
			}
		}
		else
		{
			echo "!LOGIN";
			// redirect(base_url('/auth/logout'));
		}
	}

	/**
	 * show
	 */
	private function _show($page='', $data='')
	{
		$this->load->view('head');
		$this->load->view('navbar');
		$this->load->view('sidebar/baak');
		$this->load->view($page, $data);
		$this->load->view('foot');
	}
}