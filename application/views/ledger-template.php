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
<body style="margin:0;">
	<div class="row" style="margin:0;padding:2%;">
		<div class="col-xs-12" style="margin:0 0 2% 0;border-bottom: 4px solid black;">
			<div class="col-xs-2">
				<img src="../../assets/image/logo-pnc.png" style="width:160px;">
			</div>
			<div class="col-xs-9" style="margin-bottom:2%;">
				<h3 style="margin-top:0px;word-space:50px;letter-spacing:1.5px;text-align:justify">KEMENTERIAN RISET TEKNOLOGI dan PENDIDIKAN TINGGI</h3>
				<h2 style="word-space:50px;letter-spacing:12.5px;text-align:justify">POLITEKNIK NEGERI CILACAP</h2>
				<h3 style="margin:4px 0 0 0;font-size:22px;letter-spacing:2.7px;text-align:justify">Jalan Dr. Soetomo No.1, Sidakaya, Cilacap, Jawa Tengah</h3>
				<h3 style="margin:0;font-size:22px;letter-spacing:4.4px;text-align:justify">Telepon (0282) 533329 Faksimile (0282) 537992</h3>
				<h3 style="margin:0;font-size:22px;letter-spacing:0.8px;text-align:justify">http://www.politeknikcilacap.ac.id, poltec@politeknikcilacap.ac.id</h3>
			</div>
		</div>
		<div class="row" style="padding:2%;">
			<table class="col-xs-12">
				<thead>
					<tr>
						<th rowspan="2" style="border: 1px solid black;padding:10px;text-align:center;height:30px;width:40px;">NIM.</th>
						<th rowspan="2" style="border: 1px solid black;padding:10px;text-align:center;width:200px;">NAMA</th>
						<th rowspan="2" style="border: 1px solid black;padding:10px;text-align:center;width:100px;">KELAS</th>
						<?php
							foreach ($matakuliahs as $matakuliah)
							{
								echo "
								<th colspan='2' style='border: 1px solid black;padding:10px;text-align:center;'>".$matakuliah->nama."</th>";
							}
						?>
						<th rowspan="2" style="border: 1px solid black;padding:10px;text-align:center;width:100px;">IP</th>
					</tr>
					<tr>
						<?php
							foreach ($matakuliahs as $matakuliah)
							{
								echo "
								<th style='border: 1px solid black;padding:10px;text-align:center;word-wrap:break-word'>NILAI HURUF</th>
								<th style='border: 1px solid black;padding:10px;text-align:center;word-wrap:break-word'>NILAI MUTU</th>
								";
							}
						?>
					</tr>
				</thead>
				<tbody>
					<?php $i = 0;
					foreach ($mahasiswas as $mahasiswa) {
						echo "
							<tr>
							<td style='border: 1px solid black;padding:10px;text-align:center;'>".$mahasiswa->nim."</td>
							<td style='border: 1px solid black;padding:10px;text-align:center;'>".$mahasiswa->nama."</td>
							<td style='border: 1px solid black;padding:10px;text-align:center;'>".$mahasiswa->kelas."</td>";
							foreach ($matakuliahs as $matakuliah)
							{
								echo"
									<td style='border: 1px solid black;padding:10px;text-align:center;'>".$nilais[$matakuliah->id_ajar][$mahasiswa->nim][0]."</td>
									<td style='border: 1px solid black;padding:10px;text-align:center;'>".$nilais[$matakuliah->id_ajar][$mahasiswa->nim][1]."</td>";
							}
							echo "
								<td style='border: 1px solid black;padding:10px;text-align:center;'>".$ip[$mahasiswa->nim]."</td>
								</tr>";
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>