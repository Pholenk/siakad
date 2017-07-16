<?php

defined('BASEPATH') OR exit('No Direct Script Access Allowed');

class Migration_Uangkuliah_fields extends CI_Migration 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		/**
		 * create Uangkuliah table
		 */
		$Uangkuliah_fields = array(
			'id_uangkuliah' => array(
				'type' => 'VARCHAR',
				'constraint' => 40,
				'null' => FALSE,
			),
			'nominal' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
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
		$this->dbforge->add_field($Uangkuliah_fields);
		$this->dbforge->add_key('id_uangkuliah',TRUE);
		$this->dbforge->create_table('uangkuliah',TRUE);

		/**
		 * create tenggat_bayar table
		 */
		$tenggat_bayar_fields = array(
			'id_uangkuliah' => array(
				'type' => 'VARCHAR',
				'constraint' => 40,
				'null' => FALSE,
			),
			'tgl_buka' => array(
				'type' => 'DATE',
				'null' => FALSE,
			),
			'tgl_tutup' => array(
				'type' => 'DATE',
				'null' => FALSE,
			),
		);
		$this->dbforge->add_field($tenggat_bayar_fields);
		$this->dbforge->create_table('tenggat_bayar',TRUE);
	}

	public function down()
	{}
}