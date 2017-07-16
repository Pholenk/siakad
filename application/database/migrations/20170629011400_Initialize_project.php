<?php

defined('BASEPATH') OR exit('No Direct Script Access Allowed');

class Migration_Initialize_project extends CI_Migration 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		/**
		 * create users table
		 */
		$users_fields = array(
			'id' => array(
				'type' => 'INT',
				'null' => FALSE,
				'auto_increment' => TRUE,
			),
			'fullname' => array(
				'type' => 'VARCHAR',
				'constraint' => 150,
				'null' => FALSE,
			),
			'username' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,
			),
			'password' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => FALSE,
			),
			'job' => array(
				'type' => 'VARCHAR',
				'constraint' => 30,
				'null' => FALSE,
			),
		);
		$this->dbforge->add_field($users_fields);
		$this->dbforge->add_key('id',TRUE);
		$this->dbforge->create_table('users',TRUE);
	}

	public function down()
	{}
}