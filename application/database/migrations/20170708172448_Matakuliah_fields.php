<?php

defined('BASEPATH') OR exit('No Direct Script Access Allowed');

class Migration_Matakuliah_fields extends CI_Migration 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		/**
		 * create jurusan table
		 */
		$matakuliah_fields = array(
			'id_matakuliah' => array(
				'type' => 'VARCHAR',
				'constraint' => 40,
				'null' => FALSE,
			),
			'nama' => array(
				'type' => 'VARCHAR',
				'constraint' => 80,
				'null' => FALSE,
			),
			'sks' => array(
				'type' => 'INT',
				'null' => FALSE,
			),
			'semester' => array(
				'type' => 'ENUM("1","2","3","4","5","6","7","8")',
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
		$this->dbforge->add_field($matakuliah_fields);
		$this->dbforge->add_key('id_matakuliah',TRUE);
		$this->dbforge->create_table('matakuliah',TRUE);
	}

	public function down()
	{}
}