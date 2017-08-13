<?php

class Auth extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('AuthModel');
	}

	public function index()
	{
		($this->session->logged_in === TRUE ? redirect(base_url('main')) : $this->load->view('login'));
	}

	/**
	 * login method
	 * create user's session when username and password found
	 */
	public function login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$query = $this->AuthModel->login($username, $password);
		foreach ($query as $data)
		{
			$job = $data->job;
			$name = $data->fullname;
		}

		if(!empty($job))
		{
			$data = array(
				'username' => $username,
				'job' => $job,
				'name' => $name,
				'logged_in' => TRUE,
			);
			$this->session->set_userdata($data);
			echo 'TRUE';
		}
		else
		{
			echo $this->input->post('username');//'Username or Password not found!';
		}
	}

	/**
	 * logout method
	 * destroy user's session
	 */
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}
}