<?php

class Kartu_ujian extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('kartu_ujianModel');
		$this->load->library('pdf');
		$this->PDF = $this->pdf->load();
	}

	public function index()
	{
		if ($this->session->job === 'BAAK')
		{
			$data['jurusans'] = $this->kartu_ujianModel->browse_jurusan();
			$this->_show('kartu_ujian-menu',$data);
		}
		else
		{
			redirect(base_url('auth'));
		}
	}

	public function browse_matakuliah($id_jurusan = '', $semester = '')
	{
		if (!empty($id_jurusan))
		{
			$matakuliahs = $this->kartu_ujianModel->browse_matakuliah($id_jurusan,$semester);
			foreach ($matakuliahs as $matakuliah)
			{
				echo "<option value='".$matakuliah->id_matakuliah."'>".$matakuliah->nama."</option>";
			}
		}
		else
		{
			echo "";
		}
	}

	public function browse_kelas($id_jurusan = '', $semester = '')
	{
		if (!empty($id_jurusan))
		{
			$kelas = $this->kartu_ujianModel->browse_kelas($id_jurusan,$semester);
			foreach ($kelas as $kls)
			{
				echo "<option value='".$kls->kelas."_ASC'>Sebagian Atas ".$kls->kelas."</option>";
				echo "<option value='".$kls->kelas."_DESC'>Sebagaian Bawah ".$kls->kelas."</option>";
			}
		}
		else
		{
			echo "";
		}
	}

	public function cetak()
	{
		$ujian = $this->input->post('ujian');
		$npak = $this->input->post('npak');
		$ketua_panitia = $this->input->post('ketua_panitia');
		$ruangan = $this->input->post('ruangan');
		$jurusan = $this->input->post('jurusan');
		$semester = $this->input->post('semester');
		$kelas = substr($this->input->post('kelas'),0,1);
		$type = substr($this->input->post('kelas'),2);
		
		$data = array(
			'npak' => $npak,
			'ketua_panitia' => $ketua_panitia,
			'ruangan' => $ruangan,
			'jurusan' => $jurusan,
			'semester' => $semester,
			'kelas' => $kelas,
			'type' => $type,
			'ujian' => $ujian,
		);

		$mahasiswas = $this->kartu_ujianModel->browse_mahasiswa($jurusan, $semester, $kelas, $type);
		$data['mahasiswas'] = $mahasiswas;

		for ($i=1; $i < 8;) {
			$data['tgl_ujian'][''.$i] = $this->input->post('tgl'.$i);
			for ($j=1; $j < 3; ) { 
				$data['jam_ujian'][''.$i][''.$j] = $this->input->post('jam'.$j.'-tgl'.$i);
				$data['jadwal_ujian'][''.$i][''.$j] = $this->input->post('jadwal'.$j.'-tgl'.$i);
				$j++;
			}
			$i++;
		}

		foreach ($mahasiswas as $mahasiswa)
		{
			if ($this->kartu_ujianModel->grant_cetak($mahasiswa->nim, $type, $semester, $ujian)) {
				$sumber = $this->load->view('kartu-ujian',$data,TRUE);
			$pdfName = 'kartu-ujian-'.$mahasiswa->nim.'-'.$semester.'-'.$kelas.'.pdf';
			
			$this->PDF->AddPage("","","","","",0,0,0,0,0,0,"","","","","","","","","","Legal-L");
			$this->PDF->WriteHTML($sumber);
			
			// render all necessary file and data into pdf and forced download
			$this->PDF->Output($pdfName, 'D');
			}
			else
			{
				echo "false";
			}
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