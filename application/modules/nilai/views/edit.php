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
          <form method='post' id="form_edit_nilai">
          <div class="box-body no-padding">
            <div class="login-box" style="margin-top:2%;margin-bottom:0;">
              <div class="login-logo" style="margin-bottom:0px;">
                Edit Nilai
              </div>
              <div class="login-box-body form-horizontal">
                <div id="error_form_edit_nilai"></div>
                <div class='form-group'>
                  <label class='col-xs-5 control-label'>Mata kuliah</label>
                  <div class='col-xs-7'>
                    <select name='matakuliah' id='matakuliah_nilai_edit' type='text' class='form-control' required>
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
                    <select name='kelas' id='kelas_nilai_edit' type='text' class='form-control' required>
                      <option></option>
                    </select>
                  </div>
                </div>
                <div class='form-group'>
                  <label class='col-xs-5 control-label'>Jenis Nilai</label>
                  <div class='col-xs-7'>
                    <select name='jenis' id='jenis_nilai_edit' type='text' class='form-control' required>
                      <option></option>
                      <option value="nilai_lain">Nilai Lain-lain</option>
                      <option value="nilai_uts">Nilai UTS</option>
                      <option value="nilai_uas">Nilai UAS</option>
                    </select>
                  </div>
                </div>
                <div class='form-group hide' id='pengambilan_nilai'>
                  <label class='col-xs-5 control-label'>Pengambilan</label>
                  <div class='col-xs-7'>
                    <select name='pengambilan' id='pengambilan_nilai_edit' type='text' class='form-control'>
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
              <button type="submit" class="btn btn-success hide pull-right" id="save-form-nilai"><i class="fa fa-plus"></i> <strong>Ubah</strong></button>
            </div>
          </form>
          </div>
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