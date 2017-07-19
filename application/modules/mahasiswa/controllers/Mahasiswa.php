<?php

class Mahasiswa extends MX_Controller
{
	// declared variable
	private $_access;

	public function __construct()
	{
		parent::__construct();
		$this->load->module('users');
		$this->load->module('jurusan');
		$this->load->module('uangkuliah');
		$this->load->model('MahasiswaModel');
		$this->_access = $this->session->job;
	}

	public function index()
	{
		if ($this->_access === 'BAAK')
		{
			$data = array(
				'mahasiswas' =>  $this->browse(),
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
			return $this->MahasiswaModel->browse();
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
	public function read($type = '', $data = '')
	{
		if ($this->_access === 'BAAK')
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
				$jurusanData = $this->jurusan->browse();
				$uangkuliahData = $this->uangkuliah->browse();

				foreach ($mahasiswaData as $data)
				{
					echo "
					<div class='modal-header'>
					<h1 class='modal-title'>Edit Mahasiswa</h1>
					</div>
					<div id='error_form_mahasiswa'></div>
					<form class='form-horizontal' method='post' id='edit_form_mahasiswa'>
					<div class='modal-body'>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>NIM</label>
					<label class='col-xs-4 control-label'>".$data->nim."</label>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Status</label>
					<div class='col-xs-7'>
					<select name='Status' id='status_edit' class='form-control' required>
					<option".($data->status === 'Aktif' ? 'selected' : '').">Aktif</option>
					<option".($data->status === 'Tidak' ? 'selected' : '').">Tidak</option>
					</select>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Nama</label>
					<div class='col-xs-7'>
					<input name='nama' id='nama_edit' type='text' class='form-control' value='".$data->nama."' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>
					Jurusan
					</label>
					<div class='col-xs-7'>
					<select name='id_jurusan' id='id_jurusan_edit' type='text' class='form-control' required>";
					foreach ($jurusanData as $jurusan)
					{
						echo "<option value=".$jurusan->id_jurusan."".($jurusan->id_jurusan === $data->id_jurusan ? ' selected>' : '>').$jurusan->nama."</option>";
					}
					echo "
					</select>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>
					Tempat Lahir
					</label>
					<div class='col-xs-7'>
					<input name='tempat_lahir' id='tempat_lahir_edit' type='text' class='form-control' value='".$data->tempat_lahir."' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>
					Tanggal Lahir
					</label>
					<div class='col-xs-7'>
					<input name='tanggal_lahir' id='tanggal_lahir_edit' type='date' class='form-control' value='".mdate('%Y-%m-%d', strtotime($data->tanggal_lahir))."' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>
					Jenis Kelamin
					</label>
					<div class='col-xs-7'>
					<select name='jenis_kelamin' id='jenis_kelamin_edit' type='text' class='form-control' required>
					<option value=1".($data->jenis_kelamin === '1' ? ' selected' : '').">Laki-Laki</option>
                  	<option value=0".($data->jenis_kelamin === '0' ? ' selected' : '').">Perempuan</option>
					</select>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>
					Alamat
					</label>
					<div class='col-xs-7'>
					<input name='alamat' id='alamat_edit' type='text' class='form-control' value='".$data->alamat."' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>
					Agama
					</label>
					<div class='col-xs-7'>
					<input name='agama' id='agama_edit' type='text' class='form-control' value='".$data->agama."' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>
					Email
					</label>
					<div class='col-xs-7'>
					<input name='email' id='email_edit' type='email' class='form-control' value='".$data->email."' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>
					Kelas
					</label>
					<div class='col-xs-7'>
					<input name='kelas' id='kelas_edit' type='text' class='form-control' value='".$data->kelas."' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>
					Semester
					</label>
					<div class='col-xs-7'>
					<select name='semester' id='semester_edit' type='text' class='form-control' required>".$data->semester."
					<option value=1 ".($data->semester === '1' ? ' selected' : '').">1</option>
					<option value=2 ".($data->semester === '2' ? ' selected' : '').">2</option>
					<option value=3 ".($data->semester === '3' ? ' selected' : '').">3</option>
					<option value=4 ".($data->semester === '4' ? ' selected' : '').">4</option>
					<option value=5 ".($data->semester === '5' ? ' selected' : '').">5</option>
					<option value=6 ".($data->semester === '6' ? ' selected' : '').">6</option>
					<option value=7 ".($data->semester === '7' ? ' selected' : '').">7</option>
					<option value=8 ".($data->semester === '8' ? ' selected' : '').">8</option>
					<option value=0 ".($data->semester === '0' ? ' selected' : '').">Lulus</option>
					</select>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>
					Tahun Masuk
					</label>
					<div class='col-xs-7'>
					<input name='tahun_masuk' id='tahun_masuk_edit' type='number' min=0 step=1 class='form-control' value='".mdate('%Y',strtotime($data->tahun_masuk))."' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>
					Uang Kuliah
					</label>
					<div class='col-xs-7'>
					<select name='id_uangkuliah' id='id_uangkuliah_edit' type='text' class='form-control' required>";
					foreach ($uangkuliahData as $ukt)
					{
						echo "<option value=".$ukt->id_uangkuliah." ".($ukt->id_uangkuliah === $data->id_uangkuliah ? ' selected>' : '>')." ".$ukt->nominal."</option>";
					}
					echo "
					</select>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>
					SPI
					</label>
					<div class='col-xs-7'>
					<input name='spi' id='spi_edit' type='number' min=0 step=1 class='form-control' value='".$data->spi."' required>
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
				$mahasiswaData = $this->browse();
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
		if ($this->_access === 'BAAK')
		{
			if ($this->MahasiswaModel->dataExists('mahasiswa', array('nim' => $nim)) === 1)
			{
				$mahasiswaData = array(
					'id_jurusan' => $this->input->post('id_jurusan'),
					'id_uangkuliah' => $this->input->post('id_uangkuliah'),
					'nama' => $this->input->post('nama'),
					'tempat_lahir' => $this->input->post('tempat_lahir'),
					'tanggal_lahir' => $this->input->post('tanggal_lahir'),
					'jenis_kelamin' => $this->input->post('jenis_kelamin'),
					'agama' => $this->input->post('agama'),
					'kelas' => $this->input->post('kelas'),
					'alamat' => $this->input->post('alamat'),
					'email' => $this->input->post('email'),
					'semester' => $this->input->post('semester'),
					'status' => $this->input->post('status'),
					'spi' => $this->input->post('spi'),
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
		if ($this->_access === 'BAAK')
		{
			if (empty($nim))
			{
				$jurusanData = $this->jurusan->browse();
				$uangkuliahData = $this->uangkuliah->browse();
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
					<div class='form-group'>
					<label class='col-xs-4 control-label'>
					Jurusan
					</label>
					<div class='col-xs-7'>
					<select name='id_jurusan' id='id_jurusan_add' type='text' class='form-control' required>
					";
					foreach ($jurusanData as $jurusan)
					{
						echo "<option value=".$jurusan->id_jurusan.">".$jurusan->nama."</option>";
					}
					echo "
					</select>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>
					Tempat Lahir
					</label>
					<div class='col-xs-7'>
					<input name='tempat_lahir' id='tempat_lahir_add' type='text' class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>
					Tanggal Lahir
					</label>
					<div class='col-xs-7'>
					<input name='tanggal_lahir' id='tanggal_lahir_add' type='date' value='".mdate('%Y-%m-%d', now())."' class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>
					Jenis Kelamin
					</label>
					<div class='col-xs-7'>
					<select name='jenis_kelamin' id='jenis_kelamin_add' type='text' class='form-control' required>
					<option value=1>Laki-Laki</option>
                  	<option value=0>Perempuan</option>
					</select>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>
					Alamat
					</label>
					<div class='col-xs-7'>
					<input name='alamat' id='alamat_add' type='text' class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>
					Agama
					</label>
					<div class='col-xs-7'>
					<input name='agama' id='agama_add' type='text' class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>
					Email
					</label>
					<div class='col-xs-7'>
					<input name='email' id='email_add' type='email' class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>
					Kelas
					</label>
					<div class='col-xs-7'>
					<input name='kelas' id='kelas_add' type='text' class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>
					Semester
					</label>
					<div class='col-xs-7'>
					<select name='semester' id='semester_add' type='text' class='form-control' required>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
					<option>6</option>
					<option>7</option>
					<option>8</option>
					<option>Lulus</option>
					</select>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>
					Tahun Masuk
					</label>
					<div class='col-xs-7'>
					<input name='tahun_masuk' id='tahun_masuk_add' type='number' value='".mdate('%Y', now())."' class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>
					Uang Kuliah
					</label>
					<div class='col-xs-7'>
					<select name='id_uangkuliah' id='id_uangkuliah_add' type='text' class='form-control' required>";
					foreach ($uangkuliahData as $ukt)
					{
						echo "<option value=".$ukt->id_uangkuliah.">".$ukt->nominal."</option>";
					}
					echo "
					</select>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>
					SPI
					</label>
					<div class='col-xs-7'>
					<input name='spi' id='spi_add' type='number' min=0 step=1 class='form-control' required>
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
						'id_jurusan' => $this->input->post('id_jurusan'),
						'id_uangkuliah' => $this->input->post('id_uangkuliah'),
						'nama' => $this->input->post('nama'),
						'tempat_lahir' => $this->input->post('tempat_lahir'),
						'tanggal_lahir' => $this->input->post('tanggal_lahir'),
						'jenis_kelamin' => $this->input->post('jenis_kelamin'),
						'agama' => $this->input->post('agama'),
						'alamat' => $this->input->post('alamat'),
						'email' => $this->input->post('email'),
						'kelas' => $this->input->post('kelas'),
						'semester' => $this->input->post('semester'),
						'spi' => $this->input->post('spi'),
						'created_at' => mdate('%Y-%m-%d', now()),
					);
					if($this->MahasiswaModel->add($mahasiswaData) === TRUE)
					{
						$userData = array(
							'username' => $nim,
							'fullname' => $this->input->post('nama'),
							'password' => $this->input->post('tanggal_lahir'),
							'job' => 'Mahasiswa',
						);
						echo($this->users->_add($userData));
					}
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
		if ($this->_access === 'BAAK')
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