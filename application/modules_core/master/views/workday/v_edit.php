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
					EDIT WORK DAY
					<a href="javascript:void(0);" OnClick="link_to('master/work-day');"><i class="icon-arrow-left pull-right"> Back</i></a>
				</div>
				<div class="widget-content padded clearfix">
					<?php foreach($detail as $row) : ?>
					<form id="validate-form" class="form-horizontal" method="post" action="<?php echo base_url(); ?>master/work-day/update-data">
						<input type="hidden" name="valid" value="<?php echo simple_encrypt(1); ?>" />
						<input type="hidden" name="id" value="<?php echo simple_encrypt($row->workday_id); ?>" />
						<div class="form-group">
							<label class="control-label col-md-2">Status</label>
							<div class="col-md-9">
								<div class="toggle-switch text-toggle-switch" data-off-label="<?php echo get_status(0); ?>" data-on="primary" data-on-label="<?php echo get_status(1); ?>" style="width:175px;">
									<input value="1" name="status" <?php echo (($row->workday_status == 1)?"Checked":""); ?> type="checkbox" />
								</div>	
							</div>
						</div>
						<div class="social-login clearfix"></div>
						<div class="form-group">
							<label class="control-label col-md-2">Hospital <span class="text-danger">*</span></label>
							<div class="col-md-4">
								<select class="select2able" name="hospital" required="">
									<option value="" disabled selected>Select hospital</option>
									<?php foreach($hospital as $rw) : ?>
									<option value="<?php echo $rw->hospital_id; ?>" <?php echo (($rw->hospital_id == $row->hospital_id)?"Selected":""); ?>><?php echo strip_tags($rw->hospital_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Workroster <span class="text-danger">*</span></label>
							<div class="col-md-4">
								<select class="select2able" name="workroster" required="">
									<option value="" disabled selected>Select workroster</option>
									<?php $workroster = $this->m_global->get_by_id('tm_workroster', 'workroster_status', 1); ?>
									<?php foreach($workroster as $rw) : ?>
									<option value="<?php echo $rw->workroster_id; ?>" <?php echo (($rw->workroster_id == $row->workroster_id)?"Selected":""); ?>><?php echo strip_tags($rw->workroster_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Date <span class="text-danger">*</span></label>
							<div class="col-sm-3">
								<div class="input-group date datepicker" data-date-autoclose="true" data-date-format="dd-mm-yyyy">
									<input class="form-control" type="text" name="date" value="<?php echo convert_to_dmy($row->workday_date); ?>" required=""><span class="input-group-addon"><i class="icon-calendar"></i></span></input>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Doctor</label>
							<div class="col-md-9">
								<select class="select2able" multiple="" id="doctor" name="doctor[]">
									<?php $doctor = $this->m_global->get_by_double_id_order('tm_doctor', 'hospital_id', $row->hospital_id, 'doctor_status', 1, 'doctor_name', 'ASC'); ?>
									<?php foreach($doctor as $rw) : ?>
									<option value="<?php echo $rw->doctor_id; ?>" <?php echo ((in_array($rw->doctor_id, $arr_doctor))?"Selected":""); ?>><?php echo strip_tags($rw->doctor_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Nurse</label>
							<div class="col-md-9">
								<select class="select2able" multiple="" id="nurse" name="nurse[]">
									<?php $nurse = $this->m_global->get_by_double_id_order('tm_nurse', 'hospital_id', $row->hospital_id, 'nurse_status', 1, 'nurse_name', 'ASC'); ?>
									<?php foreach($nurse as $rw) : ?>
									<option value="<?php echo $rw->nurse_id; ?>" <?php echo ((in_array($rw->nurse_id, $arr_nurse))?"Selected":""); ?>><?php echo strip_tags($rw->nurse_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Driver</label>
							<div class="col-md-9">
								<select class="select2able" multiple="" id="driver" name="driver[]">
									<?php $driver = $this->m_global->get_by_double_id_order('tm_driver', 'hospital_id', $row->hospital_id, 'driver_status', 1, 'driver_name', 'ASC'); ?>
									<?php foreach($driver as $rw) : ?>
									<option value="<?php echo $rw->driver_id; ?>" <?php echo ((in_array($rw->driver_id, $arr_driver))?"Selected":""); ?>><?php echo strip_tags($rw->driver_name); ?></option>
									<?php endforeach; ?>
								</select>
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