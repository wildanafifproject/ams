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
		
		<?php foreach($detail as $row) : ?>
		<form id="validate-form" class="form-horizontal" method="post" action="<?php echo base_url(); ?>non-emergency/update-data">
			<input type="hidden" name="valid" value="<?php echo simple_encrypt(1); ?>" readonly />
			<input type="hidden" name="id" value="<?php echo simple_encrypt($row->nonemergency_id); ?>" readonly />
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
									<option value="" selected>View all</option>
									<?php $callcenter = $this->m_global->get_by_id_and_order('tm_callcenter', 'callcenter_status', 1, 'callcenter_name', 'ASC'); ?>
									<?php foreach($callcenter as $rw) : ?>
									<option value="<?php echo $rw->callcenter_id; ?>" <?php echo (($row->callcenter_id == $rw->callcenter_id)?"Selected":""); ?>><?php echo strip_tags($rw->callcenter_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Internal Call</label>
							<div class="col-md-10">
								<select class="select2able" name="internalcall">
									<option value="" selected>View all</option>
									<?php $internalcall = $this->m_global->get_by_id_and_order('tm_internalcall', 'internalcall_status', 1, 'internalcall_name', 'ASC'); ?>
									<?php foreach($internalcall as $rw) : ?>
									<option value="<?php echo $rw->internalcall_id; ?>" <?php echo (($row->internalcall_id == $rw->internalcall_id)?"Selected":""); ?>><?php echo strip_tags($rw->internalcall_name); ?></option>
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
							<label class="control-label col-md-10"><?php echo get_dmy(); ?> / <?php echo get_his(); ?></label>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Patient Name</label>
							<div class="col-md-10">	
								<input class="form-control" placeholder="Patient Name" type="text" name="patient_name" value="<?php echo (($row->nonemergency_infoname == "")?"":$row->nonemergency_infoname); ?>" autocomplete="off" required="" minlength="3" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Phone No.</label>
							<div class="col-md-10">	
								<input class="form-control" placeholder="Phone No." type="text" name="phone_no" value="<?php echo (($row->nonemergency_infophone == "")?"":$row->nonemergency_infophone); ?>" autocomplete="off" required="" minlength="3" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Booking Date</label>
							<div class="col-md-10">
								<div class="input-group date datepicker" data-date-autoclose="true" data-date-format="dd-mm-yyyy">
									<input class="form-control" id="date" name="date" type="text" value="<?php echo (($row->nonemergency_infodate == "")?get_ymd():convert_to_dmy($row->nonemergency_infodate)); ?>" autocomplete="off" required="" OnChange="reset_area();" ><span class="input-group-addon"><i class="icon-calendar"></i></span></input>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Booking Time</label>
							<div class="col-md-10">
								<div class="input-group bootstrap-timepicker">
									<input class="form-control" id="timepicker-24h" name="time" type="text" value="<?php echo (($row->nonemergency_infotime == "")?get_his():convert_to_his($row->nonemergency_infotime)); ?>" autocomplete="off" required="" ><span class="input-group-addon"><i class="icon-time"></i></span></input>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Diagnosis</label>
							<div class="col-md-10">	
								<input class="form-control" placeholder="Diagnosis" type="text" name="diagnosis" value="<?php echo (($row->nonemergency_infodiagnosis == "")?"":$row->nonemergency_infodiagnosis); ?>" autocomplete="off" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Consultant</label>
							<div class="col-md-10">	
								<input class="form-control" placeholder="Consultant" type="text" name="consultant" value="<?php echo (($row->nonemergency_infoconsultant == "")?"":$row->nonemergency_infoconsultant); ?>" autocomplete="off" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Booking Reason</label>
							<div class="col-md-10">	
								<input class="form-control" placeholder="Booking Reason" type="text" name="reason" value="<?php echo (($row->nonemergency_inforeason == "")?"":$row->nonemergency_inforeason); ?>" autocomplete="off" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Type Transfer</label>
							<div class="col-md-10">
								<select class="select2able" name="transfer">
									<option value="" disabled selected>View all</option>
									<?php $transfer = $this->m_global->get_by_id_and_order('tm_transfer', 'transfer_status', 1, 'transfer_name', 'ASC'); ?>
									<?php foreach($transfer as $rw) : ?>
									<option value="<?php echo $rw->transfer_id; ?>" <?php echo (($row->transfer_id == $rw->transfer_id)?"Selected":""); ?>><?php echo strip_tags($rw->transfer_name); ?></option>
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
								<input class="form-control" placeholder="Name" type="text" name="name_request" value="<?php echo (($row->nonemergency_requestname == "")?"":$row->nonemergency_requestname); ?>" autocomplete="off" required="" minlength="3" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Departement</label>
							<div class="col-md-10">	
								<input class="form-control" placeholder="Departement" type="text" name="department_request" value="<?php echo (($row->nonemergency_requestdepartment == "")?"":$row->nonemergency_requestdepartment); ?>" autocomplete="off" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Staff Tittle</label>
							<div class="col-md-10">	
								<input class="form-control" placeholder="Staff Tittle" type="text" name="title_request" value="<?php echo (($row->nonemergency_requesttittle == "")?"":$row->nonemergency_requesttittle); ?>" autocomplete="off" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Notes</label>
							<div class="col-md-10">	
								<textarea class="form-control" rows="2" style="resize: none;" name="note"><?php echo strip_tags($row->nonemergency_requestnote); ?></textarea>
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
											if($row->subcategory_case == $rws->subcategory_id) {
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
								$i = 0;	$iChecked = "";		$ii = 0; $iiChecked = "";	$case_note = "";
								$category = $this->m_global->get_by_double_id_order('tm_category', 'category_status', 1, 'is_emergency', 1, 'category_id', 'ASC'); 
								foreach($category as $rw) :
									$iChecked = (($row->category_id == $rw->category_id)?"Checked":"");
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
											if($row->subcategory_id == $rws->subcategory_id) {
												$iiChecked = "Checked";
												$case_note = $row->case_note;
											}
											else {
												$iiChecked = "";
												$case_note = "";
											}
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
									<option value="" selected>View all</option>
									<?php foreach($hospital as $rw) : ?>
									<option value="<?php echo $rw->hospital_id; ?>" <?php echo (($row->nonemergency_fromhospital == $rw->hospital_id)?"Selected":""); ?>><?php echo strip_tags($rw->hospital_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<?php 
							if($row->nonemergency_from != 0) {
								$chkInternalFrom 	= "";
								$chkEksternalFrom 	= "Checked";
							}
							else {
								$chkInternalFrom 	= "Checked";
								$chkEksternalFrom 	= "";
							}
						?>
						<div class="form-group">
							<label class="control-label col-md-1">&nbsp;</label>
							<div class="col-md-9">
								<label class="radio">
									<input <?php echo $chkInternalFrom; ?> name="from_radio" type="radio" value="0"><span>INTERNAL LOCATION</span></label>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Location (ICU/UGD)</label>
							<div class="col-md-10">
								<select class="select2able" name="from_unit">
									<option value="" selected>View all</option>
									<?php $unit = $this->m_global->get_by_id_and_order('tm_unit', 'unit_status', 1, 'unit_name', 'ASC'); ?>
									<?php foreach($unit as $rw) : ?>
									<option value="<?php echo $rw->unit_id; ?>" <?php echo (($row->nonemergency_fromunit == $rw->unit_id)?"Selected":""); ?>><?php echo strip_tags($rw->unit_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">BED NO</label>
							<div class="col-md-10">	
								<input class="form-control" placeholder="Bed No." type="text" name="from_bed" value="<?php echo (($row->nonemergency_frombed == "")?"":$row->nonemergency_frombed); ?>" autocomplete="off" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-1">&nbsp;</label>
							<div class="col-md-9">
								<label class="radio">
									<input <?php echo $chkEksternalFrom; ?> name="from_radio" type="radio" value="1"><span>EXTERNAL LOCATION</span></label>
								</label>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12">
								<div class="input-group">
									<input class="form-control" id="street_search" name="street_search" value="<?php echo (($row->nonemergency_fromsearch == "")?"":$row->nonemergency_fromsearch); ?>" placeholder="Street Name" type="text">
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
							<div class="col-md-6"><input type="hidden" id="street_latitude" name="street_latitude" value="<?php echo (($row->nonemergency_fromlatitude == "")?"":$row->nonemergency_fromlatitude); ?>" readonly /></div>	
							<div class="col-md-6"><input type="hidden" id="street_longitude" name="street_longitude" value="<?php echo (($row->nonemergency_fromlongitude == "")?"":$row->nonemergency_fromlongitude); ?>" readonly /></div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Street</label>
							<div class="col-md-10"> 
								<textarea class="form-control" rows="2" style="resize: none;" id="street_address" name="street_address" readonly><?php echo (($row->nonemergency_fromstreet == "")?"":$row->nonemergency_fromstreet); ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Area</label>
							<div class="col-md-10">
								<select class="select2able" id="area" name="from_area" required="" OnChange="ambulance_by_avaibility(this.value);">
									<option value="" disabled selected>View all</option>
									<?php foreach($area as $rw) : ?>
									<option value="<?php echo $rw->area_id; ?>" <?php echo (($row->nonemergency_fromarea == $rw->area_id)?"Selected":""); ?>><?php echo strip_tags($rw->area_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Area Detail</label>
							<div class="col-md-10">	
								<select class="select2able" id="location" name="from_location" required="">
									<?php if($row->nonemergency_fromarea == "") { ?>
									<option value="" disabled selected>View all</option>
									<?php } else { ?>
									<?php $location = $this->m_global->get_by_double_id_order('tm_location', 'area_id', $row->nonemergency_fromarea, 'location_status', 1, 'location_name', 'ASC'); ?>
									<?php foreach($location as $rw) : ?>
									<option value="<?php echo $rw->location_id; ?>" <?php echo (($row->nonemergency_fromlocation == $rw->location_id)?"Selected":""); ?>><?php echo strip_tags($rw->location_name); ?></option>
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
						DESTINATION
					</div>
					<div class="widget-content padded clearfix">
						<div class="form-group">
							<label class="control-label col-md-2">Hospital</label>
							<div class="col-md-10">
								<select class="select2able" name="to_hospital" required="">
									<option value="" selected>View all</option>
									<?php foreach($hospital as $rw) : ?>
									<option value="<?php echo $rw->hospital_id; ?>" <?php echo (($row->nonemergency_tohospital == $rw->hospital_id)?"Selected":""); ?>><?php echo strip_tags($rw->hospital_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<?php 
							if($row->nonemergency_to != 0) {
								$chkInternalTo 	= "";
								$chkEksternalTo = "Checked";
							}
							else {
								$chkInternalTo 	= "Checked";
								$chkEksternalTo = "";
							}
						?>
						<div class="form-group">
							<label class="control-label col-md-1">&nbsp;</label>
							<div class="col-md-9">
								<label class="radio">
									<input <?php echo $chkInternalTo; ?> name="to_radio" type="radio" value="0"><span>INTERNAL LOCATION</span></label>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Location (ICU/UGD)</label>
							<div class="col-md-10">
								<select class="select2able" name="to_unit">
									<option value="" selected>View all</option>
									<?php $unit = $this->m_global->get_by_id_and_order('tm_unit', 'unit_status', 1, 'unit_name', 'ASC'); ?>
									<?php foreach($unit as $rw) : ?>
									<option value="<?php echo $rw->unit_id; ?>" <?php echo (($row->nonemergency_tounit == $rw->unit_id)?"Selected":""); ?>><?php echo strip_tags($rw->unit_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">BED NO</label>
							<div class="col-md-10">	
								<input class="form-control" placeholder="Bed No." type="text" name="to_bed" value="<?php echo (($row->nonemergency_tobed == "")?"":$row->nonemergency_tobed); ?>" autocomplete="off" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-1">&nbsp;</label>
							<div class="col-md-9">
								<label class="radio">
									<input <?php echo $chkEksternalTo; ?> name="to_radio" type="radio" value="1"><span>EXTERNAL LOCATION</span></label>
								</label>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12">
								<div class="input-group">
									<input class="form-control" id="street_search2" name="street_search2" value="<?php echo (($row->nonemergency_tosearch == "")?"":$row->nonemergency_tosearch); ?>" placeholder="Street Name" type="text">
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
							<div class="col-md-6"><input type="hidden" id="street_latitude2" name="street_latitude2" value="<?php echo (($row->nonemergency_tolatitude == "")?"":$row->nonemergency_tolatitude); ?>" readonly /></div>	
							<div class="col-md-6"><input type="hidden" id="street_longitude2" name="street_longitude2" value="<?php echo (($row->nonemergency_tolongitude == "")?"":$row->nonemergency_tolongitude); ?>" readonly /></div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Street</label>
							<div class="col-md-10"> 
								<textarea class="form-control" rows="2" style="resize: none;" id="street_address2" name="street_address2" readonly><?php echo (($row->nonemergency_tostreet == "")?"":$row->nonemergency_tostreet); ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Area</label>
							<div class="col-md-10">
								<select class="select2able" name="to_area" OnChange="ajax_areadetail_by_area(this.value);">
									<option value="" selected>View all</option>
									<?php foreach($area as $rw) : ?>
									<option value="<?php echo $rw->area_id; ?>" <?php echo (($row->nonemergency_toarea == $rw->area_id)?"Selected":""); ?>><?php echo strip_tags($rw->area_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Area Detail</label>
							<div class="col-md-10">	
								<select class="select2able" id="areadetail" name="to_location">
									<?php if($row->nonemergency_toarea == "") { ?>
									<option value="" selected>View all</option>
									<?php } else { ?>
									<?php $location = $this->m_global->get_by_double_id_order('tm_location', 'area_id', $row->nonemergency_toarea, 'location_status', 1, 'location_name', 'ASC'); ?>
									<?php foreach($location as $rw) : ?>
									<option value="" disabled selected>View all</option>
									<option value="<?php echo $rw->location_id; ?>" <?php echo (($row->nonemergency_tolocation == $rw->location_id)?"Selected":""); ?>><?php echo strip_tags($rw->location_name); ?></option>
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
								<?php 
									$arr_booking = array();
									$booking_ambulance = $this->load->model('master/m_ambulance')->get_booking_by_area_date_time($row->nonemergency_fromarea, $row->nonemergency_infodate, $row->nonemergency_infotime);
									foreach($booking_ambulance as $rowz) {
										$arr_booking[] = $rowz->ambulance_id;
									}
									
									$arr_available = array();
									$ambulance = $this->m_global->get_by_triple_id_order('tm_ambulance', 'ambulance_status', 0, 'is_login', 1, 'area_id', $row->nonemergency_fromarea, 'ambulance_id', 'ASC');
									foreach($ambulance as $rowz) {
										if (!in_array($rowz->ambulance_id, $arr_booking)) {
											$arr_available[] = array(
												'ambulance_id'		=> $rowz->ambulance_id,
												'hospital_code' 	=> $this->load->model('master/m_hospital')->get_code_by_id($rowz->hospital_id),
												'police_number'		=> $rowz->ambulance_police,
												'ambulance_status'	=> $rowz->ambulance_status
											);
										}
									}
									
									if(count($arr_available) > 0) {
									for($i=0; $i<count($arr_available); $i++) {
								?>
								<tr>
									<td align="center">
										<label class="checkbox-inline">
											<input type="checkbox" class="checkboxAmbulance" id="chkAmbulance<?php echo $arr_available[$i]['ambulance_id']; ?>" value="<?php echo $arr_available[$i]['ambulance_id'] ?>" name="chkAmbulance" OnChange="change_ambulance(<?php echo $arr_available[$i]['ambulance_id'] ?>);"><span></span>
										</label>
									</td>
									<td align="center"><?php echo $arr_available[$i]['hospital_code']; ?></td>
									<td align="center"><?php echo $arr_available[$i]['police_number']; ?></td>
									<td align="center">-</td>
									<td align="center">
										<span class="label label-<?php echo get_color($arr_available[$i]['ambulance_status']); ?>"><?php echo get_color($arr_available[$i]['ambulance_status']); ?></span>
									</td>
								</tr>
								<?php } ?>
								<?php } else { ?>
								<tr><td align="center" colspan="5">No data found</td></tr>
								<?php } ?>
								<?php ?>
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
								<th width="25%" style="text-align: center;">Motor Code</th>
								<th width="23%" style="text-align: center;">Police Number</th>
								<th style="text-align: center;">Case Type</th>
							</thead>
							<tbody>
								<?php 
									$motorbike = $this->m_global->get_by_triple_id_order('tm_motorbike', 'motorbike_status', 0, 'is_login', 1, 'area_id', $row->nonemergency_fromarea, 'motorbike_id', 'ASC');
									if(!empty($motorbike)) {
									foreach($motorbike as $rows) :	
								?>
								<tr>
									<td align="center">
										<label class="checkbox-inline">
											<input type="checkbox" <?php echo (($row->motorbike_id == $rows->motorbike_id)?"Checked":""); ?> class="checkboxMotorbike" id="chkMotorbike<?php echo $rows->motorbike_id ?>" value="<?php echo $rows->motorbike_id ?>" name="chkMotorbike" OnChange="change_motorbike(<?php echo $rows->motorbike_id ?>);"><span></span>
										</label>
									</td>
									<td align="center"><?php echo $this->load->model('master/m_hospital')->get_code_by_id($rows->hospital_id); ?></td>
									<td align="center"><?php echo $rows->motorbike_police; ?></td>
									<td align="center">-</td>
								</tr>
								<?php endforeach; ?>
								<?php } else { ?>
								<tr><td align="center" colspan="3">No data found</td></tr>
								<?php } ?>
								<?php ?>
							</tbody>
						</table>
					</div>
				</div>
				<br/>
				<div class="widget-container fluid-height clearfix">
					<div class="widget-content padded clearfix">
						<div class="row">
							<center>
								<a class="btn btn-danger" href="javascript:void(0);" OnClick="show_form_cancel_nonemergency('<?php echo simple_encrypt($row->nonemergency_id); ?>');"><i class="icon-trash"></i> CANCEL</a>
								<button type="reset" class="btn btn-danger"><i class="icon-repeat"></i> RESET</button>
								<a class="btn btn-primary" href="javascript:void(0);" OnClick="link_new_tab('non-emergency/prints');"><i class="icon-print"></i> PRINT</a>
								<button type="submit" class="btn btn-primary"><i class="icon-save"></i> SCHEDULE</button>
							</center>
						</div>
					</div>
				</div>
			</div>	
		</form>	
		<?php endforeach; ?>
	</div>  
</div>