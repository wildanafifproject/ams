<div class="container-fluid main-content">
    <div class="page-title">
        <h1></h1>
    </div>
    <!-- DataTables Example -->
    <div class="row">
		<div class="col-lg-12">
			<?php
				if($this->session->flashdata('message') != "") {
					$data['status'] = $this->session->flashdata('status');	
					$data['notify'] = $this->session->flashdata('message');
					$this->load->view('../v_alert', $data);
				}
			?>
		</div>
		
        <div class="col-lg-1">&nbsp;</div>
		<div class="col-lg-10">
			<div class="widget-container fluid-height clearfix">
				<div class="heading">
					EDIT WORK ROSTER
					<a href="javascript:void(0);" OnClick="link_to('master/work-roster');"><i class="icon-arrow-left pull-right"> Back</i></a>
				</div>
				<div class="widget-content padded clearfix">
					<?php foreach($detail as $row) : ?>
					<form id="validate-form" class="form-horizontal" method="post" action="<?php echo base_url(); ?>master/work-roster/update-data">
						<input type="hidden" name="valid" value="<?php echo simple_encrypt(1); ?>" />
						<input type="hidden" name="id" value="<?php echo simple_encrypt($row->workroster_id); ?>" />
						<div class="form-group">
							<label class="control-label col-md-2">Status</label>
							<div class="col-md-9">
								<div class="toggle-switch text-toggle-switch" data-off-label="<?php echo get_status(0); ?>" data-on="primary" data-on-label="<?php echo get_status(1); ?>" style="width:175px;">
									<input value="1" name="status" <?php echo (($row->workroster_status == 1)?"Checked":""); ?> type="checkbox" />
								</div>	
							</div>
						</div>
						<div class="social-login clearfix"></div>
						<div class="form-group">
							<label class="control-label col-md-2">Name <span class="text-danger">*</span></label>
							<div class="col-md-9">
								<input class="form-control" id="name" name="name" type="text" value="<?php echo strip_tags($row->workroster_name); ?>" autocomplete="off" required="" minlength="3" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Start <span class="text-danger">*</span></label>
							<div class="col-md-3">
								<div class="input-group bootstrap-timepicker">
									<input class="form-control" id="timepicker-24h" name="start" type="text" value="<?php echo convert_to_his($row->workroster_start); ?>" autocomplete="off" required="" ><span class="input-group-addon"><i class="icon-time"></i></span></input>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">End <span class="text-danger">*</span></label>
							<div class="col-md-3">
								<div class="input-group bootstrap-timepicker">
									<input class="form-control" id="timepicker-24" name="end" type="end" value="<?php echo convert_to_his($row->workroster_end); ?>" autocomplete="off" required="" ><span class="input-group-addon"><i class="icon-time"></i></span></input>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Description</label>
							<div class="col-md-9">
								<textarea class="form-control" rows="2" style="resize: none;" id="description" name="description"><?php echo strip_tags($row->workroster_description); ?></textarea>
							</div>
						</div>
						<div class="social-login clearfix"></div>
						<div class="form-group">
							<label class="control-label col-md-2"></label>
							<div class="col-md-7">
								<a class="" href="#fancybox-example"></a>
								<button class="btn btn-danger" type="reset"><i class="icon-repeat"></i> CANCEL</button>
								<button class="btn btn-primary" type="submit"><i class="icon-save"></i> SUBMIT</button>
							</div>
						</div>
					</form>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<div class="col-lg-1">&nbsp;</div>	
    </div>
    <!-- end DataTables Example -->
</div>