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
			
				<div class="widget-container fluid-height clearfix">
					<div class="heading" style="background: #f1f1f1;">
						ARCHIVE
					</div>
					<div class="col-lg-12">
						<div class="widget-container fluid-height clearfix">
						  <div class="widget-content padded">
							<form action="#" class="form-horizontal">
								<div class="form-group">
									<label class="control-label col-md-1">Case Number</label>
									<div class="col-md-2">
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
									<label class="control-label col-md-1">Date</label>
									<div class="col-md-2">
										<div class="input-group date datepicker" data-date-autoclose="true" data-date-format="dd-mm-yyyy">
											<input class="form-control" type="text"><span class="input-group-addon"><i class="icon-calendar"></i></span></input>
										</div>
									</div>
									<div class="col-md-2">
										<div class="input-group bootstrap-timepicker">
											<input class="form-control" id="timepicker-24h" type="text"><span class="input-group-addon"><i class="icon-time"></i></span></input>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-1">Case Type</label>
									<div class="col-md-4">
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
									<label class="control-label col-md-1">Hospital</label>
									<div class="col-md-4">
										<select class="select2able">
											<option value="" disabled selected>View all</option>
											<option value="Category 1">Option 1</option>
											<option value="Category 2">Option 2</option>
											<option value="Category 3">Option 3</option>
											<option value="Category 4">Option 4</option>
										</select>	
									</div>
								</div>
							</form>
						  </div>
						</div>
					</div>
					<div class="widget-content padded clearfix">
						<table class="table table-bordered table-striped">
							<thead>
								<th width="15%" style="text-align: center;">Case Number</th>
								<th style="text-align: center;">Street</th>
								<th width="15%" style="text-align: center;">Case Type</th>
								<th width="20%" style="text-align: center;">Time Phone</th>
							</thead>
							<tbody>
								<tr>
									<td align="center">CN-00001</td>
									<td align="center">Jalan Kemanggisan Ilir No 20 RT 08/06 Jakarta Barat - 11470</td>
									<td align="center">Dinie Dianie</td>
									<td align="center">20-02-2017 18:09:39</td>
								</tr>
								<tr>
									<td align="center">CN-00001</td>
									<td align="center">Jln Medan Merdeka Barat Jakarta Pusat</td>
									<td align="center">-</td>
									<td align="center">20-02-2017 18:09:39</td>
								</tr>
							</tbody>
						</table>
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