<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-info">
          <div class="box-header with-border animated">
            <h3 class="box-title">Users List</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive no-padding animated">
            <div class="col-sm-12">
              <table class="table table-hover" style="margin-top:1%;border:none;">
                <thead>
                  <tr>
                    <th style="text-align:center">ID</th>
                    <th style="text-align:center">Name</th>
                    <th style="text-align:center">Pekerjaan</th>
                    <th style="text-align:center">Action</th>
                  </tr>
                </thead>
                <tbody id="users-data">
                  <?php foreach ($users as $user) { ?>
                  <tr>
                    <td style="text-align:center">
                      <?php echo $user->username?>
                    </td>
                    <td style="text-align:center">
                      <?php echo $user->fullname; ?>
                    </td>
                    <td style="text-align:center">
                      <?php echo $user->job; ?>
                    </td>
                    <td style="text-align:center">
                      <button type='button' class='btn btn-info' data-toggle='modal' data-target='#modal' id='edit_user_<?php echo $user->username ?>'><i class='fa fa-edit'></i> EDIT</button>
                      <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#modal' id='delete_user_<?php echo $user->username ?>'><i class='fa fa-trash'></i> DELETE</button>
                    </td>
                  </tr>
                  <?php }?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer animated">
            <div class="col-sm-12" style="text-align:center;">
              <button type="button" class="btn btn-success" data-toggle='modal' data-target='#modal' id="add_user"><i class="fa fa-plus"></i> ADD</button>
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