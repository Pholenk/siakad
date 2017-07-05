<?php

class Mahasiswa extends MX_Controller
{
	// declared variable
	private $_access;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('MahasiswaModel');
		$this->_access = $this->session->job;
	}

	public function index()
	{
		$this->browse();
	}

	/**
	 * browse
	 * show list of jurusan
	 * @return mixed
	 */
	public function browse()
	{
		if ($this->_access === 'BAAK' || $this->_access === 'super_admin')
		{
			$data = array(
				'mahasiswas' =>  $this->MahasiswaModel->browse(),
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
				$mahasiswaData = $this->MahasiswaModel->browse($data);
				foreach ($mahasiswaData as $data)
				{
					echo "
					<tr id='edit_source_".$data->nim."'>
					<td style='text-align:center;'>".$i."</td>
					<td style='text-align:center;'>".$data->nim."</td>
					<td style='text-align:center;'>".$data->nama."</td>
					<td style='text-align:center;'>
					<button type='button' class='btn btn-info' data-toggle='modal' data-target='#modal' id='edit_mahasiswa_".$data->nim."'><i class='fa fa-edit'></i> EDIT</button>
					<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#modal' id='delete_mahasiswa_".$data->nim."'><i class='fa fa-trash'></i> DELETE</button>
					</td>
					</tr>
					";
					$i++;
				}
			}
			elseif ($type === 'read')
			{
				$mahasiswaData = $this->MahasiswaModel->read($data);
				foreach ($mahasiswaData as $data)
				{
					echo "
					<div class='modal-header'>
					<h1 class='modal-title'>Edit Mahasiswa</h1>
					</div>
					<div id='error_form_mahasiswa'></div>
					<form class='form-horizontal' method='post' id='edit_form_jurusan'>
					<div class='modal-body'>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>NIM</label>
					<label class='col-xs-4 control-label'>".$data->nim."</label>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Nama</label>
					<div class='col-xs-7'>
					<input name='nama' id='nama_edit' type='text' class='form-control' value='".$data->nama."' required>
					</div>
					</div>
					</div>
					<div class='modal-footer'>
					<div class='col-xs-6'>
					<button class='btn btn-success' type='submit' id='save_edit_mahasiswa'><i class='fa fa-save'></i> Save</button>
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
				$mahasiswaData = $this->MahasiswaModel->browse();
				foreach ($mahasiswaData as $data)
				{
					echo "
					<tr id='edit_source_".$data->nim."'>
					<td style='text-align:center;'>".$i."</td>
					<td style='text-align:center;'>".$data->nim."</td>
					<td style='text-align:center;'>".$data->nama."</td>
					<td style='text-align:center;'>
					<button type='button' class='btn btn-info' data-toggle='modal' data-target='#modal' id='edit_mahasiswa_".$data->nim."'><i class='fa fa-edit'></i> EDIT</button>
					<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#modal' id='delete_mahasiswa_".$data->nim."'><i class='fa fa-trash'></i> DELETE</button>
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
	public function edit($nim)
	{
		if ($this->_access === 'BAAK' || $this->_access === 'super_admin')
		{
			if ($this->MahasiswaModel->dataExists('mahasiswa', array('nim' => $nim)) === 0)
			{
				$mahasiswaData = array(
					'nama' => $this->input->post('nama'),
					'edited_at' => mdate('%Y-%m-%d', now()),
				);
				echo ($this->MahasiswaModel->edit($nim, $mahasiswaData) === TRUE ? 'TRUE' : 'FALSE');
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
	public function add($nim = '')
	{
		if ($this->_access === 'BAAK' || $this->_access === 'super_admin')
		{
			if (empty($nim))
			{
				echo "
					<div class='modal-header'>
					<h1 class='modal-title'>Add Mahasiswa</h1>
					</div>
					<div id='error_form_mahasiswa'></div>
					<form class='form-horizontal' method='post' id='add_form_mahasiswa'>
					<div class='modal-body'>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>NIM</label>
					<div class='col-xs-7'>
					<input name='nim' id='nim_add' type='text' class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Nama</label>
					<div class='col-xs-7'>
					<input name='nama' id='nama_add' type='text' class='form-control' required>
					</div>
					</div>
					</div>
					<div class='modal-footer'>
					<div class='col-xs-6'>
					<button class='btn btn-success' type='submit' id='save_add_mahasiswa'><i class='fa fa-save'></i> Save</button>
					</div>
					<div class='col-xs-6 push-left'>
					<button class='btn btn-danger push-left' type='button' data-dismiss='modal'><i class='fa fa-times'></i> Cancel</button>
					</div>
					</div>
					</form>";
			}
			else
			{
				if ($this->MahasiswaModel->dataExists('mahasiswa', array('nim' => $nim)) === 0)
				{
					$mahasiswaData = array(
						'nim' => $nim,
						'id_orangtua' => $this->input->post('id_orangtua'),
						'id_jurusan' => $this->input->post('id_jurusan'),
						'id_uangkuliah' => $this->input->post('id_uangkuliah'),
						'nama' => $this->input->post('nama'),
						'tempat_lahir' => $this->input->post('tempat_lahir'),
						'tanggal_lahir' => $this->input->post('tanggal_lahir'),
						'jenis_kelamin' => $this->input->post('jenis_kelamin'),
						'agama' => $this->input->post('agama'),
						'alamat' => $this->input->post('alamat'),
						'email' => $this->input->post('email'),
						'semester' => $this->input->post('semester'),
						'created_at' => mdate('%Y-%m-%d', now()),
					);
					echo ($this->MahasiswaModel->add($mahasiswaData) === TRUE ? 'TRUE' : 'FALSE');
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
	public function delete($nim)
	{
		if ($this->_access === 'BAAK' || $this->_access === 'super_admin')
		{
			if ($this->MahasiswaModel->dataExists('mahasiswa', array('nim' => $nim)) === 1)
			{
				echo ($this->MahasiswaModel->delete($nim) === TRUE ? 'TRUE' : 'FALSE');
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