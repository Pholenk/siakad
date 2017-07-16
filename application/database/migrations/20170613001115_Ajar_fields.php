<?php

defined('BASEPATH') OR exit('No Direct Script Access Allowed');

class Migration_Ajar_fields extends CI_Migration 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		/**
		 * create Ajar table
		 */
		$Ajar_fields = array(
			'id_ajar' => array(
				'type' => 'VARCHAR',
				'constraint' => 40,
				'null' => FALSE,
			),
			'nidn' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE,
			),
			'id_matakuliah' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE,
			),
			'kelas' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE,
			),
		);
		$this->dbforge->add_field($Ajar_fields);
		$this->dbforge->add_key('id_ajar',TRUE);
		$this->dbforge->create_table('ajar',TRUE);

		/**
		 * create nilai_uts table
		 */
		$nilai_uts_fields = array(
			'id_ajar' => array(
				'type' => 'VARCHAR',
				'constraint' => 40,
				'null' => FALSE,
			),
			'nim' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE,
			),
			'nilai' => array(
				'type' => 'INT',
				'null' => FALSE,
			),
		);
		$this->dbforge->add_field($nilai_uts_fields);
		$this->dbforge->create_table('nilai_uts',TRUE);
		/**
		 * create nilai_uas table
		 */
		$nilai_uas_fields = array(
			'id_ajar' => array(
				'type' => 'VARCHAR',
				'constraint' => 40,
				'null' => FALSE,
			),
			'nim' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE,
			),
			'nilai' => array(
				'type' => 'INT',
				'null' => FALSE,
			),
		);
		$this->dbforge->add_field($nilai_uas_fields);
		$this->dbforge->create_table('nilai_uas',TRUE);
		/**
		 * create nilai_lain table
		 */
		$nilai_lain_fields = array(
			'id_ajar' => array(
				'type' => 'VARCHAR',
				'constraint' => 40,
				'null' => FALSE,
			),
			'nim' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE,
			),
			'pengambilan' => array(
				'type' => 'INT',
				'null' => FALSE,
			),
			'nilai' => array(
				'type' => 'INT',
				'null' => FALSE,
			),
		);
		$this->dbforge->add_field($nilai_lain_fields);
		$this->dbforge->create_table('nilai_lain',TRUE);
	}

	public function down()
	{}
}