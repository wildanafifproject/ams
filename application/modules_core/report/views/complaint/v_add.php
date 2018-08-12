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
					ADD COMPLAINT
					<a href="javascript:void(0);" OnClick="link_to('complaint');"><i class="icon-arrow-left pull-right"> Back</i></a>
				</div>
				<div class="widget-content padded clearfix">
					<form id="validate-form" class="form-horizontal" method="post" action="" enctype="multipart/form-data" >
						<input type="hidden" name="complaint" value="1" />
						
						<div class="social-login clearfix"></div>

						<div class="form-group">
							<label class="control-label col-md-2">Name</label>
							<div class="col-md-9">
								<input class="form-control" name="name" type="text" value="" autocomplete="off" maxlength="255" />
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-2">Type <span class="text-danger">*</span></label>
							<div class="col-md-4">
								<select class="select2able" name="type" required="" >
									<option value="" disabled selected>Select Type</option>
									<option value="1"  >Satu</option>
									<option value="2"  >Dua</option>
									
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-2">Complaint</label>
							<div class="col-md-9">
								<textarea class="form-control" rows="8" style="resize: none;"  name="description"></textarea>
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
											<input type="file" name="file" />
										</span>
										<a class="btn btn-default fileupload-exists" data-dismiss="fileupload" href="javascript:void(0);">Remove</a>
									</div>
								</div>
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