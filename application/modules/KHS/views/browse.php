<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Kartu Hasil Studi</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body no-padding">
            <div class="login-box" style="margin-top:2%;margin-bottom:0;">
              <div class="login-logo" style="margin-bottom:0px;">
                Pencarian Nilai
              </div>
              <div class="login-box-body form-horizontal">
                <form method='post' id="read_khs">
              <?php
                foreach ($data_diri as $mahasiswa)
                { ?>
                  <div class='form-group'>
                    <label class='col-xs-5 control-label' style="text-align:left;">Nama</label>
                    <label class='col-xs-7 control-label' style="text-align:left;"><?php echo $mahasiswa->nama; ?></label>
                  </div>
                  <div class='form-group'>
                    <label class='col-xs-5 control-label' style="text-align:left;">NIM</label>
                    <label class='col-xs-7 control-label' style="text-align:left;"><?php echo $mahasiswa->nim; ?></label>
                  </div>
                  <div class='form-group'>
                    <label class='col-xs-5 control-label' style="text-align:left;">Tahun Ajaran</label>
                    <label class='col-xs-7 control-label' style="text-align:left;"><?php echo mdate('%Y',now()).' / '; echo mdate('%Y', now())+1; ?></label>
                  </div>
                  <div class='form-group'>
                    <label class='col-xs-5 control-label' style="text-align:left;">Jurusan</label>
                    <label class='col-xs-7 control-label' style="text-align:left;"><?php echo $mahasiswa->jurusan; ?></label>
                  </div>
                  <div class='form-group'>
                    <label class='col-xs-5 control-label' style="text-align:left;">Semester</label>
                    <div class='col-xs-7'>
                      <select name='semester' id='semester_khs' type='text' class='form-control' required>
                        <option></option>
                        <?php
                          for($i=1;$i <= $mahasiswa->semester;){
                            echo "<option value='".$i."'>".$i."</option>";
                            $i++;
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class='form-group'>
                    <label class='col-xs-5 control-label' style="text-align:left;">Kelas</label>
                    <label class='col-xs-7 control-label' style="text-align:left;"><?php echo $mahasiswa->kelas; ?></label>
                  </div>
                  <?php } ?>
                  <div class="col-xs-12" style="margin-top:7%;margin-left:5%;">
                    <button type="submit" class="btn btn-block btn-success pull-right" id="cari_khs_read"><i class="fa fa-search"></i> <strong>Cari</strong></button>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-xs-12" id="table-khs" style="margin-top:5%;"></div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer"></div>
        </div>
        <!-- /.box -->
        <div class="modal fade" id="modal" tab-index="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
            </div>
          </div>
        </div>
        <!-- /.modal -->
      </div>
    </div>
  </section>
</div>