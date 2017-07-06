<?php

defined('BASEPATH') OR exit('No Direct Script Access Allowed');

class Migration_Mahasiswa_fields extends CI_Migration 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		/**
		 * create mahasiswa table
		 */
		$mahasiswa_fields = array(
			'nim' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE,
			),
			'id_jurusan' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE,
			),
			'id_uangkuliah' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE,
			),
			'nama' => array(
				'type' => 'VARCHAR',
				'constraint' => 150,
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
			'kelas' => array(
				'type' => 'VARCHAR',
				'constraint' => 4,
				'null' => FALSE,
			),
			'alamat' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => 150,
				'null' => FALSE,
			),
			'semester' => array(
				'type' => 'ENUM("1","2","3","4","5","6","7","8","LULUS")',
				'default' => '1',
				'null' => FALSE,
			),
			'status' => array(
				'type' => 'ENUM("aktif","cuti")',
				'default' => 'aktif',
				'null' => FALSE,
			),
			'spi' => array(
				'type' => 'INT',
				'constraint' => 150,
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
		$this->dbforge->add_field($mahasiswa_fields);
		$this->dbforge->add_key('nim',TRUE);
		$this->dbforge->create_table('mahasiswa',TRUE);
	}

	public function down()
	{}
}