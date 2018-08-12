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
							<div class="col-md-12" >
								<form class="form-horizontal" method="post" action="">
									<input type="hidden" value="a" name="statistic">
									<!-- <div class="form-group">
										<label class="control-label col-md-2">Order Type</label>
										<div class="col-md-4">
											<select class="select2able" name="type">
												<option value="" disabled selected>View all</option>
												<option value="1" <?php echo (($this->session->userdata('type') == 1)?"Selected":""); ?>>Emergency</option>
												<option value="2" <?php echo (($this->session->userdata('type') == 2)?"Selected":""); ?>>Non Emergency</option>
											</select>
										</div>
									</div> -->
									<div class="form-group">
										<label class="control-label col-md-2">Date Range</label>
										 <div class="col-sm-2">
											<select name="month_from" class="form-control" >
												<?php 
												$monthFrom = 1;
												if(isset($month_from)){
													$monthFrom = $month_from;
												}
												for ($i=1; $i < 13; $i++) { ?>
													<option value="<?php echo $i ?>" <?php echo ($i == intval($monthFrom) ? 'selected' : '');?>  ><?php echo convert_month_from_int($i); ?></option>
												<?php } ?>
											</select>
											
										</div>
										<div class="col-sm-1" style="padding-left: 0;" >
											<select class="form-control" name="year_from" >
												<?php
													$year = date("Y");
													if(isset($year_from)){
														$year = $year_from;
													}
													for($i = 2017 ; $i<2030 ; $i++){ ?>
														<option value="<?php echo $i; ?>" <?php echo ($i == intval($year) ? 'selected' : '');?> ><?php echo $i; ?></option>
												<?php }?>
											</select>
										 </div>

										 <div class="col-sm-2">
											<select name="month_to" class="form-control" >
												<?php 
												$monthTo = intval(date("m"));
												if(isset($month_to)){
													$monthTo = $month_to;
												}
												for ($i=1; $i < 13; $i++) { ?>
													<option value="<?php echo $i ?>" <?php echo ($i == intval($monthTo) ? 'selected' : '');?>  ><?php echo convert_month_from_int($i); ?></option>
												<?php } ?>
												
											</select>
											
										</div>
										<div class="col-sm-1" style="padding-left: 0;" >
											<select class="form-control" name="year_to" >
												<?php
													$yearTo = date("Y");
													if(isset($year_to)){
														$yearTo = $year_to;
													}
													for($i = 2017 ; $i<2030 ; $i++){ ?>
														<option value="<?php echo $i; ?>" <?php echo ($i == intval($yearTo) ? 'selected' : '');?> ><?php echo $i; ?></option>
												<?php }?>
											</select>
										 </div>
										
									</div>
									<div class="form-group">
										<label class="control-label col-md-2">Hospital</label>
										<div class="col-md-4">
											<select class="select2able" name="hospital" <?php if($this->session->userdata('user_authority') == 1) { echo 'required=""'; }  ?>>
												<option value="" disabled selected>View all</option>
												<?php foreach($hospital_list as $rw) : ?>
												<option value="<?php echo $rw->hospital_id; ?>" <?php echo (($hospital == $rw->hospital_id)?"Selected":""); ?>><?php echo strip_tags($rw->hospital_name); ?></option>
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
				</div>
			</div>
			
		</div>

		<div class="widget-content padded clearfix">
				<script src="<?php echo base_url('assets/javascripts/Chart.bundle.js') ?>"></script>
				<div style="padding: 100px;">
					<canvas id="myChart" width="100" height="30"></canvas>
				</div>
				<?php if (isset($statistic)) { ?>
				<script>
				var ctx = document.getElementById("myChart");
				var myChart = new Chart(ctx, {
				    type: 'bar',
				    options: {
				        legend: {
				            display: true,
				            labels: {
				                fontColor: 'rgb(255, 99, 132)'
				            }
				        }
					},
				    data: {
				        labels: [ <?php foreach ($statistic as $key => $value) {
				        	$mo = explode("-", $value->nonemergency_date);
				        	$month = intval($mo[1]);
				        	echo "'".convert_month_from_int($month)." ".$mo[0] ."'".",";
				        } ?> ],
				        datasets: [
				        	{
					            label: 'Emergency',
					           data: [<?php foreach ($statistic_nonemergency as $key => $value) {
					            	echo $value->total_pemakaian.", ";
					            } ?>],
					            backgroundColor: 'rgba(255, 99, 132, 0.2)',				              
					            borderWidth: 1
				        	},
				        	{
					            label: 'Non Emergency',
					            data: [<?php foreach ($statistic as $key => $value) {
					            	echo $value->total_pemakaian.", ";
					            } ?>],
					            backgroundColor: 'rgb(114, 183, 117)',				              
					            borderWidth: 1
				        	}
				        ]
				    },
				    options: {
				        scales: {
				            yAxes: [{
				                ticks: {
				                    beginAtZero:true
				                }
				            }]
				        }
				    }
				});
				</script>	
				<?php } ?>
				
			</div>
	</div>  
</div>
<script type="text/javascript">
	$("#totalPemakaianAmbulance").text("Total Pemakaian: <?php echo $totalCompleteAmbulance ?>");
</script>