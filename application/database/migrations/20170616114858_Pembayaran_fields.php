<?php

defined('BASEPATH') OR exit('No Direct Script Access Allowed');

class Migration_Pembayaran_fields extends CI_Migration 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		/**
		 * create pembayaran table
		 */
		$pembayaran_fields = array(
			'id_bayar' => array(
				'type' => 'VARCHAR',
				'constraint' => 40,
				'null' => FALSE,
			),
			'nim' => array(
				'type' => 'VARCHAR',
				'constraint' => 40,
				'null' => FALSE,
			),
			'tgl_bayar' => array(
				'type' => 'DATE',
				'null' => FALSE,
			),
		);
		$this->dbforge->add_field($pembayaran_fields);
		$this->dbforge->add_key('id_bayar',TRUE);
		$this->dbforge->create_table('pembayaran',TRUE);

		/**
		 * create det_bayar_spi table
		 */
		$det_bayar_spi_fields = array(
			'id_bayar' => array(
				'type' => 'VARCHAR',
				'constraint' => 40,
				'null' => FALSE,
			),
			'cicilan' => array(
				'type' => 'INT',
				'null' => FALSE,
			),
			'nominal' => array(
				'type' => 'INT',
				'null' => FALSE,
			),
		);
		$this->dbforge->add_field($det_bayar_spi_fields);
		$this->dbforge->create_table('det_bayar_spi',TRUE);
		
		/**
		 * create det_bayar_spi table
		 */
		$det_bayar_semester_fields = array(
			'id_bayar' => array(
				'type' => 'VARCHAR',
				'constraint' => 40,
				'null' => FALSE,
			),
			'semester' => array(
				'type' => 'ENUM("1","2","3","4","5","6","7","8")',
				'null' => FALSE,
			),
			'cicilan' => array(
				'type' => 'INT',
				'null' => FALSE,
			),
			'nominal' => array(
				'type' => 'INT',
				'null' => FALSE,
			),
		);
		$this->dbforge->add_field($det_bayar_semester_fields);
		$this->dbforge->create_table('det_bayar_semester',TRUE);
	}

	public function down()
	{}
}