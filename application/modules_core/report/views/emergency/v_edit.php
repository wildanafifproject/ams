<div class="container-fluid main-content">
    <div class="row">
		<div class="col-lg-12"></div>
		
		<?php foreach($detail as $row) : ?>
		<form class="form-horizontal" method="post" action="<?=base_url('report/emergency/update_data')?>">
			<input type="hidden" name="id" value="<?php echo simple_encrypt($row->emergency_id); ?>" readonly />
			<div class="col-lg-6">
				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						GLOBAL INFO
					</div>
					<div class="widget-content padded clearfix">
						<!-- <div class="form-group">
							<label class="control-label col-md-2">Time Phone</label>
							<label class="control-label col-md-10"><?php echo convert_to_dmy($row->emergency_date); ?> / <?php echo convert_to_his($row->emergency_time); ?></label>
						</div> -->

						<div class="form-group">
							<label class="control-label col-md-2">Date Phone</label>
							<div class="col-md-10">
								<div class="input-group date datepicker" data-date-autoclose="true" data-date-format="dd-mm-yyyy">
									<input class="form-control" name="emergency_date" type="text" value="<?php echo convert_to_dmy($row->emergency_date); ?>" autocomplete="off" required="" ><span class="input-group-addon"><i class="icon-calendar"></i></span></input>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Time Phone</label>
							<div class="col-md-10">
								<div class="input-group bootstrap-timepicker">
									<input class="form-control" id="timepicker-24h" name="emergency_time" type="text" value="<?php echo convert_to_his($row->emergency_time); ?>" autocomplete="off" required="" ><span class="input-group-addon"><i class="icon-time"></i></span></input>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Call Ref No.</label>
							<div class="col-md-10">	
								<input class="form-control" type="text" value="<?php echo $row->emergency_callreference; ?>" readonly />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Source Call</label>
							<div class="col-md-10">
								<input class="form-control" type="text" value="<?php echo strip_tags($this->m_source->get_name_by_id($row->source_id)); ?>" readonly />
							</div>
						</div>
						<!-- <div class="form-group">
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
						</div> -->
						<div class="form-group">
							<label class="control-label col-md-2">Forward To</label>
							<div class="col-md-10">
								<input class="form-control" type="text" value="<?php echo strip_tags($this->m_forward->get_name_by_id($row->forward_id)); ?>" readonly />
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
								<input name="emergency_callername" class="form-control" type="text" value="<?php echo strip_tags($row->emergency_callername); ?>"  />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Phone No.</label>
							<div class="col-md-10">	
								<input name="emergency_callerphone" class="form-control" type="text" value="<?php echo $row->emergency_callerphone; ?>"  />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Other Phone</label>
							<div class="col-md-10">	
								<input name="emergency_callerother" class="form-control" type="text" value="<?php echo $row->emergency_callerother; ?>"  />
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
								<input class="form-control" name="emergency_patienttotal" type="number" value="<?php echo $row->emergency_patienttotal; ?>"  />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Total Unconscious</label>
							<div class="col-md-10">	
								<input class="form-control" name="emergency_patientunconscious" type="number" value="<?php echo $row->emergency_patientunconscious; ?>"  />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Notes</label>
							<div class="col-md-10">	
								<textarea name="emergency_patientnote" class="form-control" rows="2" style="resize: none;" ><?php echo strip_tags($row->emergency_patientnote); ?></textarea>
							</div>
						</div>
						<div class="form-group" style="border-bottom: 1px solid #eee;"></div>
						<div class="form-group">
							<label class="control-label col-md-2">Patient Name</label>
							<div class="col-md-10">
									<input name="emergency_patientname" class="form-control" value="<?php echo $row->emergency_patientname; ?>" type="text"  />
										<!-- <span class="input-group-btn">
											<a class="btn btn-default"><i class="icon-search"></i></a>
										</span> -->
									</input>
								
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-2">Patient DOB</label>
							<div class="col-md-10">
								<!-- <div class="input-group">
									<input class="form-control" type="text" value="<?php echo (($row->emergency_patientdob == "")?NULL:convert_to_dmy($row->emergency_patientdob)); ?>"  /><span class="input-group-addon"><i class="icon-calendar"></i></span></input>
								</div> -->
								<div class="input-group date datepicker" data-date-autoclose="true" data-date-format="dd-mm-yyyy">
									<input class="form-control" name="emergency_patientdob" type="text" value="<?php echo (($row->emergency_patientdob == "")?NULL:convert_to_dmy($row->emergency_patientdob)); ?>" autocomplete="off"  ><span class="input-group-addon"><i class="icon-calendar"></i></span></input>
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
								<input disabled <?php echo $iChecked; ?> type="radio" value="<?php echo $rw->category_id; ?>"><span><?php echo strip_tags($rw->category_name); ?></span></label>
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
										}
								?>
								
								<label class="radio">
									<input disabled <?php echo $iiChecked; ?> type="radio" value="<?php echo $rws->subcategory_id; ?>"><span><?php echo strip_tags($rws->subcategory_name); ?></span>
								</label>
								<?php endforeach; ?>
								<input class="form-control" type="text" value="<?php echo $case_note; ?>" readonly />
							</div>
						</div>
						<?php endforeach; ?>
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
							<label class="control-label col-md-2">Street</label>
							<div class="col-md-10">	
								<textarea class="form-control" rows="2" style="resize: none;" readonly><?php echo strip_tags($row->emergency_infostreet); ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Area</label>
							<div class="col-md-10">
								<input class="form-control" type="text" value="<?php echo strip_tags($this->m_area->get_name_by_id($row->area_id)); ?>" readonly />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Area Detail</label>
							<div class="col-md-10">	
								<input class="form-control" type="text" value="<?php echo strip_tags($this->m_location->get_name_by_id($row->location_id)); ?>" readonly />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Other Info</label>
							<div class="col-md-10">	
								<textarea name="emergency_infootherinformation" class="form-control" rows="2" style="resize: none;" ><?php echo strip_tags($row->emergency_infootherinformation); ?></textarea>
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
						<table class="table table-bordered table-striped">
							<thead>
								<th width="25%" style="text-align: center;">Hospital Code</th>
								<th width="23%" style="text-align: center;">Police Number</th>
								<th style="text-align: center;">Case Type</th>
							</thead>
							<tbody>
								<?php 
									$ambulance = $this->m_global->get_by_id('tm_ambulance', 'ambulance_id', $row->ambulance_id);
									if(!empty($ambulance)) {
									foreach($ambulance as $rows) :	
								?>
								<tr>
									<td align="center"><?php echo $this->load->model('master/m_hospital')->get_code_by_id($rows->hospital_id); ?></td>
									<td align="center"><?php echo $rows->ambulance_police; ?></td>
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
					<div class="heading" style="background: #f1f1f1;">
						MOTOR BIKE
					</div>
					<div class="widget-content padded clearfix" id="listing_motorbike">
						<table class="table table-bordered table-striped">
							<thead>
								<th width="25%" style="text-align: center;">Hospital Code</th>
								<th width="23%" style="text-align: center;">Police Number</th>
								<th style="text-align: center;">Case Type</th>
							</thead>
							<tbody>
								<?php 
									$motorbike = $this->m_global->get_by_id('tm_motorbike', 'motorbike_id', $row->motorbike_id);
									if(!empty($motorbike)) {
									foreach($motorbike as $rows) :	
								?>
								<tr>
									<td align="center"><?php echo $this->load->model('master/m_hospital')->get_code_by_id($rows->hospital_id); ?></td>
									<td align="center"><?php echo $rows->motorbike_police; ?></td>
									<td align="center">-</td>
								</tr>
								<?php endforeach; ?>
								<?php } else { ?>
								<tr><td align="center" colspan="3">No data found</td></tr>
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
								<?php 
									$arr = array(6,7,8,9,11,12,13);
									if (in_array($row->emergency_status, $arr)) { 
								?>
								<a class="btn btn-danger" href="<?=base_url('report/emergency/delete/'. simple_encrypt($row->emergency_id))?>" onclick="return confirm('Do you want to delete this data?')"><i class="icon-trash"></i> Delete</a>
								<a class="btn btn-info" href="javascript:void(0);" OnClick="get_crew(1, '<?php echo simple_encrypt($row->emergency_id); ?>', '<?php echo $this->load->model('master/m_ambulance')->get_plat_by_id($row->ambulance_id) .' - '. $this->load->model('master/m_hospital')->get_code_by_id($row->hospital_id); ?>');"><i class="icon-user"></i> CREW</a>
								<?php } ?>
								<a class="btn btn-warning" href="javascript:void(0);" OnClick="show_message('uwiww uwiiww uwwwiiiiwww');"><i class="icon-bell"></i> SIRINE</a>
								<a class="btn btn-primary" href="javascript:void(0);" OnClick="link_new_tab('emergency/prints');"><i class="icon-print"></i> PRINT</a>
								<button class="btn btn-primary" type="submit"><i class="icon-save"></i> Save</button>
							</center>
						</div>
					</div>
				</div>
				<br/>
				<div class="widget-container">
					<div class="widget-content padded">
						<div class="form-group">
							<div class="col-md-12">
								<div id="mapCanvas"></div>
							</div>
						</div>	
					</div>
				</div>
				<br/>
				<?php 
					$arr = array(6,7,8,9,11,12,13);
					if (in_array($row->emergency_status, $arr)) { 
				?>
				<div class="widget-container fluid-height clearfix">
					<div class="widget-content padded clearfix">
						<div class="row">
							<center>
								<a class="btn btn-warning" href="javascript:void(0);" OnClick="show_form_status_emergency_report('<?php echo simple_encrypt($row->emergency_id); ?>',6);">Depart Scene <br /><?php echo (($row->time_to_patient == "")?"00:00:00":convert_to_his($row->time_to_patient)); ?></a>
								<a class="btn btn-warning" href="javascript:void(0);" OnClick="show_form_status_emergency_report('<?php echo simple_encrypt($row->emergency_id); ?>',11);">RMO Call Scene <br /><?php echo (($row->time_call_patient == "")?"00:00:00":convert_to_his($row->time_call_patient)); ?></a>
								<a class="btn btn-warning" href="javascript:void(0);" OnClick="show_form_status_emergency_report('<?php echo simple_encrypt($row->emergency_id); ?>',12);">Arrival at Scene <br /><?php echo (($row->time_arrived_patient == "")?"00:00:00":convert_to_his($row->time_arrived_patient)); ?></a>
								<a class="btn btn-warning" href="javascript:void(0);" OnClick="show_form_status_emergency_report('<?php echo simple_encrypt($row->emergency_id); ?>',7);">Depat to Hospital <br /><?php echo (($row->time_to_hospital == "")?"00:00:00":convert_to_his($row->time_to_hospital)); ?></a>
								<a class="btn btn-warning" href="javascript:void(0);" OnClick="show_form_status_emergency_report('<?php echo simple_encrypt($row->emergency_id); ?>',13);">Arrival at Hospital <br /><?php echo (($row->time_arrived_hospital == "")?"00:00:00":convert_to_his($row->time_arrived_hospital)); ?></a>
								<a class="btn btn-warning" href="javascript:void(0);" OnClick="show_form_status_emergency_report('<?php echo simple_encrypt($row->emergency_id); ?>',8);">Depart to Base Hospital <br /><?php echo (($row->time_back_hospital == "")?"00:00:00":convert_to_his($row->time_back_hospital)); ?></a>
								<a class="btn btn-warning" href="javascript:void(0);" OnClick="show_form_status_emergency_report('<?php echo simple_encrypt($row->emergency_id); ?>',9);">Arrival at Base Hospital <br /><?php echo (($row->time_complete == "")?"00:00:00":convert_to_his($row->time_complete)); ?></a>
							</center>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>	
		</form>	
		<script type="text/javascript">
			var datetime_emergency = '<?=$row->emergency_date  ?>';
		</script>
		<?php endforeach; ?>
	</div>  
</div>
<?php if($this->session->userdata('user_authority') == 0) { ?>
<script type="text/javascript">
	function show_form_status_emergency_report(id, status) {
		document.getElementById("emergency_status").value = id;
		document.getElementById("status_emergency").value = status;
		document.getElementById("datetime_emergency").value = datetime_emergency;
		$("#form_update_emergency").attr('action','<?php echo base_url(); ?>report/emergency/set-status');
		
		$('#modal-status-emergency').modal()                      
		$('#modal-status-emergency').modal({ keyboard: false })   
		$('#modal-status-emergency').modal('show')                
	}
</script>
<?php } ?>

