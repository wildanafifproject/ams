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
					LIST WORK DAY
					<a href="javascript:void(0);" OnClick="link_add('master/work-day');"><i class="icon-plus pull-right"> Add Data</i></a>
				</div>
				<div class="col-lg-12">
					<div class="widget-container fluid-height clearfix">
						<div class="widget-content padded">
							<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>master/work-day">
								<div class="form-group">
									<label class="control-label col-md-1">Date Range</label>
									 <div class="col-sm-2">
										<input class="form-control" data-date-autoclose="true" data-date-format="dd-mm-yyyy" id="dpd1" placeholder="Start date" type="text" name="start" value="<?php echo (($this->session->userdata('from') == "")?"":convert_to_dmy($this->session->userdata('from'))); ?>" />
									</div>
									<div class="col-sm-2">
										<input class="form-control" data-date-autoclose="true" data-date-format="dd-mm-yyyy" id="dpd2" placeholder="End date" type="text" name="end" value="<?php echo (($this->session->userdata('to') == "")?"":convert_to_dmy($this->session->userdata('to'))); ?>" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-1">Hospital</label>
									<div class="col-md-4">
										<select class="select2able" name="hospital">
											<option value="" disabled selected>View all</option>
											<?php 
											if($this->session->userdata('user_authority') == 1) {	
												$hospital = $this->m_global->get_by_id('tm_hospital', 'hospital_id', $this->session->userdata('hospital_id'));
											}
											else {
												$hospital = $this->m_global->get_by_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', 'ASC');
											}
											?>
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
					</div>
				</div>
				<div class="widget-content padded clearfix">
					<table class="table table-bordered table-striped" id="dataTableOrder">
						<thead>
							<tr>
								<th style="display:none;">Date</th>
								<th>Date</th>
								<th width="25%">Hospital</th>
								<th width="25%">Work Roster</th>
								<th width="10%" class="hidden-xs">Status</th>
								<th width="15%">Action</th>								
							</tr>
						</thead>
						<tbody>
							<?php foreach($list as $row) : ?>
							<tr>
								<td align="center" style="display:none;"><?php echo date("Ymd", strtotime($row->workday_date)); ?></td>
								<td align="center"><?php echo date("d-m-Y", strtotime($row->workday_date)); ?></td>
								<td><?php echo strip_tags($this->m_hospital->get_name_by_id($row->hospital_id)); ?></td>
								<td align="center"><?php echo strip_tags($this->m_workroster->get_name_by_id($row->workroster_id)); ?></td>
								<td align="center" class="hidden-xs"><span class="label label-<?php echo (($row->workday_status == 1)?'success':'danger'); ?>"><?php echo get_status($row->workday_status); ?></span></td>
								<td class="actions" align="center">
									<div class="action-buttons">
										<a class="table-actions" href="javascript:void(0);" onClick="edit_data('master/work-day', '<?php echo simple_encrypt($row->workday_id); ?>');"><i class="icon-pencil"></i></a>
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

