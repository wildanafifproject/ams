<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<?php
			if($this->session->flashdata('message') != "") {
				$data['status'] = $this->session->flashdata('status');	
				$data['notify'] = $this->session->flashdata('message');
				$this->load->view('../v_alert', $data);
			}
		?>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
            <div class="col-xs-12">
				<!-- Default box -->
				<div class="box box-success">
					<div class="box-header with-border">
						<h3 class="box-title">Change Password</h3>
					</div>
					<div class="box-body table-responsive">
						<?php foreach($detail as $row) : ?>
						<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>change-password/update_password">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-2 control-label">Old Password <span class="merah">*</span></label>
									<div class="col-sm-9">
										<input type="password" class="form-control" value="" name="o_pass" autocomplete="off" required="" minlength="5" maxlength="25" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">New Password <span class="merah">*</span></label>
									<div class="col-sm-9">
										<input type="password" class="form-control" value="" name="n_pass" autocomplete="off" required="" minlength="5" maxlength="25" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Confirm Password <span class="merah">*</span></label>
									<div class="col-sm-9">
										<input type="password" class="form-control" value="" name="c_pass" autocomplete="off" required="" minlength="5" maxlength="25" />
									</div>
								</div>
								<div class="form-group">
									<span class="col-sm-2"></span>
									<div class="col-sm-9">
										<input type="reset" name="reset" value="Clear" class="btn" />
										<input type="submit" name="submit" value="Save Change" class="btn btn-primary" />
									</div>
								</div>
							</div><!-- /.box-body -->	
						</form>
						<?php endforeach; ?>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div><!-- /.col-xs-12 -->
		</div><!-- /.row -->
	</section><!-- /.content -->
</div><!-- /.content-wrapper --> 