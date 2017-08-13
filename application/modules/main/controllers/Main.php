<?php

class Main extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->load->model('AuthModel');
	}

	public function index()
	{
		if ($this->session->logged_in === TRUE)
		{
			switch ($this->session->job)
			{
                case 'BAAK': 
                    $this->_show('baak');
                    break;
                case 'Keuangan': 
                    $this->_show('keuangan');
                    break;
                case 'Dosen': 
                    $this->_show('dosen');
                    break;
                case 'Mahasiswa': 
                    $this->_show('mahasiswa');
                    break;
			}
		}
		else
		{
			redirect(base_url('auth'));
		}
	}

	private function _show($page='')
	{
		$this->load->view('head');
		$this->load->view('navbar');
		$this->load->view('sidebar/'.$page);
		$this->load->view('main');
		$this->load->view('foot');
	}
}