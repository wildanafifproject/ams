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
		
		<form id="validate-form" class="form-horizontal" method="post" action="<?php echo base_url(); ?>emergency/process-data">
			<input type="hidden" name="valid" value="<?php echo simple_encrypt(1); ?>" />
			<input type="hidden" id="date" value="<?php echo get_ymd(); ?>" />
			<input type="hidden" name="time_start_form" value="<?php echo get_ymdhis(); ?>" />
			<input type="hidden" id="timepicker-24h" value="<?php echo get_h() ."00:00"; ?>" />
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
									<option value="<?php echo $rw->source_id; ?>" <?php echo (($this->session->flashdata('source') == $rw->source_id)?"Selected":""); ?>><?php echo strip_tags($rw->source_name); ?></option>
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
									<option value="<?php echo $rw->forward_id; ?>" <?php echo (($this->session->flashdata('forward') == $rw->forward_id)?"Selected":""); ?>><?php echo strip_tags($rw->forward_name); ?></option>
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
						CALLER INFO / INFORMASI PENELEPHONE
					</div>
					<div class="widget-content padded clearfix">
						<div class="form-group">
							<label class="control-label col-md-2">Call Name</label>
							<div class="col-md-10">	
								<input class="form-control" placeholder="Call Name" type="text" name="call_name" value="<?php echo (($this->session->flashdata('call_name') == "")?"":$this->session->flashdata('call_name')); ?>" autocomplete="off" required="" minlength="3" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Phone No.</label>
							<div class="col-md-10">	
								<input class="form-control" placeholder="Phone No." type="text" name="call_phone" value="<?php echo (($this->session->flashdata('call_phone') == "")?"":$this->session->flashdata('call_phone')); ?>" autocomplete="off" required="" minlength="3" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Other Phone</label>
							<div class="col-md-10">	
								<input class="form-control" type="text"name="other_phone" value="<?php echo (($this->session->flashdata('other_phone') == "")?"":$this->session->flashdata('other_phone')); ?>" autocomplete="off" axlength="255" />
							</div>
						</div>
					</div>
				</div>
				<br/>
				<!-- aptien -->
				<br/>
				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						PATIENT INFO / INFORMASI TENTANG PASIEN
					</div>
					<div class="widget-content padded clearfix">
						<input class="form-control" placeholder="Total Patient" type="hidden" name="total_patient" value="<?php echo (($this->session->flashdata('total_patient') == "")?"1":$this->session->flashdata('total_patient')); ?>" min="1" max="100" />
						<div class="form-group" style="display: none;">
							<label class="control-label col-md-2">Total Patient</label>
							<div class="col-md-10">	
								
							</div>
						</div>
						<input class="form-control" placeholder="Total Unconscious" type="hidden" name="total_unconscious" value="<?php echo (($this->session->flashdata('total_unconscious') == "")?"0":$this->session->flashdata('total_unconscious')); ?>" min="0" max="100" />
						<div class="form-group" style="display: none;" >
							<label class="control-label col-md-2">Total Unconscious</label>
							<div class="col-md-10">	
								
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Notes</label>
							<div class="col-md-10">	
								<textarea placeholder="ISIKAN DENGAN KONDISI PASIEN DAN CREW YANG JALAN" class="form-control" rows="2" style="resize: none;" name="note"><?php echo (($this->session->flashdata('note') == "")?"":strip_tags($this->session->flashdata('note'))); ?></textarea>
							</div>
						</div>
						<div class="form-group" style="border-bottom: 1px solid #eee;"></div>
						<div class="form-group">
							<label class="control-label col-md-2">Patient Name</label>
							<div class="col-md-7">
								<input autocomplete="off" id="patient_search" name="patient_name" class="form-control typeahead tt-query" dir="auto" placeholder="Patient Name" spellcheck="false" value="<?php echo (($this->session->flashdata('name_patient') == "")?"":$this->session->flashdata('name_patient')); ?>" type="text" required="" maxlength="255">
							</div>
						</div>
						<input class="form-control" type="hidden" name="patient_dob" value="<?php echo (($this->session->flashdata('dob_patient') == "")?"":$this->session->flashdata('dob_patient')); ?>" autocomplete="off" required="" /></input>
						<!-- <div class="form-group" style="display:none;" >
							<label class="control-label col-md-2">Patient DOB</label>
							<div class="col-md-10">
								<div class="input-group date datepicker" data-date-autoclose="true" data-date-format="dd-mm-yyyy">
									
								</div>
							</div>
						</div> -->
						<!-- <div class="form-group">
							<label class="control-label col-md-2">Medical Record No.</label>
							<div class="col-md-10">	
								<input class="form-control" readonly type="text" />
							</div>
						</div> -->
					</div>
				</div>
				<br/>
				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						CASE TYPE
					</div>
				</div>
				<div class="widget-container fluid-height clearfix">
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
									<input required="" <?php echo $iiChecked; ?> name="sub_category" type="radio" value="<?php echo $rws->subcategory_id; ?>" OnChange="change_radio(<?php echo $rw->category_id; ?>);"><span><?php echo strip_tags($rws->subcategory_name); ?></span>
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
			<div class="col-lg-6">
				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						CASE INFO / TEMPAT ALAMAT KEJADIAN
					</div>
					<!-- add this PATIENT INFO REPLACMENT -->
					<div class="widget-content padded clearfix">
						<div class="widget-content padded clearfix" style="background: #f1f1f1;">
							<div class="form-group">
								<div class="col-md-12">
									<div class="input-group">
										<input class="form-control" id="street_search" name="street_search" value="" placeholder="Street Name" type="text" autocomplete="off" required="" minlength="3" maxlength="255" />
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
							<div class="form-group">
								<label class="control-label col-md-2">Area</label>
								<div class="col-md-10">
									<select class="select2able" id="area" name="area" required="" OnChange="ambulance_by_avaibility(this.value);">
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
									<select class="select2able" id="location" name="location" required="">
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
								<label class="control-label col-md-2">Other Info</label>
								<div class="col-md-10">	
									<textarea class="form-control" rows="2" style="resize: none;" name="other_info"><?php echo (($this->session->flashdata('other_info') == "")?"":strip_tags($this->session->flashdata('other_info'))); ?></textarea>
								</div>
							</div>
						</div>
					</div>
					<!-- END OF PATIENT INFO REPLACMENT -->
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
								<th width="25%" style="text-align: center;">Hospital Code</th>
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
								<a class="btn btn-warning" href="javascript:void(0);" OnClick="show_message('uwiww uwiiww uwwwiiiiwww');"><i class="icon-bell"></i> SIRINE</a>
								<a class="btn btn-primary" href="javascript:void(0);" OnClick="link_new_tab('emergency/prints');"><i class="icon-print"></i> PRINT</a>
								<button type="submit" class="btn btn-primary"><i class="icon-save"></i> SAVE ORDER</button>
							</center>
						</div>
					</div>
				</div>
			</div>	
		</form>	
	</div>  
</div>
<script type="text/javascript">

	$( "#validate-form" ).submit(function( event ) {
		if($("#street_latitude").val()=='' || $("#street_longitude").val()==''||$("#street_latitude").val()=='0' || $("#street_longitude").val()=='0'){
			alert("Lokasi di map tidak boleh kosong");
			return false;
		}else{
			return true;
		}
		
	 // alert( "Handler for .submit() called." );
	  event.preventDefault();
	});
</script>