<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Jurusan List</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <div class="col-xs-12">
              <table class="table table-hover" style="margin-top:1%;border:none;">
                <thead>
                  <tr>
                    <th style="text-align:center">ID Jurusan</th>
                    <th style="text-align:center">Kode Jurusan</th>
                    <th style="text-align:center">Name</th>
                    <th style="text-align:center">Action</th>
                  </tr>
                </thead>
                <tbody id="jurusan-data">
                  <?php foreach ($jurusans as $jurusan) { ?>
                  <tr>
                    <td style="text-align:center">
                      <?php echo $jurusan->id_jurusan; ?>
                    </td>
                    <td style="text-align:center">
                      <?php echo $jurusan->kode_jurusan; ?>
                    </td>
                    <td style="text-align:center">
                      <?php echo $jurusan->nama; ?>
                    </td>
                    <td style='text-align:center'>
                      <button type='button' class='btn btn-info' data-toggle='modal' data-target='#modal' id='edit_jurusan_<?php echo $jurusan->id_jurusan ?>'><i class='fa fa-edit'></i> EDIT</button>
                      <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#modal' id='delete_jurusan_<?php echo $jurusan->id_jurusan ?>'><i class='fa fa-trash'></i> DELETE</button>
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
              <button type="button" class="btn btn-success pull-right" data-toggle='modal' data-target='#modal' id="add_jurusan"><i class="fa fa-plus"></i> ADD</button>
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