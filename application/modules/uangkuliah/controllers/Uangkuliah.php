<?php

class Uangkuliah extends MX_Controller
{
	// declared variable
	private $_access;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('uangkuliahModel');
		$this->_access = $this->session->job;
	}

	public function index()
	{
		$this->browse();
	}

	/**
	 * browse
	 * show list of uangkuliah
	 * @return mixed
	 */
	public function browse()
	{
		if ($this->_access === 'BAAK' || $this->_access === 'super_admin')
		{
			$data = array(
				'uangkuliahs' =>  $this->uangkuliahModel->browse(),
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
				$uangkuliahData = $this->uangkuliahModel->browse($data);
				foreach ($uangkuliahData as $data)
				{
					echo "
					<tr id='edit_source_".$data->id_uangkuliah."'>
					<td style='text-align:center;'>".$i."</td>
					<td style='text-align:center;'>".$data->id_uangkuliah."</td>
					<td style='text-align:center;'>".$data->nama."</td>
					<td style='text-align:center;'>".$data->sks."</td>
					<td style='text-align:center;'>".$data->semester."</td>
					<td style='text-align:center;'>
					<button type='button' class='btn btn-info' data-toggle='modal' data-target='#modal' id='edit_uangkuliah_".$data->id_uangkuliah."'><i class='fa fa-edit'></i> EDIT</button>
					<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#modal' id='delete_uangkuliah_".$data->id_uangkuliah."'><i class='fa fa-trash'></i> DELETE</button>
					</td>
					</tr>
					";
					$i++;
				}
			}
			elseif ($type === 'read')
			{
				$uangkuliahData = $this->uangkuliahModel->read($data);
				foreach ($uangkuliahData as $data)
				{
					echo "
					<div class='modal-header'>
					<h1 class='modal-title'>Edit uangkuliah</h1>
					</div>
					<div id='error_form_uangkuliah'></div>
					<form class='form-horizontal' method='post' id='edit_form_uangkuliah'>
					<div class='modal-body'>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Kode uangkuliah</label>
					<label class='col-xs-4 control-label'>".$data->id_uangkuliah."</label>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Nama</label>
					<div class='col-xs-7'>
					<input name='namauangkuliah' id='namauangkuliah_edit' type='text' class='form-control' value='".$data->nama."' required>
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
					<button class='btn btn-success' type='submit' id='save_edit_uangkuliah'><i class='fa fa-save'></i> Save</button>
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
				$uangkuliahData = $this->uangkuliahModel->browse();
				foreach ($uangkuliahData as $data)
				{
					echo "
					<tr id='edit_source_".$data->id_uangkuliah."'>
					<td style='text-align:center;'>".$i."</td>
					<td style='text-align:center;'>".$data->id_uangkuliah."</td>
					<td style='text-align:center;'>".$data->nama."</td>
					<td style='text-align:center;'>".$data->sks."</td>
					<td style='text-align:center;'>".$data->semester."</td>
					<td style='text-align:center;'>
					<button type='button' class='btn btn-info' data-toggle='modal' data-target='#modal' id='edit_uangkuliah_".$data->id_uangkuliah."'><i class='fa fa-edit'></i> EDIT</button>
					<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#modal' id='delete_uangkuliah_".$data->id_uangkuliah."'><i class='fa fa-trash'></i> DELETE</button>
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
	public function edit($id_uangkuliah)
	{
		if ($this->_access === 'BAAK' || $this->_access === 'super_admin')
		{
			if ($this->uangkuliahModel->dataExists('uangkuliah', array('id_uangkuliah' => $id_uangkuliah)) === 0)
			{
				$uangkuliahData = array(
					'nama' => $this->input->post('namauangkuliah'),
					'sks' => $this->input->post('sks'),
					'semester' => $this->input->post('semester'),
					'edited_at' => mdate('%Y-%m-%d', now()),
				);
				echo ($this->uangkuliahModel->edit($id_uangkuliah, $uangkuliahData) === TRUE ? 'TRUE' : 'FALSE');
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
	public function add($id_uangkuliah = '')
	{
		if ($this->_access === 'BAAK' || $this->_access === 'super_admin')
		{
			if (empty($id_uangkuliah))
			{
				echo "
					<div class='modal-header'>
					<h1 class='modal-title'>Add uang Kuliah</h1>
					</div>
					<div id='error_form_uangkuliah'></div>
					<form class='form-horizontal' method='post' id='add_form_uangkuliah'>
					<div class='modal-body'>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Kode uangkuliah</label>
					<div class='col-xs-7'>
					<input name='iduangkuliah' id='iduangkuliah_add' type='text' class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Nama</label>
					<div class='col-xs-7'>
					<input name='namauangkuliah' id='namauangkuliah_add' type='text' class='form-control' required>
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
					<button class='btn btn-success' type='submit' id='save_add_uangkuliah'><i class='fa fa-save'></i> Save</button>
					</div>
					<div class='col-xs-6 push-left'>
					<button class='btn btn-danger push-left' type='button' data-dismiss='modal'><i class='fa fa-times'></i> Cancel</button>
					</div>
					</div>
					</form>";
			}
			else
			{
				if ($this->uangkuliahModel->dataExists('uangkuliah', array('id_uangkuliah' => $id_uangkuliah)) === 0)
				{
					$uangkuliahData = array(
						'id_uangkuliah' => $id_uangkuliah,
						'nama' => $this->input->post('namauangkuliah'),
						'sks' => $this->input->post('sks'),
						'semester' => $this->input->post('semester'),
						'created_at' => mdate('%Y-%m-%d', now()),
					);
					echo ($this->uangkuliahModel->add($uangkuliahData) === TRUE ? 'TRUE' : 'FALSE');
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
	public function delete($id_uangkuliah)
	{
		if ($this->_access === 'BAAK' || $this->_access === 'super_admin')
		{
			if ($this->uangkuliahModel->dataExists('uangkuliah', array('id_uangkuliah' => $id_uangkuliah)) === 1)
			{
				echo ($this->uangkuliahModel->delete($id_uangkuliah) === TRUE ? 'TRUE' : 'FALSE');
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