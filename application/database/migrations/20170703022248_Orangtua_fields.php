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
			'id_orangtua' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE,
			),
			'nama' => array(
				'type' => 'VARCHAR',
				'constraint' => 150,
				'null' => FALSE,
			),
			'alamat' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
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
			'jenis_kelamin' => array(
				'type' => 'ENUM("1","0")',
				'null' => FALSE,
			),
			'agama' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE,
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => 150,
				'null' => FALSE,
			),
			'telepon' => array(
				'type' => 'VARCHAR',
				'constraint' => 4,
				'null' => FALSE,
			),
			'created_at' => array(
				'type' => 'DATE',
				'null' => FALSE,
			),
			'edited_at' => array(
				'type' => 'DATE',
				'null' => TRUE,
			),
			'deleted_at' => array(
				'type' => 'DATE',
				'null' => TRUE,
			),
		);
		$this->dbforge->add_field($orangtua_fields);
		$this->dbforge->add_key('id_orangtua',TRUE);
		$this->dbforge->create_table('orangtua',TRUE);
	}

	public function down()
	{}
}