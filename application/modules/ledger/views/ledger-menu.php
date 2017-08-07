<div class="content-wrapper">
<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-success">
					<div class="box-body no-padding">
						<div class="login-box" style="margin-top:2%;margin-bottom:0;">
							<div class="login-logo" style="margin-bottom:0px;">Cetak Ledger Nilai</div>
							<div class="login-box-body form-horizontal">
								<form method='post' action="<?php echo base_url('/ledger/cetak'); ?>">
								<div class='form-group'>
									<label class='col-xs-5 control-label'>Jurusan</label>
									<div class='col-xs-7'>
										<select name='jurusan' class='form-control' required>
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
									<label class='col-xs-5 control-label'>Semester</label>
									<div class='col-xs-7'>
										<select name='semester' class='form-control' required>
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
							</div>
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