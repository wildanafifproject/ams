<div class="container-fluid main-content">
    <!-- Statistics -->
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
		<div class="col-lg-6">
			<div class="widget-container fluid-height clearfix">
				<div class="heading" style="background: #f1f1f1;">
					EMERGENCY CASE OVERVIEW
				</div>
				<div class="col-lg-12">
					<div class="widget-container fluid-height clearfix">
						<div class="widget-content padded">
							<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>dashboard">
								<div class="form-group">
									<label class="control-label col-md-2">Call Ref No.</label>
									<div class="col-md-4">
										<select class="select2able" name="call_ref">
											<option value="" selected>View all</option>
											<?php foreach($call_ref as $rw) : ?>
											<option value="<?php echo simple_encrypt($rw->emergency_id); ?>" <?php echo (($this->session->userdata('call_ref') == $rw->emergency_id)?"Selected":""); ?>><?php echo $rw->emergency_callreference; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-2">Hospital</label>
									<div class="col-md-6">
										<select class="select2able" name="hospital_emergency">
											<option value="" selected>View all</option>
											<?php foreach($hospital as $rw) : ?>
											<option value="<?php echo $rw->hospital_id; ?>" <?php echo (($this->session->userdata('hospital_emergency') == $rw->hospital_id)?"Selected":""); ?>><?php echo strip_tags($rw->hospital_name); ?></option>
											<?php endforeach; ?>
										</select>	
									</div>
								</div>
								<div class="social-login clearfix"></div>
								<div class="form-group">
									<label class="control-label col-md-2"></label>
									<div class="col-md-7">
										<button class="btn btn-danger" type="reset"><i class="icon-repeat"></i> CANCEL</button>
										<button class="btn btn-primary" type="submit"><i class="icon-search"></i> SEARCH</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="widget-content padded clearfix">
					<table class="table table-bordered table-striped">
						<thead>
							<th width="12%">No</th>
							<th width="30%">Time Record</th>
							<th>Ambulance No.</th>
							<th width="18%">Status</th>
						</thead>
						<tbody>
							<?php 
								$i = 0;
								if(!empty($emergency)) {
								foreach($emergency as $row) :	
									$i = $i+1;
									switch($row->emergency_status) {
										case 0 :
											$datetime = convert_to_dmy($row->emergency_date) .' '. convert_to_his($row->emergency_time);
										break;
										case 1 :
											$datetime = (($row->time_confirmed == "")?"":convert_to_dmyhis($row->time_confirmed));
										break;
										case 2 :
											$datetime = (($row->time_cancel == "")?"":convert_to_dmyhis($row->time_cancel));
										break;
										case 3 :
											$datetime = (($row->time_reject == "")?"":convert_to_dmyhis($row->time_reject));
										break;
										case 4 :
											$datetime = (($row->time_confirmed == "")?"":convert_to_dmyhis($row->time_confirmed));
										break;
										case 5 :
											$datetime = (($row->time_waiting == "")?"":convert_to_dmyhis($row->time_waiting));
										break;
										case 6 :
											$datetime = (($row->time_to_patient == "")?"":convert_to_dmyhis($row->time_to_patient));
										break;
										case 7 :
											$datetime = (($row->time_to_hospital == "")?"":convert_to_dmyhis($row->time_to_hospital));
										break;
										case 8 :
											$datetime = (($row->time_back_hospital == "")?"":convert_to_dmyhis($row->time_back_hospital));
										break;
										case 9 :
											$datetime = (($row->time_complete == "")?"":convert_to_dmyhis($row->time_complete));
										break;
										case 11 :
											$datetime = (($row->time_call_patient == "")?"":convert_to_dmyhis($row->time_call_patient));
										break;
										case 12 :
											$datetime = (($row->time_arrived_patient == "")?"":convert_to_dmyhis($row->time_arrived_patient));
										break;
										case 13 :
											$datetime = (($row->time_arrived_hospital == "")?"":convert_to_dmyhis($row->time_arrived_hospital));
										break;
									}
							?>
							<tr>
								<td align="center"><?php echo $i; ?></td>
								<td align="center"><?php echo $datetime; ?></td>
								<td align="center"><?php echo $this->load->model('master/m_ambulance')->get_plat_by_id($row->ambulance_id); ?></td>
								<td align="center">
									<?php if($row->emergency_status == 0) { ?>
									<a href="javascript:void(0);" OnClick="edit_to('emergency/edit-data', '<?php echo simple_encrypt($row->emergency_id); ?>');">
										<span class="label label-<?php echo get_color($row->emergency_status); ?>"><?php echo get_transaction($row->emergency_status); ?></span>
									</a>
									<?php } else if($row->emergency_status == 1) { ?>
									<a href="javascript:void(0);" OnClick="edit_to('emergency/editing-data', '<?php echo simple_encrypt($row->emergency_id); ?>');">
										<span class="label label-<?php echo get_color($row->emergency_status); ?>"><?php echo get_transaction($row->emergency_status); ?></span>
									</a>
									<?php } else if($row->emergency_status == 2 || $row->emergency_status == 3) { ?>
									<span class="label label-<?php echo get_color($row->emergency_status); ?>"><?php echo get_transaction($row->emergency_status); ?></span>
									<?php } else if($row->emergency_status == 9) { ?>
									<span class="label label-<?php echo get_color($row->emergency_status); ?>"><?php echo get_transaction($row->emergency_status); ?></span>
									<?php } else { ?>
									<a href="javascript:void(0);" OnClick="edit_to('emergency/detail-data', '<?php echo simple_encrypt($row->emergency_id); ?>');">
										<span class="label label-<?php echo get_color($row->emergency_status); ?>"><?php echo get_transaction($row->emergency_status); ?></span>
									</a>
									<?php } ?>
								</td>	
							</tr>
							<?php endforeach; ?>
							<?php } else { ?>
							<tr><td align="center" colspan="4">No data found</td></tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="widget-container fluid-height clearfix">
				<div class="heading" style="background: #f1f1f1;">
					AMBULANCE BOOKING
				</div>
				<div class="col-lg-12">
					<div class="widget-container fluid-height clearfix">
						<div class="widget-content padded">
							<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>dashboard">
								<div class="form-group">
									<label class="control-label col-md-2">Booking Range</label>
									 <div class="col-sm-3">
										<input class="form-control" data-date-autoclose="true" data-date-format="dd-mm-yyyy" id="dpd1" placeholder="Start date" type="text" name="start" value="<?php echo (($this->session->userdata('from_nonemergency') == "")?"":convert_to_dmy($this->session->userdata('from_nonemergency'))); ?>" />
									</div>
									<div class="col-sm-3">
										<input class="form-control" data-date-autoclose="true" data-date-format="dd-mm-yyyy" id="dpd2" placeholder="End date" type="text" name="end" value="<?php echo (($this->session->userdata('to_nonemergency') == "")?"":convert_to_dmy($this->session->userdata('to_nonemergency'))); ?>" />
									</div>
								</div>
								<div class="social-login clearfix"></div>
								<div class="form-group">
									<label class="control-label col-md-2"></label>
									<div class="col-md-7">
										<button class="btn btn-danger" type="reset"><i class="icon-repeat"></i> CANCEL</button>
										<button class="btn btn-primary" type="submit"><i class="icon-search"></i> SEARCH</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="widget-content padded clearfix">
					<table class="table table-bordered table-striped">
						<thead>
							<th width="10%">Booking ID</th>
							<th width="20%">Call Date</th>
							<th width="20%">Booking Date</th>
							<th>Ambulance</th>
							<th width="18%">Status</th>
						</thead>
						<tbody>
							<?php 
								if(!empty($nonemergency)) {
								foreach($nonemergency as $row) :	
							?>
							<tr>
								<td align="center"><?php echo $row->nonemergency_callreference; ?></td>
								<td align="center"><?php echo convert_to_dmy($row->nonemergency_date) .' '. convert_to_his($row->nonemergency_time); ?></td>
								<td align="center"><?php echo convert_to_dmy($row->nonemergency_infodate) .' '. convert_to_his($row->nonemergency_infotime); ?></td>
								<td align="center"><?php echo $this->load->model('master/m_ambulance')->get_plat_by_id($row->ambulance_id); ?></td>
								<td align="center">
									<?php if($row->nonemergency_status == 0) { ?>
									<a href="javascript:void(0);" OnClick="edit_to('non-emergency/edit-data', '<?php echo simple_encrypt($row->nonemergency_id); ?>');">
										<span class="label label-<?php echo get_color($row->nonemergency_status); ?>"><?php echo get_transaction($row->nonemergency_status); ?></span>
									</a>
									<?php } else if($row->nonemergency_status == 1) { ?>
									<a href="javascript:void(0);" OnClick="edit_to('non-emergency/editing-data', '<?php echo simple_encrypt($row->nonemergency_id); ?>');">
										<span class="label label-<?php echo get_color($row->nonemergency_status); ?>"><?php echo get_transaction($row->nonemergency_status); ?></span>
									</a>
									<?php } else if($row->nonemergency_status == 14) { ?>
									<a href="javascript:void(0);" OnClick="edit_to('non-emergency/editing-data', '<?php echo simple_encrypt($row->nonemergency_id); ?>');">
										<span class="label label-<?php echo get_color($row->nonemergency_status); ?>"><?php echo get_transaction($row->nonemergency_status); ?></span>
									</a>
									<?php } else if($row->nonemergency_status == 2 || $row->nonemergency_status == 3) { ?>
									<span class="label label-<?php echo get_color($row->nonemergency_status); ?>"><?php echo get_transaction($row->nonemergency_status); ?></span>
									<?php } else if($row->nonemergency_status == 9) { ?>
									<span class="label label-<?php echo get_color($row->nonemergency_status); ?>"><?php echo get_transaction($row->nonemergency_status); ?></span>
									<?php } else { ?>
									<a href="javascript:void(0);" OnClick="edit_to('non-emergency/detail-data', '<?php echo simple_encrypt($row->nonemergency_id); ?>');">
										<span class="label label-<?php echo get_color($row->nonemergency_status); ?>"><?php echo get_transaction($row->nonemergency_status); ?></span>
									</a>
									<?php } ?>
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
		</div>	
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="widget-container fluid-height clearfix" style="margin-top: 15px;">
				<div class="heading" style="background: #f1f1f1;">
					AMBULANCE STATUS
				</div>
				<div class="col-lg-12">
					<div class="widget-container fluid-height clearfix">
						<div class="widget-content padded">
							<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>dashboard">
								<div class="form-group">
									<label class="control-label col-md-1">Hospital</label>
									<div class="col-md-3">
										<select class="select2able" name="hospital_ambulance">
											<option value="" disabled selected>View all</option>
											<?php foreach($hospital as $rw) : ?>
											<option value="<?php echo $rw->hospital_id; ?>" <?php echo (($this->session->userdata('hospital_ambulance') == $rw->hospital_id)?"Selected":""); ?>><?php echo strip_tags($rw->hospital_name); ?></option>
											<?php endforeach; ?>
										</select>	
									</div>
								</div>
								<div class="social-login clearfix"></div>
								<div class="form-group">
									<label class="control-label col-md-1"></label>
									<div class="col-md-7">
										<button class="btn btn-danger" type="reset"><i class="icon-repeat"></i> CANCEL</button>
										<button class="btn btn-primary" type="submit"><i class="icon-search"></i> SEARCH</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="widget-content padded clearfix">
					<table class="table table-bordered table-striped" id="dataTableNoSort">
						<thead>
							<th style="text-align: center;">Hospital</th>
							<th width="10%" style="text-align: center;">Ambulace No</th>
							<th width="15%" style="text-align: center;">Police No</th>
							<th width="10%" style="text-align: center;">Status</th>
							<th width="15%" style="text-align: center;">ETA Scene</th>
							<th width="15%" style="text-align: center;">ETA Hospital</th>
						</thead>
						<tbody>
							<?php 
								if(!empty($ambulance)) {
								foreach($ambulance as $row) :	
							?>
							<tr>
								<td><?php echo $this->load->model('master/m_hospital')->get_name_by_id($row->hospital_id); ?></td>
								<td align="center"><?php echo $this->load->model('master/m_hospital')->get_code_by_id($row->hospital_id); ?></td>
								<td align="center"><?php echo $row->ambulance_police; ?></td>
								<td align="center">
									<span class="label label-<?php echo get_color($row->ambulance_status); ?>"><?php echo get_ambulance($row->ambulance_status); ?></span>
								</td>
								<td align="center"><?php echo $row->ambulance_eta; ?></td>
								<td align="center"><?php echo $row->ambulance_etahospital; ?></td>
							</tr>
							<?php endforeach; ?>
							<?php } else { ?>
							<tr><td align="center" colspan="6">No data found</td></tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>	
</div>