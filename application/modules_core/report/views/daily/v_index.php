<div class="container-fluid main-content">
    <div class="row">
		<div class="col-lg-12"></div>
		
		<div class="widget-container fluid-height clearfix">
			<div class="heading" style="background: #f1f1f1;">
				Daily Report
				
			</div>
			<div class="col-lg-12">
				<div class="widget-container fluid-height clearfix">
					<div class="widget-content padded">
						<div class="row" >
							<div class="col-md-12" >
								<form class="form-horizontal" method="post" action="">
									<input type="hidden" value="a" name="daily">
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
											<div class="input-group date datepicker" data-date-autoclose="true" data-date-format="dd-mm-yyyy">
												<input class="form-control" id="date" name="date_from" type="text" value="<?php echo (($this->session->flashdata('date') == "")?get_dmy():convert_to_dmy($this->session->flashdata('date'))); ?>" autocomplete="off" required="" OnChange="reset_area();"><span class="input-group-addon"><i class="icon-calendar"></i></span></input>
											</div>
											
										</div>
										
										 <div class="col-sm-2">
											<div class="input-group date datepicker" data-date-autoclose="true" data-date-format="dd-mm-yyyy">
												<input class="form-control" id="date" name="date_to" type="text" value="<?php echo (($this->session->flashdata('date') == "")?get_dmy():convert_to_dmy($this->session->flashdata('date'))); ?>" autocomplete="off" required="" OnChange="reset_area();"><span class="input-group-addon"><i class="icon-calendar"></i></span></input>
											</div>
											
										</div>
										
										
									</div>
									
									<div class="social-login clearfix"></div>
									<div class="form-group">
										<label class="control-label col-md-1"></label>
										<div class="col-md-7">
											<button class="btn btn-danger" type="reset"><i class="icon-repeat"></i> CANCEL</button>
											<button class="btn btn-primary" type="submit"><i class="icon-save"></i> DOWNLOAD</button>
										</div>
									</div>
								</form>
							</div>
							
						</div>
						
					</div>
				</div>
			</div>
			
		</div>
		
		


		

	</div>  
</div>
