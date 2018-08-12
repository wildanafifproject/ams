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
					ADD WORK DAY
					<a href="javascript:void(0);" OnClick="link_to('master/work-day');"><i class="icon-arrow-left pull-right"> Back</i></a>
				</div>
				<div class="widget-content padded clearfix">
					<form id="validate-form" class="form-horizontal" method="post" action="<?php echo base_url(); ?>master/work-day/insert-data">
						<input type="hidden" name="valid" value="<?php echo simple_encrypt(1); ?>" />
						<div class="form-group">
							<label class="control-label col-md-2">Status</label>
							<div class="col-md-9">
								<div class="toggle-switch text-toggle-switch" data-off-label="<?php echo get_status(0); ?>" data-on="primary" data-on-label="<?php echo get_status(1); ?>" style="width:175px;">
									<input value="1" name="status" checked type="checkbox" />
								</div>	
							</div>
						</div>
						<div class="social-login clearfix"></div>
						<div class="form-group">
							<label class="control-label col-md-2">Hospital <span class="text-danger">*</span></label>
							<div class="col-md-4">
								<select class="select2able" name="hospital" required="" onChange="ajax_hospital(this.value);">
									<option value="" disabled selected>Select hospital</option>
									<?php foreach($hospital as $rw) : ?>
									<option value="<?php echo $rw->hospital_id; ?>" <?php echo (($this->session->flashdata('hospital') == $rw->hospital_id)?"Selected":""); ?>><?php echo strip_tags($rw->hospital_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Work Roster <span class="text-danger">*</span></label>
							<div class="col-md-4">
								<select class="select2able" name="workroster" required="">
									<option value="" disabled selected>Select work roster</option>
									<?php $workroster = $this->m_global->get_by_id('tm_workroster', 'workroster_status', 1); ?>
									<?php foreach($workroster as $rw) : ?>
									<option value="<?php echo $rw->workroster_id; ?>" <?php echo (($this->session->flashdata('workroster') == $rw->workroster_id)?"Selected":""); ?>><?php echo strip_tags($rw->workroster_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Date Range <span class="text-danger">*</span></label>
							 <div class="col-sm-2">
								<input class="form-control" data-date-autoclose="true" data-date-format="dd-mm-yyyy" id="dpd1" placeholder="Start date" type="text" name="start" value="" required="" />
							</div>
							<div class="col-sm-2">
								<input class="form-control" data-date-autoclose="true" data-date-format="dd-mm-yyyy" id="dpd2" placeholder="End date" type="text" name="end" value="" required="" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Doctor</label>
							<div class="col-md-9">
								<select class="select2able" multiple="" id="doctor" name="doctor[]"></select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Nurse</label>
							<div class="col-md-9">
								<select class="select2able" multiple="" id="nurse" name="nurse[]"></select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Driver</label>
							<div class="col-md-9">
								<select class="select2able" multiple="" id="driver" name="driver[]"></select>
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
				</div>
			</div>
		</div>
		<div class="col-lg-1">&nbsp;</div>	
    </div>
    <!-- end DataTables Example -->
</div>