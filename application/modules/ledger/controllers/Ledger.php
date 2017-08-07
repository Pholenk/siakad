<?php

class Ledger extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ledgerModel');
		$this->load->library('pdf');
		$this->PDF = $this->pdf->load();
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
		$mahasiswas = $this->ledgerModel->browse_mahasiswa($this->input->post('jurusan'), $this->input->post('semester'));
		$kelas = $this->ledgerModel->browse_kelas($this->input->post('jurusan'), $this->input->post('semester'));
		$matakuliahs = '';
		
		foreach ($kelas as $kls)
		{
			foreach ($mahasiswas as $mahasiswa)
			{
				$jumlah_sks = 0;
				$jumlah_nilai_mutu = 0;
				$jurusan = $mahasiswa->jurusan;

				$matakuliahs = $this->ledgerModel->browse_matakuliah($this->input->post('jurusan'), $this->input->post('semester'), $mahasiswa->kelas);
				foreach ($matakuliahs as $matakuliah)
				{
					$nilai = $this->ledgerModel->nilai_matakuliah($mahasiswa->nim, $matakuliah->id_ajar);
					$huruf = $this->ledgerModel->konversi_nilai($nilai);
					$jumlah_sks += $matakuliah->sks;
					$jumlah_nilai_mutu += $huruf[1] * $matakuliah->sks;
					$data['nilais'][$matakuliah->id_ajar][$mahasiswa->nim] = array($huruf[0],$huruf[1] * $matakuliah->sks,);
				}
				$ip = ($jumlah_nilai_mutu > 0 ? $jumlah_nilai_mutu / $jumlah_sks : 0);
				$data['ip'][$mahasiswa->nim] = $ip;
			}

			$data['mahasiswas'] = $mahasiswas;
			$data['kelas'] = $kelas;
			$data['matakuliahs'] = $matakuliahs;
			
			$sumber = $this->load->view('ledger-template',$data,TRUE);
			$pdfName = 'Ledger-'.$jurusan.'-'.$this->input->post('semester').'-'.$kls->kelas.'.pdf';
			
			$this->PDF->AddPage("","","","","",0,0,0,0,0,0,"","","","","","","","","","Legal-L");
			$this->PDF->WriteHTML($sumber);
			
			// render all necessary file and data into pdf and forced download
			$this->PDF->Output($pdfName, 'D');
		}

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