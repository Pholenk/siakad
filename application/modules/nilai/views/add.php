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
            <form method="post" action=<?php echo base_url('nilai/add/TRUE');?> id="tambah_nilai">
            <div class="box-body no-padding">
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
                            echo "<option value='".$ajar->id_ajar."'>".$ajar->nama_matakuliah."</option>";
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class='form-group'>
                    <label class='col-xs-5 control-label'>Kelas</label>
                    <div class='col-xs-7'>
                      <select name='kelas' id='kelas_nilai_add' class='form-control' required>
                        <option value='C'>C</option>
                      </select>
                    </div>
                  </div>
                  <div class='form-group'>
                    <label class='col-xs-5 control-label'>Jenis Nilai</label>
                    <div class='col-xs-7'>
                      <select name='jenis' id='jenis_nilai_add' type="text" class='form-control' required>
                        <option></option>
                        <option value="nilai_lain">Nilai Lain-lain</option>
                        <option value="nilai_uts">Nilai UTS</option>
                        <option value="nilai_uas">Nilai UAS</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xs-12" id="form-nilai">
                <div  class='box' style='margin-top:1%;padding:0 2% 2% 2%;'>
                  <div class='box-body form-horizontal'>
            <div class='col-xs-12'><?php
          foreach ($mahasiswas as $mahasiswa)
          {
                    echo"
                      <div class='form-group'>
              <label class='col-xs-5 control-label' style='text-align: left;'>".$mahasiswa->nama."</label>
              <div class='col-xs-6'>
                      <input name='nilai_".str_replace('.','',$mahasiswa->nim)."' type='text' class='form-control' id='nilai_add' required>
                      </div>
              </div>";
            }?>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="col-xs-6">
                <button type='submit' class="btn btn-lg btn-success hide pull-right"><i class="fa fa-plus"></i> ADD</button>
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