<div class="container-fluid main-content">
    <div class="row">
		<div class="col-lg-12"></div>
		
		<?php foreach($detail as $row) : ?>
		<form class="form-horizontal" method="post" action="<?=base_url('report/non-emergency/update_data')?>" >
			<input type="hidden" name="id" value="<?php echo simple_encrypt($row->nonemergency_id); ?>" >
			<div class="col-lg-6">
				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						BOOKING REFERENCE
					</div>
					<div class="widget-content padded clearfix">
						<div class="form-group">
							<label class="control-label col-md-2">Call Ref No.</label>
							<div class="col-md-10">	
								<input class="form-control" placeholder="Refrence No." type="text" value="<?php echo $row->nonemergency_callreference; ?>" readonly />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Call Center</label>
							<div class="col-md-10">
								<input class="form-control" type="text" value="<?php echo strip_tags($this->m_callcenter->get_name_by_id($row->callcenter_id)); ?>" readonly />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Internal Call</label>
							<div class="col-md-10">
								<input class="form-control" type="text" value="<?php echo strip_tags($this->m_internalcall->get_name_by_id($row->internalcall_id)); ?>" readonly />
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
							<label class="control-label col-md-10"><?php echo convert_to_dmy($row->nonemergency_date); ?> / <?php echo convert_to_his($row->nonemergency_time); ?></label>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Date Phone</label>
							<div class="col-md-10">
								<div class="input-group date datepicker" data-date-autoclose="true" data-date-format="dd-mm-yyyy">
									<input class="form-control" name="nonemergency_date" type="text" value="<?php echo convert_to_dmy($row->nonemergency_date); ?>" autocomplete="off" required="" ><span class="input-group-addon"><i class="icon-calendar"></i></span></input>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Time Phone</label>
							<div class="col-md-10">
								<div class="input-group bootstrap-timepicker">
									<input class="form-control" id="timepicker-24h" name="nonemergency_time" type="text" value="<?php echo convert_to_his($row->nonemergency_time); ?>" autocomplete="off" required="" ><span class="input-group-addon"><i class="icon-time"></i></span></input>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Patient Name</label>
							<div class="col-md-10">	
								<input name="nonemergency_infoname" class="form-control" type="text" value="<?php echo $row->nonemergency_infoname; ?>"  />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Phone No.</label>
							<div class="col-md-10">	
								<input name="nonemergency_infophone" class="form-control" type="text" value="<?php echo $row->nonemergency_infophone; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Booking Date</label>
							<div class="col-md-10">
								<div class="input-group date datepicker" data-date-autoclose="true" data-date-format="dd-mm-yyyy">
									<input class="form-control" name="nonemergency_infodate" type="text" value="<?php echo (($row->nonemergency_infodate == "")?get_ymd():convert_to_dmy($row->nonemergency_infodate)); ?>" autocomplete="off" required="" ><span class="input-group-addon"><i class="icon-calendar"></i></span></input>
								</div>
								<!-- <div class="input-group">
									<input class="form-control" type="text" value="<?php echo (($row->nonemergency_infodate == "")?get_ymd():convert_to_dmy($row->nonemergency_infodate)); ?>" readonly ><span class="input-group-addon"><i class="icon-calendar"></i></span></input>
								</div> -->
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Booking Time</label>
							<div class="col-md-10">

								<div class="input-group">
									<input class="form-control" name="nonemergency_infotime" type="text" value="<?php echo (($row->nonemergency_infotime == "")?get_his():convert_to_his($row->nonemergency_infotime)); ?>"  ><span class="input-group-addon"><i class="icon-time"></i></span></input>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Diagnosis</label>
							<div class="col-md-10">	
								<input name="nonemergency_infodiagnosis" class="form-control" type="text" value="<?php echo $row->nonemergency_infodiagnosis; ?>"  />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Consultant</label>
							<div class="col-md-10">	
								<input class="form-control" name="nonemergency_infoconsultant" type="text" value="<?php echo $row->nonemergency_infoconsultant; ?>"  />	
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Booking Reason</label>
							<div class="col-md-10">	
								<input name="nonemergency_inforeason" class="form-control" type="text" value="<?php echo $row->nonemergency_inforeason; ?>"  />	
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Type Transfer</label>
							<div class="col-md-10">
								<input class="form-control" type="text" value="<?php echo strip_tags($this->m_transfer->get_name_by_id($row->transfer_id)); ?>" readonly />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Notes</label>
							<div class="col-md-10">	
								<textarea name="nonemergency_requestnote" class="form-control" rows="2" style="resize: none;" ><?php echo strip_tags($row->nonemergency_requestnote); ?></textarea>
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
								<input name="nonemergency_requestname" class="form-control" type="text" value="<?php echo $row->nonemergency_requestname; ?>"  />	
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Departement</label>
							<div class="col-md-10">	
								<input name="nonemergency_requestdepartment" class="form-control" type="text" value="<?php echo $row->nonemergency_requestdepartment; ?>"  />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Staff Tittle</label>
							<div class="col-md-10">	
								<input name="nonemergency_requesttittle" class="form-control" type="text" value="<?php echo $row->nonemergency_requesttittle; ?>"  />
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
								$i = 0;	$iChecked = "";		$ii = 0; $iiChecked = "";
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
									<?php 
											$ii = $ii + 1;
										endforeach; 
									?>
									<input class="form-control" type="text" value="<?php echo $case_note; ?>" readonly />
								</div>
							</div>
							<?php 
									$i = $i + 1;
								endforeach; 
							?>
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
								<input class="form-control" type="text" value="<?php echo strip_tags($this->m_hospital->get_name_by_id($row->nonemergency_fromhospital)); ?>" readonly />
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
									<input disabled <?php echo $chkInternalFrom; ?> type="radio"><span>INTERNAL LOCATION</span></label>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Location (ICU/UGD)</label>
							<div class="col-md-10">
								<input class="form-control" type="text" value="<?php echo strip_tags($this->m_unit->get_name_by_id($row->nonemergency_fromunit)); ?>" readonly />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">BED NO</label>
							<div class="col-md-10">	
								<input class="form-control" type="text" value="<?php echo (($row->nonemergency_frombed == "")?"":$row->nonemergency_frombed); ?>" readonly />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-1">&nbsp;</label>
							<div class="col-md-9">
								<label class="radio">
									<input disabled <?php echo $chkEksternalFrom; ?> type="radio"><span>EXTERNAL LOCATION</span></label>
								</label>
							</div>
						</div>
						<?php
							$arr = array(5,6,7,8,9);
							if (!in_array($row->nonemergency_status, $arr)) { 
						?>
						<div class="form-group">
							<div class="col-md-12">
								<div id="mapCanvas"></div>
							</div>
						</div>	
						<?php } ?>
						<div class="form-group">
							<label class="control-label col-md-2">Street</label>
							<div class="col-md-10">	
								<textarea class="form-control" rows="2" style="resize: none;" readonly><?php echo strip_tags($row->nonemergency_fromstreet); ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Area</label>
							<div class="col-md-10">
								<input class="form-control" type="text" value="<?php echo strip_tags($this->m_area->get_name_by_id($row->nonemergency_fromarea)); ?>" readonly />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Area Detail</label>
							<div class="col-md-10">	
								<input class="form-control" type="text" value="<?php echo strip_tags($this->m_location->get_name_by_id($row->nonemergency_fromlocation)); ?>" readonly />
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
								<input class="form-control" type="text" value="<?php echo strip_tags($this->m_hospital->get_name_by_id($row->nonemergency_tohospital)); ?>" readonly />
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
									<input disabled <?php echo $chkInternalTo; ?> type="radio"><span>INTERNAL LOCATION</span></label>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Location (ICU/UGD)</label>
							<div class="col-md-10">
								<input class="form-control" type="text" value="<?php echo strip_tags($this->m_unit->get_name_by_id($row->nonemergency_tounit)); ?>" readonly />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">BED NO</label>
							<div class="col-md-10">	
								<input class="form-control" type="text" value="<?php echo $row->nonemergency_tobed; ?>" readonly />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-1">&nbsp;</label>
							<div class="col-md-9">
								<label class="radio">
									<input disabled <?php echo $chkEksternalTo; ?> type="radio"><span>EXTERNAL LOCATION</span></label>
								</label>
							</div>
						</div>
						<?php
							$arr = array(5,6,7,8,9);
							if (!in_array($row->nonemergency_status, $arr)) { 
						?>
						<div class="form-group">
							<div class="col-md-12">
								<div id="mapCanvas2"></div>
							</div>
						</div>	
						<?php } ?>
						<div class="form-group">
							<label class="control-label col-md-2">Street</label>
							<div class="col-md-10">	
								<textarea class="form-control" rows="2" style="resize: none;" readonly><?php echo strip_tags($row->nonemergency_tostreet); ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Area</label>
							<div class="col-md-10">
								<input class="form-control" type="text" value="<?php echo strip_tags($this->m_area->get_name_by_id($row->nonemergency_toarea)); ?>" readonly />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Area Detail</label>
							<div class="col-md-10">	
								<input class="form-control" type="text" value="<?php echo strip_tags($this->m_location->get_name_by_id($row->nonemergency_tolocation)); ?>" readonly />
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
								<th width="25%" style="text-align: center;">Ambulance Code</th>
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
									<td align="center"><?php echo $rows->ambulance_no; ?></td>
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
						<input type="hidden" name="chkMotorbike" value="" />
						<table class="table table-bordered table-striped">
							<thead>
								<th width="25%" style="text-align: center;">Motor Code</th>
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
									<td align="center"><?php echo $rows->motorbike_no; ?></td>
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
								<?php 
									$arr = array(4,6,7,8,9,11,12,13);
									if (in_array($row->nonemergency_status, $arr)) { 
								?>
								<a class="btn btn-danger" href="<?=base_url('report/non-emergency/delete/'. simple_encrypt($row->nonemergency_id))?>" onclick="return confirm('Do you want to delete this data?')"><i class="icon-trash"></i> Delete</a>
								<a class="btn btn-danger" href="javascript:void(0);" OnClick="get_crew(2, '<?php echo simple_encrypt($row->nonemergency_id); ?>', '<?php echo $this->load->model('master/m_ambulance')->get_plat_by_id($row->ambulance_id) .' - '. $this->load->model('master/m_hospital')->get_code_by_id($row->nonemergency_fromhospital); ?>');"><i class="icon-user"></i> CREW</a>
								<?php } ?>
								<a class="btn btn-warning" href="javascript:void(0);" OnClick="show_message('uwiww uwiiww uwwwiiiiwww');"><i class="icon-bell"></i> SIRINE</a>
								<a class="btn btn-primary" href="javascript:void(0);" OnClick="link_new_tab('emergency/prints');"><i class="icon-print"></i> PRINT</a>
								<button class="btn btn-primary" type="submit" ><i class="icon-save"></i> SAVE</button>
							</center>
						</div>
					</div>
				</div>
				<br/>
				<?php
					$arr = array(4,6,7,8,9,11,12,13);
					if (in_array($row->nonemergency_status, $arr)) { 
				?>
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
				<?php } ?>
				<?php 
					$arr = array(4,6,7,8,9,11,12,13);
					if (in_array($row->nonemergency_status, $arr)) { 
				?>
				<div class="widget-container fluid-height clearfix">
					<div class="widget-content padded clearfix">
						<div class="row">
							<center>
								<a class="btn btn-warning" href="javascript:void(0);" OnClick="show_form_status_nonemergency_report('<?php echo simple_encrypt($row->nonemergency_id); ?>',6);">Depart Scene <br /><?php echo (($row->time_to_patient == "")?"-":convert_to_dmy($row->time_to_patient)); ?><br /><?php echo (($row->time_to_patient == "")?"00:00:00":convert_to_his($row->time_to_patient)); ?></a>
								<a class="btn btn-warning" href="javascript:void(0);" OnClick="show_form_status_nonemergency_report('<?php echo simple_encrypt($row->nonemergency_id); ?>',11);">RMO Call Scene <br /><?php echo (($row->time_call_patient == "")?"-":convert_to_dmy($row->time_call_patient)); ?><br /><?php echo (($row->time_call_patient == "")?"00:00:00":convert_to_his($row->time_call_patient)); ?></a>
								<a class="btn btn-warning" href="javascript:void(0);" OnClick="show_form_status_nonemergency_report('<?php echo simple_encrypt($row->nonemergency_id); ?>',12);">Arrival at Scene <br /><?php echo (($row->time_arrived_patient == "")?"-":convert_to_dmy($row->time_arrived_patient)); ?><br /><?php echo (($row->time_arrived_patient == "")?"00:00:00":convert_to_his($row->time_arrived_patient)); ?></a>
								<a class="btn btn-warning" href="javascript:void(0);" OnClick="show_form_status_nonemergency_report('<?php echo simple_encrypt($row->nonemergency_id); ?>',7);">Depat to Hospital <br /><?php echo (($row->time_to_hospital == "")?"-":convert_to_dmy($row->time_to_hospital)); ?><br /><?php echo (($row->time_to_hospital == "")?"00:00:00":convert_to_his($row->time_to_hospital)); ?></a>
								<a class="btn btn-warning" href="javascript:void(0);" OnClick="show_form_status_nonemergency_report('<?php echo simple_encrypt($row->nonemergency_id); ?>',13);">Arrival at Hospital <br /><?php echo (($row->time_arrived_hospital == "")?"-":convert_to_dmy($row->time_arrived_hospital)); ?><br /><?php echo (($row->time_arrived_hospital == "")?"00:00:00":convert_to_his($row->time_arrived_hospital)); ?></a>
								<a class="btn btn-warning" href="javascript:void(0);" OnClick="show_form_status_nonemergency_report('<?php echo simple_encrypt($row->nonemergency_id); ?>',8);">Depart to Base Hospital <br /><?php echo (($row->time_back_hospital == "")?"-":convert_to_dmy($row->time_back_hospital)); ?><br /><?php echo (($row->time_back_hospital == "")?"00:00:00":convert_to_his($row->time_back_hospital)); ?></a>
								<a class="btn btn-warning" href="javascript:void(0);" OnClick="show_form_status_nonemergency_report('<?php echo simple_encrypt($row->nonemergency_id); ?>',9);">Arrival at Base Hospital <br /><?php echo (($row->time_complete == "")?"-":convert_to_dmy($row->time_complete)); ?><br /><?php echo (($row->time_complete == "")?"00:00:00":convert_to_his($row->time_complete)); ?></a>
							</center>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>	
		</form>	
		<?php endforeach; ?>
	</div>  
</div>
<?php
	if($this->session->userdata('user_authority') == 0) { ?>
<script type="text/javascript">
	function show_form_status_nonemergency_report(id, status) {
		document.getElementById("nonemergency_status").value = id;
		document.getElementById("status_nonemergency").value = status;
		$("#form_update_nonemergency").attr('action','<?php echo base_url(); ?>report/non-emergency/set-status')
		
		$('#modal-status-nonemergency').modal()                      
		$('#modal-status-nonemergency').modal({ keyboard: false })   
		$('#modal-status-nonemergency').modal('show')                
	}
</script>
<?php } ?>