<?php

class Matakuliah extends MX_Controller
{
	// declared variable
	private $_access;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('MatakuliahModel');
		$this->_access = $this->session->job;
	}

	public function index()
	{
		$this->browse();
	}

	/**
	 * browse
	 * show list of matakuliah
	 * @return mixed
	 */
	public function browse()
	{
		if ($this->_access === 'BAAK' || $this->_access === 'super_admin')
		{
			$data = array(
				'matakuliahs' =>  $this->MatakuliahModel->browse(),
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
				$matakuliahData = $this->MatakuliahModel->browse($data);
				foreach ($matakuliahData as $data)
				{
					echo "
					<tr id='edit_source_".$data->id_matakuliah."'>
					<td style='text-align:center;'>".$i."</td>
					<td style='text-align:center;'>".$data->id_matakuliah."</td>
					<td style='text-align:center;'>".$data->nama."</td>
					<td style='text-align:center;'>".$data->sks."</td>
					<td style='text-align:center;'>".$data->semester."</td>
					<td style='text-align:center;'>
					<button type='button' class='btn btn-info' data-toggle='modal' data-target='#modal' id='edit_matakuliah_".$data->id_matakuliah."'><i class='fa fa-edit'></i> EDIT</button>
					<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#modal' id='delete_matakuliah_".$data->id_matakuliah."'><i class='fa fa-trash'></i> DELETE</button>
					</td>
					</tr>
					";
					$i++;
				}
			}
			elseif ($type === 'read')
			{
				$matakuliahData = $this->MatakuliahModel->read($data);
				foreach ($matakuliahData as $data)
				{
					echo "
					<div class='modal-header'>
					<h1 class='modal-title'>Edit matakuliah</h1>
					</div>
					<div id='error_form_matakuliah'></div>
					<form class='form-horizontal' method='post' id='edit_form_matakuliah'>
					<div class='modal-body'>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Kode matakuliah</label>
					<label class='col-xs-4 control-label'>".$data->id_matakuliah."</label>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Nama</label>
					<div class='col-xs-7'>
					<input name='namamatakuliah' id='namamatakuliah_edit' type='text' class='form-control' value='".$data->nama."' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Jumlah SKS</label>
					<div class='col-xs-7'>
					<input name='sks' id='sks_edit' type='text' class='form-control' value='".$data->sks."' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Semester</label>
					<div class='col-xs-7'>
					<input name='semester' id='semester_edit' type='text' class='form-control' value='".$data->semester."' required>
					</div>
					</div>
					</div>
					<div class='modal-footer'>
					<div class='col-xs-6'>
					<button class='btn btn-success' type='submit' id='save_edit_matakuliah'><i class='fa fa-save'></i> Save</button>
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
				$matakuliahData = $this->MatakuliahModel->browse();
				foreach ($matakuliahData as $data)
				{
					echo "
					<tr id='edit_source_".$data->id_matakuliah."'>
					<td style='text-align:center;'>".$i."</td>
					<td style='text-align:center;'>".$data->id_matakuliah."</td>
					<td style='text-align:center;'>".$data->nama."</td>
					<td style='text-align:center;'>".$data->sks."</td>
					<td style='text-align:center;'>".$data->semester."</td>
					<td style='text-align:center;'>
					<button type='button' class='btn btn-info' data-toggle='modal' data-target='#modal' id='edit_matakuliah_".$data->id_matakuliah."'><i class='fa fa-edit'></i> EDIT</button>
					<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#modal' id='delete_matakuliah_".$data->id_matakuliah."'><i class='fa fa-trash'></i> DELETE</button>
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
	public function edit($id_matakuliah)
	{
		if ($this->_access === 'BAAK' || $this->_access === 'super_admin')
		{
			if ($this->MatakuliahModel->dataExists('matakuliah', array('id_matakuliah' => $id_matakuliah)) === 0)
			{
				$matakuliahData = array(
					'nama' => $this->input->post('namamatakuliah'),
					'sks' => $this->input->post('sks'),
					'semester' => $this->input->post('semester'),
					'edited_at' => mdate('%Y-%m-%d', now()),
				);
				echo ($this->MatakuliahModel->edit($id_matakuliah, $matakuliahData) === TRUE ? 'TRUE' : 'FALSE');
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
	public function add($id_matakuliah = '')
	{
		if ($this->_access === 'BAAK' || $this->_access === 'super_admin')
		{
			if (empty($id_matakuliah))
			{
				echo "
					<div class='modal-header'>
					<h1 class='modal-title'>Add Mata Kuliah</h1>
					</div>
					<div id='error_form_matakuliah'></div>
					<form class='form-horizontal' method='post' id='add_form_matakuliah'>
					<div class='modal-body'>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Kode matakuliah</label>
					<div class='col-xs-7'>
					<input name='idmatakuliah' id='idmatakuliah_add' type='text' class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Nama</label>
					<div class='col-xs-7'>
					<input name='namamatakuliah' id='namamatakuliah_add' type='text' class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Jumlah SKS</label>
					<div class='col-xs-7'>
					<input name='sks' id='sks_add' type='text' class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Semester</label>
					<div class='col-xs-7'>
					<input name='semester' id='semester_add' type='text' class='form-control' required>
					</div>
					</div>
					</div>
					<div class='modal-footer'>
					<div class='col-xs-6'>
					<button class='btn btn-success' type='submit' id='save_add_matakuliah'><i class='fa fa-save'></i> Save</button>
					</div>
					<div class='col-xs-6 push-left'>
					<button class='btn btn-danger push-left' type='button' data-dismiss='modal'><i class='fa fa-times'></i> Cancel</button>
					</div>
					</div>
					</form>";
			}
			else
			{
				if ($this->MatakuliahModel->dataExists('matakuliah', array('id_matakuliah' => $id_matakuliah)) === 0)
				{
					$matakuliahData = array(
						'id_matakuliah' => $id_matakuliah,
						'nama' => $this->input->post('namamatakuliah'),
						'sks' => $this->input->post('sks'),
						'semester' => $this->input->post('semester'),
						'created_at' => mdate('%Y-%m-%d', now()),
					);
					echo ($this->MatakuliahModel->add($matakuliahData) === TRUE ? 'TRUE' : 'FALSE');
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
	public function delete($id_matakuliah)
	{
		if ($this->_access === 'BAAK' || $this->_access === 'super_admin')
		{
			if ($this->MatakuliahModel->dataExists('matakuliah', array('id_matakuliah' => $id_matakuliah)) === 1)
			{
				echo ($this->MatakuliahModel->delete($id_matakuliah) === TRUE ? 'TRUE' : 'FALSE');
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