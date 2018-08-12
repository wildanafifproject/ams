<div class="container-fluid main-content">
    <div class="page-title">
        <h1></h1>
    </div>
    <!-- DataTables Example -->
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
		
        <div class="col-lg-1">&nbsp;</div>
		<div class="col-lg-10">
			<div class="widget-container fluid-height clearfix">
				<div class="heading">
					LIST EMERGENCY
				</div>
				<div class="col-lg-12">
					<div class="widget-container fluid-height clearfix">
						<div class="widget-content padded">
							<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>report/emergency">
								<div class="form-group">
									<label class="control-label col-md-2">Date Range</label>
									 <div class="col-sm-2">
										<input class="form-control" data-date-autoclose="true" data-date-format="dd-mm-yyyy" id="dpd1" placeholder="Start date" type="text" name="start" value="<?php echo (($this->session->userdata('from') == "")?"":convert_to_dmy($this->session->userdata('from'))); ?>" />
									</div>
									<div class="col-sm-2">
										<input class="form-control" data-date-autoclose="true" data-date-format="dd-mm-yyyy" id="dpd2" placeholder="End date" type="text" name="end" value="<?php echo (($this->session->userdata('to') == "")?"":convert_to_dmy($this->session->userdata('to'))); ?>" />
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
					<table class="table table-bordered table-striped" id="dataTableNoSort">
						<thead>
							<tr>
								<th width="12%" class="hidden-xs">Date</th>
								<th width="10%" class="hidden-xs">Time</th>
								<th width="20%" class="hidden-xs">Call No.</th>
								<th width="25%">Caller Name</th>
								<th width="15%" class="hidden-xs">Caller Phone</th>
								<th width="15%">Ambulance</th>
								<th width="15%">Status</th>
								<th width="15%">Action</th>								
							</tr>
						</thead>
						<tbody>
							<?php foreach($list as $row) : ?>
							<tr>
								<td align="center" class="hidden-xs"><?php echo convert_to_dmy($row->emergency_date); ?></td>
								<td align="center" class="hidden-xs"><?php echo convert_to_his($row->emergency_time); ?></td>
								<td align="center" class="hidden-xs"><?php echo $row->emergency_callreference; ?></td>
								<td><?php echo strip_tags($row->emergency_patientname); ?></td>
								<td align="center" class="hidden-xs"><?php echo $row->emergency_callerphone; ?></td>
								<td align="center"><?php echo strip_tags($this->m_ambulance->get_plat_by_id($row->ambulance_id)); ?></td>
								<td align="center">
									<span class="label label-<?php echo get_color($row->emergency_status); ?>"><?php echo get_transaction($row->emergency_status); ?></span>
								</td>
								<td class="actions" align="center">
									<div class="action-buttons">
										<a class="table-actions" href="javascript:void(0);" onClick="link_detail('report/emergency', '<?php echo simple_encrypt($row->emergency_id); ?>');"><i class="icon-list-alt"></i></a>
									</div>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-1">&nbsp;</div>
    </div>
    <!-- end DataTables Example -->
</div>