<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Uang Kuliah List</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <div class="col-xs-12">
              <table class="table table-hover" style="margin-top:1%;border:none;">
                <thead>
                  <tr>
                    <th style="text-align:center">Golongan</th>
                    <th style="text-align:center">Nominal</th>
                    <th style="text-align:center">Tanggal Buka</th>
                    <th style="text-align:center">Tanggal Tutup</th>
                    <th style="text-align:center">Action</th>
                  </tr>
                </thead>
                <tbody id="uangkuliah-data">
                  <?php foreach ($uangkuliahs as $uangkuliah) { ?>
                  <tr>
                    <td style="text-align:center">
                      <?php echo $uangkuliah->id_uangkuliah; ?>
                    </td>
                    <td style="text-align:center">
                      <?php echo $uangkuliah->nominal; ?>
                    </td>
                    <td style="text-align:center">
                      <?php echo $uangkuliah->tgl_buka; ?>
                    </td>
                    <td style="text-align:center">
                      <?php echo $uangkuliah->tgl_tutup; ?>
                    </td>
                    <td style='text-align:center;'>
                      <button type='button' class='btn btn-info' data-toggle='modal' data-target='#modal' id='edit_uangkuliah_<?php echo $uangkuliah->id_uangkuliah ?>'><i class='fa fa-edit'></i> EDIT</button>
                      <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#modal' id='delete_uangkuliah_<?php echo $uangkuliah->id_uangkuliah ?>'><i class='fa fa-trash'></i> DELETE</button>
                    </td>
                  </tr>
                  <?php }?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <div class="col-xs-6">
              <button type="button" class="btn btn-success pull-right" data-toggle='modal' data-target='#modal' id="add_uangkuliah"><i class="fa fa-plus"></i> ADD</button>
            </div>
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