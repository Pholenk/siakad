<div class="content-wrapper">
<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-success">
					<div class="box-header">Cetak Kartu Ujian</div>
					<div class="box-body no-padding">
						<form method='post' id="form-kartu-ujian" action="<?php echo base_url('/kartu_ujian/cetak');?>">
						<div class="col-xs-12">
							<div class="col-xs-6 form-horizontal">
								<div class='form-group'>
									<label class='col-xs-5 control-label'>Jurusan</label>
									<div class='col-xs-7'>
										<select name='jurusan' id="kartu-ujian-jurusan" class='form-control' required>
											<option></option>
											<?php
											foreach ($jurusans as $jurusan)
											{
											echo "<option value='".$jurusan->id_jurusan."'>".$jurusan->nama."</option>";
											}
											?>
										</select>
									</div>
								</div>
								<div class='form-group'>
									<label class='col-xs-5 control-label'>Jenis Ujian</label>
									<div class='col-xs-7'>
										<select name='ujian' id="kartu-ujian-jenis-ujian" class='form-control' required>
											<option></option>
											<option value="TENGAH_SEMESTER">Tengah Semester</option>
											<option value="AKHIR_SEMESTER">Akhir Semester</option>
										</select>
									</div>
								</div>
								<div class='form-group'>
									<label class='col-xs-5 control-label'>Semester</label>
									<div class='col-xs-7'>
										<select name='semester' id="kartu-ujian-semester" class='form-control' onchange='opt_kelas(); opt_matakuliah();' required>
											<option></option>
											<option>1</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
											<option>5</option>
											<option>6</option>
											<option>7</option>
											<option>8</option>
										</select>
									</div>
								</div>
								<div class='form-group'>
									<label class='col-xs-5 control-label'>Kelas</label>
									<div class='col-xs-7'>
										<select name='kelas' id="kartu-ujian-kelas" class='form-control' required></select>
									</div>
								</div>
								<div class='form-group'>
									<label class='col-xs-5 control-label'>Ruangan</label>
									<div class='col-xs-7'>
										<input name='ruangan' type="text" class='form-control' required>
									</div>
								</div>
								<div class='form-group'>
									<label class='col-xs-5 control-label'>Ketua Panitia</label>
									<div class='col-xs-7'>
										<input name='ketua_panitia' type="text" class='form-control' required>
									</div>
								</div>
								<div class='form-group'>
									<label class='col-xs-5 control-label'>NPAK</label>
									<div class='col-xs-7'>
										<input name='npak' type="text" class='form-control' required>
									</div>
								</div>
							</div>
							<div class="col-xs-6 form-horizontal">
								<div class='form-group'>
									<label class='col-xs-5 control-label'>Tanggal Hari Ke - 1</label>
									<div class='col-xs-7'>
										<input name='tgl1' class='form-control' type="date" value="<?php echo date('Y-m-d', now());?>" required>
									</div>
								</div>
								<div class='form-group'>
									<label class='col-xs-5 control-label'>Tanggal Hari Ke - 2</label>
									<div class='col-xs-7'>
										<input name='tgl2' class='form-control' type="date" value="<?php echo date('Y-m-d', strtotime("+1 day"));?>" required>
									</div>
								</div>
								<div class='form-group'>
									<label class='col-xs-5 control-label'>Tanggal Hari Ke - 3</label>
									<div class='col-xs-7'>
										<input name='tgl3' class='form-control' type="date" value="<?php echo date('Y-m-d', strtotime("+2 day"));?>" required>
									</div>
								</div>
								<div class='form-group'>
									<label class='col-xs-5 control-label'>Tanggal Hari Ke - 4</label>
									<div class='col-xs-7'>
										<input name='tgl4' class='form-control' type="date" value="<?php echo date('Y-m-d', strtotime("+3 day"));?>" required>
									</div>
								</div>
								<div class='form-group'>
									<label class='col-xs-5 control-label'>Tanggal Hari Ke - 5</label>
									<div class='col-xs-7'>
										<input name='tgl5' class='form-control' type="date" value="<?php echo date('Y-m-d', strtotime("+4 day"));?>" required>
									</div>
								</div>
								<div class='form-group'>
									<label class='col-xs-5 control-label'>Tanggal Hari Ke - 6</label>
									<div class='col-xs-7'>
										<input name='tgl6' class='form-control' type="date" value="<?php echo date('Y-m-d', strtotime("+5 day"));?>" required>
									</div>
								</div>
								<div class='form-group'>
									<label class='col-xs-5 control-label'>Tanggal Hari Ke - 7</label>
									<div class='col-xs-7'>
										<input name='tgl7' class='form-control' type="date" value="<?php echo date('Y-m-d', strtotime("+6 day"));?>" required>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12">
							<table class="table table-border">
								<thead>
									<tr>
										<th></th>
										<th>Jam</th>
										<th>Jadwal</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td rowspan="2" style="width:100px;vertical-align:middle;"><label class='control-label'>Hari Ke - 1</label></td>
										<td style="width:100px;"><input name='jam1-tgl1' class='form-control' type="time" value="<?php echo date('H:i', now());?>" required></td>
										<td>
											<select name='jadwal1-tgl1' id="kartu-ujian-jadwal" class='form-control'></select>
										</td>
									</tr>
									<tr>
										<td style="width:100px;"><input name='jam2-tgl1' class='form-control' type="time" value="<?php echo date('H:i', strtotime("+90 Minute"));?>" required></td>
										<td>
											<select name='jadwal2-tgl1' id="kartu-ujian-jadwal" class='form-control'></select>
										</td>
									</tr>
									<tr>
										<td rowspan="2" style="width:100px;vertical-align:middle;"><label class='control-label'>Hari Ke - 2</label></td>
										<td style="width:100px;"><input name='jam1-tgl2' class='form-control' type="time" value="<?php echo date('H:i', now());?>" required></td>
										<td>
											<select name='jadwal1-tgl2' id="kartu-ujian-jadwal" class='form-control'></select>
										</td>
									</tr>
									<tr>
										<td style="width:100px;"><input name='jam2-tgl2' class='form-control' type="time" value="<?php echo date('H:i', strtotime("+90 Minute"));?>" required></td>
										<td>
											<select name='jadwal2-tgl2' id="kartu-ujian-jadwal" class='form-control'></select>
										</td>
									</tr>
									<tr>
										<td rowspan="2" style="width:100px;vertical-align:middle;"><label class='control-label'>Hari Ke - 3</label></td>
										<td style="width:100px;"><input name='jam1-tgl3' class='form-control' type="time" value="<?php echo date('H:i', now());?>" required></td>
										<td>
											<select name='jadwal1-tgl3' id="kartu-ujian-jadwal" class='form-control'></select>
										</td>
									</tr>
									<tr>
										<td style="width:100px;"><input name='jam2-tgl3' class='form-control' type="time" value="<?php echo date('H:i', strtotime("+90 Minute"));?>" required></td>
										<td>
											<select name='jadwal2-tgl3' id="kartu-ujian-jadwal" class='form-control'></select>
										</td>
									</tr>
									<tr>
										<td rowspan="2" style="width:100px;vertical-align:middle;"><label class='control-label'>Hari Ke - 4</label></td>
										<td style="width:100px;"><input name='jam1-tgl4' class='form-control' type="time" value="<?php echo date('H:i', now());?>" required></td>
										<td>
											<select name='jadwal1-tgl4' id="kartu-ujian-jadwal" class='form-control'></select>
										</td>
									</tr>
									<tr>
										<td style="width:100px;"><input name='jam2-tgl4' class='form-control' type="time" value="<?php echo date('H:i', strtotime("+90 Minute"));?>" required></td>
										<td>
											<select name='jadwal2-tgl4' id="kartu-ujian-jadwal" class='form-control'></select>
										</td>
									</tr>
									<tr>
										<td rowspan="2" style="width:100px;vertical-align:middle;"><label class='control-label'>Hari Ke - 5</label></td>
										<td style="width:100px;"><input name='jam1-tgl5' class='form-control' type="time" value="<?php echo date('H:i', now());?>" required></td>
										<td>
											<select name='jadwal1-tgl5' id="kartu-ujian-jadwal" class='form-control'></select>
										</td>
									</tr>
									<tr>
										<td style="width:100px;"><input name='jam2-tgl5' class='form-control' type="time" value="<?php echo date('H:i', strtotime("+90 Minute"));?>" required></td>
										<td>
											<select name='jadwal2-tgl5' id="kartu-ujian-jadwal" class='form-control'></select>
										</td>
									</tr>
									<tr>
										<td rowspan="2" style="width:100px;vertical-align:middle;"><label class='control-label'>Hari Ke - 6</label></td>
										<td style="width:100px;"><input name='jam1-tgl6' class='form-control' type="time" value="<?php echo date('H:i', now());?>" required></td>
										<td>
											<select name='jadwal1-tgl6' id="kartu-ujian-jadwal" class='form-control'></select>
										</td>
									</tr>
									<tr>
										<td style="width:100px;"><input name='jam2-tgl6' class='form-control' type="time" value="<?php echo date('H:i', strtotime("+90 Minute"));?>" required></td>
										<td>
											<select name='jadwal2-tgl6' id="kartu-ujian-jadwal" class='form-control'></select>
										</td>
									</tr>
									<tr>
										<td rowspan="2" style="width:100px;vertical-align:middle;"><label class='control-label'>Hari Ke - 7</label></td>
										<td style="width:100px;"><input name='jam1-tgl7' class='form-control' type="time" value="<?php echo date('H:i', now());?>" required></td>
										<td>
											<select name='jadwal1-tgl7' id="kartu-ujian-jadwal" class='form-control'></select>
										</td>
									</tr>
									<tr>
										<td style="width:100px;"><input name='jam2-tgl7' class='form-control' type="time" value="<?php echo date('H:i', strtotime("+90 Minute"));?>" required></td>
										<td>
											<select name='jadwal2-tgl7' id="kartu-ujian-jadwal" class='form-control'></select>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="box-footer">
						<div class="col-xs-3" style="margin-left:40%;">
						<button type="submit" class="btn btn-block btn-success"><i class="fa fa-print"></i> <strong>Cetak</strong></button>
						</div>
					</div>
					</form>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
		</div>
	</section>
</div>
<script>
function opt_kelas() {
    jQuery.ajax({
      url: '/kartu_ujian/browse_kelas/'+jQuery('#kartu-ujian-jurusan').val()+'/'+jQuery('#kartu-ujian-semester').val(),
      success: function(response) {
        (response !== '!LOGIN' ? jQuery('#kartu-ujian-kelas').html(response) : window.location = '/')
      }
  })
}

function opt_matakuliah() {
    jQuery.ajax({
      url: '/kartu_ujian/browse_matakuliah/'+jQuery('#kartu-ujian-jurusan').val()+'/'+jQuery('#kartu-ujian-semester').val(),
      success: function(response) {
        (response !== '!LOGIN' ? jQuery('[id="kartu-ujian-jadwal"]').html(response) : window.location = '/')
      }
  })
}

function cetak() {
	jQuery.ajax({
		url: '/kartu_ujian/cetak',
		type: 'POST',
		data: jQuery('#form-kartu-ujian').serialize(),
	})	
}

</script>
