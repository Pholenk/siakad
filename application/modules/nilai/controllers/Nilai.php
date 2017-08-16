<?php

class Nilai extends MX_Controller
{
	// declared variable
	private $_access;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('nilaiModel');
		$this->load->module('mahasiswa');
		$this->load->module('ajar');
		$this->_access = $this->session->job;
	}

	public function index()
	{
		if ($this->_access === 'Dosen')
		{
			$data['ajars'] = $this->ajar->_browse($this->session->username);
			
			$this->_show('browse', $data);
		}		
		else
		{
			redirect(base_url('/auth/logout'));
		}
	}

	/**
	 * browse
	 * show list of nilai
	 * @return mixed
	 */
	public function browse()
	{
		if ($this->_access === 'Dosen')
		{
			$nilais = $this->nilaiModel->browse(substr($this->input->post('matakuliah'),1),$this->input->post('jenis'), $this->input->post('kelas'));
			$mahasiswas = $this->mahasiswa->_browse($this->input->post('kelas'), substr($this->input->post('matakuliah'),0,1));
	
			$pengambilans = $this->nilaiModel->getPengambilan(substr($this->input->post('matakuliah'),1), $this->input->post('kelas'), substr($this->input->post('matakuliah'),0,1));
			// print_r($nilais);
			echo "
				<table class='table table-hover' style='margin-top:1%;border:none;'>
				<thead>
				<tr>
				<th ".($this->input->post('jenis') === 'nilai_lain' ? 'rowspan=2' : '')." style='text-align:center;vertical-align:middle'>Mahasiswa</th>
				<th ".($this->input->post('jenis') === 'nilai_lain' ? 'rowspan=2' : '')." style='text-align:center;vertical-align:middle'>Kelas</th>
				<th ".($this->input->post('jenis') === 'nilai_lain' ? 'rowspan=2' : '')." style='text-align:center;vertical-align:middle'>Semester</th>
				<th ".($this->input->post('jenis') === 'nilai_lain' ? 'colspan=4' : '')." style='text-align:center'>Nilai</th>
				</tr>";
			if ($this->input->post('jenis') === 'nilai_lain')
			{
				echo "<tr>";
				foreach ($pengambilans as $pengambilan)
				{
					echo "<th style='text-align:center'>Q".$pengambilan->pengambilan."</th>";
				}
				echo "</tr>";
			}
			echo "
				</thead>
				<tbody id='ajar-data'>";
				foreach ($mahasiswas as $mahasiswa)
				{
					echo"
					<tr>
					<td style=>".$mahasiswa->nama."</td>
					<td style='text-align:center'>".$mahasiswa->kelas."</td>
					<td style='text-align:center'>".$mahasiswa->semester."</td>";
					foreach ($nilais as $nilai)
					{
						if ($mahasiswa->nim === $nilai->nim)
						{
							echo"<td style='text-align:center;'>".$nilai->nilai."</td>";
						}
					}
				}
				echo"
				</tr>
				</tbody>
				</table>
			";
		}
		else
		{
			redirect(base_url('/auth/logout'));
		}
		
	}

	/**
	 * read
	 * search data use fullname or read data use single username user
	 * @param string type
	 * @param string username or fullname
	 * @return mixed
	 */
	public function read()
	{
		if ($this->_access === 'Dosen')
		{
			if (!empty($this->input->post('jenis')))
			{
				$nilais = $this->nilaiModel->browse(substr($this->input->post('matakuliah'),1), $this->input->post('jenis'), $this->input->post('kelas'), $this->input->post('pengambilan'));
				$mahasiswas = $this->mahasiswa->_browse($this->input->post('kelas'), substr($this->input->post('matakuliah'), 0, 1));

				if (!empty($nilais))
				{
					echo "
						<div  class='box' style='margin-top:1%;padding:0 2% 2% 2%;'>
	            		<div class='box-body form-horizontal'>
						<div class='col-xs-12'>";
					foreach ($mahasiswas as $mahasiswa)
					{
	                	echo"
		                	<div class='form-group'>
							<label class='col-xs-5 control-label' style='text-align: left;'>".$mahasiswa->nama."</label>
							<div class='col-xs-6'>
							<input name='nilai_".str_replace('.','',$mahasiswa->nim)."' type='number' min=0.00 max=100.00 step=0.01 class='form-control' id='nilai_edit'";
						foreach ($nilais as $nilai)
						{
							if ($mahasiswa->nim === $nilai->nim)
							{
								echo "value='".$nilai->nilai."'";
							}
						}
					echo "
						required>
	                	</div>
						</div>";
					}
				}
				else
				{
					echo "
						<div  class='box' style='margin-top:1%;padding:0 2% 2% 2%;'>
	            		<div class='box-body form-horizontal'>
						<div class='col-xs-12'>
						<div class='alert alert-danger'><span class='fa fa-exclamation'></span> &nbsp; Data nilai tidak ada!</div>
						";
				}
				
			}
			else
			{
				$data['ajars'] = $this->ajar->_browse($this->session->username);
				$this->_show('edit',$data);
			}
		}
		else
		{
			echo "!LOGIN";
			redirect(base_url('/auth/logout'));
		}
		
	}

	/**
	 * edit
	 * edit data from a single username of user
	 * @param string username
	 * @return string
	 */
	public function edit()
	{
		if ($this->_access === 'Dosen')
		{
			$status = 'FALSE';
			if (!empty($this->input->post('jenis')))
			{
				$jenis = $this->input->post('jenis');
				$id_ajar = $this->input->post('matakuliah');
				$mahasiswas = $this->mahasiswa->_browse($this->input->post('kelas'), substr($id_ajar, 0, 1));
				$pengambilan = $this->input->post('pengambilan');
				$nilaiData = array(
					'id_ajar'=> substr($id_ajar,1),
				);
				($jenis === 'nilai_lain' ? $nilaiData['pengambilan'] = $pengambilan : '');
				$this->db->trans_begin();
				foreach ($mahasiswas as $mahasiswa)
				{
					$nilaiData['nim'] = $mahasiswa->nim;

					$nilai = $this->input->post('nilai_'.str_replace('.','',$mahasiswa->nim));

					if($this->nilaiModel->dataExists($jenis, $nilaiData) === 1)
					{
						$status = ($this->nilaiModel->edit($jenis, $nilaiData['id_ajar'], $nilaiData['nim'], $nilai, ($jenis === 'nilai_lain' ? $nilaiData['pengambilan'] = $pengambilan : '')) === TRUE ? 'TRUE' : 'FALSE');
					}
					else
					{
						$status = 'ERROR';
					}
				// print_r($this->input->post('nilai_'.str_replace('.','',$mahasiswa->nim)));
				}
				($this->db->trans_status() === TRUE ? $this->db->trans_commit() : $this->db->trans_rollback());
				echo $status;//$this->nilaiModel->dataExists($this->input->post('jenis'), $nilaiData);//
			}
			else
			{
				echo $status;//$this->nilaiModel->dataExists($this->input->post('jenis'), $nilaiData);//
				// echo $this->input->post('jenis');
			}
		}
		else
		{
			echo "!LOGIN";
			redirect(base_url('/auth/logout'));
		}
	}

	/**
	 * add
	 * add new data of user
	 * @param string username
	 * @return mixed
	 */
	public function add($fill = 'FALSE')
	{
		if ($this->_access === 'Dosen')
		{
			if (!empty($this->input->post('jenis')))
			{
				$id_ajar = $this->input->post('matakuliah');
				$mahasiswas = $this->mahasiswa->_browse($this->input->post('kelas'), substr($id_ajar, 0, 1));

				if ($fill === 'TRUE')
				{
					$pengambilan = $this->_lastPengambilan(substr($id_ajar,1), $this->input->post('kelas'), substr($id_ajar, 0, 1));
					$status = 'FALSE';
					$this->db->trans_begin();
					foreach ($mahasiswas as $mahasiswa)
					{
						$nilaiData = array(
							'id_ajar'=> substr($id_ajar,1),
							'nim' => $mahasiswa->nim,
						);
						if($this->input->post('jenis') === 'nilai_lain')
						{
							$nilaiData['pengambilan'] = $pengambilan;
						}
						if($this->nilaiModel->dataExists($this->input->post('jenis'), $nilaiData) === 0)
						{
							$nilaiData['nilai'] = $this->input->post('nilai_'.str_replace('.','',$mahasiswa->nim));
							$status = ($this->nilaiModel->add($this->input->post('jenis'), $nilaiData) ? 'TRUE' : 'FALSE');
						}
						else
						{
							$status = 'ERROR';
						}
					}
					($this->db->trans_status() === TRUE ? $this->db->trans_commit() : $this->db->trans_rollback());
					echo $status;
				}
				else
				{
					echo "
						<div  class='box' style='margin-top:1%;padding:0 2% 2% 2%;'>
	            		<div class='box-body form-horizontal'>
						<div class='col-xs-12'>";
					foreach ($mahasiswas as $mahasiswa)
					{
	                	echo"
		                	<div class='form-group'>
							<label class='col-xs-5 control-label' style='text-align: left;'>".$mahasiswa->nama."</label>
							<div class='col-xs-6'>
		                	<input name='nilai_".str_replace('.','',$mahasiswa->nim)."' type='number' min=0.00 max=100.00 step=0.01 class='form-control' id='nilai_add' required>
		                	</div>
							</div>";
					}
				}
			}
			else
			{
				$data['ajars'] = $this->ajar->_browse($this->session->username);
				echo $this->_show('add',$data);
			}
		}
		else
		{
			echo "!LOGIN";
			redirect(base_url('/auth/logout'));
		}
	}

	/**
	 * fix it
	 * delete
	 * delete user data by username
	 * @param string username
	 */
	public function delete($id_nilai)
	{
		if ($this->_access === 'Dosen')
		{
			if ($this->nilaiModel->dataExists('nilai', array('id_nilai' => $id_nilai)) === 1)
			{
				echo ($this->nilaiModel->delete($id_nilai) === TRUE ? 'TRUE' : 'FALSE');
			}
			else
			{
				echo "ERROR";
			}
		}
		else
		{
			echo "!LOGIN";
			redirect(base_url('/auth/logout'));
		}
	}

	/**
	 * show
	 */
	private function _show($page='', $data='')
	{
		$this->load->view('head');
		$this->load->view('navbar');
		$this->load->view('sidebar/dosen');
		$this->load->view($page, $data);
		$this->load->view('foot');
	}

	public function getKelas($id_ajar)
	{
		if ($this->_access === 'Dosen')
		{
			$kelas = $this->ajar->_readKelas($id_ajar);
			foreach ($kelas as $kelass)
			{
				$options = explode(',', $kelass->kelas);
				foreach ($options as $option => $optionValue)
				{
					echo "<option value='".$optionValue."'>".$optionValue."</option>";
				}
			}
		}		
		else
		{
			echo "!LOGIN";
			redirect(base_url('/auth/logout'));
		}
	}

	public function getPengambilan($id_ajar,$kelas, $semester)
	{
		$pengambilans = $this->nilaiModel->getPengambilan($id_ajar, $kelas, $semester);
		foreach ($pengambilans as $pengambilan)
		{
			echo "<option></option>";
			echo "<option value='".$pengambilan->pengambilan."'> Q".$pengambilan->pengambilan."</option>";
		}
	}

	function _lastPengambilan($id_ajar,$kelas, $semester)
	{
		$pengambilan = $this->nilaiModel->maxPengambilan($id_ajar, $kelas, $semester);
		return $pengambilan+1;
	}
}