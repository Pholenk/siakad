<?php

class Bayar extends MX_Controller
{
	// declared variable
	private $_access;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('bayarModel');
		$this->load->module('mahasiswa');
		$this->_access = $this->session->job;
	}

	public function index($tipe)
	{
		if ($this->_access === 'Keuangan')
		{
			$data = array(
				'tipe' => $tipe,
				'bayars' => $this->browse($tipe),
			);
			$this->_show('browse', $data);
		}
		else
		{
			echo "!LOGIN";
			redirect(base_url('/auth/logout'));
		}
	}

	/**
	 * browse
	 * show list of uangkuliah
	 * @return mixed
	 */
	public function browse($tipe)
	{
		if ($this->_access === 'Keuangan')
		{
			return $this->bayarModel->browse($tipe);
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
	public function read($id_uangkuliah)
	{
		if ($this->_access === 'Keuangan')
		{
			$uangkuliahData = $this->bayarModel->read($id_uangkuliah);
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
				<label class='col-xs-4 control-label'>nominal</label>
				<div class='col-xs-7'>
				<input name='nominaluangkuliah' id='nominaluangkuliah_edit' type='text' class='form-control' value='".$data->nominal."' required>
				</div>
				</div>
				<div class='form-group'>
				<label class='col-xs-4 control-label'>Tanggal Buka</label>
				<div class='col-xs-7'>
				<input name='tgl_buka' id='tgl_buka_add' type='date' value='".mdate('%Y-%m-%d', strtotime($data->tgl_buka))."' class='form-control' required>
				</div>
				</div>
				<div class='form-group'>
				<label class='col-xs-4 control-label'>Tanggal Tutup</label>
				<div class='col-xs-7'>
				<input name='tgl_tutup' id='tgl_tutup_add' type='date' value='".mdate('%Y-%m-%d', strtotime($data->tgl_tutup))."' class='form-control' required>
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
		if ($this->_access === 'Keuangan')
		{
			if ($this->bayarModel->dataExists('uangkuliah', array('id_uangkuliah' => $id_uangkuliah)) === 0)
			{
				$uangkuliahData = array(
					'nominal' => $this->input->post('nominaluangkuliah'),
					'tgl_buka' => $this->input->post('tgl_buka'),
					'tgl_tutup' => $this->input->post('tgl_tutup'),
					'edited_at' => mdate('%Y-%m-%d', now()),
				);
				echo($this->bayarModel->edit($id_uangkuliah, $uangkuliahData) ? 'TRUE' : 'FALSE');
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
	public function add($tipe)
	{
		if ($this->_access === 'Keuangan')
		{
			if (empty($this->input->post('cicilan_bayar')))
			{
				$mahasiswaData = $this->mahasiswa->_browse();
				echo "
					<div class='modal-header'>
					<h1 class='modal-title'>Add Pembayaran </h1>
					</div>
					<div id='error_form_bayar'></div>
					<form class='form-horizontal' method='post' id='add_form_bayar'>
					<div class='modal-body'>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Mahasiswa</label>
					<div class='col-xs-7'>
					<select name='nim_bayar' id='nim_bayar_add' class='form-control' required>
					<option></option>
					";
				foreach ($mahasiswaData as $mhs)
				{
					echo "<option value=".$mhs->nim.">".$mhs->nim." - ".$mhs->nama."</option>";
				}
				echo "
					</select>
					</div>
					</div>
					<div class='form-group ".($tipe === 'SPI' ? 'hide' : '')."'>
					<label class='col-xs-4 control-label'>Semester</label>
					<div class='col-xs-7'>
					<input name='semester_bayar' id='semester_bayar_add' type='number' value=1 min=1 max=8 class='form-control'".($tipe === 'SPI' ? '' : 'required').">
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Cicilan</label>
					<div class='col-xs-7'>
					<input name='cicilan_bayar' id='cicilan_bayar_add' type='number' min=1 class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Nominal</label>
					<div class='col-xs-7'>
					<input name='nominal_bayar' id='nominal_bayar_add' type='number' min=100000 step=100 class='form-control' required>
					</div>
					</div>
					</div>
					<div class='modal-footer'>
					<div class='col-xs-6'>
					<button class='btn btn-success' type='submit' id='save_add_".$tipe."'><i class='fa fa-save'></i> Save</button>
					</div>
					<div class='col-xs-6 push-left'>
					<button class='btn btn-danger push-left' type='button' data-dismiss='modal'><i class='fa fa-times'></i> Cancel</button>
					</div>
					</div>
					</form>";
			}
			else
			{
				$table = '';
				$nim_bayar = $this->input->post('nim_bayar');
				$cicilan_bayar = $this->input->post('cicilan_bayar');
				$semester_bayar = $this->input->post('semester_bayar');
				$nominal_bayar = $this->input->post('nominal_bayar');

				$dataInput = array(
					'nim' => $nim_bayar,
					'cicilan' => $cicilan_bayar
				);

				if ($tipe === 'uangkuliah')
				{
					$dataInput['semester'] = $semester_bayar;
					$table = 'det_bayar_semester';
				}
				else
				{
					$table = 'det_bayar_spi';
				}

				if ($this->bayarModel->detailExists($table, $dataInput) === 0)
				{
					$id_bayar = $this->bayarModel->genID($tipe);

					$bayarData = array(
						'id_bayar' => $id_bayar,
						'nim' => $nim_bayar,
						'tgl_bayar' => mdate('%Y-%m-%d', now()),
					);

					$detBayarData = array(
						'id_bayar' => $id_bayar,
						'nominal' => $nominal_bayar,
						'cicilan' => $cicilan_bayar,
					);

					($tipe === 'uangkuliah' ? $detBayarData['semester'] = $semester_bayar : '');

					echo($this->bayarModel->add($tipe, $bayarData, $detBayarData) === TRUE ? 'TRUE' : 'FALSE');
				}

				elseif ($this->bayarModel->detailExists(($tipe === 'uangkuliah' ? 'det_bayar_semester' : 'det_bayar_spi'), $dataInput) === 1)
				{
					$tgl_bayar = $this->bayarModel->dateTransaction($tipe, $dataInput);
					echo "Mahasiswa ini sudah pernah melakukan transaksi yang sama pada ".$tgl_bayar;
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
	 * fix it
	 * delete
	 * delete user data by username
	 * @param string username
	 */
	public function delete($tipe, $id_bayar)
	{
		if ($this->_access === 'Keuangan')
		{
			$table = ($tipe === 'uangkuliah' ? 'det_bayar_semester' : 'det_bayar_spi');
			if ($this->bayarModel->dataExists($table, $id_bayar) === 1)
			{
				echo ($this->bayarModel->delete($table, $id_bayar) === TRUE ? 'TRUE' : 'FALSE');
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
		$this->load->view('sidebar/keuangan');
		$this->load->view($page, $data);
		$this->load->view('foot');
	}

	/**
	 * validate amount of payment in one transaction
	 * @param string type
	 * @param string nim
	 * @param string semester
	 * @param string nominal
	 */
	public function validate_payment($type, $nim, $nominal, $semester = NULL)
	{
		if ($nominal > $this->bayarModel->remainingPayment($type, $nim, $semester))
		{
			echo $this->bayarModel->remainingPayment($type, $nim, $semester);
		}
	}
}