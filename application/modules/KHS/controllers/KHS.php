<?php

class KHS extends MX_Controller
{
	// declared variable
	private $_access;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('khsModel');
		$this->load->module('matakuliah');
		$this->load->module('ajar');
		$this->_access = $this->session->job;
	}

	public function index()
	{
		if ($this->_access === 'Mahasiswa')
		{
			$data['data_diri'] = $this->browse();
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
		if ($this->_access === 'Mahasiswa')
		{
			return $this->khsModel->selfData($this->session->username);
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
		if ($this->_access === 'Mahasiswa')
		{
			if (!empty($this->input->post('semester')))
			{
				$jumlah_sks = 0;
				$jumlah_nilai_mutu = 0;
				$matakuliahs = $this->khsModel->data_matakuliah($this->input->post('semester'));
				$i = 1;
				if(!empty($matakuliahs))
				{
					echo "
						<table class='table table-responsive'>
						<thead>
						<tr>
						<th style='padding:10px;text-align:center;'>No.</th>
						<th style='padding:10px;text-align:center;'>KODE MK</th>
						<th style='padding:10px;text-align:center;'>MATA KULIAH</th>
						<th style='padding:10px;text-align:center;'>SKS</th>
						<th style='padding:10px;text-align:center;word-wrap:break-word'>NILAI HURUF</th>
						<th style='padding:10px;text-align:center;word-wrap:break-word'>NILAI MUTU</th>
						</tr>
						</thead>
						<tbody>
					";
					foreach ($matakuliahs as $matakuliah) {
						$nilai_real = $this->khsModel->nilai_matakuliah($this->session->username, $matakuliah->id_ajar);
						$nilai_akhir = $this->khsModel->konversi_nilai($nilai_real);
						echo "
							<tr>
							<td style='padding:10px;text-align:center;'>".$i."</td>
							<td style='padding:10px;text-align:center;'>".$matakuliah->id_matakuliah."</td>
							<td style='padding:10px;text-align:center;'>".$matakuliah->nama."</td>
							<td style='padding:10px;text-align:center;'>".$matakuliah->sks."</td>
							<td style='padding:10px;text-align:center;'>".$nilai_akhir[0]."</td>
							<td style='padding:10px;text-align:center;'>".$nilai_akhir[1] * $matakuliah->sks."</td>
							</tr>
						";
						$jumlah_sks += $matakuliah->sks;
						$jumlah_nilai_mutu += $nilai_akhir[1] * $matakuliah->sks;
						$i++;
					}
					echo"
						<tr>
						<td></td>
						</tr>
						<tr>
						<td colspan='3' style='padding:10px;text-align:center;'>JUMLAH : </td>
						<td style='padding:10px;text-align:center;'>".$jumlah_sks."</td>
						<td style='padding:10px;text-align:right;'></td>
						<td style='padding:10px;text-align:center;'>".$jumlah_nilai_mutu."</td>
						<td style='padding:10px;text-align:right;'></td>
						</tr>
						<tr>
						<td colspan='2' style='padding:10px;text-align:left;'>INDEKS PRESTASI SEMESTER ".$this->input->post('semester')."</td>
						<td colspan='5' style='padding:10px;text-align:left;'> : ".$jumlah_nilai_mutu / $jumlah_sks."</td>
						</tr>
						<tr>
						<td colspan='2' style='padding:10px;text-align:left;'>INDEKS PRESTASI KUMULATIF</td>
						<td colspan='5' style='padding:10px;text-align:left;'> : ".$this->_ipk()."</td>
						</tr>
						<tr>
						<td colspan='2' style='padding:10px;text-align:left;'>STATUS KELULUSAN</td>
						<td colspan='5' style='padding:10px;text-align:left;'> : LULUS </td>
						</tr>
						</tbody>
						</table>
						";
				}
				else
				{
					echo "Maaf data tidak ditemukan";
				}
			}
		}
		else
		{
			echo "!LOGIN";
			redirect(base_url('/auth/logout'));
		}
	}

	/**
	 * count indeks prestasi kumulatif
	 * @return float ipk
	 */
	function _ipk()
	{
		// call all data as needed
		$mahasiswa = $this->browse();

		// declared all variable that may be use
		$jumlah_sks = 0;
		$jumlah_nilai_mutu = 0;
		$ip = 0;
		$ipk = 0;
		$semester = 0;

		// this array use for collect all data indeks prestasi from every semester
		$ips = array();

		foreach ($mahasiswa as $data)
		{
			$semester = $data->semester;

			// count all score from every matakuliah on a semester
			for ($i=1; $i <= $semester;)
			{
				$data_matakuliah = $this->khsModel->data_matakuliah($i);

				// make sure the array object that we use in looping statement is not empty
				if (!empty($data_matakuliah))
				{
					foreach ($data_matakuliah as $matakuliah)
					{
						$nilai_real = $this->khsModel->nilai_matakuliah($this->session->username, $matakuliah->id_ajar);
						$nilai_akhir = $this->khsModel->konversi_nilai($nilai_real);
						$jumlah_sks += $matakuliah->sks;
						$jumlah_nilai_mutu += $nilai_akhir[1] * $matakuliah->sks;
						$ip = $jumlah_nilai_mutu / $jumlah_sks;
					}
				}

				// inserting data to array so we can sumarize at the end of this process
				array_push($ips, $ip);
				$i++;
			}

		}
		$ipk = array_sum($ips) / $semester;
		return $ipk;
	}

	/**
	 * show
	 */
	private function _show($page='', $data='')
	{
		$this->load->view('head');
		$this->load->view('navbar');
		$this->load->view('sidebar/mahasiswa');
		$this->load->view($page, $data);
		$this->load->view('foot');
	}
}