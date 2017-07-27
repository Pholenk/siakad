<?php
/**
* 
*/
class Email extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('email');
	}

	public function SendEmail()
	{
		$config['protocol'] = "smtp";
		$config['smtp_host'] = "ssl://smtp.gmail.com";
		$config['smtp_port'] = "465";
		$config['smtp_user'] = "pholenkadi17@gmail.com"; 
		$config['smtp_pass'] = "pholenk0049";
		$config['charset'] = "utf-8";
		$config['mailtype'] = "html";
		$config['newline'] = "\r\n";

		$this->email->initialize($config);

		$this->email->from('pholenkadi17@gmail.com', 'Pholenkadi17');
		$this->email->to('bramandityaadi@yahoo.co.id');
		$this->email->subject('fucking first email test');
		$this->email->message('you should be read this fucking email from pholenkadi17@gmail.com');
		echo($this->email->send() ? 'fuck yes' : $this->email->print_debugger());
	}
}