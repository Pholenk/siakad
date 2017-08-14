<?php

class Ledger extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ledgerModel');
		$this->load->library('pdf');
		$this->load->helper('download');
	}

	public function index()
	{
		if ($this->session->job === 'BAAK')
		{
			$data['jurusans'] = $this->ledgerModel->browse_jurusan();
			$this->_show('ledger-menu', $data);
		}
		else
		{
			redirect(base_url('auth'));
		}
	}

	public function cetak()
	{
		$zipName = FCPATH.'/tmpfile/archieve-ledger.zip';
		$zip = new ZipArchive();
		if ($zip->open($zipName, ZipArchive::CREATE) !== TRUE)
		{
			echo "zip failed";
		}

		$kelas = $this->ledgerModel->browse_kelas($this->input->post('jurusan'), $this->input->post('semester'));
		$matakuliahs = '';
		
		foreach ($kelas as $kls)
		{
			$this->PDF = $this->pdf->load();
			$sumber = $this->_dataPrint($this->input->post('jurusan'), $this->input->post('semester'), $kls->kelas);
			$pdfName = FCPATH.'/tmpfile/Ledger-'.$this->input->post('jurusan').'-'.$this->input->post('semester').'-'.$kls->kelas.'.pdf';
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
	function _pdf($sumber, $pdfName)
	{
		$this->PDF->AddPage("","","","","",0,0,0,0,0,0,"","","","","","","","","","Legal-L");
		$this->PDF->WriteHTML($sumber);

		// // render all necessary file and data into pdf and forced download
		$this->PDF->Output($pdfName);
		chmod($pdfName, 0777);
	}

	/**
	 * retrieve all necessary data to render into pdf
	 * @param string jurusan
	 * @param string semester
	 * @param string kelas
	 * @return string 
	 */
	function _dataPrint($jurusan, $semester, $kelas)
	{
		$mahasiswas = $this->ledgerModel->browse_mahasiswa($jurusan, $semester, $kelas);
		foreach ($mahasiswas as $mahasiswa)
			{
				$jumlah_sks = 0;
				$jumlah_nilai_mutu = 0;

				$matakuliahs = $this->ledgerModel->browse_matakuliah($jurusan, $semester, $kelas);
				foreach ($matakuliahs as $matakuliah)
				{
					$nilai = $this->ledgerModel->nilai_matakuliah($mahasiswa->nim, $matakuliah->id_ajar);
					$huruf = $this->ledgerModel->konversi_nilai($nilai);
					$jumlah_sks += $matakuliah->sks;
					$jumlah_nilai_mutu += $huruf[1] * $matakuliah->sks;
					$data['nilais'][$matakuliah->id_ajar][$mahasiswa->nim] = array($huruf[0],$huruf[1] * $matakuliah->sks,);
				}
				$ip = ($jumlah_nilai_mutu > 0 ? $jumlah_nilai_mutu / $jumlah_sks : 0);
				$data['ip'][$mahasiswa->nim] = round($ip,2);
			}

			$data['mahasiswas'] = $mahasiswas;
			$data['kelas'] = $kelas;
			$data['matakuliahs'] = $matakuliahs;
			return $this->load->view('ledger-template',$data,TRUE);
	}

	private function _show($page='', $data='')
	{
		$this->load->view('head');
		$this->load->view('navbar');
		$this->load->view('sidebar/baak');
		$this->load->view($page,$data);
		$this->load->view('foot');
	}
}