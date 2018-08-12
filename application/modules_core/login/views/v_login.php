<body class="login2">
    <!-- Login Screen -->
    <div class="login-wrapper">
        <a href="javascript:void(0);"><img width="100" height="30" src="<?php echo base_url(); ?>assets/images/1health polos.png" /></a>
		<?php
			$message = $this->session->flashdata('message');
			echo $message == '' ? '<div class="alert alert-info"><button class="close" data-dismiss="alert" type="button">&times;</button>Sign in to start your session.</div>' : '<div class="alert alert-danger"><button class="close" data-dismiss="alert" type="button">&times;</button>' . $message . '</div>';
		?>
		<form id="validate-form" action="<?php echo base_url(); ?>login/process-login" method="post">
            <div class="form-group">
               <input class="form-control" placeholder="Username" id="username" name="username" type="text" autocomplete="off" />
            </div>
            <div class="form-group">
                <input class="form-control" placeholder="Password" type="password" id="password" name="password" autocomplete="off"  />
            </div>
			<div class="social-login clearfix"></div>
            <input class="btn btn-lg btn-primary btn-block" type="submit" value="Log in" />
        </form>
    </div>
    <!-- End Login Screen -->