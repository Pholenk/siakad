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
		$this->browse();
	}

	/**
	 * browse
	 * show list of users
	 * @return mixed
	 */
	public function browse()
	{
		if ($this->_access === 'BAAK' || $this->_access === 'super_admin')
		{
			$data = array(
				'users' =>  $this->UsersModel->browse(),
			);
			$this->_show('browse', $data);
		}		
		else
		{
			redirect(base_url('/auth/logout'));
		}
		
	}

	/**
	 * read
	 * search data use fullname or read data use single username user
	 * @param string type
	 * @param string username or fullname
	 * @return mixed
	 */
	public function read($type = '', $data = '')
	{
		if ($this->_access === 'BAAK' || $this->_access === 'super_admin')
		{
			$i = 1;
			if ($type === 'search')
			{
				$userData = $this->UsersModel->browse($data);
				foreach ($userData as $data)
				{
					echo "
					<tr id='edit_source_".$data->id."'>
					<td style='text-align:center;'>".$i."</td>
					<td style='text-align:center;'>".$data->username."</td>
					<td style='text-align:center;'>".$data->fullname."</td>
					<td style='text-align:center;'>".$data->job."</td>
					<td style='text-align:center;'>
					<button type='button' class='btn btn-info' data-toggle='modal' data-target='#modal' id='edit_user_".$data->username."'><i class='fa fa-edit'></i> EDIT</button>
					<a href='".base_url('/users/delete/'.$data->id)."'>
					<button type='button' class='btn btn-danger'><i class='fa fa-trash'></i> DELETE</button>
					</a>
					</td>
					</tr>
					";
				}
			}
			elseif ($type === 'read')
			{
				$userData = $this->UsersModel->read($data);
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
				$userData = $this->UsersModel->browse();
				foreach ($userData as $data)
				{
					echo "
					<tr id='edit_source_".$data->id."'>
					<td style='text-align:center;'>".$i."</td>
					<td style='text-align:center;'>".$data->username."</td>
					<td style='text-align:center;'>".$data->fullname."</td>
					<td style='text-align:center;'>".$data->job."</td>
					<td style='text-align:center;'>
					<button type='button' class='btn btn-info' data-toggle='modal' data-target='#modal' id='edit_user_".$data->username."'><i class='fa fa-edit'></i> EDIT</button>
					<a href='".base_url('/users/delete/'.$data->id)."'>
					<button type='button' class='btn btn-danger'><i class='fa fa-trash'></i> DELETE</button>
					</a>
					</td>
					</tr>
					";
				}
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
		if ($this->_access === 'BAAK' || $this->_access === 'super_admin')
		{
			if ($this->UsersModel->dataExists('users', array('username' => $username)) === 1)
			{
				$userData = array(
					'password' => $this->input->post('password'),
					'fullname' => $this->input->post('fullname'),
					'job' => $this->input->post('job'),
				);
				echo ($this->UsersModel->edit($username, $userData) === TRUE ? '/users' : 'Data gagal diubah!');
			}
			else
			{
				echo "Data tidak ditemukan!";
			}
			
		}
		else
		{
			echo "!LOGIN";
			redirect(base_url('/auth/logout'));
		}
	}

	/**
	 * add
	 * add new data of user
	 * @param string username
	 * @return mixed
	 */
	public function add($username = '')
	{
		if ($this->_access === 'BAAK' || $this->_access === 'super_admin')
		{
			if (empty($username))
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
				// echo $this->UsersModel->dataExists('users', array('username' => $username));
				if ($this->UsersModel->dataExists('users', array('username' => $username)) === 0)
				{
					$userData = array(
						'username' => $username,
						'fullname' => $this->input->post('fullname'),
						'password' => $this->input->post('password'),
						'job' => $this->input->post('job'),
					);
					echo ($this->UsersModel->add($userData) === TRUE ? 'TRUE' : 'FALSE');
				}
				else
				{
					echo "ERROR";
				}
			}
		}
		else
		{
			echo "!LOGIN";
			redirect(base_url('/auth/logout'));
		}
	}

	/**
	 * delete
	 * delete user data by username
	 * @param string username
	 */
	public function delete($username)
	{
		if ($this->_access === 'BAAK' || $this->_access === 'super_admin')
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
			redirect(base_url('/auth/logout'));
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