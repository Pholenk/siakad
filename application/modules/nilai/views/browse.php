<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Daftar Nilai</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body no-padding">
            <div class="login-box" style="margin-top:2%;margin-bottom:0;">
              <div class="login-logo" style="margin-bottom:0px;">
                Pencarian Nilai
              </div>
              <div class="login-box-body form-horizontal">
                <form method='post' id="pencarian_nilai">
                  <div class='form-group'>
                    <label class='col-xs-5 control-label'>Mata kuliah</label>
                    <div class='col-xs-7'>
                      <select name='matakuliah' id='matakuliah_nilai_browse' type='text' class='form-control' required>
                        <option></option>
                        <?php
                          foreach ($ajars as $ajar)
                          {
                            echo "<option value='".$ajar->id_ajar."'>".$ajar->nama_matakuliah."</option>";
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class='form-group'>
                    <label class='col-xs-5 control-label'>Jenis Nilai</label>
                    <div class='col-xs-7'>
                      <select name='jenis' id='jenis_nilai_browse' type='text' class='form-control' required>
                        <option value="nilai_lain">Nilai Lain-lain</option>
                        <option value="nilai_uts">Nilai UTS</option>
                        <option value="nilai_uas">Nilai UAS</option>
                      </select>
                    </div>
                  </div>
                  <div class='form-group'>
                    <label class='col-xs-5 control-label'>Kelas</label>
                    <div class='col-xs-7'>
                      <select name='kelas' id='kelas_nilai_browse' type='text' class='form-control' required>
                        <option></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-xs-12" style="margin-top:7%;margin-left:5%;">
                    <button type="submit" class="btn btn-block btn-success pull-right" id="cari_nilai_browse"><i class="fa fa-search"></i> <strong>Cari</strong></button>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-xs-12 table-responsive"></div>
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