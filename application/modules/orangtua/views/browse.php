<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Orang Tua List</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <div class="col-xs-12">
              <table class="table table-hover" style="margin-top:1%;border:none;">
                <thead>
                  <tr>
                    <th style="text-align:center">No</th>
                    <th style="text-align:center">Orang Tua</th>
                    <th style="text-align:center">Mahasiswa</th>
                    <th style="text-align:center">Email</th>
                    <th style="text-align:center">Telepon</th>
                    <th style="text-align:center">Action</th>
                  </tr>
                </thead>
                <tbody id="orangtua-data">
                  <?php $i=1; foreach ($orangtuas as $orangtua) { ?>
                  <tr>
                    <td style="text-align:center">
                      <?php echo $i; ?>
                    </td>
                    <td style="text-align:center">
                      <?php echo $orangtua->nama; ?>
                    </td>
                    <td style="text-align:center">
                      <?php echo $orangtua->mahasiswa; ?>
                    </td>
                    <td style="text-align:center">
                      <?php echo $orangtua->email; ?>
                    </td>
                    <td style="text-align:center">
                      <?php echo $orangtua->telepon; ?>
                    </td>
                    <td style='text-align:center;'>
                      <button type='button' class='btn btn-info' data-toggle='modal' data-target='#modal' id='edit_orangtua_<?php echo $orangtua->nim ?>'><i class='fa fa-edit'></i> EDIT</button>
                      <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#modal' id='delete_orangtua_<?php echo $orangtua->nim ?>'><i class='fa fa-trash'></i> DELETE</button>
                    </td>
                  </tr>
                  <?php $i++;}?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <div class="col-xs-6">
              <button type="button" class="btn btn-success pull-right" data-toggle='modal' data-target='#modal' id="add_orangtua"><i class="fa fa-plus"></i> ADD</button>
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