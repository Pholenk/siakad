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
		if ($this->_access === 'BAAK' || $this->_access === 'super_admin')
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
	public function read($type = '', $data = '')
	{
		if ($this->_access === 'BAAK' || $this->_access === 'super_admin')
		{
			$i = 1;
			if ($type === 'search')
			{
				$ajarData = $this->ajarModel->browse($data);
				foreach ($ajarData as $data)
				{
					echo "
					<tr>
                    <td style='text-align:center'>".$i."</td>
                    <td style='text-align:center'>".$ajar->nama_dosen."</td>
                    <td style='text-align:center'>".$ajar->nama_matakuliah."</td>
                    <td style='text-align:center'>".$ajar->kelas."</td>
                    <td style='text-align:center;'>
                      <button type='button' class='btn btn-info' data-toggle='modal' data-target='#modal' id='edit_matakuliah_".$ajar->id_ajar."'><i class='fa fa-edit'></i> EDIT</button>
                      <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#modal' id='delete_matakuliah_".$ajar->id_ajar."'><i class='fa fa-trash'></i> DELETE</button>
                    </td>
                  	</tr>
					";
					$i++;
				}
			}
			elseif ($type === 'read')
			{
				$ajarData = $this->ajarModel->read($data);
				$matakuliahs = $this->matakuliah->browse();
				$dosens = $this->dosen->browse();
				foreach ($ajarData as $data)
				{
					echo "
					<div class='modal-header'>
					<h1 class='modal-title'>Edit ajar</h1>
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
				$ajarData = $this->ajarModel->browse();
				foreach ($ajarData as $data)
				{
					echo "
					<tr id='edit_source_".$data->id_ajar."'>
					<td style='text-align:center;'>".$i."</td>
					<td style='text-align:center;'>".$data->id_ajar."</td>
					<td style='text-align:center;'>".$data->nama."</td>
					<td style='text-align:center;'>".$data->sks."</td>
					<td style='text-align:center;'>".$data->semester."</td>
					<td style='text-align:center;'>
					<button type='button' class='btn btn-info' data-toggle='modal' data-target='#modal' id='edit_ajar_".$data->id_ajar."'><i class='fa fa-edit'></i> EDIT</button>
					<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#modal' id='delete_ajar_".$data->id_ajar."'><i class='fa fa-trash'></i> DELETE</button>
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
	public function edit($id_ajar)
	{
		if ($this->_access === 'BAAK' || $this->_access === 'super_admin')
		{
			if ($this->ajarModel->dataExists('ajar', array('id_ajar' => $id_ajar)) === 0)
			{
				$ajarData = array(
					'nama' => $this->input->post('namaajar'),
					'sks' => $this->input->post('sks'),
					'semester' => $this->input->post('semester'),
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
	public function add($id_ajar = '')
	{
		if ($this->_access === 'BAAK' || $this->_access === 'super_admin')
		{
			if (empty($id_ajar))
			{
				echo "
					<div class='modal-header'>
					<h1 class='modal-title'>Add Mata Kuliah</h1>
					</div>
					<div id='error_form_ajar'></div>
					<form class='form-horizontal' method='post' id='add_form_ajar'>
					<div class='modal-body'>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Kode ajar</label>
					<div class='col-xs-7'>
					<input name='idajar' id='idajar_add' type='text' class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Nama</label>
					<div class='col-xs-7'>
					<input name='namaajar' id='namaajar_add' type='text' class='form-control' required>
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
				if ($this->ajarModel->dataExists('ajar', array('id_ajar' => $id_ajar)) === 0)
				{
					$ajarData = array(
						'id_ajar' => $id_ajar,
						'nama' => $this->input->post('namaajar'),
						'sks' => $this->input->post('sks'),
						'semester' => $this->input->post('semester'),
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
		if ($this->_access === 'BAAK' || $this->_access === 'super_admin')
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