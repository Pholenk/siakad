<?php


class Db extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
        if (!$this->input->is_cli_request()) {
            exit('Direct access is not allowed. This is a command line tool, use the terminal');
        }
        $this->load->library('migration');
    }

    function migrate()
    {
        $message = NULL;
        $migrationStatus = $this->migration->latest();
        if($migrationStatus != 0)
        {
            $message = 'migrating success';
        }
        else
        {
            $message = $this->migration->error_string();
        }
        echo $message;
    }

    function seed()
    {
        $usersData = array(
            'fullname' => 'BAAK',
        	'username' => 'super@admin',
            'password' => '12345',
            'job' => 'BAAK',
        );
        $message = ($this->db->insert('users',$usersData) ? 'seeding success' : 'seeding fail');
        echo $message;
    }
}