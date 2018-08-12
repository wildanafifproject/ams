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
					EDIT HOSPITAL
					<a href="javascript:void(0);" OnClick="link_to('master/hospital');"><i class="icon-arrow-left pull-right"> Back</i></a>
				</div>
				<div class="widget-content padded clearfix">
					<?php foreach($detail as $row) : ?>
					<form id="validate-form" class="form-horizontal" method="post" action="<?php echo base_url(); ?>master/hospital/update-data" enctype="multipart/form-data">
						<input type="hidden" name="valid" value="<?php echo simple_encrypt(1); ?>" />
						<input type="hidden" name="id" value="<?php echo simple_encrypt($row->hospital_id); ?>" />
						<div class="form-group">
							<label class="control-label col-md-2">Status</label>
							<div class="col-md-9">
								<div class="toggle-switch text-toggle-switch" data-off-label="<?php echo get_status(0); ?>" data-on="primary" data-on-label="<?php echo get_status(1); ?>" style="width:175px;">
									<input value="1" name="status" <?php echo (($row->hospital_status == 1)?"Checked":""); ?> type="checkbox" />
								</div>	
							</div>
						</div>
						<div class="social-login clearfix"></div>
						<div class="form-group">
							<label class="control-label col-md-2">Area <span class="text-danger">*</span></label>
							<div class="col-md-4">
								<select class="select2able" name="area" required="" OnChange="ajax_hospital(this.value);">
									<option value="" disabled selected>Select area</option>
									<?php $area = $this->m_global->get_by_id('tm_area', 'area_status', 1); ?>
									<?php foreach($area as $rw) : ?>
									<option value="<?php echo $rw->area_id; ?>" <?php echo (($row->area_id == $rw->area_id)?"Selected":""); ?>><?php echo strip_tags($rw->area_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">NO <span class="text-danger">*</span></label>
							<div class="col-md-3">
								<input class="form-control" id="code" name="code" type="text" value="<?php echo $row->hospital_no; ?>" autocomplete="off" required="" minlength="1" maxlength="10" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Name <span class="text-danger">*</span></label>
							<div class="col-md-9">
								<input class="form-control" id="name" name="name" type="text" value="<?php echo strip_tags($row->hospital_name); ?>" autocomplete="off" required="" minlength="3" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Email <span class="text-danger">*</span></label>
							<div class="col-md-9">
								<input class="form-control" id="email" name="email" type="email" value="<?php echo $row->hospital_email; ?>" autocomplete="off" required="" minlength="3" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Specialist</label>
							<div class="col-md-9">
								<select class="select2able" multiple="" id="specialist" name="specialist[]">
									<?php $specialist = $this->m_global->get_by_id('tm_specialist', 'specialist_status', 1); ?>
									<?php foreach($specialist as $rw) : ?>
									<option value="<?php echo $rw->specialist_id; ?>" <?php echo ((in_array($rw->specialist_id, $arr_specialist))?"Selected":""); ?>><?php echo strip_tags($rw->specialist_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Facility</label>
							<div class="col-md-9">
								<select class="select2able" multiple="" id="facility" name="facility[]">
									<?php $facility = $this->m_global->get_by_id('tm_facility', 'facility_status', 1); ?>
									<?php foreach($facility as $rw) : ?>
									<option value="<?php echo $rw->facility_id; ?>" <?php echo ((in_array($rw->facility_id, $arr_facility))?"Selected":""); ?>><?php echo strip_tags($rw->facility_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Identity</label>
							<div class="col-md-9">
								<input class="form-control" id="identity" name="identity" type="text" value="<?php echo $row->hospital_identity; ?>" autocomplete="off" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Phone</label>
							<div class="col-md-9">
								<input class="form-control" id="phone" name="phone" type="text" value="<?php echo $row->hospital_phone; ?>" autocomplete="off" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Latitude</label>
							<div class="col-md-9">
								<input class="form-control" id="latitude" name="latitude" type="text" value="<?php echo $row->hospital_latitude; ?>" autocomplete="off" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Longitude</label>
							<div class="col-md-9">
								<input class="form-control" id="longitude" name="longitude" type="text" value="<?php echo $row->hospital_longitude; ?>" autocomplete="off" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Address</label>
							<div class="col-md-9">
								<textarea class="form-control" rows="2" style="resize: none;" id="address" name="address"><?php echo strip_tags($row->hospital_address); ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Image</label>
							<div class="col-md-9">
								<div class="fileupload fileupload-new" data-provides="fileupload">
									<div class="fileupload-new img-thumbnail" style="width: 150px; height: 150px;">
										<img src="<?php echo base_url() ."assets/uploads/".(($row->hospital_image != "")?"hospital/thumb/". $row->hospital_image:"no_image.png"); ?>" style="width: 150px; max-height: 150px" />
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