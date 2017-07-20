<?php

/**
* 
*/
class AjarModel extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * @inherit doc
	 */
	public function browse()
	{
		$this->db->select('ajar.id_ajar,ajar.id_dosen,dosen.nama as nama_dosen,ajar.id_matakuliah,matakuliah.nama as nama_matakuliah,ajar.kelas')
		->from('ajar');
		$this->db->join('dosen', 'ajar.id_dosen = dosen.id_dosen');
		$this->db->join('matakuliah', 'ajar.id_matakuliah = matakuliah.id_matakuliah');
		$this->db->where('dosen.deleted_at is Null');
		$this->db->where('ajar.deleted_at is Null');
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * @inherit doc
	 */
	public function read($id_ajar)
	{
		$this->db->select('*')->from('ajar');
		$this->db->where('id_ajar', $id_ajar);
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * @inherit doc
	 */
	public function edit($id_ajar, $ajarData)
	{
		$this->db->where('id_ajar', $id_ajar);
		return($this->db->update('ajar', $ajarData) ? TRUE : FALSE);
	}

	/**
	 * @inherit doc
	 */
	public function add($ajarData)
	{
		return ($this->db->insert('ajar', $ajarData) ? TRUE : FALSE);
	}

	/**
	 * @inherit doc
	 */
	public function delete($id_ajar)
	{
		$this->db->where('id_ajar', $id_ajar);
		return($this->db->update('ajar',array('deleted_at' => mdate('%Y-%m-%d', now()))) ? TRUE : FALSE);
	}

	/**
	 * check the existence of data
	 * @param string table
	 * @param mixed data
	 * @return bool
	 */
	public function dataExists($table, $data)
	{
		$this->db->where('deleted_at is Null');
		$this->db->where($data);
		$query = $this->db->get($table);
		$queryStats = ($query->num_rows() > 0 ? 1 : 0);
		return $queryStats;
		// return $query->num_rows();
	}

	/**
	 * generate new id_ajar
	 * @return string id_ajar
	 */
	public function genID()
	{
		$result = $this->_getLastID()->id;
		if($result <= 0)
		{
			$id_ajar = 'A0001';
			return $id_ajar;
		}
		elseif($result > 0 && $result < 9)
		{
			$id_ajar = $result+1;
			return 'A000'.$id_ajar;
		}
		elseif($result > 8 && $result < 99)
		{
			$id_ajar = $result+1;
			return 'A00'.$id_ajar;
		}
		elseif($result > 98 && $result < 999)
		{
			$id_ajar = $result+1;
			return 'A0'.$id_ajar;
		}
		elseif ($result > 998 && $result < 9999) {
			$id_ajar = $result+1;
			return 'A'.$id_ajar;
		}
	}

	/**
	 * retrieve biggest id from presistence storage
	 */
	function _getLastID()
	{
		$this->db->select('SUBSTRING(max(id_ajar),3,4) as id', FALSE)->from('ajar');
		$query = $this->db->get();
		return $query->row();
	}
}