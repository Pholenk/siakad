<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Mahasiswa List</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <div class="box-tools">
              <label class="col-xs-3 control-label">
                <strong>Search by Name</strong>
              </label>
              <div class="input-group">
                <input type="text" id="mahasiswa_search" class="form-control input-text" placeholder="Search">
                <span class="input-group-addon input-icon" style="padding:1%"><i class="fa fa-search"></i></span>
              </div>
            </div>
            <div class="col-xs-12">
              <table class="table table-hover" id="table-mahasiswa" style="margin-top:1%;border:none;">
                <thead>
                  <tr>
                    <th id="col" style="text-align:center"></th>
                    <th style="text-align:center">No</th>
                    <th style="text-align:center">ID</th>
                    <th style="text-align:center">Name</th>
                    <th style="text-align:center">Action</th>
                  </tr>
                </thead>
                <tbody id="mahasiswa-data">
                  <?php $i=1; foreach ($mahasiswas as $mahasiswa) { ?>
                  <tr>
                    <td style="text-align:center">
                      <?php echo $i; ?>
                    </td>
                    <td style="text-align:center">
                      <?php echo $mahasiswa->id_jurusan; ?>
                    </td>
                    <td style="text-align:center">
                      <?php echo $mahasiswa->nama; ?>
                    </td>
                    <td style='text-align:center;'>
                      <button type='button' class='btn btn-info' data-toggle='modal' data-target='#modal' id='edit_jurusan_<?php echo $mahasiswa->id_jurusan ?>'><i class='fa fa-edit'></i> EDIT</button>
                      <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#modal' id='delete_jurusan_<?php echo $mahasiswa->id_jurusan ?>'><i class='fa fa-trash'></i> DELETE</button>
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