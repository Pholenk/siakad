<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Mata Kuliah List</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <div class="col-xs-12">
              <table class="table table-hover" style="margin-top:1%;border:none;">
                <thead>
                  <tr>
                    <th style="text-align:center">No</th>
                    <th style="text-align:center">ID</th>
                    <th style="text-align:center">Name</th>
                    <th style="text-align:center">SKS</th>
                    <th style="text-align:center">Semester</th>
                    <th style="text-align:center">Action</th>
                  </tr>
                </thead>
                <tbody id="matakuliah-data">
                  <?php $i=1; foreach ($matakuliahs as $matakuliah) { ?>
                  <tr>
                    <td style="text-align:center">
                      <?php echo $i; ?>
                    </td>
                    <td style="text-align:center">
                      <?php echo $matakuliah->id_matakuliah; ?>
                    </td>
                    <td style="text-align:center">
                      <?php echo $matakuliah->nama; ?>
                    </td>
                    <td style="text-align:center">
                      <?php echo $matakuliah->sks; ?>
                    </td>
                    <td style="text-align:center">
                      <?php echo $matakuliah->semester; ?>
                    </td>
                    <td style='text-align:center;'>
                      <button type='button' class='btn btn-info' data-toggle='modal' data-target='#modal' id='edit_matakuliah_<?php echo $matakuliah->id_matakuliah ?>'><i class='fa fa-edit'></i> EDIT</button>
                      <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#modal' id='delete_matakuliah_<?php echo $matakuliah->id_matakuliah ?>'><i class='fa fa-trash'></i> DELETE</button>
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
              <button type="button" class="btn btn-success pull-right" data-toggle='modal' data-target='#modal' id="add_matakuliah"><i class="fa fa-plus"></i> ADD</button>
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