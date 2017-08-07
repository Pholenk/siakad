<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SIAKAD</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!--link rel="shortcut icon" type="image/x-icon" href="../../assets/image/logo_pnc_hea_icon.ico"-->
  <!-- custom.css>
  <link rel="stylesheet" href="../../assets/css/custom.css" -->
  <!-- bootstrap.css -->
  <link rel="stylesheet" href="../../vendor/almasaeed2010/adminlte/bootstrap/css/bootstrap.min.css">
</head>
<body style="">
	<div class="row" style="margin-left:0;">
		<div class="col-xs-4" style="border:2px solid black;padding:2px;margin-top:50px;">
			<p style="margin:0 3px 0 10px;font-size:12px;letter-spacing:0.2px;text-align:justify">KEMENTERIAN RISET TEKNOLOGI dan PENDIDIKAN TINGGI</p>
			<h4 style="margin:0 3px 0 10px;letter-spacing:3.5px;text-align:justify">POLITEKNIK NEGERI CILACAP</h4>
			<p style="margin:0 3px 0 10px;font-size:12px;letter-spacing:0.4px;text-align:justify">Jalan Dr. Soetomo No.1, Sidakaya, Cilacap, Jawa Tengah</p>
			<p style="margin:0 3px 0 10px;font-size:12px;letter-spacing:1.3px;text-align:justify">Telepon (0282) 533329 Faksimile (0282) 537992</p>
			<p style="margin:0 3px 0 10px;font-size:11px;text-align:justify">http://www.politeknikcilacap.ac.id, poltec@politeknikcilacap.ac.id</p>
			<p style="border-top: 2px solid black;"></p>
			<p style="margin:5px 3px 15px 10px;text-align:center;padding:2px;word-spacing:10px;letter-spacing:3px;">KARTU PESERTA UJIAN <?php echo str_replace('_', ' ', $ujian)." TAHUN AKADEMIK ".date('Y', now())." / ".date('Y', strtotime("+1 Year"))?></p>
			<?php foreach ($mahasiswas as $mahasiswa)
			{
			?>
			<div class="col-xs-12" style="text-align:justify;">
				<p>NAMA : <?php echo $mahasiswa->nama; ?></p>
			</div>
			<div class="col-xs-12" style="text-align:justify;">
				<p>NIM : <?php echo $mahasiswa->nim; ?></p>
			</div>
			<div class="col-xs-12" style="text-align:justify;">
				<p>JURUSAN : <?php echo $mahasiswa->jurusan; ?></p>
			</div>
			<div class="col-xs-12" style="text-align:justify;">
				<p>SEMESTER / KELAS : <?php echo $mahasiswa->semester.' / '.$mahasiswa->kelas; ?></p>
			</div>
			<?php } ?>
		<p style="margin-left:45%;">Cilacap, <?php echo date('d M Y', now()); ?></p>
		<p style="margin-left:45%;">Ketua Panitia</p>
		<p style="margin-left:45%;margin-top:50px;margin-bottom:0px;text-decoration:underline;"><?php echo $ketua_panitia ?></p>
		<p style="margin-left:45%;margin-top:0px;font-weight:bold;">NPAK : <?php echo $npak; ?></p>
		</div>
		<div class="col-xs-7" style="border:2px solid black;padding:2px;margin-bottom:0px;">
			<h4 style="margin:10px 3px 15px 10px;text-align:center;padding:2px;">Jadwal Ujian Tengah Semester</h4>
			<table class="table" style="margin-left:2%;margin-right:2%;margin-bottom:13%;border:1px solid black;">
				<thead>
					<tr>
						<th style="border: 1px solid black;text-align:center;">Tanggal</th>
						<th style="border: 1px solid black;text-align:center;">Jam</th>
						<th style="border: 1px solid black;text-align:center;">Ruang</th>
						<th style="border: 1px solid black;text-align:center;height:30px;">Mata Kuliah</th>
					</tr>
				</thead>
				<tbody>
					<?php for ($i=1; $i < 8 ; $i++) { 
						echo "<tr>
							<td rowspan='2' style='border: 1px solid black;vertical-align:middle;text-align:center;'>".$tgl_ujian[''.$i]."</td>";
						 for ($j=1; $j < 2 ; $j++) { 
						 	echo "
								<td style='border: 1px solid black;text-align:center;'>".$jam_ujian[''.$i][''.$j]."</td>
								<td rowspan='2' style='border: 1px solid black;text-align:center;'>".$ruangan."</td>
								<td style='border: 1px solid black;text-align:center;height:30px;'>".$jadwal_ujian[''.$i][''.$j]."</td>
							</tr>";
						 } 
						 for ($j=2; $j < 3 ; $j++) { 
						 	echo "
							<tr>
								<td style='border: 1px solid black;text-align:center;'>".$jam_ujian[''.$i][''.$j]."</td>
								<td style='border: 1px solid black;text-align:center;height:30px;'>".$jadwal_ujian[''.$i][''.$j]."</td>
							</tr>";
						 } 
					 } ?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>