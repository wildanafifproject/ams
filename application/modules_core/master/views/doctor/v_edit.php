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
					EDIT DOCTORS
					<a href="javascript:void(0);" OnClick="link_to('master/doctor');"><i class="icon-arrow-left pull-right"> Back</i></a>
				</div>
				<div class="widget-content padded clearfix">
					<?php foreach($detail as $row) : ?>
					<form id="validate-form" class="form-horizontal" method="post" action="<?php echo base_url(); ?>master/doctor/update-data" enctype="multipart/form-data">
						<input type="hidden" name="valid" value="<?php echo simple_encrypt(1); ?>" />
						<input type="hidden" name="id" value="<?php echo simple_encrypt($row->doctor_id); ?>" />
						<div class="form-group">
							<label class="control-label col-md-2">Status</label>
							<div class="col-md-9">
								<div class="toggle-switch text-toggle-switch" data-off-label="<?php echo get_status(0); ?>" data-on="primary" data-on-label="<?php echo get_status(1); ?>" style="width:175px;">
									<input value="1" name="status" <?php echo (($row->doctor_status == 1)?"Checked":""); ?> type="checkbox" />
								</div>	
							</div>
						</div>
						<div class="social-login clearfix"></div>
						<div class="form-group">
							<label class="control-label col-md-2">Hospital <span class="text-danger">*</span></label>
							<div class="col-md-4">
								<select class="select2able" name="hospital" required="">
									<?php $hospital = $this->m_global->get_by_id('tm_hospital', 'hospital_status', 1); ?>
									<?php foreach($hospital as $rw) : ?>
									<option value="<?php echo $rw->hospital_id; ?>" <?php echo (($rw->hospital_id == $row->hospital_id)?"Selected":""); ?>><?php echo strip_tags($rw->hospital_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Specialist <span class="text-danger">*</span></label>
							<div class="col-md-4">
								<select class="select2able" name="specialist" required="">
									<option value="" disabled selected>Select specialist</option>
									<?php $specialist = $this->m_global->get_by_id('tm_specialist', 'specialist_status', 1); ?>
									<?php foreach($specialist as $rw) : ?>
									<option value="<?php echo $rw->specialist_id; ?>" <?php echo (($rw->specialist_id == $row->specialist_id)?"Selected":""); ?>><?php echo strip_tags($rw->specialist_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Code <span class="text-danger">*</span></label>
							<div class="col-md-4">
								<input class="form-control" id="code" name="code" type="text" value="<?php echo $row->doctor_code; ?>" autocomplete="off" required="" minlength="3" maxlength="25" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Name <span class="text-danger">*</span></label>
							<div class="col-md-9">
								<input class="form-control" id="name" name="name" type="text" value="<?php echo strip_tags($row->doctor_name); ?>" autocomplete="off" required="" minlength="3" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Phone <span class="text-danger">*</span></label>
							<div class="col-md-3">
								<input class="form-control" id="phone" name="phone" type="text" value="<?php echo $row->doctor_phone; ?>" autocomplete="off" required="" minlength="3" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Email <span class="text-danger">*</span></label>
							<div class="col-md-9">
								<input class="form-control" id="email" name="email" type="email" value="<?php echo $row->doctor_email; ?>" autocomplete="off" required="" minlength="3" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Address</label>
							<div class="col-md-9">
								<textarea class="form-control" rows="2" style="resize: none;" id="address" name="address"><?php echo strip_tags($row->doctor_address); ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Image</label>
							<div class="col-md-9">
								<div class="fileupload fileupload-new" data-provides="fileupload">
									<div class="fileupload-new img-thumbnail" style="width: 150px; height: 150px;">
										<img src="<?php echo base_url() ."assets/uploads/".(($row->doctor_image != "")?"doctor/thumb/". $row->doctor_image:"no_image.png"); ?>" style="width: 150px; max-height: 150px" />
									</div>
									<div class="fileupload-preview fileupload-exists img-thumbnail" style="width: 150px; max-height: 150px"></div>
									<div>
										<span class="btn btn-default btn-file">
											<span class="fileupload-new">Select image</span>
											<span class="fileupload-exists">Change</span>
											<input type="file" name="userfile" />
										</span>
										<a class="btn btn-default fileupload-exists" data-dismiss="fileupload" href="javascript:void(0);">Remove</a>
									</div>
								</div>
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