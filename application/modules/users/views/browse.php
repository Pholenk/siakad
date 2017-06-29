<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-success">
					<div class="box-header with-border">
						<h3 class="box-title">Users List</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body table-responsive no-padding">
						<div class="col-xs-12" style="padding: 0 5%;">
							<table class="table table-hover" style="margin-top:1%;border:none;" id="table_breeder">
								<tr style="text-align:center;">
									<th>No</th>
									<th>Id</th>
									<th>Job</th>
									<th>Action</th>
								</tr>
								<?php
								$i = 1; 
								foreach ($users as $key)
								{
									echo'
									<tr id="edit_source_#">
									<td>'. $i .'</td>
									<td>'. $key->id .'</td>
									<td>'. $key->job .'</td>
									<td>
									<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal" id="edit_breeder_#"><i class="fa fa-edit"></i> EDIT</button>
									<a href="/breeder/delete/#"><button type="button" class="btn btn-danger"><i class="fa fa-trash"></i> DELETE</button></a>
									</td>
									</tr>';
									$i++;
								}
								?>
							</table>
						</div>
					</div>
					<!-- /.box-body -->
					<!-- box-footer -->
					<div class="box-footer">
						<div class="col-sm-6">
							<button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#modal" id="add_breeder"><i class="fa fa-plus"></i> ADD</button>
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
			</div>
		</div>
	</section>
</div>