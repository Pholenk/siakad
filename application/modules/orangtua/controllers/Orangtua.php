<?php

class Orangtua extends MX_Controller
{
	// declared variable
	private $_access;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('OrangtuaModel');
		$this->load->module('mahasiswa');
		$this->_access = $this->session->job;
	}

	public function index()
	{
		if ($this->_access === 'BAAK')
		{
			$data = array(
				'orangtuas' =>  $this->browse(),
			);
			$this->_show('browse', $data);
		}		
		else
		{
			redirect(base_url('/auth/logout'));
		}
		$this->browse();
	}

	/**
	 * browse
	 * show list of orangtua
	 * @return mixed
	 */
	public function browse()
	{
		return $this->OrangtuaModel->browse();
	}

	/**
	 * read
	 * search data use fullname or read data use single username user
	 * @param string type
	 * @param string username or fullname
	 * @return mixed
	 */
	public function read($data = '')
	{
		if ($this->_access === 'BAAK')
		{
			$orangtuaData = $this->OrangtuaModel->read($data);
			foreach ($orangtuaData as $data)
			{
				echo "
				<div class='modal-header'>
				<h1 class='modal-title'>Edit Orang Tua</h1>
				</div>
				<div id='error_form_orangtua'></div>
				<form class='form-horizontal' method='post' id='edit_form_orangtua'>
				<div class='modal-body'>
				<div class='form-group'>
				<label class='col-xs-4 control-label'>NIM</label>
				<label class='col-xs-4 control-label'>".$data->nim."</label>
				</div>
				<div class='form-group'>
				<label class='col-xs-4 control-label'>Nama</label>
				<div class='col-xs-7'>
				<input name='namaorangtua' id='namaorangtua_edit' type='text' class='form-control' value='".$data->nama."' required>
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
				<input name='tanggal_lahir' id='tanggal_lahir_edit' type='date' class='form-control' value='".mdate('%Y-%m-%d', strtotime($data->tanggal_lahir))."' required>
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
				<div class='form-group'>
				<label class='col-xs-4 control-label'>Telepon</label>
				<div class='col-xs-7'>
				<input name='telepon' id='telepon_edit' type='text' class='form-control' value='".$data->telepon."' required>
				</div>
				</div>
				</div>
				<div class='modal-footer'>
				<div class='col-xs-6'>
				<button class='btn btn-success' type='submit' id='save_edit_orangtua'><i class='fa fa-save'></i> Save</button>
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
	public function edit($nim)
	{
		if ($this->_access === 'BAAK')
		{
			if ($this->OrangtuaModel->dataExists('orangtua', array('nim' => $nim)) === 1)
			{
				$orangtuaData = array(
					'nama' => $this->input->post('namaorangtua'),
					'tempat_lahir' => $this->input->post('tempat_lahir'),
					'tanggal_lahir' => $this->input->post('tanggal_lahir'),
					'jenis_kelamin' => $this->input->post('jenis_kelamin'),
					'agama' => $this->input->post('agama'),
					'alamat' => $this->input->post('alamat'),
					'email' => $this->input->post('email'),
					'telepon' => $this->input->post('telepon'),
				);
				echo ($this->OrangtuaModel->edit($nim, $orangtuaData) === TRUE ? 'TRUE' : 'FALSE');
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
	public function add()
	{
		if ($this->_access === 'BAAK')
		{
			if (empty($this->input->post('nim')))
			{
				$mahasiswa = $this->mahasiswa->_browse();
				echo "
					<div class='modal-header'>
					<h1 class='modal-title'>Add orangtua</h1>
					</div>
					<div id='error_form_orangtua'></div>
					<form class='form-horizontal' method='post' id='add_form_orangtua'>
					<div class='modal-body'>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Mahasiswa</label>
					<div class='col-xs-7'>
					<select name='nim' id='nim_add' type='text' class='form-control' required>";
					foreach ($mahasiswa as $key)
					{
						echo "<option value='".$key->nim."'>".$key->nama."</option>";
					}
					echo "
					</select>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Nama</label>
					<div class='col-xs-7'>
					<input name='namaorangtua' id='namaorangtua_add' type='text' class='form-control' required>
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
					<input name='tanggal_lahir' id='tanggal_lahir_add' type='date' class='form-control' value='".mdate('%Y-%m-%d', now())."' required>
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
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Telepon</label>
					<div class='col-xs-7'>
					<input name='telepon' id='telepon_add' type='text' class='form-control' required>
					</div>
					</div>
					</div>
					<div class='modal-footer'>
					<div class='col-xs-6'>
					<button class='btn btn-success' type='submit' id='save_add_orangtua'><i class='fa fa-save'></i> Save</button>
					</div>
					<div class='col-xs-6 push-left'>
					<button class='btn btn-danger push-left' type='button' data-dismiss='modal'><i class='fa fa-times'></i> Cancel</button>
					</div>
					</div>
					</form>";
			}
			else
			{
				$orangtuaData = array(
					'nim' => $this->input->post('nim'),
					'nama' => $this->input->post('namaorangtua'),
					'tempat_lahir' => $this->input->post('tempat_lahir'),
					'tanggal_lahir' => $this->input->post('tanggal_lahir'),
					'jenis_kelamin' => $this->input->post('jenis_kelamin'),
					'agama' => $this->input->post('agama'),
					'alamat' => $this->input->post('alamat'),
					'email' => $this->input->post('email'),
					'telepon' => $this->input->post('telepon'),
				);
				if ($this->OrangtuaModel->dataExists('orangtua', array('nim' => $this->input->post('nim'))) === 0)
				{
					echo ($this->OrangtuaModel->add($orangtuaData) === TRUE ? 'TRUE' : 'FALSE');
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
			// redirect(base_url('/auth/logout'));
		}
	}

	/**
	 * delete
	 * delete user data by username
	 * @param string username
	 */
	public function delete($nim)
	{
		if ($this->_access === 'BAAK')
		{
			if ($this->OrangtuaModel->dataExists('orangtua', array('nim' => $nim)) === 1)
			{
				echo ($this->OrangtuaModel->delete($nim) === TRUE ? 'TRUE' : 'FALSE');
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