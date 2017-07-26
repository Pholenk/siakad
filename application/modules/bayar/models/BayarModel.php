<?php

/**
* 
*/
class BayarModel extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * @inherit doc
	 */
	public function browse($tipe)
	{
		$this->db->select('pembayaran.id_bayar');
		$this->db->select('mahasiswa.nama as mahasiswa');
		$this->db->select('pembayaran.tgl_bayar');
		$this->db->from('pembayaran');
		$this->db->join('mahasiswa', 'mahasiswa.nim = pembayaran.nim');
		if ($tipe === 'uangkuliah')
		{
			$this->db->select('det_bayar_semester.semester');
			$this->db->select('det_bayar_semester.cicilan');
			$this->db->select('det_bayar_semester.nominal');
			$this->db->join('det_bayar_semester', 'det_bayar_semester.id_bayar = pembayaran.id_bayar');
		}
		elseif ($tipe === 'SPI')
		{
			$this->db->select('det_bayar_spi.cicilan');
			$this->db->select('det_bayar_spi.nominal');
			$this->db->join('det_bayar_spi', 'det_bayar_spi.id_bayar = pembayaran.id_bayar');
		}
		
		$query = $this->db->get();
		
		return $query->result();
	}

	/**
	 * @inherit doc
	 */
	public function read($id_bayar)
	{
		$this->db->select('*')->from('pembayaran');
		$this->db->where('id_bayar', $id_bayar);
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * @inherit doc
	 */
	public function edit($id_bayar, $bayarData, $tenggatData)
	{
		$this->db->where('id_bayar', $id_bayar);
		return($this->db->update('pembayaran', $bayarData) ? TRUE : FALSE);
	}

	/**
	 * @inherit doc
	 */
	public function add($tipe, $bayarData, $detailBayar)
	{
		if($this->db->insert('pembayaran', $bayarData))
		{
			$table = ($tipe === 'uangkuliah' ? 'det_bayar_semester' : 'det_bayar_spi');
			return ($this->db->insert($table, $detailBayar) ? TRUE : FALSE);
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * @inherit doc
	 */
	public function delete($table, $id_bayar)
	{
		if ($this->db->delete($table, array('id_bayar' => $id_bayar)))
		{
			return($this->db->delete('pembayaran',array('id_bayar' => $id_bayar)) ? TRUE : FALSE);
		}
		else
		{
			return FALSE;
		}
		
	}

	/**
	 * check the existence of data in specified table using specified parameter
	 * @param string table
	 * @param mixed data
	 * @return bool
	 */
	public function detailExists($table, $data)
	{
		$this->db->from('pembayaran')
			 ->join($table, 'pembayaran.id_bayar='.$table.'.id_bayar');
		$this->db->where($table.'.cicilan', $data['cicilan']);
		$this->db->where('pembayaran.nim', $data['nim']);
		if($table === 'det_bayar_semester')
		{
			$this->db->where('det_bayar_semester.semester', $data['semester']);
		}
		$query = $this->db->get();
		$queryStats = ($query->num_rows() > 0 ? 1 : 0);
		return $queryStats;
		// return $query->num_rows();
	}

	/**
	 * check the existence of data in specified table using specified parameter
	 * @param string table
	 * @param mixed data
	 * @return bool
	 */
	public function dataExists($table, $id_bayar)
	{
		$this->db->from('pembayaran')
			 ->join($table, 'pembayaran.id_bayar='.$table.'.id_bayar');
		$this->db->where('pembayaran.id_bayar', $id_bayar);
		$query = $this->db->get();
		$queryStats = ($query->num_rows() > 0 ? 1 : 0);
		return $queryStats;
		// return $query->num_rows();
	}

	/**
	 * generate new id_ajar
	 * @return string id_ajar
	 */
	public function genID($tipe)
	{
		$result = $this->_getLastID($tipe)->id;
		if($result <= 0)
		{
			$id_ajar = ($tipe ==='uangkuliah' ? 'UKT0001' : 'SPI0001');
			return $id_ajar;
		}
		elseif($result > 0 && $result < 9)
		{
			$id_ajar = $result+1;
			return ($tipe ==='uangkuliah' ? 'UKT000' : 'SPI000').$id_ajar;
		}
		elseif($result > 8 && $result < 99)
		{
			$id_ajar = $result+1;
			return ($tipe ==='uangkuliah' ? 'UKT00' : 'SPI00').$id_ajar;
		}
		elseif($result > 98 && $result < 999)
		{
			$id_ajar = $result+1;
			return ($tipe ==='uangkuliah' ? 'UKT0' : 'SPI0').$id_ajar;
		}
		elseif ($result > 998 && $result < 9999) {
			$id_ajar = $result+1;
			return ($tipe ==='uangkuliah' ? 'UKT' : 'SPI').$id_ajar;
		}
	}

	/**
	 * retrieve biggest id from presistence storage
	 * @param string tipe
	 * @return mixed
	 */
	function _getLastID($tipe)
	{
		$this->db->select('SUBSTRING(max(id_bayar),4,4) as id', FALSE)->from(($tipe === 'uangkuliah' ? 'det_bayar_semester' : 'det_bayar_spi'));
		$query = $this->db->get();
		return $query->row();
	}

	/**
	 * retrieve date of transaction from presistence storage
	 * @param string tipe
	 * @param string nim
	 * @param int cicilan
	 * @param string semester (this can be set for null value)
	 * @return date result
	 */
	public function dateTransaction($tipe, $data)
	{
		$this->db->select('pembayaran.tgl_bayar')
		->from('pembayaran')
		->join(($tipe === 'uangkuliah' ? 'det_bayar_semester' : 'det_bayar_spi'), ($tipe === 'uangkuliah' ? 'det_bayar_semester.id_bayar = pembayaran.id_bayar' : 'det_bayar_spi.id_bayar = pembayaran.id_bayar'));
		$this->db->where('pembayaran.nim', $data['nim']);
		$this->db->where(($tipe === 'uangkuliah' ? 'det_bayar_semester.cicilan' : 'det_bayar_spi.cicilan'), $data['cicilan']);
		if($tipe === 'uangkuliah')
		{
			$this->db->where('det_bayar_semester.semester', $data['semester']);
		}
		$result = $this->db->get()->row();
		return $result->tgl_bayar;
	}
}