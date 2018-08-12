<div class="container-fluid main-content">
    <div class="row">
		<div class="col-lg-12"></div>
		
		<div class="widget-container fluid-height clearfix">
			<div class="heading" style="background: #f1f1f1;">
				CREW
				<a href="javascript:void(0);" OnClick="link_to('report/crew/export-to-excel');"><i class="icon-print pull-right"> To Excel</i></a>
			</div>
			<div class="col-lg-12">
				<div class="widget-container fluid-height clearfix">
					<div class="widget-content padded">
						<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>report/crew">
							<div class="form-group">
								<label class="control-label col-md-1">Crew Type</label>
								<div class="col-md-2">
									<select class="select2able" name="type">
										<option value="" disabled selected>View all</option>
										<option value="1" <?php echo (($this->session->userdata('type') == 1)?"Selected":""); ?>>Driver</option>
										<option value="2" <?php echo (($this->session->userdata('type') == 2)?"Selected":""); ?>>Doctor</option>
										<option value="3" <?php echo (($this->session->userdata('type') == 3)?"Selected":""); ?>>Nurse</option>
									</select>
								</div>
							</div>
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
				<table class="table table-bordered table-striped" id="dataTableNoSort">
					<thead>
						<th width="10%" style="text-align: center;">Case number</th>
						<th style="text-align: center;">Hospital</th>
						<th width="15%" style="text-align: center;">Ambulance</th>
						<th width="20%" style="text-align: center;">Type</th>
						<th width="15%" style="text-align: center;">Name</th>
					</thead>
					<tbody>
						<?php 
							if(count($list) > 0) {
								for($i=0; $i<count($list); $i++) {
						?>		
						<tr>
							<td align="center"><?php echo $list[$i]['code']; ?></td>
							<td align="center"><?php echo $list[$i]['hospi']; ?></td>
							<td align="center"><?php echo $list[$i]['ambulance']; ?></td>
							<td align="center"><?php echo $list[$i]['crew']; ?></td>
							<td align="center"><?php echo $list[$i]['name']; ?></td>
						</tr>
						<?php 
								} 
							} 
							else { 
						?>
						<tr><td align="center" colspan="5">No data found</td></tr>
						<?php } ?>	
					</tbody>
				</table>
			</div>
		</div>
	</div>  
</div>