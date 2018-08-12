<div class="container-fluid main-content">
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
		
		<form id="validate-form" class="form-horizontal" method="post" action="<?php echo base_url(); ?>non-emergency/process-data">
			<input type="hidden" name="valid" value="<?php echo simple_encrypt(1); ?>" />
			<input type="hidden" name="time_start_form" value="<?php echo get_ymdhis(); ?>" />
			<div class="col-lg-6">
				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						BOOKING REFERENCE
					</div>
					<div class="widget-content padded clearfix">
						<div class="form-group">
							<label class="control-label col-md-2">Call Ref No.</label>
							<div class="col-md-10">	
								<input class="form-control" placeholder="Refrence No." type="text" value="<?php echo $code; ?>" readonly />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Call Center</label>
							<div class="col-md-10">
								<select class="select2able" name="callcenter">
									<option value="" disabled selected>View all</option>
									<?php $callcenter = $this->m_global->get_by_id_and_order('tm_callcenter', 'callcenter_status', 1, 'callcenter_name', 'ASC'); ?>
									<?php foreach($callcenter as $rw) : ?>
									<option value="<?php echo $rw->callcenter_id; ?>" <?php echo (($this->session->flashdata('callcenter') == $rw->callcenter_id)?"Selected":""); ?>><?php echo strip_tags($rw->callcenter_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Internal Call</label>
							<div class="col-md-10">
								<select class="select2able" name="internalcall">
									<option value="" disabled selected>View all</option>
									<?php $internalcall = $this->m_global->get_by_id_and_order('tm_internalcall', 'internalcall_status', 1, 'internalcall_name', 'ASC'); ?>
									<?php foreach($internalcall as $rw) : ?>
									<option value="<?php echo $rw->internalcall_id; ?>" <?php echo (($this->session->flashdata('internalcall') == $rw->internalcall_id)?"Selected":""); ?>><?php echo strip_tags($rw->internalcall_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<br/>
				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						GLOBAL INFO
					</div>
					<div class="widget-content padded clearfix">
						<div class="form-group">
							<label class="control-label col-md-2">Time Phone</label>
							<label class="control-label col-md-10"><?php echo get_ymd(); ?> / <?php echo get_his(); ?></label>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Patient Name</label>
							<div class="col-md-10">	
								<input class="form-control" placeholder="Patient Name" type="text" name="patient_name" value="<?php echo (($this->session->flashdata('patient_name') == "")?"":$this->session->flashdata('patient_name')); ?>" autocomplete="off" required="" minlength="3" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Phone No.</label>
							<div class="col-md-10">	
								<input class="form-control" placeholder="Phone No." type="text" name="phone_no" value="<?php echo (($this->session->flashdata('phone_no') == "")?"":$this->session->flashdata('phone_no')); ?>" autocomplete="off" required="" minlength="3" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Booking Date</label>
							<div class="col-md-10">
								<div class="input-group date datepicker" data-date-autoclose="true" data-date-format="dd-mm-yyyy">
									<input class="form-control" id="date" name="date" type="text" value="<?php echo (($this->session->flashdata('date') == "")?get_dmy():convert_to_dmy($this->session->flashdata('date'))); ?>" autocomplete="off" required="" OnChange="reset_area();"><span class="input-group-addon"><i class="icon-calendar"></i></span></input>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Booking Time</label>
							<div class="col-md-10">
								<div class="input-group bootstrap-timepicker">
									<input class="form-control" id="timepicker-24h" name="time" type="text" value="<?php echo (($this->session->flashdata('time') == "")?get_his():$this->session->flashdata('time')); ?>" autocomplete="off" required="" OnChange="reset_area();"><span class="input-group-addon"><i class="icon-time"></i></span></input>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Diagnosis</label>
							<div class="col-md-10">	
								<input class="form-control" placeholder="Diagnosis" type="text" name="diagnosis" value="<?php echo (($this->session->flashdata('diagnosis') == "")?"":$this->session->flashdata('diagnosis')); ?>" autocomplete="off" required="" minlength="3"  maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Consultant</label>
							<div class="col-md-10">	
								<input class="form-control" placeholder="Isikan dengan nama dokter spesialis" type="text" name="consultant" value="<?php echo (($this->session->flashdata('consultant') == "")?"":$this->session->flashdata('consultant')); ?>" autocomplete="off" required="" minlength="3"  maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Booking Reason</label>
							<div class="col-md-10">	
								<input class="form-control" placeholder="Booking Reason" type="text" name="reason" value="<?php echo (($this->session->flashdata('reason') == "")?"":$this->session->flashdata('reason')); ?>" autocomplete="off" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Type Transfer</label>
							<div class="col-md-10">
								<select class="select2able" name="transfer">
									<option value="" disabled selected>View all</option>
									<?php $transfer = $this->m_global->get_by_id_and_order('tm_transfer', 'transfer_status', 1, 'transfer_name', 'ASC'); ?>
									<?php foreach($transfer as $rw) : ?>
									<option value="<?php echo $rw->transfer_id; ?>" <?php echo (($this->session->flashdata('transfer') == $rw->transfer_id)?"Selected":""); ?>><?php echo strip_tags($rw->transfer_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<br/>
				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						REQUEST INFO
					</div>
					<div class="widget-content padded clearfix">
						<div class="form-group">
							<label class="control-label col-md-2">Name</label>
							<div class="col-md-10">	
								<input class="form-control" placeholder="Name" type="text" name="name_request" value="<?php echo (($this->session->flashdata('name_request') == "")?"":$this->session->flashdata('name_request')); ?>" autocomplete="off" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Departement</label>
							<div class="col-md-10">	
								<input class="form-control" placeholder="Departement" type="text" name="department_request" value="<?php echo (($this->session->flashdata('department_request') == "")?"":$this->session->flashdata('department_request')); ?>" autocomplete="off" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Staff Tittle</label>
							<div class="col-md-10">	
								<input class="form-control" placeholder="Staff Tittle" type="text" name="title_request" value="<?php echo (($this->session->flashdata('title_request') == "")?"":$this->session->flashdata('title_request')); ?>" autocomplete="off" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Notes</label>
							<div class="col-md-10">	
								<textarea class="form-control" rows="2" style="resize: none;" name="note"><?php echo (($this->session->flashdata('note') == "")?"":strip_tags($this->session->flashdata('note'))); ?></textarea>
							</div>
						</div>
					</div>
				</div>
				<br/>
				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						CASE TYPE
					</div>
					<div class="widget-container fluid-height clearfix">
						<div class="widget-content padded clearfix">
							<?php 
								$iiiChecked = "";	$iii = 0;
								$category = $this->m_global->get_by_double_id_order('tm_category', 'category_status', 1, 'is_emergency', 0, 'category_id', 'ASC'); 
								foreach($category as $rw) :
							?>
							<div class="form-group">
								<label class="control-label col-md-2">&nbsp;</label>
								<div class="col-md-10">
									<label class="radio">
									<input Checked type="radio"><span><?php echo strip_tags($rw->category_name); ?></span></label>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">&nbsp;</label>
								<div class="col-md-9">
									<?php 
										$subcategory = $this->m_global->get_by_double_id_order('tm_subcategory', 'subcategory_status', 1, 'category_id', $rw->category_id, 'subcategory_id', 'ASC'); 
										foreach($subcategory as $rws) :
											if($this->session->flashdata('sub_category_case') == $rws->subcategory_id) {
												$iiiChecked = "Checked";
											}	
											else {
												if($iii == 0) {
													$iiiChecked = "Checked";
												}
												else  {
													$iiiChecked = "";
												}
											}
									?>
									<label class="radio">
										<input <?php echo $iiiChecked; ?> name="sub_category_case" type="radio" value="<?php echo $rws->subcategory_id; ?>"><span><?php echo strip_tags($rws->subcategory_name); ?></span>
									</label>
									<?php 
											$iii = $iii + 1;
										endforeach; 
									?>
								</div>
							</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
				<br/>
				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						CASE TYPE
					</div>
					<div class="widget-container fluid-height clearfix">
						<div class="widget-content padded clearfix">
							<?php 
								$i = 0;	$iChecked = "";		$ii = 0; $iiChecked = "";
								$category = $this->m_global->get_by_double_id_order('tm_category', 'category_status', 1, 'is_emergency', 1, 'category_id', 'ASC'); 
								foreach($category as $rw) :
									if($this->session->flashdata('category') == $rw->category_id) {
										$iChecked = "Checked";
									}	
									else {
										if($i == 0) {
											$iChecked = "Checked";									}
										else  {
											$iChecked = "";
										}
									}
							?>
							<div class="form-group">
								<label class="control-label col-md-2">&nbsp;</label>
								<div class="col-md-10">
									<label class="radio">
									<input <?php echo $iChecked; ?> id="category<?php echo $rw->category_id; ?>" name="category" type="radio" value="<?php echo $rw->category_id; ?>"><span><?php echo strip_tags($rw->category_name); ?></span></label>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">&nbsp;</label>
								<div class="col-md-9">
									<?php 
										$subcategory = $this->m_global->get_by_double_id_order('tm_subcategory', 'subcategory_status', 1, 'category_id', $rw->category_id, 'subcategory_id', 'ASC'); 
										foreach($subcategory as $rws) :
											if($this->session->flashdata('sub_category') == $rws->subcategory_id) {
												$iiChecked = "Checked";
											}	
											else {
												if($ii == 0) {
													$iiChecked = "Checked";
												}
												else  {
													$iiChecked = "";
												}
											}
											
											$case_note = (($this->session->flashdata('description') == "")?"":$this->session->flashdata('description'));
									?>
									
									<label class="radio">
										<input <?php echo $iiChecked; ?> name="sub_category" type="radio" value="<?php echo $rws->subcategory_id; ?>" OnChange="change_radio(<?php echo $rw->category_id; ?>);"><span><?php echo strip_tags($rws->subcategory_name); ?></span>
									</label>
									<?php 
											$ii = $ii + 1;
										endforeach; 
									?>
								</div>
							</div>
							<?php 
									$i = $i + 1;
								endforeach; 
							?>
							<div class="form-group">
								<label class="control-label col-md-3">&nbsp;</label>
								<div class="col-md-9">
									<input class="form-control" type="text" id="description<?php echo $rw->category_id; ?>" value="<?php echo $case_note; ?>" name="description[]" autocomplete="off" maxlength="255" />
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						PICK UP FROM
					</div>
					<div class="widget-content padded clearfix">
						<div class="form-group">
							<label class="control-label col-md-2">Hospital</label>
							<div class="col-md-10">
								<select class="select2able" name="from_hospital" required="">
									<option value="" disabled selected>View all</option>
									<?php foreach($hospital as $rw) : ?>
									<option value="<?php echo $rw->hospital_id; ?>" <?php echo (($this->session->flashdata('from_hospital') == $rw->hospital_id)?"Selected":""); ?>><?php echo strip_tags($rw->hospital_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Area</label>
							<div class="col-md-10">
								<select class="select2able" id="area" name="from_area" required="" OnChange="ambulance_by_avaibility(this.value);">
									<option value="" disabled selected>View all</option>
									<?php foreach($area as $rw) : ?>
									<option value="<?php echo $rw->area_id; ?>"><?php echo strip_tags($rw->area_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Area Detail</label>
							<div class="col-md-10">	
								<select class="select2able" id="location" name="from_location" required="">
									<?php if($this->session->flashdata('area') == "") { ?>
									<option value="" disabled selected>View all</option>
									<?php } else { ?>
									<?php $location = $this->m_global->get_by_double_id_order('tm_location', 'area_id', $this->session->flashdata('area'), 'location_status', 1, 'location_name', 'ASC'); ?>
									<?php foreach($location as $rw) : ?>
									<option value="<?php echo $rw->location_id; ?>"><?php echo strip_tags($rw->location_name); ?></option>
									<?php endforeach; ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-1">&nbsp;</label>
							<div class="col-md-9">
								<label class="radio">
									<input checked name="from_radio" type="radio" value="0"><span>INTERNAL LOCATION</span></label>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Location (ICU/UGD)</label>
							<div class="col-md-10">
								<select class="select2able" name="from_unit" id="pickupInternalLocation">
									<option value="" disabled selected>View all</option>
									<?php $unit = $this->m_global->get_by_id_and_order('tm_unit', 'unit_status', 1, 'unit_name', 'ASC'); ?>
									<?php foreach($unit as $rw) : ?>
									<option value="<?php echo $rw->unit_id; ?>" <?php echo (($this->session->flashdata('from_unit') == $rw->unit_id)?"Selected":""); ?>><?php echo strip_tags($rw->unit_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">BED NO</label>
							<div class="col-md-10">	
								<input id="pickupInternalBed" class="form-control" placeholder="Bed No." type="text" name="from_bed" value="<?php echo (($this->session->flashdata('from_bed') == "")?"":$this->session->flashdata('from_bed')); ?>" autocomplete="off" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-1">&nbsp;</label>
							<div class="col-md-9">
								<label class="radio">
									<input name="from_radio" type="radio" value="1"><span>EXTERNAL LOCATION</span></label>
								</label>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12">
								<div class="input-group">
									<input readonly="" class="form-control" id="street_search" name="street_search" value="" placeholder="Street Name" type="text">
										<span class="input-group-btn">
											<a href="javscript:void(0);" OnClick="codeAddress();" class="btn btn-default"><i class="icon-search"></i></a>
										</span>
									</input>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12">
								<div id="mapCanvas"></div>
							</div>
						</div>	
						<div class="form-group">
							<div class="col-md-6"><input type="hidden" id="street_latitude" name="street_latitude" value="" readonly /></div>	
							<div class="col-md-6"><input type="hidden" id="street_longitude" name="street_longitude" value="" readonly /></div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Street</label>
							<div class="col-md-10"> 
								<textarea class="form-control" rows="2" style="resize: none;" id="street_address" name="street_address" readonly></textarea>
							</div>
						</div>
						
					</div>
				</div>
				<br/>
				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						DESTINATION
					</div>
					<div class="widget-content padded clearfix">
						<div class="form-group">
							<label class="control-label col-md-2">Hospital</label>
							<div class="col-md-10">
								<select class="select2able" name="to_hospital" required="">
									<option value="" disabled selected>View all</option>
									<?php foreach($hospital as $rw) : ?>
									<option value="<?php echo $rw->hospital_id; ?>" <?php echo (($this->session->flashdata('to_hospital') == $rw->hospital_id)?"Selected":""); ?>><?php echo strip_tags($rw->hospital_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-1">&nbsp;</label>
							<div class="col-md-9">
								<label class="radio">
									<input  name="to_radio" disabled=""  id="to_internal" type="radio" value="0"><span>INTERNAL LOCATION</span></label>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Location (ICU/UGD)</label>
							<div class="col-md-10">
								<select class="select2able" name="to_unit" id="toInternalLocation" disabled="" >
									<option value="" disabled selected>View all</option>
									<?php $unit = $this->m_global->get_by_id_and_order('tm_unit', 'unit_status', 1, 'unit_name', 'ASC'); ?>
									<?php foreach($unit as $rw) : ?>
									<option value="<?php echo $rw->unit_id; ?>" <?php echo (($this->session->flashdata('to_unit') == $rw->unit_id)?"Selected":""); ?>><?php echo strip_tags($rw->unit_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">BED NO</label>
							<div class="col-md-10">	
								<input  readonly="" id="toInternalBed" class="form-control" placeholder="Bed No." type="text" name="to_bed" value="<?php echo (($this->session->flashdata('to_bed') == "")?"":$this->session->flashdata('from_bed')); ?>" autocomplete="off" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-1">&nbsp;</label>
							<div class="col-md-9">
								<label class="radio">
									<input checked name="to_radio" id="to_external" type="radio" value="1"><span>EXTERNAL LOCATION</span></label>
								</label>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12">
								<div class="input-group">
									<input class="form-control" id="street_search2" name="street_search2" value="" placeholder="Street Name" type="text">
										<span class="input-group-btn">
											<a href="javscript:void(0);" OnClick="codeAddress2();" class="btn btn-default"><i class="icon-search"></i></a>
										</span>
									</input>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12">
								<div id="mapCanvas2"></div>
							</div>
						</div>	
						<div class="form-group">
							<div class="col-md-6"><input type="hidden" id="street_latitude2" name="street_latitude2" value="" readonly /></div>	
							<div class="col-md-6"><input type="hidden" id="street_longitude2" name="street_longitude2" value="" readonly /></div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Street</label>
							<div class="col-md-10"> 
								<textarea class="form-control" rows="2" style="resize: none;" id="street_address2" name="street_address2" readonly></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Area</label>
							<div class="col-md-10">
								<select class="select2able" name="to_area" OnChange="ajax_areadetail_by_area(this.value);">
									<option value="" disabled selected>View all</option>
									<?php foreach($area as $rw) : ?>
									<option value="<?php echo $rw->area_id; ?>"><?php echo strip_tags($rw->area_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Area Detail</label>
							<div class="col-md-10">	
								<select class="select2able" id="areadetail" name="to_location">
									<?php if($this->session->flashdata('area') == "") { ?>
									<option value="" disabled selected>View all</option>
									<?php } else { ?>
									<?php $location = $this->m_global->get_by_double_id_order('tm_location', 'area_id', $this->session->flashdata('area'), 'location_status', 1, 'location_name', 'ASC'); ?>
									<?php foreach($location as $rw) : ?>
									<option value="<?php echo $rw->location_id; ?>"><?php echo strip_tags($rw->location_name); ?></option>
									<?php endforeach; ?>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<br/>
				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						AMBULANCE
					</div>
					<div class="widget-content padded clearfix" id="listing_ambulance">
						<input type="hidden" name="chkAmbulance" value="" />
						<table class="table table-bordered table-striped">
							<thead>
								<th width="10%" style="text-align: center;">&nbsp;</th>
								<th width="25%" style="text-align: center;">Ambulance Code</th>
								<th width="23%" style="text-align: center;">Police Number</th>
								<th style="text-align: center;">Case Type</th>
								<th width="18%" style="text-align: center;">Status</th>
							</thead>
							<tbody>
								<tr><td align="center" colspan="5">No data found</td></tr>
							</tbody>
						</table>
					</div>
				</div>
				<br/>
				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						MOTOR BIKE
					</div>
					<div class="widget-content padded clearfix" id="listing_motorbike">
						<input type="hidden" name="chkMotorbike" value="" />
						<table class="table table-bordered table-striped">
							<thead>
								<th width="10%" style="text-align: center;">&nbsp;</th>
								<th width="25%" style="text-align: center;">Motor Code</th>
								<th width="23%" style="text-align: center;">Police Number</th>
								<th style="text-align: center;">Case Type</th>
								<th width="18%" style="text-align: center;">Status</th>
							</thead>
							<tbody>
								<tr><td align="center" colspan="5">No data found</td></tr>
							</tbody>
						</table>
					</div>
				</div>
				<br/>
				<div class="widget-container fluid-height clearfix">
					<div class="widget-content padded clearfix">
						<div class="row">
							<center>
								<a class="btn btn-danger" href="javascript:void(0);" OnClick="link_to('dashboard');"><i class="icon-trash"></i> CANCEL ORDER</a>
								<button type="reset" class="btn btn-danger"><i class="icon-repeat"></i> RESET</button>
								<a class="btn btn-primary" href="javascript:void(0);" OnClick="link_new_tab('non-emergency/prints');"><i class="icon-print"></i> PRINT</a>
								<button type="submit" class="btn btn-primary"><i class="icon-save"></i> SCHEDULE</button>
							</center>
						</div>
					</div>
				</div>
			</div>	
		</form>	
	</div>  
</div>

<script type="text/javascript">
	$(document).ready(function() {
	    $('input[type=radio][name=from_radio]').change(function() {
	        if (this.value == '0') {
	           //alert("internall");
	            $("#to_external").prop('checked',true);
	            $("#to_internal").prop('checked',false);
	            $('#to_internal').attr('disabled',true);
	            $('#to_external').removeAttr('disabled');

	            $('#street_search').attr('readonly', true);
	            $('#pickupInternalBed').removeAttr('readonly');
	            $('#pickupInternalLocation').removeAttr('disabled');

	            $('#street_search2').removeAttr('readonly');
	            $('#toInternalBed').attr('readonly',true);
	            $('#toInternalLocation').attr('disabled', true);

	            //set val
	            $('#street_search').val('');
	            $('#street_address').val('');

	            // $('#street_search2').val('');
	            // $('#street_address2').val('');
	            //$('#to_external').attr('readonly','');
	        }
	        else if (this.value == '1') {
	        	$("#to_external").prop('checked',false);
	            $("#to_internal").prop('checked',true);
	            $('input[type=radio][name=from_radio]').attr('readonly','');
	            
	            $('#to_external').attr('disabled',true);
	            $('#to_internal').removeAttr('disabled');

	            $('#pickupInternalBed').val("");
	            $('#pickupInternalLocation').val("");
	            $('#pickupInternalLocation').trigger('change');
	           // $('#pickupInternalLocation option[value=]').attr('selected','selected');
	            $('#street_search').removeAttr('readonly');
	            $('#pickupInternalBed').attr('readonly',true);
	            $('#pickupInternalLocation').attr('disabled', true);

	            

	            $('#street_search2').attr('readonly',true);
	            $('#toInternalBed').removeAttr('readonly');
	            $('#toInternalLocation').removeAttr('disabled');

	            $('#street_search2').val('');
	            $('#street_address2').val('');
	            //alert("EXTERNAL");
	        }
	    });
	});
</script>