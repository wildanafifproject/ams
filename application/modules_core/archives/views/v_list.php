<div class="container-fluid main-content">
    <div class="row">
		<div class="col-lg-12"></div>
		
		<div class="widget-container fluid-height clearfix">
			<div class="heading" style="background: #f1f1f1;">
				ARCHIVE
				<a href="javascript:void(0);" OnClick="link_to('archives/export-to-excel');"><i class="icon-print pull-right"> To Excel</i></a>
			</div>
			<div class="col-lg-12">
				<div class="widget-container fluid-height clearfix">
					<div class="widget-content padded">
						<div class="row" >
							<div class="col-md-8" >
								<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>archives">
									<div class="form-group">
										<label class="control-label col-md-2">Order Type</label>
										<div class="col-md-4">
											<select class="select2able" name="type">
												<option value="" disabled selected>View all</option>
												<option value="1" <?php echo (($this->session->userdata('type') == 1)?"Selected":""); ?>>Emergency</option>
												<option value="2" <?php echo (($this->session->userdata('type') == 2)?"Selected":""); ?>>Non Emergency</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2">Date Range</label>
										 <div class="col-sm-4">
											<input class="form-control" data-date-autoclose="true" data-date-format="dd-mm-yyyy" id="dpd1" placeholder="Start date" type="text" name="start" value="<?php echo (($this->session->userdata('from') == "")?"":convert_to_dmy($this->session->userdata('from'))); ?>" />
										</div>
										<div class="col-sm-4">
											<input class="form-control" data-date-autoclose="true" data-date-format="dd-mm-yyyy" id="dpd2" placeholder="End date" type="text" name="end" value="<?php echo (($this->session->userdata('to') == "")?"":convert_to_dmy($this->session->userdata('to'))); ?>" />
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2">Hospital</label>
										<div class="col-md-4">
											<select class="select2able" name="hospital">
												<option value="" disabled selected>View all</option>
												<?php foreach($hospital as $rw) : ?>
												<option value="<?php echo $rw->hospital_id; ?>" <?php echo (($this->session->userdata('hospital') == $rw->hospital_id)?"Selected":""); ?>><?php echo strip_tags($rw->hospital_name); ?></option>
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
							<div class="col-md-4"  >
								<?php 
									if($this->session->userdata('type')=='1'){
										$labelEmergencyType = 'Emergency';
									}else if($this->session->userdata('type')=='2'){
										$labelEmergencyType = 'Non Emergency';
									}else{
										$labelEmergencyType = '';

									}
								 ?>
								 <div style="padding-top: 35%;float: right;padding-right: 20px;" >
								 	<div>Total <?= $labelEmergencyType ?> case: <?php echo count($list) ?></div>
									<div id="totalPemakaianAmbulance" ></div>

								 </div>
								
								
							</div>
						</div>
						
					</div>
				</div>
			</div>
			<div class="widget-content padded clearfix">
				<table class="table table-bordered table-striped" id="dataTableNoSort">
					<thead>
						<th width="10%" style="text-align: center;">Case number</th>
						<th style="text-align: center;">Patient name</th>
						<th width="20%" style="text-align: center;">From</th>
						<th width="20%" style="text-align: center;">To</th>
						<th width="15%" style="text-align: center;">Area</th>
						<th width="10%" style="text-align: center;">Ambulance</th>
						<th width="10%" style="text-align: center;">Time of call</th>
						<th width="10%" style="text-align: center;">Time response</th>
						<th width="10%" style="text-align: center;">Action</th>
					</thead>
					<tbody>
						<?php $totalCompleteAmbulance = '00:00:00' ?>
						<?php 
							if(count($list) > 0) {
								for($i=0; $i<count($list); $i++) {
						?>		
						<tr>
							<td align="center"><?php echo $list[$i]['code']; ?></td>
							<td align="center"><?php echo $list[$i]['patient']; ?></td>
							<td><?php echo $list[$i]['from']; ?></td>
							<td><?php echo $list[$i]['to']; ?></td>
							<td align="center"><?php echo $list[$i]['area']; ?></td>
							<td align="center"><?php echo $list[$i]['ambulance']; ?></td>
							<td align="center"><?php echo $list[$i]['time_booked']; ?></td>
							<td align="center"><?php echo $list[$i]['time_response']; ?></td>
							<td class="actions" align="center">
								<div class="action-buttons">
									<a class="table-actions" href="javascript:void(0);" onClick="link_detail('report/<?php echo $list[$i]['label_type']; ?>', '<?php echo $list[$i]['encrypt_id']; ?>');"><i class="icon-list-alt"></i></a>
								</div>
							</td>
						</tr>
						<?php 
							$timeUpdate = sum_the_date($list[$i]['time_complete'],$list[$i]['time_to_patient']);
							$totalCompleteAmbulance = sum_the_time($totalCompleteAmbulance, $timeUpdate);

								} 
							} 
							else { 
						?>
						<tr><td align="center" colspan="7">No data found</td></tr>
						<?php } ?>	
					</tbody>
				</table>
			</div>
		</div>
	</div>  
</div>
<script type="text/javascript">
	$("#totalPemakaianAmbulance").text("Total Pemakaian: <?php echo $totalCompleteAmbulance ?>");
</script>