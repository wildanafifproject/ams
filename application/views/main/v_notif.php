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
					SEND NOTIFICATION
				</div>
				<div class="widget-content padded clearfix">
					<form id="validate-form" class="form-horizontal" method="post" action="<?php echo base_url(); ?>crons/send_notification">
						<div class="form-group">
							<label class="control-label col-md-2">Status</label>
							<div class="col-md-4">
								<select class="select2able" name="status">
									<?php for($i=1; $i<=14; $i++) { ?>
									<option value="<?php echo $i; ?>" <?php echo (($status == $i)?"Selected":""); ?>><?php echo get_notify($i); ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Device Token <span class="merah">*</span></label>
							<div class="col-md-9">
								<textarea class="form-control" rows="2" style="resize: none;" name="token" style="resize: none;" required><?php echo $token; ?></textarea>
							</div>
						</div>
						<?php if($token != "") { ?>
						<div class="social-login clearfix"></div>
						<div class="form-group">
							<label class="control-label col-md-2"></label>
							<div class="col-md-9">
								<cite><?php echo $result; ?></cite>	
							</div>
						</div>
						<?php } ?>
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