<?php

defined('BASEPATH') OR exit('No Direct Script Access Allowed');

class Migration_Jurusan_fields extends CI_Migration 
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
		$jurusan_fields = array(
			'id_jurusan' => array(
				'type' => 'VARCHAR',
				'constraint' => 40,
				'null' => FALSE,
			),
			'kode_jurusan' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'null' => FALSE,
			),
			'nama' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
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
		$this->dbforge->add_field($jurusan_fields);
		$this->dbforge->add_key('id_jurusan',TRUE);
		$this->dbforge->create_table('jurusan',TRUE);
	}

	public function down()
	{}
}