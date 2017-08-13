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
				<h3 style="margin-top:0px;margin-bottom:0px;font-size:20px;text-align:justify">KEMENTERIAN RISET TEKNOLOGI dan PENDIDIKAN TINGGI</h3>
				<h2 style="margin-top:0px;margin-bottom:0px;word-space:5px;letter-spacing:5px;text-align:justify">POLITEKNIK NEGERI CILACAP</h2>
				<h3 style="margin:4px 0 0 0;font-size:19px;letter-spacing:1px;text-align:justify">Jalan Dr. Soetomo No.1, Sidakaya, Cilacap, Jawa Tengah</h3>
				<h3 style="margin:0;font-size:19px;letter-spacing:0.8px;text-align:justify">Telepon (0282) 533329 Faksimile (0282) 537992</h3>
				<h3 style="margin:0;font-size:18px;text-align:justify">http://www.politeknikcilacap.ac.id, poltec@politeknikcilacap.ac.id</h3>
			</div>
		</div>
		<div class="col-xs-12" style="border-bottom: 2px solid black;border-top: 2px solid black;">
			<h3 style="text-align:center;vertical-align:middle;"> KARTU HASIL STUDI </h3>
		</div>
		<div class="row" style="margin-top:2%;">
			<?php foreach ($self_data as $mahasiswa) { ?>
			<div class="col-xs-12" style="">
				<div class="col-xs-5" style="text-align:justify;">
					<h5>NAMA : <?php echo $mahasiswa->nama ;?></h5>
				</div>
				<div class="col-xs-5 pull-right" style="text-align:justify;">
					<h5>JURUSAN : <?php echo $mahasiswa->jurusan ;?></h5>
				</div>
			</div>
			<div class="col-xs-12" style="">
				<div class="col-xs-5" style="text-align:justify;">
					<h5>NIM : <?php echo $mahasiswa->nim ;?></h5>
				</div>
				<div class="col-xs-5 pull-right" style="text-align:justify;">
					<h5>JENJANG : DIPLOMA III POLITEKNIK</h5>
				</div>
			</div>
			<div class="col-xs-12" style="">
				<div class="col-xs-5" style="text-align:justify;">
					<h5>SEMESTER / TAHUN AJARAN : <?php echo $semester; ?> / <?php echo date('Y',now())." - ".date('Y', strtotime("+1 Year")); ?></h5>
				</div>
				<div class="col-xs-5 pull-right" style="text-align:justify;">
					<h5>KELAS : <?php echo $mahasiswa->kelas ;?></h5>
				</div>
			</div>
			<?php } ?>
		</div>
		<div class="row" style="padding:2%;">
			<table class="col-xs-12">
				<thead>
					<tr>
						<th style="border: 1px solid black;padding:10px;text-align:center;height:20px;width:40px;">No.</th>
						<th style="border: 1px solid black;padding:10px;text-align:center;width:100px;">KODE MK</th>
						<th style="border: 1px solid black;padding:10px;text-align:center;width:250px;">MATA KULIAH</th>
						<th style="border: 1px solid black;padding:10px;text-align:center;width:50px;">SKS</th>
						<th style="border: 1px solid black;padding:10px;text-align:center;width:100px;word-wrap:break-word">NILAI HURUF</th>
						<th style="border: 1px solid black;padding:10px;text-align:center;width:100px;word-wrap:break-word">NILAI MUTU</th>
						<th style="border: 1px solid black;padding:10px;text-align:center;">KET</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=1;
					foreach ($matakuliahs as $matakuliah) {
						echo "
						<tr>
							<td style='border: 1px solid black;padding:5px;text-align:center;'>".$i."</td>
							<td style='border: 1px solid black;padding:5px;text-align:center;'>".$matakuliah->id_matakuliah."</td>
							<td style='border: 1px solid black;padding:5px;text-align:left;'>".$matakuliah->nama."</td>
							<td style='border: 1px solid black;padding:5px;text-align:center;'>".$matakuliah->sks."</td>
							<td style='border: 1px solid black;padding:5px;text-align:center;'>".$nilai[''.$i][0]."</td>
							<td style='border: 1px solid black;padding:5px;text-align:center;'>".$nilai[''.$i][1]."</td>
							<td style='border: 1px solid black;padding:5px;text-align:center;'></td>
						</tr>";
						$i++;
					}
					?>
					<tr style="border-left: 1px solid black;border-right: 1px solid black;">
						<td colspan="3" style="padding:5px;text-align:right;">JUMLAH :</td>
						<td style="padding:5px;text-align:center;"><?php echo $jumlah_sks; ?> </td>
						<td style="padding:5px;text-align:center;"></td>
						<td style="padding:5px;text-align:center;"><?php echo $jumlah_nilai_mutu; ?> </td>
						<td style="padding:5px;text-align:center;"></td>
					</tr>
					<tr style="border-left: 1px solid black;border-right: 1px solid black;">
						<td colspan="2" style="padding:5px;text-align:left;">INDEKS PRESTASI</td>
						<td colspan="5" style="padding:5px;text-align:left;"> : <?php echo $ips; ?> </td>
					</tr>
					<tr style="border-left: 1px solid black;border-right: 1px solid black;">
						<td colspan="2" style="padding:5px;text-align:left;">INDEKS PRESTASI KUMULATIF</td>
						<td colspan="5" style="padding:5px;text-align:left;"> : <?php echo $ipk; ?> </td>
					</tr>
					<tr style="border-left: 1px solid black;border-right: 1px solid black;">
						<td colspan="2" style="padding:5px;text-align:left;">STATUS KELULUSAN</td>
						<td colspan="5" style="padding:5px;text-align:left;"> : <?php echo $kelulusan; ?> </td>
					</tr>
					<tr style="border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">
						<td colspan="7" style="padding:10px;text-align:left;"></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>