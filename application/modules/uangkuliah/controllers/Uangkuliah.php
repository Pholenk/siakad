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
		$config = array(
			'api_key' => 'a0e1e0d5', 
			'api_secret' => '6c8abc91cb631241',
			'from' => 'PNC',
		);
		$this->load->library('sms',$config);
	}

	public function index()
	{
		if ($this->_access === 'BAAK')
		{
			$data = array(
				'uangkuliahs' => $this->browse(),
			);
			$this->_show('browse', $data);
		}
		else
		{
			echo "!LOGIN";
			redirect(base_url('/auth/logout'));
		}
	}

	function sendSMS($id_uangkuliah)
	{
		// '+6285747577748','+6285701703169','+6285747149129','+628574740719','+6285640846856','+628561185775'
		$listReceiver = array();
		$messages = '';
		$uangkuliahData = $this->uangkuliahModel->read($id_uangkuliah);
		$receivers = $this->uangkuliahModel->browseOrangtua($id_uangkuliah);
		
		foreach ($uangkuliahData as $data)
		{
			$messages = 'pembayaran uang kuliah Politeknik Negeri Cilacap dapat dilakukan pada tanggal '.date('d F Y',strtotime($data->tgl_buka)).' sampai dengan '.date('d F Y',strtotime($data->tgl_tutup));
		}

		foreach ($receivers as $receiver)
		{
			array_push($listReceiver, substr_replace($receiver->telepon, '+62', 0, 1));
		}

		// print_r($messages);
		$this->sms->send($messages, $listReceiver);
		return '';
	}

	/**
	 * browse
	 * show list of uangkuliah
	 * @return mixed
	 */
	public function browse()
	{
		if ($this->_access === 'BAAK')
		{
			return $this->uangkuliahModel->browse();
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
		if ($this->_access === 'BAAK')
		{
			$uangkuliahData = $this->uangkuliahModel->read($id_uangkuliah);
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
		if ($this->_access === 'BAAK')
		{
			if ($this->uangkuliahModel->dataExists('uangkuliah', array('id_uangkuliah' => $id_uangkuliah)) === 1)
			{
				$uangkuliahData = array(
					'nominal' => $this->input->post('nominaluangkuliah'),
					'tgl_buka' => $this->input->post('tgl_buka'),
					'tgl_tutup' => $this->input->post('tgl_tutup'),
					'edited_at' => mdate('%Y-%m-%d', now()),
				);
				echo($this->uangkuliahModel->edit($id_uangkuliah, $uangkuliahData) ? 'TRUE' : 'FALSE');
				$this->sendSMS($id_uangkuliah);
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
		if ($this->_access === 'BAAK')
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
					<label class='col-xs-4 control-label'>Golongan Uang Kuliah</label>
					<div class='col-xs-7'>
					<input name='iduangkuliah' id='iduangkuliah_add' type='number' min=1 step=1 class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>nominal</label>
					<div class='col-xs-7'>
					<input name='nominaluangkuliah' id='nominaluangkuliah_add' type='number' min=1000 class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Tanggal Buka</label>
					<div class='col-xs-7'>
					<input name='tgl_buka' id='tgl_buka_add' type='date' value='".mdate('%Y-%m-%d', now())."' class='form-control' required>
					</div>
					</div>
					<div class='form-group'>
					<label class='col-xs-4 control-label'>Tanggal Tutup</label>
					<div class='col-xs-7'>
					<input name='tgl_tutup' id='tgl_tutup_add' type='date' value='".mdate('%Y-%m-%d', now())."' class='form-control' required>
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
						'nominal' => $this->input->post('nominaluangkuliah'),
						'tgl_buka' => $this->input->post('tgl_buka'),
						'tgl_tutup' => $this->input->post('tgl_tutup'),
						'created_at' => mdate('%Y-%m-%d', now()),
					);
					echo($this->uangkuliahModel->add($uangkuliahData) === TRUE ? 'TRUE' : 'FALSE');
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
		if ($this->_access === 'BAAK')
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