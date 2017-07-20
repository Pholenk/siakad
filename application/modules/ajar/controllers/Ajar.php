<?php

class Ajar extends MX_Controller
{
	// declared variable
	private $_access;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ajarModel');
		$this->load->module('dosen');
		$this->load->module('matakuliah');
		$this->_access = $this->session->job;
	}

	public function index()
	{
		$this->browse();
	}

	/**
	 * browse
	 * show list of ajar
	 * @return mixed
	 */
	public function browse()
	{
		if ($this->_access === 'BAAK')
		{
			$data = array(
				'ajars' =>  $this->ajarModel->browse(),
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
	public function read($id_ajar = '')
	{
		if ($this->_access === 'BAAK')
		{
			$ajarData = $this->ajarModel->read($id_ajar);
			$matakuliahs = $this->matakuliah->_browse();
			$dosens = $this->dosen->_browse();
			foreach ($ajarData as $data)
			{
				echo "
				<div class='modal-header'>
				<h1 class='modal-title'>Edit Ajar</h1>
				</div>
				<div id='error_form_ajar'></div>
				<form class='form-horizontal' method='post' id='edit_form_ajar'>
				<div class='modal-body'>
				<div class='form-group'>
				<label class='col-xs-4 control-label'>Kode ajar</label>
				<label class='col-xs-4 control-label'>".$data->id_ajar."</label>
				</div>
				<div class='form-group'>
				<label class='col-xs-4 control-label'>Mata Kuliah</label>
				<div class='col-xs-7'>
				<select name='matakuliah' id='matakuliah_edit' type='text' class='form-control' required>";
				foreach ($matakuliahs as $matakuliah)
				{
					echo "<option value='".$matakuliah->id_matakuliah."'".($matakuliah->id_matakuliah === $data->id_matakuliah ? 'selected' : '').">".$matakuliah->nama."</option>";
				}
				echo "
				</select>
				</div>
				</div>
				<div class='form-group'>
				<label class='col-xs-4 control-label'>Dosen</label>
				<div class='col-xs-7'>
				<select name='dosen' id='dosen_edit' type='text' class='form-control' required>";
				foreach ($dosens as $dosen)
				{
					echo "<option value='".$dosen->id_dosen."'".($dosen->id_dosen === $data->id_dosen ? 'selected' : '').">".$dosen->nama."</option>";
				}
				echo "
				</select>
				</div>
				</div>
				<div class='form-group'>
				<label class='col-xs-4 control-label'>Kelas</label>
				<div class='col-xs-7'>
				<input name='kelas' id='kelas_edit' type='text' class='form-control' value='".$data->kelas."' required>
				</div>
				</div>
				</div>
				<div class='modal-footer'>
				<div class='col-xs-6'>
				<button class='btn btn-success' type='submit' id='save_edit_ajar'><i class='fa fa-save'></i> Save</button>
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
	public function edit($id_ajar)
	{
		if ($this->_access === 'BAAK')
		{
			if ($this->ajarModel->dataExists('ajar', array('id_ajar' => $id_ajar)) === 1)
			{
				$ajarData = array(
					'id_matakuliah' => $this->input->post('matakuliah'),
					'id_dosen' => $this->input->post('dosen'),
					'kelas' => $this->input->post('kelas'),
					'edited_at' => mdate('%Y-%m-%d', now()),
				);
				echo ($this->ajarModel->edit($id_ajar, $ajarData) === TRUE ? 'TRUE' : 'FALSE');
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
			if (empty($this->input->post('kelas')))
			{
				$matakuliahs = $this->matakuliah->_browse();
				$dosens = $this->dosen->_browse();
				echo "
				<div class='modal-header'>
				<h1 class='modal-title'>Add Ajar</h1>
				</div>
				<div id='error_form_ajar'></div>
				<form class='form-horizontal' method='post' id='add_form_ajar'>
				<div class='modal-body'>
				<div class='form-group'>
				<label class='col-xs-4 control-label'>Mata Kuliah</label>
				<div class='col-xs-7'>
				<select name='matakuliah' id='matakuliah_edit' type='text' class='form-control' required>";
				foreach ($matakuliahs as $matakuliah)
				{
					echo "<option value='".$matakuliah->id_matakuliah."'>".$matakuliah->nama."</option>";
				}
				echo "
				</select>
				</div>
				</div>
				<div class='form-group'>
				<label class='col-xs-4 control-label'>Dosen</label>
				<div class='col-xs-7'>
				<select name='dosen' id='dosen_edit' type='text' class='form-control' required>";
				foreach ($dosens as $dosen)
				{
					echo "<option value='".$dosen->id_dosen."'>".$dosen->nama."</option>";
				}
				echo "
				</select>
				</div>
				</div>
				<div class='form-group'>
				<label class='col-xs-4 control-label'>Kelas</label>
				<div class='col-xs-7'>
				<input name='kelas' id='kelas_edit' type='text' class='form-control' required>
				</div>
				</div>
				</div>
				<div class='modal-footer'>
				<div class='col-xs-6'>
				<button class='btn btn-success' type='submit' id='save_add_ajar'><i class='fa fa-save'></i> Save</button>
				</div>
				<div class='col-xs-6 push-left'>
				<button class='btn btn-danger push-left' type='button' data-dismiss='modal'><i class='fa fa-times'></i> Cancel</button>
				</div>
				</div>
				</form>";
			}
			else
			{
				// echo $this->ajarModel->dataExists('ajar', array('id_dosen' => '08.014','id_matakuliah' => 'TI215P'));
				if ($this->ajarModel->dataExists('ajar', array('id_dosen' => $this->input->post('dosen'),'id_matakuliah' => $this->input->post('matakuliah'))) === 0)
				{
					$ajarData = array(
						'id_ajar' => $this->ajarModel->genID(),
						'id_matakuliah' => $this->input->post('matakuliah'),
						'id_dosen' => $this->input->post('dosen'),
						'kelas' => $this->input->post('kelas'),
						'created_at' => mdate('%Y-%m-%d', now()),
					);
					echo ($this->ajarModel->add($ajarData) === TRUE ? 'TRUE' : 'FALSE');
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
	public function delete($id_ajar)
	{
		if ($this->_access === 'BAAK')
		{
			if ($this->ajarModel->dataExists('ajar', array('id_ajar' => $id_ajar)) === 1)
			{
				echo ($this->ajarModel->delete($id_ajar) === TRUE ? 'TRUE' : 'FALSE');
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