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
		<form id="validate-form" class="form-horizontal" method="post" action="<?php echo base_url(); ?>emergency/update-data">
			<input type="hidden" name="valid" value="<?php echo simple_encrypt(1); ?>" readonly />
			<input type="hidden" id="date" value="<?php echo get_ymd(); ?>" />
			<input type="hidden" id="timepicker-24h" value="<?php echo get_h() ."00:00"; ?>" />
			<input type="hidden" name="id" value="<?php echo simple_encrypt($row->emergency_id); ?>" readonly />
			<div class="col-lg-6">
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
							<label class="control-label col-md-2">Call Ref No.</label>
							<div class="col-md-10">	
								<input class="form-control" placeholder="Refrence No." type="text" value="<?php echo $code; ?>" readonly />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Source Call</label>
							<div class="col-md-10">
								<select class="select2able" name="source" required="">
									<option value="" disabled selected>View all</option>
									<?php $source = $this->m_global->get_by_id_and_order('tm_source', 'source_status', 1, 'source_name', 'ASC'); ?>
									<?php foreach($source as $rw) : ?>
									<option value="<?php echo $rw->source_id; ?>" <?php echo (($row->source_id == $rw->source_id)?"Selected":""); ?>><?php echo strip_tags($rw->source_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Forward To</label>
							<div class="col-md-10">
								<select class="select2able" name="forward" required="">
									<option value="" disabled selected>View all</option>
									<?php foreach($forward as $rw) : ?>
									<?php if($rw->forward_status == 1) { ?>
									<option value="<?php echo $rw->forward_id; ?>" <?php echo (($row->forward_id == $rw->forward_id)?"Selected":""); ?>><?php echo strip_tags($rw->forward_name); ?></option>
									<?php } ?>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<br/>
				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						CALLER INFO
					</div>
					<div class="widget-content padded clearfix">
						<div class="form-group">
							<label class="control-label col-md-2">Call Name</label>
							<div class="col-md-10">	
								<input class="form-control" placeholder="Call Name" type="text" name="call_name" value="<?php echo (($row->emergency_callername == "")?"":$row->emergency_callername); ?>" autocomplete="off" required="" minlength="3" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Phone No.</label>
							<div class="col-md-10">	
								<input class="form-control" placeholder="Phone No." type="text" name="call_phone" value="<?php echo (($row->emergency_callerphone == "")?"":$row->emergency_callerphone); ?>" autocomplete="off" required="" minlength="3" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Other Phone</label>
							<div class="col-md-10">	
								<input class="form-control" type="text" name="other_phone" value="<?php echo (($row->emergency_callerother == "")?"":$row->emergency_callerother); ?>" autocomplete="off" axlength="255" />
							</div>
						</div>
					</div>
				</div>
				<br/>
				<!-- aptien -->
				<br/>
				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						PATIENT INFO
					</div>
					<div class="widget-content padded clearfix">
						<div class="form-group">
							<label class="control-label col-md-2">Total Patient</label>
							<div class="col-md-10">	
								<input class="form-control" placeholder="Total Patient" type="number" name="total_patient" value="<?php echo $row->emergency_patienttotal; ?>" min="1" max="100" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Total Unconscious</label>
							<div class="col-md-10">	
								<input class="form-control" placeholder="Total Unconscious" type="number" name="total_unconscious" value="<?php echo $row->emergency_patientunconscious; ?>" min="0" max="100" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Notes</label>
							<div class="col-md-10">	
								<textarea class="form-control" rows="2" style="resize: none;" name="note"><?php echo strip_tags($row->emergency_patientnote); ?></textarea>
							</div>
						</div>
						<div class="form-group" style="border-bottom: 1px solid #eee;"></div>
						<div class="form-group">
							<label class="control-label col-md-2">Patient Name</label>
							<div class="col-md-7">
								<input autocomplete="off" id="patient_search" name="patient_name" class="form-control typeahead tt-query" dir="auto" placeholder="Patient Name" spellcheck="false" value="<?php echo $row->emergency_patientname; ?>" type="text" required="" maxlength="255">
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-2">Patient DOB</label>
							<div class="col-md-10">
								<div class="input-group date datepicker" data-date-autoclose="true" data-date-format="dd-mm-yyyy">
									<input class="form-control" type="text" name="patient_dob" value="<?php echo (($row->emergency_patientdob == "")?NULL:convert_to_dmy($row->emergency_patientdob)); ?>" autocomplete="off" required="" /><span class="input-group-addon"><i class="icon-calendar"></i></span></input>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Medical Record No.</label>
							<div class="col-md-10">	
								<input class="form-control" readonly type="text" />
							</div>
						</div>
					</div>
				</div>
				<br/>
				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						CASE TYPE
					</div>
					<div class="widget-content padded clearfix">
						<div class="form-group">
							<label class="control-label col-md-1">&nbsp;</label>
							<div class="col-md-11">
								<label class="radio">
									<input checked="" name="optionsRadios_1" type="radio" value="emergency"><span>Emergency</span></label>
								</label>
							</div>
						</div>
						<?php 
							$iChecked = "";		$iiChecked = "";	$case_note = "";
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
								<?php endforeach; ?>
							</div>
						</div>
						<?php endforeach; ?>
						<div class="form-group">
							<label class="control-label col-md-3">&nbsp;</label>
							<div class="col-md-9">
								<input class="form-control" type="text" id="description<?php echo $rw->category_id; ?>" value="<?php echo $case_note; ?>" name="description[]" autocomplete="off" maxlength="255" />
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						CASE INFO
					</div>
					<div class="widget-content padded clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<div class="input-group">
									<input class="form-control" id="street_search" name="street_search" value="<?php echo $row->emergency_infosearch; ?>" placeholder="Street Name" type="text" autocomplete="off" required="" minlength="3" maxlength="255" />
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
							<div class="col-md-12"><input type="hidden" id="street_latitude" name="street_latitude" value="<?php echo $row->emergency_infolatitude; ?>" readonly /></div>	
							<div class="col-md-12"><input type="hidden" id="street_longitude" name="street_longitude" value="<?php echo $row->emergency_infolongitude; ?>" readonly /></div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Street</label>
							<div class="col-md-10">	
								<textarea class="form-control" rows="2" style="resize: none;" id="street_address" name="street_address" readonly><?php echo strip_tags($row->emergency_infostreet); ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Area</label>
							<div class="col-md-10">
								<select class="select2able" id="area"  name="area" required="" OnChange="ambulance_by_avaibility(this.value);">
									<option value="" disabled selected>View all</option>
									<?php foreach($area as $rw) : ?>
									<option value="<?php echo $rw->area_id; ?>" <?php echo (($row->area_id == $rw->area_id)?"Selected":""); ?>><?php echo strip_tags($rw->area_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Area Detail</label>
							<div class="col-md-10">	
								<select class="select2able" id="location" name="location" required="">
									<option value="" disabled selected>View all</option>
									<?php $location = $this->m_global->get_by_double_id_order('tm_location', 'area_id', $row->area_id, 'location_status', 1, 'location_name', 'ASC'); ?>
									<?php foreach($location as $rw) : ?>
									<option value="<?php echo $rw->location_id; ?>" <?php echo (($row->location_id == $rw->location_id)?"Selected":""); ?>><?php echo strip_tags($rw->location_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Other Info</label>
							<div class="col-md-10">	
								<textarea class="form-control" rows="2" style="resize: none;" name="other_info"><?php echo strip_tags($row->emergency_infootherinformation); ?></textarea>
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
								<th width="25%" style="text-align: center;">Hospital Code</th>
								<th width="23%" style="text-align: center;">Police Number</th>
								<th style="text-align: center;">Case Type</th>
								<th width="18%" style="text-align: center;">Status</th>
							</thead>
							<tbody>
								<?php 
									$ambulance = $this->m_global->get_by_triple_id_order('tm_ambulance', 'ambulance_status', 0, 'is_login', 1, 'area_id', $row->area_id, 'ambulance_id', 'ASC');
									if(!empty($ambulance)) {
									foreach($ambulance as $rows) :	
								?>
								<tr>
									<td align="center">
										<label class="checkbox-inline">
											<input type="checkbox" <?php echo (($row->ambulance_id == $rows->ambulance_id)?"Checked":""); ?> class="checkboxAmbulance" id="chkAmbulance<?php echo $rows->ambulance_id ?>" value="<?php echo $rows->ambulance_id ?>" name="chkAmbulance" OnChange="change_ambulance(<?php echo $rows->ambulance_id ?>);"><span></span>
										</label>
									</td>
									<td align="center"><?php echo $this->load->model('master/m_hospital')->get_code_by_id($rows->hospital_id); ?></td>
									<td align="center"><?php echo $rows->ambulance_police; ?></td>
									<td align="center">-</td>
									<td align="center">
										<span class="label label-<?php echo get_color($rows->ambulance_status); ?>"><?php echo get_ambulance($rows->ambulance_status); ?></span>
									</td>
								</tr>
								<?php endforeach; ?>
								<?php } else { ?>
								<tr><td align="center" colspan="5">No data found</td></tr>
								<?php } ?>
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
								<th width="25%" style="text-align: center;">Hospital Code</th>
								<th width="23%" style="text-align: center;">Police Number</th>
								<th style="text-align: center;">Case Type</th>
								<th width="18%" style="text-align: center;">Status</th>
							</thead>
							<tbody>
								<?php 
									$motorbike = $this->m_global->get_by_triple_id_order('tm_motorbike', 'motorbike_status', 0, 'is_login', 1, 'area_id', $row->area_id, 'motorbike_id', 'ASC');
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
									<td align="center">
										<span class="label label-<?php echo get_color($rows->motorbike_status); ?>"><?php echo get_color($rows->motorbike_status); ?></span>
									</td>
								</tr>
								<?php endforeach; ?>
								<?php } else { ?>
								<tr><td align="center" colspan="5">No data found</td></tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<br/>
				<div class="widget-container fluid-height clearfix">
					<div class="widget-content padded clearfix">
						<div class="row">
							<center>
								<a class="btn btn-danger" href="javascript:void(0);" OnClick="show_form_cancel_emergency('<?php echo simple_encrypt($row->emergency_id); ?>');"><i class="icon-trash"></i> CANCEL</a>
								<button type="reset" class="btn btn-danger"><i class="icon-repeat"></i> RESET</button>
								<a class="btn btn-warning" href="javascript:void(0);" OnClick="show_message('uwiww uwiiww uwwwiiiiwww');"><i class="icon-bell"></i> SIRINE</a>
								<a class="btn btn-primary" href="javascript:void(0);" OnClick="link_new_tab('emergency/prints');"><i class="icon-print"></i> PRINT</a>
								<button type="submit" class="btn btn-primary"><i class="icon-save"></i> ORDER</button>
							</center>
						</div>
					</div>
				</div>
			</div>	
		</form>	
		<?php endforeach; ?>
	</div>  
</div>