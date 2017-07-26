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
			$nilais = $this->nilaiModel->browse($this->input->post('matakuliah'),$this->input->post('jenis'), $this->input->post('kelas'));
			$mahasiswas = $this->mahasiswa->_browse($this->input->post('kelas'));
	
			if ($this->input->post('jenis') === 'nilai_lain')
			{
				$pengambilans = $this->nilaiModel->getPengambilan($this->input->post('matakuliah'), $this->input->post('kelas'));
				// print_r($nilais);
				echo "
					<table class='table table-hover' style='margin-top:1%;border:none;'>
					<thead>
					<tr>
					<th rowspan='2' style='text-align:center;vertical-align:middle'>Mahasiswa</th>
					<th rowspan='2' style='text-align:center;vertical-align:middle'>Kelas</th>
					<th rowspan='2' style='text-align:center;vertical-align:middle'>Semester</th>
					<th colspan='4' style='text-align:center'>Nilai</th>
					</tr>
					<tr>";
					foreach ($pengambilans as $pengambilan)
					{
						echo "<th style='text-align:center'>Q".$pengambilan->pengambilan."</th>";
					}
					echo "
					</tr>
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
				echo "
					<table class='table table-hover' style='margin-top:1%;border:none;'>
					<thead>
					<tr>
					<th style='text-align:center;'>Mahasiswa</th>
					<th style='text-align:center;'>Kelas</th>
					<th style='text-align:center;'>Semester</th>
					<th style='text-align:center;'>Nilai</th>
					</tr>
					<tr>
					</tr>
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
								echo "<td style='text-align:center;'>".$nilai->nilai."</td>";
							}
						}
					}
					echo "
					</tr>
					</tbody>
					</table>
				";
			}
			
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
			$mahasiswas = $this->mahasiswa->_browse($this->input->post('kelas'));
			$tabel = $this->input->post('jenis');
			$parameterNilai['id_ajar'] = $this->input->post('matakuliah');
			if ($tabel === 'nilai_lain')
			{
				$parameterNilai['pengambilan'] = $this->input->post('pengambilan');
			}
			$exist = FALSE;
			// echo "<pre>";
			// print_r($this->nilaiModel->dataExists($tabel, $parameterNilai));
			// echo "</pre>";
			foreach ($mahasiswas as $mahasiswa)
			{
				$parameterNilai['nim'] = $mahasiswa->nim;
				if ($this->nilaiModel->dataExists($tabel, $parameterNilai) === 1)
				{
					$exist = TRUE;
				}
			}

			if ($exist === TRUE)
			{
				$nilais = $this->nilaiModel->browse($this->input->post('matakuliah'),$this->input->post('jenis'), $this->input->post('kelas'), $this->input->post('pengambilan'));
				echo "
				<div class='box' style='margin-top:2%;'>
                <div class='box-body'>
				<table class='table table-hover' style='margin-top:1%;border:none;'>
				<thead>
				<tr>
				<th style='text-align:center;'>Mahasiswa</th>
				<th style='text-align:center;'>Kelas</th>
				<th style='text-align:center;'>Semester</th>
				<th style='text-align:center;'>Nilai</th>
				</tr>
				<tr>
				</tr>
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
							echo "<td style='text-align:center;'>".$nilai->nilai."</td>";
						}
					}
				}
				echo "
				</tr>
				</tbody>
				</table>
				</div>
				</div>
				";
			}
			else
			{
				echo "
				<div class='callout callout-danger'>
				<h4><i class='fa fa-exclamation'></i> Warning</h4>
				<p>
				Data nilai tidak ditemukan.
				</p>
				</div>";
			}
		}
		else
		{
			echo "!LOGIN";
		}
		
	}

	/**
	 * edit
	 * edit data from a single username of user
	 * @param string username
	 * @return string
	 */
	public function edit($id_nilai)
	{
		if ($this->_access === 'Dosen')
		{
			if ($this->nilaiModel->dataExists('nilai', array('id_nilai' => $id_nilai)) === 0)
			{
				$nilaiData = array(
					'nama' => $this->input->post('namanilai'),
					'sks' => $this->input->post('sks'),
					'semester' => $this->input->post('semester'),
					'edited_at' => mdate('%Y-%m-%d', now()),
				);
				echo ($this->nilaiModel->edit($id_nilai, $nilaiData) === TRUE ? 'TRUE' : 'FALSE');
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
	 * add
	 * add new data of user
	 * @param string username
	 * @return mixed
	 */
	public function add($fill = 'FALSE')
	{
		if ($this->_access === 'Dosen')
		{
			// $id_ajar = '',$kelas = '',$jenis = '',$fill = 'FALSE'
			if (!empty($this->input->post('kelas')))
			{
				$mahasiswas = $this->mahasiswa->_browse($this->input->post('kelas'));

				if ($fill === 'TRUE')
				{
					$id_ajar = $this->input->post('matakuliah');
					if($this->input->post('jenis') === 'nilai_lain')
					{
						$nilaiData['pengambilan'] = $this->_lastPengambilan($id_ajar, $this->input->post('kelas'));
					}
					$this->db->trans_begin();
					foreach ($mahasiswas as $mahasiswa)
					{
						$nilaiData = array(
							'id_ajar'=> $id_ajar,
							'nim' => $mahasiswa->nim,
							'nilai' => $this->input->post('nilai_'.str_replace('.','',$mahasiswa->nim)),
						);
						// echo str_replace('.','',$mahasiswa->nim).' => '.$this->input->post('nilai_'.str_replace('.','',$mahasiswa->nim)).',';
						$this->nilaiModel->add($this->input->post('jenis'), $nilaiData);
					}
					($this->db->trans_status() === TRUE ? $this->db->trans_commit() : $this->db->trans_rollback());
					// echo $this->db->trans_status();
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
		                	<input name='nilai_".str_replace('.','',$mahasiswa->nim)."' type='text' class='form-control' id='nilai_add' required>
		                	</div>
							</div>";
					}
				}
			}
			else
			{
				$data['ajars'] = $this->ajar->_browse($this->session->username);
				$data['mahasiswas'] = $this->mahasiswa->_browse($this->input->post('kelas'));
				$this->load->view('add', $data);
				// echo $this->_show('add',$data);
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

	function _lastPengambilan($id_ajar,$kelas)
	{
		$pengambilan = $this->nilaiModel->maxPengambilan($id_ajar, $kelas);
		return $pengambilan+1;
	}
}