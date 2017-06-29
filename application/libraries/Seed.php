<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class MY_Seed
{

//-----------------------------------declare all variables---------------------------------//


//-----------------------------------------------------------------------------------------//

//-----------------------------------start the code below----------------------------------//

	function __construct()
	{
		// assign CodeIgniter super-object
		$CI =& get_instance();

		// show warning when seeder will use while migration mode is disabled
		if ($CI->config->item('migration_enabled') !== TRUE)
		{
			echo "You should enable migration on config.php";
		}

		// load library database to manipulate data
		$CI->load->library('database');

	}

	public function seeder()
	{
		
	}



//-----------------------------------------------------------------------------------------//
}