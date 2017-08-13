<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title"><?php echo $tipe; ?> List</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <div class="col-xs-12">
              <table class="table table-hover" style="margin-top:1%;border:none;">
                <thead>
                  <tr>
                    <th style="text-align:center">No</th>
                    <th style="text-align:center">Mahasiswa</th>
                    <th style="text-align:center">Tanggal Bayar</th>
                    <th style="text-align:center;<?php echo($tipe === 'uangkuliah' ? '': 'display:none;');?>">Semester</th>
                    <th style="text-align:center">Cicilan</th>
                    <th style="text-align:center">Nominal</th>
                    <th style="text-align:center">Action</th>
                  </tr>
                </thead>
                <tbody id="bayar-data">
                  <?php foreach ($bayars as $bayar) { ?>
                  <tr>
                    <td style="text-align:center">
                      <?php echo $bayar->id_bayar; ?>
                    </td>
                    <td style="text-align:center">
                      <?php echo $bayar->mahasiswa; ?>
                    </td>
                    <td style="text-align:center">
                      <?php echo $bayar->tgl_bayar; ?>
                    </td>
                    <td style="text-align:center;<?php echo($tipe === 'uangkuliah' ? '' : 'display:none;');?>">
                      <?php echo($tipe === 'uangkuliah' ? ''.$bayar->semester.'' : '');?>
                    </td>
                    <td style="text-align:center">
                      <?php echo $bayar->cicilan; ?>
                    </td>
                    <td style="text-align:center">
                      <?php echo $bayar->nominal; ?>
                    </td>
                    <td style='text-align:center;'>
                      <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#modal' id='bayar_delete_<?php echo $tipe.'_'.$bayar->id_bayar ?>'><i class='fa fa-trash'></i> DELETE</button>
                    </td>
                  </tr>
                  <?php }?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.box-body -->
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