<script>
	function change_radio(id) {
		document.getElementById("category"+id).checked = true;
	}
	
	function change_ambulance(id) {
		$('.checkboxAmbulance').each(function () {
            this.checked = false;
        });
		
		document.getElementById("chkAmbulance"+id).checked = true;
	}
	
	function change_motorbike(id) {
		$('.checkboxMotorbike').each(function () {
            this.checked = false;
        });
		
		document.getElementById("chkMotorbike"+id).checked = true;
	}
</script>

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
		
		<form id="validate-form" class="form-horizontal" method="post" action="<?php echo base_url(); ?>emeregency/process-data">
			<input type="hidden" name="valid" value="<?php echo simple_encrypt(1); ?>" />
			<div class="col-lg-3">
				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						GLOBAL INFO
					</div>
					<div class="widget-content padded clearfix">
						<div class="form-group">
							<label class="control-label col-md-4">Time Phone</label>
							<label class="control-label col-md-8"><?php echo get_dmy(); ?> / <?php echo get_his(); ?></label>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Call Ref No.</label>
							<div class="col-md-8">	
								<input class="form-control" placeholder="Refrence No." type="text" value="<?php echo $code; ?>" name="reference_no" readonly />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Source Call</label>
							<div class="col-md-8">
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
							<label class="control-label col-md-4">Forward To</label>
							<div class="col-md-8">
								<select class="select2able" name="forward" required="" OnChange="ajax_ambulance_by_forward(this.value);">
									<option value="" disabled selected>View all</option>
									<?php $forward = $this->m_global->get_by_id_and_order('tm_forward', 'forward_status', 1, 'forward_name', 'ASC'); ?>
									<?php foreach($forward as $rw) : ?>
									<option value="<?php echo $rw->forward_id; ?>"><?php echo strip_tags($rw->forward_name); ?></option>
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
							<label class="control-label col-md-4">Call Name</label>
							<div class="col-md-8">	
								<input class="form-control" placeholder="Call Name" type="text" name="call_name" value="<?php echo (($this->session->flashdata('call_name') == "")?"":$this->session->flashdata('call_name')); ?>" autocomplete="off" required="" minlength="3" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Phone No.</label>
							<div class="col-md-8">	
								<input class="form-control" placeholder="Phone No." type="text" type="text" name="call_phone" value="<?php echo (($this->session->flashdata('call_phone') == "")?"":$this->session->flashdata('call_phone')); ?>" autocomplete="off" required="" minlength="3" maxlength="255" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Other Phone</label>
							<div class="col-md-8">	
								<input class="form-control" type="text" type="text" name="other_phone" value="<?php echo (($this->session->flashdata('other_phone') == "")?"":$this->session->flashdata('other_phone')); ?>" autocomplete="off" axlength="255" />
							</div>
						</div>
					</div>
				</div>
				<br/>
				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						CASE INFO
					</div>
					<div class="widget-content padded clearfix">
						<div class="form-group">
							<label class="control-label col-md-4">Street</label>
							<div class="col-md-8">	
								<textarea class="form-control" rows="2" style="resize: none;" name="street"><?php echo (($this->session->flashdata('street') == "")?"":strip_tags($this->session->flashdata('street'))); ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Area</label>
							<div class="col-md-8">
								<select class="select2able" name="area" required="" OnChange="ajax_location_by_area(this.value);">
									<option value="" disabled selected>View all</option>
									<?php $area = $this->m_global->get_by_id_and_order('tm_area', 'area_status', 1, 'area_name', 'ASC'); ?>
									<?php foreach($area as $rw) : ?>
									<option value="<?php echo $rw->area_id; ?>" <?php echo (($this->session->flashdata('area') == $rw->area_id)?"Selected":""); ?>><?php echo strip_tags($rw->area_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Area Detail</label>
							<div class="col-md-8">	
								<select class="select2able" id="location" name="location" required="">
									<?php if($this->session->flashdata('area') == "") { ?>
									<option value="" disabled selected>View all</option>
									<?php } else { ?>
									<?php $location = $this->m_global->get_by_double_id_order('tm_location', 'area_id', $this->session->flashdata('area'), 'location_status', 1, 'location_name', 'ASC'); ?>
									<?php foreach($location as $rw) : ?>
									<option value="<?php echo $rw->location_id; ?>" <?php echo (($this->session->flashdata('location') == $rw->location_id)?"Selected":""); ?>><?php echo strip_tags($rw->location_name); ?></option>
									<?php endforeach; ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Other Info</label>
							<div class="col-md-8">	
								<textarea class="form-control" rows="2" style="resize: none;" name="other_info"><?php echo (($this->session->flashdata('other_info') == "")?"":strip_tags($this->session->flashdata('other_info'))); ?></textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						PATIENT INFO
					</div>
					<div class="widget-content padded clearfix">
						<div class="form-group">
							<label class="control-label col-md-4">Total Patient</label>
							<div class="col-md-8">	
								<input class="form-control" placeholder="Total Patient" type="number" name="total_patient" value="<?php echo (($this->session->flashdata('total_patient') == "")?"":$this->session->flashdata('total_patient')); ?>" min="0" max="100" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Total Unconscious</label>
							<div class="col-md-8">	
								<input class="form-control" placeholder="Total Unconscious" type="number"  name="total_unconscious" value="<?php echo (($this->session->flashdata('total_unconscious') == "")?"":$this->session->flashdata('total_unconscious')); ?>" min="0" max="100" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Notes</label>
							<div class="col-md-8">	
								<textarea class="form-control" rows="2" style="resize: none;" name="note"><?php echo (($this->session->flashdata('note') == "")?"":strip_tags($this->session->flashdata('note'))); ?></textarea>
							</div>
						</div>
						<div class="form-group" style="border-bottom: 1px solid #eee;"></div>
						<div class="form-group">
							<label class="control-label col-md-4">Patient Name</label>
							<div class="col-md-5">	
								<input class="form-control" placeholder="Patient Name" type="text" />
							</div>
							<div class="col-md-1">	
								<a class="btn btn-default"><i class="icon-search"></i></a>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Medical Record No.</label>
							<div class="col-md-8">	
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
									<input checked="" name="optionsRadios_1" type="radio" value="Emeregency"><span>Emeregency</span></label>
								</label>
							</div>
						</div>
						<?php 
							$i = 0;	$iChecked = "";		$ii = 0; $iiChecked = "";
							$category = $this->m_global->get_by_double_id_order('tm_category', 'category_status', 1, 'is_emeregency', 1, 'category_id', 'ASC'); 
							foreach($category as $rw) :
								$iChecked = (($i == 0)?"Checked":"");
						?>
						<div class="form-group">
							<label class="control-label col-md-2">&nbsp;</label>
							<div class="col-md-10">
								<label class="radio">
								<input <?php echo $iChecked; ?> <?php echo (($this->session->flashdata('category') == $rw->category_id)?"Checked":""); ?> id="category<?php echo $rw->category_id; ?>" name="category" type="radio" value="<?php echo $rw->category_id; ?>"><span><?php echo strip_tags($rw->category_name); ?></span></label>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">&nbsp;</label>
							<div class="col-md-9">
								<?php 
									$subcategory = $this->m_global->get_by_double_id_order('tm_subcategory', 'subcategory_status', 1, 'category_id', $rw->category_id, 'subcategory_id', 'ASC'); 
									foreach($subcategory as $rws) :
										$iiChecked = (($ii == 0)?"Checked":"");
								?>
								
								<label class="radio">
									<input <?php echo $iiChecked; ?> <?php echo (($this->session->flashdata('sub_category') == $rws->subcategory_id)?"Checked":""); ?> name="sub_category" type="radio" value="<?php echo $rws->subcategory_id; ?>" OnChange="change_radio(<?php echo $rw->category_id; ?>);"><span><?php echo strip_tags($rws->subcategory_name); ?></span>
								</label>
								<?php 
										$ii = $ii + 1;
									endforeach; 
								?>
								<input class="form-control" type="text" id="description<?php echo $rw->category_id; ?>" value="" name="description" autocomplete="off" maxlength="255" />
							</div>
						</div>
						<?php 
								$i = $i + 1;
							endforeach; 
						?>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
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
								<tr>
									<td align="center" colspan="5">No data found</td>
								</tr>
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
								<tr>
									<td align="center" colspan="5">No data found</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<br/>
				<div class="widget-container fluid-height clearfix">
					<div class="widget-content padded clearfix">
						<div class="row">
							<center>
								<a class="btn btn-danger" href="javascrip:void(0);" OnClick="link_to('dashboard');"><i class="icon-trash"></i> CANCEL</a>
								<button type="reset" class="btn btn-danger"><i class="icon-repeat"></i> RESET</button>
								<a class="btn btn-warning btn fancybox" href="#fancybox-example"><i class="icon-bell"></i> SIRINE</a>
								<a class="btn btn-primary" href="javascrip:void(0);" OnClick="link_new_tab('emeregency/prints');"><i class="icon-print"></i> PRINT</a>
								<button type="submit" class="btn btn-primary"><i class="icon-save"></i> ORDER</button>
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