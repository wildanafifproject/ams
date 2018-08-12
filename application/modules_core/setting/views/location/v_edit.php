<div class="container-fluid main-content">
    <div class="page-title">
        <h1></h1>
    </div>
    <!-- DataTables Example -->
    <div class="row">
		<div class="col-lg-12"></div>
		
        <div class="col-lg-1">&nbsp;</div>
		<div class="col-lg-10">
			<div class="widget-container fluid-height clearfix">
				<div class="heading">
					EDIT AREA DETAIL
					<a href="javascript:void(0);" OnClick="link_to('setting/location');"><i class="icon-arrow-left pull-right"> Back</i></a>
				</div>
				<div class="widget-content padded clearfix">
					<?php foreach($detail as $row) : ?>
					<form id="validate-form" class="form-horizontal" method="post" action="<?php echo base_url(); ?>setting/location/update-data">
						<input type="hidden" name="valid" value="<?php echo simple_encrypt(1); ?>" />
						<input type="hidden" name="id" value="<?php echo simple_encrypt($row->location_id); ?>" />
						<div class="form-group">
							<label class="control-label col-md-2">Status</label>
							<div class="col-md-9">
								<div class="toggle-switch text-toggle-switch" data-off-label="<?php echo get_status(0); ?>" data-on="primary" data-on-label="<?php echo get_status(1); ?>" style="width:175px;">
									<input value="1" name="status" <?php echo (($row->location_status == 1)?"Checked":""); ?> type="checkbox" />
								</div>	
							</div>
						</div>
						<div class="social-login clearfix"></div>
						<div class="form-group">
							<label class="control-label col-md-2">Area <span class="text-danger">*</span></label>
							<div class="col-md-4">
								<select class="select2able" name="area" required="">
									<option value="" disabled selected>Select area</option>
									<?php $area = $this->m_global->get_by_id('tm_area', 'area_status', 1); ?>
									<?php foreach($area as $rw) : ?>
									<option value="<?php echo $rw->area_id; ?>"  <?php echo (($row->area_id == $rw->area_id)?"Selected":""); ?>><?php echo strip_tags($rw->area_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Name <span class="text-danger">*</span></label>
							<div class="col-md-9">
								<input class="form-control" id="name" name="name" type="text" value="<?php echo strip_tags($row->location_name); ?>" autocomplete="off" required="" minlength="3" maxlength="255" />
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
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<div class="col-lg-1">&nbsp;</div>	
    </div>
    <!-- end DataTables Example -->
</div>