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
		
		<form action="#" class="form-horizontal">
			<div class="col-lg-3">
				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						BOOKING REFERENCE
					</div>
					<div class="widget-content padded clearfix">
						<div class="form-group">
							<label class="control-label col-md-4">Call Center</label>
							<div class="col-md-8">
								<select class="select2able">
									<option value="" disabled selected>View all</option>
									<option value="Category 1">Option 1</option>
									<option value="Category 2">Option 2</option>
									<option value="Category 3">Option 3</option>
									<option value="Category 4">Option 4</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Internal Call</label>
							<div class="col-md-8">
								<select class="select2able">
									<option value="" disabled selected>View all</option>
									<option value="Category 1">Option 1</option>
									<option value="Category 2">Option 2</option>
									<option value="Category 3">Option 3</option>
									<option value="Category 4">Option 4</option>
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
							<label class="control-label col-md-4">Time Phone</label>
							<label class="control-label col-md-8">20-02-2017 / 20:09:37</label>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Patient Name</label>
							<div class="col-md-8">	
								<input class="form-control" placeholder="Patient Name" type="text" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Phone No.</label>
							<div class="col-md-8">	
								<input class="form-control" placeholder="Phone No." type="text" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Diagnosis</label>
							<div class="col-md-8">	
								<input class="form-control" type="text" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Consultant</label>
							<div class="col-md-8">	
								<input class="form-control" type="text" />
							</div>
						</div>
						<div class="form-group">
								<label class="control-label col-md-4">Date</label>
								<div class="col-md-8">
									<div class="input-group date datepicker" data-date-autoclose="true" data-date-format="dd-mm-yyyy">
										<input class="form-control" type="text"><span class="input-group-addon"><i class="icon-calendar"></i></span></input>
									</div>
								</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Booking Reason</label>
							<div class="col-md-8">	
								<input class="form-control" type="text" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Type Transfer</label>
							<div class="col-md-8">
								<select class="select2able">
									<option value="" disabled selected>High Care</option>
									<option value="Category 1">Option 1</option>
									<option value="Category 2">Option 2</option>
									<option value="Category 3">Option 3</option>
									<option value="Category 4">Option 4</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<br/>
				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						CASE TYPE
					</div>
					<div class="form-group">
							<label class="control-label col-md-1">&nbsp;</label>
							<div class="col-md-9">
								<label class="radio">
									<input checked="" name="optionsRadios_1" type="radio" value="Emeregency"><span>NON EMERGENCY (Transfer to A&E) </span></label>
								</label>
							</div>
					</div>
					<div class="form-group">
							<label class="control-label col-md-3">&nbsp;</label>
							<div class="col-md-6">
								<label class="radio">
									<input checked="" name="optionsRadios_1" type="radio" value="Emeregency"><span>Booking Ambulance</span>
									</label>
								</label>
							</div>
					</div>
					<div class="form-group">
							<label class="control-label col-md-3">&nbsp;</label>
							<div class="col-md-6">
								<label class="radio">
									<input checked="" name="optionsRadios_1" type="radio" value="Emeregency"><span>ETC Telephone Consulting</span>
									</label>
								</label>
							</div>
					</div>
					<br/>
				</div>
				<br/>
				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						PICK UP FROM
					</div>
					<div class="widget-content padded clearfix">
						<div class="form-group">
							<label class="control-label col-md-1">&nbsp;</label>
							<div class="col-md-9">
								<label class="radio">
									<input checked="" name="optionsRadios_1" type="radio" value="Emeregency"><span>INTERNAL LOCATION</span></label>
								</label>
						</div>
					</div>
						<div class="form-group">
							<label class="control-label col-md-4">Hospital</label>
							<div class="col-md-8">
								<select class="select2able">
									<option value="" disabled selected>Siloam Lippo Village</option>
									<option value="Category 1">Option 1</option>
									<option value="Category 2">Option 2</option>
									<option value="Category 3">Option 3</option>
									<option value="Category 4">Option 4</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Location (ICU/UGD)</label>
							<div class="col-md-8">
								<select class="select2able">
									<option value="" disabled selected>AE</option>
									<option value="Category 1">Option 1</option>
									<option value="Category 2">Option 2</option>
									<option value="Category 3">Option 3</option>
									<option value="Category 4">Option 4</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">BED NO</label>
							<div class="col-md-8">	
								<input class="form-control" placeholder="" type="text" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-1">&nbsp;</label>
							<div class="col-md-9">
								<label class="radio">
									<input checked="" name="optionsRadios_1" type="radio" value="Emeregency"><span>EXTERNAL LOCATION</span></label>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Street</label>
							<div class="col-md-8">	
								<input class="form-control" placeholder="" type="text" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Area</label>
							<div class="col-md-8">
								<select class="select2able">
									<option value="" disabled selected>Area</option>
									<option value="Category 1">Option 1</option>
									<option value="Category 2">Option 2</option>
									<option value="Category 3">Option 3</option>
									<option value="Category 4">Option 4</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Area Detail</label>
							<div class="col-md-8">	
								<input class="form-control" placeholder="" type="text" />
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3">

				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						DESTINATION
					</div>
					<div class="widget-content padded clearfix">
						<div class="form-group">
							<label class="control-label col-md-1">&nbsp;</label>
							<div class="col-md-9">
								<label class="radio">
									<input checked="" name="optionsRadios_1" type="radio" value="Emeregency"><span>INTERNAL LOCATION</span></label>
								</label>
						</div>
					</div>
						<div class="form-group">
							<label class="control-label col-md-4">Hospital</label>
							<div class="col-md-8">
								<select class="select2able">
									<option value="" disabled selected>Siloam Lippo Village</option>
									<option value="Category 1">Option 1</option>
									<option value="Category 2">Option 2</option>
									<option value="Category 3">Option 3</option>
									<option value="Category 4">Option 4</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Location (ICU/UGD)</label>
							<div class="col-md-8">
								<select class="select2able">
									<option value="" disabled selected>AE</option>
									<option value="Category 1">Option 1</option>
									<option value="Category 2">Option 2</option>
									<option value="Category 3">Option 3</option>
									<option value="Category 4">Option 4</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">BED NO</label>
							<div class="col-md-8">	
								<input class="form-control" placeholder="" type="text" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-1">&nbsp;</label>
							<div class="col-md-9">
								<label class="radio">
									<input checked="" name="optionsRadios_1" type="radio" value="Emeregency"><span>EXTERNAL LOCATION</span></label>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Street</label>
							<div class="col-md-8">	
								<input class="form-control" placeholder="" type="text" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Area</label>
							<div class="col-md-8">
								<select class="select2able">
									<option value="" disabled selected>Area</option>
									<option value="Category 1">Option 1</option>
									<option value="Category 2">Option 2</option>
									<option value="Category 3">Option 3</option>
									<option value="Category 4">Option 4</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Area Detail</label>
							<div class="col-md-8">	
								<input class="form-control" placeholder="" type="text" />
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
							<label class="control-label col-md-4">Name</label>
							<div class="col-md-8">	
								<input class="form-control" placeholder="Name" type="text" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Departement</label>
							<div class="col-md-8">	
								<input class="form-control" placeholder="Departement" type="text" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Staff Tittle</label>
							<div class="col-md-8">	
								<input class="form-control" placeholder="Staff Tittle" type="text" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Internal Call</label>
							<div class="col-md-8">
								<select class="select2able">
									<option value="" disabled selected>View all</option>
									<option value="Category 1">Option 1</option>
									<option value="Category 2">Option 2</option>
									<option value="Category 3">Option 3</option>
									<option value="Category 4">Option 4</option>
								</select>
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
									<input checked="" name="optionsRadios_1" type="radio" value="Emeregency"><span>Emeregency</span></label>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">&nbsp;</label>
							<div class="col-md-10">
								<label class="radio" for="option_11">
								<input checked="" id="option_11" name="optionsRadios" type="radio" value="Trauma"><span>Trauma</span></label>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">&nbsp;</label>
							<div class="col-md-9">
								<label class="radio">
									<input checked="" name="optionsRadios1" type="radio" value="option2"><span>Traffic Accident</span>
								</label>
								<label class="radio">
									<input name="optionsRadios1" type="radio" value="option2"><span>Fall</span>
								</label>
								<label class="radio">
									<input name="optionsRadios1" type="radio" value="option3"><span>Burn</span>
								</label>
								<label class="radio">
									<input name="optionsRadios1" type="radio" value="option4"><span>Other</span>
								</label>
								<input class="form-control" type="text" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2"></label>
							<div class="col-md-7">
								<label class="radio" for="option_22">
								<input id="option_22" name="optionsRadios" type="radio" value="Trauma"><span>Non Trauma</span></label>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3"></label>
							<div class="col-md-9">
								<label class="radio">
									<input name="optionsRadios1" type="radio" value="option2"><span>Chest Pain</span>
								</label>
								<label class="radio">
									<input name="optionsRadios1" type="radio" value="option2"><span>Unconscious</span>
								</label>
								<label class="radio">
									<input name="optionsRadios1" type="radio" value="option3"><span>Respiratory Disorder</span>
								</label>
								<label class="radio">
									<input name="optionsRadios1" type="radio" value="option3"><span>Bleeding / Shock</span>
								</label>
								<label class="radio">
									<input name="optionsRadios1" type="radio" value="option4"><span>Other</span>
								</label>
								<input class="form-control" type="text" />
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						REQUEST INFO
					</div>
					<br/>
					<div class="form-group">
							<label class="control-label col-md-2">Nurse</label>
							<div class="col-md-3">
								<select class="select2able">
									<option value="" disabled selected>View all</option>
									<option value="Category 1">Option 1</option>
									<option value="Category 2">Option 2</option>
									<option value="Category 3">Option 3</option>
									<option value="Category 4">Option 4</option>
								</select>
							</div>
					</div>
					<div class="form-group">
							<label class="control-label col-md-2">Department</label>
							<div class="col-md-3">
								<select class="select2able">
									<option value="" disabled selected>View all</option>
									<option value="Category 1">Option 1</option>
									<option value="Category 2">Option 2</option>
									<option value="Category 3">Option 3</option>
									<option value="Category 4">Option 4</option>
								</select>
							</div>
					</div>
					<div class="form-group">
							<label class="control-label col-md-2">ABC Nurse</label>
							<div class="col-md-3">
								<select class="select2able">
									<option value="" disabled selected>View all</option>
									<option value="Category 1">Option 1</option>
									<option value="Category 2">Option 2</option>
									<option value="Category 3">Option 3</option>
									<option value="Category 4">Option 4</option>
								</select>
							</div>
					</div>
					<div class="form-group">
							<label class="control-label col-md-2">RMO</label>
							<div class="col-md-3">
								<select class="select2able">
									<option value="" disabled selected>View all</option>
									<option value="Category 1">Option 1</option>
									<option value="Category 2">Option 2</option>
									<option value="Category 3">Option 3</option>
									<option value="Category 4">Option 4</option>
								</select>
							</div>
					</div>
				<br/>
				<div class="widget-container fluid-height clearfix">
					<div class="widget-content padded clearfix">
						<div class="row">
							<center>
								<a class="btn btn-danger btn fancybox" href="#fancybox-example"><i class="icon-trash"></i> CANCEL</a>
								<a class="btn btn-danger btn fancybox" href="#fancybox-example"><i class="icon-repeat"></i> RESET</a>
								<a class="btn btn-primary btn fancybox" href="#fancybox-example"><i class="icon-print"></i> PRINT</a>
								<a class="btn btn-primary btn fancybox" href="#fancybox-example"><i class="icon-save"></i> SCHEDULE</a>
							</center>
						</div>
					</div>
				</div>
			</div>	
		</form>	
	</div>  
</div>

<div id="fancybox-example" style="display: none;">
	<div class="widget-container fluid-height clearfix">
		<div class="heading" style="background: #f1f1f1;height: 60px;">
			<p>AMBULANCE ON DUTY (CREW) <br> B 2222 MOM - SHMD</p>
		</div>
		<div class="widget-content padded clearfix">
			<table class="table table-bordered table-striped">
				<thead>
					<th style="text-align: center;">Driver</th>
					<th width="33%" style="text-align: center;">Doctors</th>
					<th width="33%" style="text-align: center;">Nurses</th>
				</thead>
				<tbody>
					<tr>
						<td align="center">Sugeng Hidayat</td>
						<td align="center">Iker Casillas</td>
						<td align="center">Dinie Dianie</td>
					</tr>
					<tr>
						<td align="center">Wagiman</td>
						<td align="center">Ibrahimovic</td>
						<td align="center">-</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>