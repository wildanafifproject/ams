<body>
	<div class="modal-shiftfix">	
		<div class="navbar navbar-fixed-top scroll-hide">
			<div class="container-fluid top-bar">
				<div class="pull-right">
					<ul class="nav navbar-nav pull-right">
						<?php if($this->session->userdata('user_authority') != 1) { ?>
						<li class="dropdown messages hidden-xs">
							<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><span aria-hidden="true" class="icon-ambulance"></span>
								<div class="sr-only">Emergency</div>
								<div id="count_emergency"></div>
							</a>
							<ul class="dropdown-menu" id="notif_emergency"></ul>
						</li>
						<li class="dropdown notifications hidden-xs">
							<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><span aria-hidden="true" class="icon-truck"></span>
								<div class="sr-only">Non Emergency</div>
								<div id="count_nonemergency"></div>
							</a>
							<ul class="dropdown-menu" id="notif_nonemergency"></ul>
						</li>
						<?php } ?>
						<li class="dropdown user hidden-xs">
							<a data-toggle="dropdown" class="dropdown-toggle" href="javascript:void(0);">
								<img width="34" height="34" src="<?php echo base_url() ."assets/uploads/".(($this->session->userdata('user_image') != "")?"user/thumb/". $this->session->userdata('user_image'):"no_image.png"); ?>" />
								<?php echo (($this->session->userdata('user_fullname') != "")?$this->session->userdata('user_fullname'):"-"); ?>
								<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li>
									<a href="javascript:void(0);" OnClick="link_to('change-password');">
										<i class="icon-lock"></i>Change Password
									</a>
								</li>
								<li>
									<a href="javascript:void(0);" OnClick="link_to('login/process-logout');">
										<i class="icon-signout"></i>Logout
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
				<button class="navbar-toggle"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
				<a class="logo" href="javascript:void(0);" OnClick="link_to('login/process-logout');"><img class="logo_img" src="<?php echo base_url(); ?>assets/images/icon_logout.gif" width="24" /></a>
				<div class="navbar-form form-inline col-lg-2 hidden-xs">
					<h5 style="font-weight: bold; margin-top: 6px;"><img class="logo_img" src="<?php echo base_url(); ?>assets/images/1health polos.png" height="24" /> AMBULANCE MANAGEMENT SYSTEM</h5>
				</div>				
			</div>
			<!-- Navigation -->
			<?php $this->load->view('v_navigation'); ?>
			<!-- End Navigation -->
		</div>