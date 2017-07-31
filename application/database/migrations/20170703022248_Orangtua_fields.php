<?php

defined('BASEPATH') OR exit('No Direct Script Access Allowed');

class Migration_Orangtua_fields extends CI_Migration 
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
		$orangtua_fields = array(
			'nim' => array(
				'type' => 'VARCHAR',
				'constraint' => 40,
				'null' => FALSE,
			),
			'nama' => array(
				'type' => 'VARCHAR',
				'constraint' => 150,
				'null' => FALSE,
			),
			'alamat' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
				'null' => FALSE,
			),
			'tempat_lahir' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,
			),
			'tanggal_lahir' => array(
				'type' => 'DATE',
				'null' => FALSE,
			),
			'agama' => array(
				'type' => 'VARCHAR',
				'constraint' => 35,
				'null' => FALSE,
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,
			),
			'telepon' => array(
				'type' => 'INT',
				'null' => FALSE,
			),
		);
		$this->dbforge->add_field($orangtua_fields);
		$this->dbforge->create_table('orangtua',TRUE);
	}

	public function down()
	{}
}