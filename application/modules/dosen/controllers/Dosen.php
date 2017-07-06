<?php

class Dosen extends MX_Controller
{
	// declared variable
	private $_access;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('DosenModel');
		$this->load->module('auth');
		$this->_access = $this->session->job;
	}

	public function index()
	{
		$this->browse();
	}

	/**
	 * browse
	 * show list of dosen
	 * @return mixed
	 */
	public function browse()
	{
		if ($this->_access === 'BAAK' || $this->_access === 'super_admin')
		{
			$data = array(
				'dosens' =>  $this->DosenModel->browse(),
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
				$dosenData = $this->DosenModel->browse($data);
				foreach ($dosenData as $data)
				{
					echo "
					<tr id='edit_source_".$data->nidn."'>
					<td style='text-align:center;'>".$i."</td>
					<td style='text-align:center;'>".$data->nidn."</td>
					<td style='text-align:center;'>".$data->nama."</td>
					<td style='text-align:center;'>
					<button type='button' class='btn btn-info' data-toggle='modal' data-target='#modal' id='edit_dosen_".$data->nidn."'><i class='fa fa-edit'></i> EDIT</button>
					<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#modal' id='delete_dosen_".$data->nidn."'><i class='fa fa-trash'></i> DELETE</button>
					</td>
					</tr>
					";
					$i++;
				}
			}
			elseif ($type === 'read')
			{
				$dosenData = $this->DosenModel->read($data);
				foreach ($dosenData as $data)
				{
					echo "
					<div class='modal-header'>
					<h1 class='modal-title'>Edit dosen</h1>
					</div>
					<div id='error_form_dosen'></div>
					<form class='form-horizontal' method='post' id='edit_form_dosen'>
					<div class='modal-body'>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>NIDN</label>
					<label class='col-xs-4 control-label'>".$data->nidn."</label>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Nama</label>
					<div class='col-xs-7'>
					<input name='namadosen' id='namadosen_edit' type='text' class='form-control' value='".$data->nama."' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Tempat Lahir</label>
					<div class='col-xs-7'>
					<input name='tempat_lahir' id='tempat_lahir_edit' type='text' class='form-control' value='".$data->tempat_lahir."' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Tanggal Lahir</label>
					<div class='col-xs-7'>
					<input name='tanggal_lahir' id='tanggal_lahir_edit' type='date' class='form-control' value='".$data->tanggal_lahir."' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Jenis Kelamin</label>
					<div class='col-xs-7'>
					<div class='radio'>
                      <label style='padding-right:12px;padding-left=8px;font-weight:bold;'>
                        <input name='jenis_kelamin' type='radio' value='0' id='jenis_kelamin_edit' ".($data->jenis_kelamin === '0' ? 'checked' : '')." required> Perempuan</label>
                      <label style='padding-right:12px;padding-left=8px;font-weight:bold;'>
                        <input name='jenis_kelamin' type='radio' value='1' id='jenis_kelamin_edit' ".($data->jenis_kelamin === '1' ? 'checked' : '')." required> Laki-laki</label>
					</div>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Alamat</label>
					<div class='col-xs-7'>
					<input name='alamat' id='alamat_edit' type='text' class='form-control' value='".$data->alamat."' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Agama</label>
					<div class='col-xs-7'>
					<input name='agama' id='agama_edit' type='text' class='form-control' value='".$data->agama."' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Email</label>
					<div class='col-xs-7'>
					<input name='email' id='email_edit' type='email' class='form-control' value='".$data->email."' required>
					</div>
					</div>
					</div>
					<div class='modal-footer'>
					<div class='col-xs-6'>
					<button class='btn btn-success' type='submit' id='save_edit_dosen'><i class='fa fa-save'></i> Save</button>
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
				$dosenData = $this->DosenModel->browse();
				foreach ($dosenData as $data)
				{
					echo "
					<tr id='edit_source_".$data->nidn."'>
					<td style='text-align:center;'>".$i."</td>
					<td style='text-align:center;'>".$data->nidn."</td>
					<td style='text-align:center;'>".$data->nama."</td>
					<td style='text-align:center;'>
					<button type='button' class='btn btn-info' data-toggle='modal' data-target='#modal' id='edit_dosen_".$data->nidn."'><i class='fa fa-edit'></i> EDIT</button>
					<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#modal' id='delete_dosen_".$data->nidn."'><i class='fa fa-trash'></i> DELETE</button>
					</td>
					</tr>
					";
					$i++;
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
	public function edit($nidn)
	{
		if ($this->_access === 'BAAK' || $this->_access === 'super_admin')
		{
			if ($this->DosenModel->dataExists('dosen', array('nidn' => $nidn)) === 1)
			{
				$dosenData = array(
					'nama' => $this->input->post('namadosen'),
					'tempat_lahir' => $this->input->post('tempat_lahir'),
					'tanggal_lahir' => $this->input->post('tanggal_lahir'),
					'jenis_kelamin' => $this->input->post('jenis_kelamin'),
					'agama' => $this->input->post('agama'),
					'alamat' => $this->input->post('alamat'),
					'email' => $this->input->post('email'),
					'edited_at' => mdate('%Y-%m-%d', now()),
				);
				echo ($this->DosenModel->edit($nidn, $dosenData) === TRUE ? 'TRUE' : 'FALSE');
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
	 * add
	 * add new data of user
	 * @param string username
	 * @return mixed
	 */
	public function add($nidn = '')
	{
		if ($this->_access === 'BAAK' || $this->_access === 'super_admin')
		{
			if (empty($nidn))
			{
				echo "
					<div class='modal-header'>
					<h1 class='modal-title'>Add dosen</h1>
					</div>
					<div id='error_form_dosen'></div>
					<form class='form-horizontal' method='post' id='add_form_dosen'>
					<div class='modal-body'>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>NIDN</label>
					<div class='col-xs-7'>
					<input name='nidn' id='nidn_add' type='text' class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Nama</label>
					<div class='col-xs-7'>
					<input name='namadosen' id='namadosen_add' type='text' class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Tempat Lahir</label>
					<div class='col-xs-7'>
					<input name='tempat_lahir' id='tempat_lahir_add' type='text' class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Tanggal Lahir</label>
					<div class='col-xs-7'>
					<input name='tanggal_lahir' id='tanggal_lahir_add' type='date' class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Jenis Kelamin</label>
					<div class='col-xs-7'>
					<div class='radio'>
                      <label style='padding-right:12px;padding-left=8px;font-weight:bold;'>
                        <input name='jenis_kelamin' type='radio' value='0' id='jenis_kelamin_add' required> Perempuan</label>
                      <label style='padding-right:12px;padding-left=8px;font-weight:bold;'>
                        <input name='jenis_kelamin' type='radio' value='1' id='jenis_kelamin_add' required> Laki-laki</label>
					</div>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Alamat</label>
					<div class='col-xs-7'>
					<input name='alamat' id='alamat_add' type='text' class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Agama</label>
					<div class='col-xs-7'>
					<input name='agama' id='agama_add' type='text' class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Email</label>
					<div class='col-xs-7'>
					<input name='email' id='email_add' type='email' class='form-control' required>
					</div>
					</div>
					</div>
					<div class='modal-footer'>
					<div class='col-xs-6'>
					<button class='btn btn-success' type='submit' id='save_add_dosen'><i class='fa fa-save'></i> Save</button>
					</div>
					<div class='col-xs-6 push-left'>
					<button class='btn btn-danger push-left' type='button' data-dismiss='modal'><i class='fa fa-times'></i> Cancel</button>
					</div>
					</div>
					</form>";
			}
			else
			{
				if ($this->DosenModel->dataExists('dosen', array('nidn' => $nidn)) === 0)
				{
					$dosenData = array(
						'nidn' => $nidn,
						'nama' => $this->input->post('namadosen'),
						'tempat_lahir' => $this->input->post('tempat_lahir'),
						'tanggal_lahir' => $this->input->post('tanggal_lahir'),
						'jenis_kelamin' => $this->input->post('jenis_kelamin'),
						'agama' => $this->input->post('agama'),
						'alamat' => $this->input->post('alamat'),
						'email' => $this->input->post('email'),
						'created_at' => mdate('%Y-%m-%d', now()),
					);
					echo ($this->DosenModel->add($dosenData) === TRUE ? 'TRUE' : 'FALSE');
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
	 * fix it
	 * delete
	 * delete user data by username
	 * @param string username
	 */
	public function delete($nidn)
	{
		if ($this->_access === 'BAAK' || $this->_access === 'super_admin')
		{
			if ($this->DosenModel->dataExists('dosen', array('nidn' => $nidn)) === 1)
			{
				echo ($this->DosenModel->delete($nidn) === TRUE ? 'TRUE' : 'FALSE');
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