<?php

/**
* 
*/
class Test extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('TestModel');
	}

	public function index($jenis=82)
	{
		$data['nilai'] = $this->TestModel->test($jenis);
		$data['mhs'] = $this->TestModel->browse_mahasiswa();
		$this->load->view('head');
		$this->load->view('navbar');
		$this->load->view('browse', $data);
		$this->load->view('sidebar');
		$this->load->view('foot');
	}
}