<?php

class Jurusan extends MX_Controller
{
	// declared variable
	private $_access;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('JurusanModel');
		$this->_access = $this->session->job;
	}

	public function index()
	{
		if ($this->_access === 'BAAK')
		{
			$data = array(
				'jurusans' => $this->browse(),
			);
			$this->_show('browse', $data);
		}		
		else
		{
			redirect(base_url('/auth/logout'));
		}
	}

	/**
	 * browse
	 * show list of jurusan
	 * @return mixed
	 */
	public function browse()
	{
		if ($this->_access === 'BAAK')
		{
			return $this->JurusanModel->browse();
		}
		else
		{
			echo "!LOGIN";
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
	public function read($id_jurusan)
	{
		if ($this->_access === 'BAAK')
		{
			$jurusanData = $this->JurusanModel->read($id_jurusan);
			foreach ($jurusanData as $data)
			{
				echo "
				<div class='modal-header'>
				<h1 class='modal-title'>Edit Jurusan</h1>
				</div>
				<div id='error_form_jurusan'></div>
				<form class='form-horizontal' method='post' id='edit_form_jurusan'>
				<div class='modal-body'>
				<div class='form-group'>
				<label class='col-xs-4 control-label'>Kode Jurusan</label>
				<label class='col-xs-4 control-label'>".$data->id_jurusan."</label>
				</div>
				<div class='form-group'>
				<label class='col-xs-4 control-label'>Kode Jurusan</label>
				<div class='col-xs-7'>
				<input name='kode_jurusan' id='kode_jurusan_edit' type='text' class='form-control' value='".$data->kode_jurusan."' required>
				</div>
				</div>
				<div class='form-group'>
				<label class='col-xs-4 control-label'>Nama Jurusan</label>
				<div class='col-xs-7'>
				<input name='namajurusan' id='namajurusan_edit' type='text' class='form-control' value='".$data->nama."' required>
				</div>
				</div>
				</div>
				<div class='modal-footer'>
				<div class='col-xs-6'>
				<button class='btn btn-success' type='submit' id='save_edit_jurusan'><i class='fa fa-save'></i> Save</button>
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
	public function edit($id_jurusan)
	{
		if ($this->_access === 'BAAK')
		{
			if ($this->JurusanModel->dataExists('jurusan', array('id_jurusan' => $id_jurusan)) === 0)
			{
				$jurusanData = array(
					'kode_jurusan' => $this->input->post('kode_jurusan'),
					'nama' => $this->input->post('namajurusan'),
					'edited_at' => mdate('%Y-%m-%d', now()),
				);
				echo ($this->JurusanModel->edit($id_jurusan, $jurusanData) === TRUE ? 'TRUE' : 'FALSE');
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
	public function add($id_jurusan = '')
	{
		if ($this->_access === 'BAAK')
		{
			if (empty($id_jurusan))
			{
				echo "
					<div class='modal-header'>
					<h1 class='modal-title'>Add jurusan</h1>
					</div>
					<div id='error_form_jurusan'></div>
					<form class='form-horizontal' method='post' id='add_form_jurusan'>
					<div class='modal-body'>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>ID Jurusan</label>
					<div class='col-xs-7'>
					<input name='idjurusan' id='idjurusan_add' type='text' class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Kode Jurusan</label>
					<div class='col-xs-7'>
					<input name='kode_jurusan' id='kode_jurusan_add' type='text' class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Nama</label>
					<div class='col-xs-7'>
					<input name='namajurusan' id='namajurusan_add' type='text' class='form-control' required>
					</div>
					</div>
					</div>
					<div class='modal-footer'>
					<div class='col-xs-6'>
					<button class='btn btn-success' type='submit' id='save_add_jurusan'><i class='fa fa-save'></i> Save</button>
					</div>
					<div class='col-xs-6 push-left'>
					<button class='btn btn-danger push-left' type='button' data-dismiss='modal'><i class='fa fa-times'></i> Cancel</button>
					</div>
					</div>
					</form>";
			}
			else
			{
				if ($this->JurusanModel->dataExists('jurusan', array('id_jurusan' => $id_jurusan)) === 0)
				{
					$jurusanData = array(
						'id_jurusan' => $id_jurusan,
						'kode_jurusan' => $this->input->post('kode_jurusan'),
						'nama' => $this->input->post('namajurusan'),
						'created_at' => mdate('%Y-%m-%d', now()),
					);
					echo ($this->JurusanModel->add($jurusanData) === TRUE ? 'TRUE' : 'FALSE');
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
	public function delete($id_jurusan)
	{
		if ($this->_access === 'BAAK')
		{
			if ($this->JurusanModel->dataExists('jurusan', array('id_jurusan' => $id_jurusan)) === 1)
			{
				echo ($this->JurusanModel->delete($id_jurusan) === TRUE ? 'TRUE' : 'FALSE');
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