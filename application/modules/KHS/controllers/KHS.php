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
		$this->load->library('pdf');
		$this->load->helper('download');
		$this->_access = $this->session->job;
	}

	public function index()
	{
		if ($this->_access === 'Mahasiswa')
		{
			$data['data_diri'] = $this->_browse();
			$this->_show('browse', $data);
		}
		else if ($this->_access === 'BAAK')
		{
			$data['jurusans'] = $this->khsModel->browse_jurusan();
			$this->_show('khs-menu', $data);
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
	function _browse()
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
				
				$kelas = '';
				foreach ($this->_browse() as $data)
				{
					$kelas = $data->kelas;
				}

				$matakuliahs = $this->khsModel->data_matakuliah($this->input->post('semester'), $kelas);
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
						<td colspan='5' style='padding:10px;text-align:left;'> : ".round($jumlah_nilai_mutu / $jumlah_sks, 2)."</td>
						</tr>
						<tr>
						<td colspan='2' style='padding:10px;text-align:left;'>INDEKS PRESTASI KUMULATIF</td>
						<td colspan='5' style='padding:10px;text-align:left;'> : ".$this->_ipk($this->session->username)."</td>
						</tr>
						<tr>
						<td colspan='2' style='padding:10px;text-align:left;'>STATUS KELULUSAN</td>
						<td colspan='5' style='padding:10px;text-align:left;'> : ".($jumlah_nilai_mutu / $jumlah_sks > 1.99 ? 'LULUS' : 'TIDAK LULUS')." </td>
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
	 * @param string nim
	 * @return float ipk
	 */
	function _ipk($nim)
	{
		// call all data as needed
		$mahasiswa = $this->khsModel->selfData($nim);

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
			$kelas = $data->kelas;

			// count all score from every matakuliah on a semester
			for ($i=1; $i <= $semester;)
			{
				$data_matakuliah = $this->khsModel->data_matakuliah($i, $kelas);

				// make sure the array object that we use in looping statement is not empty
				if (!empty($data_matakuliah))
				{
					foreach ($data_matakuliah as $matakuliah)
					{
						$nilai_real = $this->khsModel->nilai_matakuliah($nim, $matakuliah->id_ajar);
						$nilai_akhir = $this->khsModel->konversi_nilai($nilai_real);
						$jumlah_sks += $matakuliah->sks;
						$jumlah_nilai_mutu += $nilai_akhir[1] * $matakuliah->sks;
						$ip = ($jumlah_nilai_mutu > 0 ? $jumlah_nilai_mutu / $jumlah_sks : 0);
					}
				}

				// inserting data to array so we can sumarize at the end of this process
				array_push($ips, $ip);
				$i++;
			}

		}
		$ipk = array_sum($ips) / $semester;
		return round($ipk,2);
	}

	/**
	 * accesible or executable function for rendering document which mime type is .pdf
	 * after all data rendered successfully it will forced to download a file .zip
	 * @return void
	 */
	public function cetak()
	{
		$page = 'kartu-hasil-studi';
		$zipName = FCPATH.'/tmpfile/archieve-khs.zip';
		$zip = new ZipArchive();
		if ($zip->open($zipName, ZipArchive::CREATE) !== TRUE)
		{
			echo "zip failed";
		}

		$mahasiswas = $this->khsModel->browse_mahasiswa($this->input->post('jurusan'),$this->input->post('semester'));
		
		foreach ($mahasiswas as $mahasiswa)
		{
			$this->PDF = $this->pdf->load();
			$sumber = $this->_dataCetak($mahasiswa->nim, $page);
			$pdfName = FCPATH.'/tmpfile/KHS-'.$mahasiswa->nim.'-'.$mahasiswa->semester.'-'.$mahasiswa->kelas.'.pdf';
			$this->_pdf($sumber, $pdfName);
			if (file_exists($pdfName))
			{
				$zip->addFile($pdfName);
			}
		}
		$zip->close();
		force_download($zipName, NULL);
	}

	/**
	 * render all data into a document with mime type .pdf
	 * @void
	 */
	private function _pdf($sumber, $pdfName)
	{
		$this->PDF->AddPage("","","","","",0,0,0,0,0,0,"","","","","","","","","","A4");
		$this->PDF->WriteHTML($sumber);

		// // render all necessary file and data into pdf and forced download
		$this->PDF->Output($pdfName);
		chmod($pdfName, 0777);
	}


	/**
	 * retrieve all data as needed from single nim and fetch to page
	 * i don't even know why this function so needed if we want to render pdf file
	 * @param string nim
	 * @param string page
	 * @return string
	 */
	private function _dataCetak($nim, $page)
	{
		$mahasiswas = $this->khsModel->selfData($nim);;
		$data['self_data'] = $mahasiswas;

		foreach ($mahasiswas as $mahasiswa)
		{
			$kelas = $mahasiswa->kelas;
			$_semester = $mahasiswa->semester;
			$nilai_real = 0;
			$nilai_akhir = '';
			$ip = 0;
			$jumlah_sks = 0;
			$jumlah_nilai_mutu = 0;
			$data['kelas'] = $kelas;

			if ($_semester === '1')
			{
				$data['semester'] = 'I';
			}

			elseif ($_semester === '2' )
			{
				$data['semester'] = 'II';
			}

			elseif ($_semester === '3')
			{
				$data['semester'] = 'III';
			}

			elseif ($_semester === '4')
			{
				$data['semester'] = 'IV';
			}

			elseif ($_semester === '5')
			{
				$data['semester'] = 'V';
			}

			elseif ($_semester === '6')
			{
				$data['semester'] = 'VI';
			}

			elseif ($_semester === '7')
			{
				$data['semester'] = 'VII';
			}

			elseif ($_semester === '8')
			{
				$data['semester'] = 'VIII';
			}
			
			$matakuliahs = $this->khsModel->data_matakuliah($_semester, $kelas);
			$data['matakuliahs'] = $matakuliahs;
			$i = 1;
			foreach ($matakuliahs as $matakuliah)
			{
				$nilai_real = $this->khsModel->nilai_matakuliah($mahasiswa->nim, $matakuliah->id_ajar);
				$nilai_akhir = $this->khsModel->konversi_nilai($nilai_real);
				
				$jumlah_sks += $matakuliah->sks;
				$nilai_mutu = $nilai_akhir[1] * $matakuliah->sks;
				$jumlah_nilai_mutu += $nilai_mutu;
				$data['nilai'][''.$i] = array($nilai_akhir[0], $nilai_mutu); // huruf mutu // nilai huruf
				$i++;
			}
			$ip = ($jumlah_nilai_mutu / $jumlah_sks > 0 ? $jumlah_nilai_mutu / $jumlah_sks : 0);

			$data['jumlah_sks'] = $jumlah_sks;
			$data['jumlah_nilai_mutu'] = $jumlah_nilai_mutu;
			$data['ips'] = $ip; // ip semester
			$data['ipk'] = $this->_ipk($mahasiswa->nim); // ip kumulatif
			$data['kelulusan'] = ($ip > 1.99 ? 'LULUS' : 'TIDAK LULUS');
		}
		return $this->load->view($page,$data,TRUE);
	}

	/**
	 * show
	 */
	private function _show($page='', $data='')
	{
		$this->load->view('head');
		$this->load->view('navbar');
		$this->load->view(($this->_access === 'BAAK' ? 'sidebar/baak' : 'sidebar/mahasiswa' ));
		$this->load->view($page, $data);
		$this->load->view('foot');
	}
}