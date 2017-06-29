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

	public function index()
    {
        $migrationStatus = $this->migration->latest();
    	if($migrationStatus != 0)
        {
            echo ($this->_seeder() ? 'migrating & seeding success' : 'migrating & seeding not success');
        }
        else
        {
            show_error($this->migration->error_string());    		
    	}
    }

    private function _seeder()
    {
        $usersData = array(
            'fullname' => 'super admin',
        	'username' => 'super@admin',
            'password' => '12345',
            'job' => 'super_admin',
        );
        return ($this->db->insert('users',$usersData) ? TRUE : FALSE);
    }
}