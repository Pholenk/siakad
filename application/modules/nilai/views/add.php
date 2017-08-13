<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <!-- /.box-header -->
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Nilai</h3>
            </div>
            <form method="post" id="form_add_nilai">
            <div class="box-body no-padding">
              <div id="error_form_add_nilai"></div>
              <div class="login-box" style="margin-top:2%;margin-bottom:0;">
                <div class="login-logo" style="margin-bottom:0px;">
                  Tambah Nilai
                </div>
                <div class="login-box-body form-horizontal">
                  <div class='form-group'>
                    <label class='col-xs-5 control-label'>Mata kuliah</label>
                    <div class='col-xs-7'>
                      <select name='matakuliah' id='matakuliah_nilai_add' class='form-control' required>
                        <option></option>
                        <?php
                          foreach ($ajars as $ajar)
                          {
                            echo "<option value='".$ajar->semester."".$ajar->id_ajar."'>".$ajar->nama_matakuliah."</option>";
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class='form-group'>
                    <label class='col-xs-5 control-label'>Kelas</label>
                    <div class='col-xs-7'>
                      <select name='kelas' id='kelas_nilai_add' class='form-control' disabled required>
                        <option></option>
                      </select>
                    </div>
                  </div>
                  <div class='form-group'>
                    <label class='col-xs-5 control-label'>Jenis Nilai</label>
                    <div class='col-xs-7'>
                      <select name='jenis' id='jenis_nilai_add' type="text" class='form-control' disabled required>
                        <option></option>
                        <option value="nilai_lain">Nilai Lain-lain</option>
                        <option value="nilai_uts">Nilai UTS</option>
                        <option value="nilai_uas">Nilai UAS</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xs-12" id="form-nilai"></div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="col-xs-6">
                <button type='submit' class="btn btn-success hide pull-right" id="save-form-nilai"><i class="fa fa-plus"></i> <strong>ADD</strong></button>
              </div>
            </div>
          </form>
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