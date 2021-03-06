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
					ADD MOTOR BIKE
					<a href="javascript:void(0);" OnClick="link_to('master/motor-bike');"><i class="icon-arrow-left pull-right"> Back</i></a>
				</div>
				<div class="widget-content padded clearfix">
					<form id="validate-form" class="form-horizontal" method="post" action="<?php echo base_url(); ?>master/motor-bike/insert-data" enctype="multipart/form-data">
						<input type="hidden" name="valid" value="<?php echo simple_encrypt(1); ?>" />
						<div class="form-group">
							<label class="control-label col-md-2">Username <span class="text-danger">*</span></label>
							<div class="col-md-4">
								<input class="form-control" id="username" name="username" type="text" autocomplete="off" required="" minlength="5" maxlength="25" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Password <span class="text-danger">*</span></label>
							<div class="col-md-4">
								<input class="form-control" id="password" name="password" type="password" autocomplete="off" required="" minlength="5" maxlength="25" />
							</div>
						</div>
						<div class="social-login clearfix"></div>
						<div class="form-group">
							<label class="control-label col-md-2">Area <span class="text-danger">*</span></label>
							<div class="col-md-4">
								<select class="select2able" name="area" required="" OnChange="ajax_hospital(this.value);">
									<option value="" disabled selected>Select area</option>
									<?php $area = $this->m_global->get_by_id('tm_area', 'area_status', 1); ?>
									<?php foreach($area as $rw) : ?>
									<option value="<?php echo $rw->area_id; ?>" <?php echo (($this->session->flashdata('area') == $rw->area_id)?"Selected":""); ?>><?php echo strip_tags($rw->area_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Hospital <span class="text-danger">*</span></label>
							<div class="col-md-4">
								<select class="select2able" name="hospital" required="" OnChange="ajax_driver_by_hospital(this.value);">
									<option value="" disabled selected>Select hospital</option>
									<?php foreach($hospital as $rw) : ?>
									<option value="<?php echo $rw->hospital_id; ?>" <?php echo (($this->session->flashdata('hospital') == $rw->hospital_id)?"Selected":""); ?>><?php echo strip_tags($rw->hospital_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">NO <span class="text-danger">*</span></label>
							<div class="col-md-3">
								<input class="form-control" id="code" name="code" type="text" value="<?php echo (($this->session->flashdata('code') == "")?"":$this->session->flashdata('code')); ?>" autocomplete="off" required="" minlength="1" maxlength="10" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Police No. <span class="text-danger">*</span></label>
							<div class="col-md-3">
								<input class="form-control" id="plat" name="plat" type="text" value="<?php echo (($this->session->flashdata('plat') == "")?"":$this->session->flashdata('plat')); ?>" autocomplete="off" required="" minlength="5" maxlength="12" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Status</label>
							<div class="col-md-3">
								<select class="select2able" name="status">
									<option value="" disabled selected>Select status</option>
									<?php for($i=0; $i<=2; $i++) { ?>
									<option value="<?php echo $i; ?>" <?php echo (($this->session->flashdata('status') == $i)?"Selected":""); ?>><?php echo get_ambulance($i); ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Image</label>
							<div class="col-md-9">
								<div class="fileupload fileupload-new" data-provides="fileupload">
									<div class="fileupload-new img-thumbnail" style="width: 150px; height: 150px;">
										<img src="<?php echo base_url() ."assets/uploads/no_image.png"; ?>" style="width: 150px; max-height: 150px" />
									</div>
									<div class="fileupload-preview fileupload-exists img-thumbnail" style="width: 150px; max-height: 150px"></div>
									<div>
										<span class="btn btn-default btn-file">
											<span class="fileupload-new">Select image</span>
											<span class="fileupload-exists">Change</span>
											<input type="file" name="userfile" />
										</span>
										<a class="btn btn-default fileupload-exists" data-dismiss="fileupload" href="javascript:void(0);">Remove</a>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2"></label>
							<div class="col-md-7">
								<label class="checkbox"><input type="checkbox" name="check" value="1" /><span>Login</span></label>
							</div>
						</div>
						<div class="social-login clearfix"></div>
						<div class="form-group">
							<label class="control-label col-md-2"></label>
							<div class="col-md-7">
								<a class="" href="#fancybox-example"></a>
								<button class="btn btn-danger" type="reset"><i class="icon-repeat"></i> CANCEL</button>
								<button class="btn btn-primary" type="submit"><i class="icon-save"></i> SUBMIT</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-lg-1">&nbsp;</div>	
    </div>
    <!-- end DataTables Example -->
</div>