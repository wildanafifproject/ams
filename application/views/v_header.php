<!DOCTYPE html>
<html> 
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
		
		<title></title>
		<link rel="icon" href="<?php echo base_url(); ?>assets/images/LOGO-AMS.png" type="image/x-icon" />
		<script>var base_url = "<?php echo base_url(); ?>"</script>
		<script>var user_authority = "<?php echo $this->session->userdata('user_authority'); ?>"</script>
                <script>var hospital_id_notif = "<?php echo $this->session->userdata('hospital_id'); ?>"</script>
		
		<link href="<?php echo base_url(); ?>assets/stylesheets/font.css" media="all" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/stylesheets/bootstrap.min.css" media="all" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/stylesheets/se7en-font.css" media="all" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/stylesheets/isotope.css" media="all" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/stylesheets/jquery.fancybox.css" media="all" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/stylesheets/fullcalendar.css" media="all" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/stylesheets/wizard.css" media="all" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/stylesheets/select2.css" media="all" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/stylesheets/morris.css" media="all" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/stylesheets/jquery.dataTables.css" media="all" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/stylesheets/datepicker.css" media="all" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/stylesheets/timepicker.css" media="all" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/stylesheets/colorpicker.css" media="all" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/stylesheets/bootstrap-switch.css" media="all" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/stylesheets/daterange-picker.css" media="all" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/stylesheets/typeahead.css" media="all" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/stylesheets/summernote.css" media="all" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/stylesheets/pygments.css" media="all" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/stylesheets/style.css" media="all" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/stylesheets/color/green.css" media="all" rel="alternate stylesheet" title="green-theme" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/stylesheets/color/orange.css" media="all" rel="alternate stylesheet" title="orange-theme" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/stylesheets/color/magenta.css" media="all" rel="alternate stylesheet" title="magenta-theme" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/stylesheets/color/gray.css" media="all" rel="alternate stylesheet" title="gray-theme" type="text/css" />
		

		<script src="https://www.gstatic.com/firebasejs/5.3.1/firebase.js"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/custom/Firebase.js"></script>

		<?php 

                if ($this->session->flashdata('update_firebase')) {
                    $msg = $this->session->flashdata('update_firebase');
                        
                 ?>
                       <script type="text/javascript">
                            notifToDevice(<?php echo $msg ?>);
                         
                        </script>
                <?php } ?>


		<script src="<?php echo base_url(); ?>assets/javascripts/jquery-1.10.2.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/jquery-ui.js" type="text/javascript"></script>
		<script src="<?php echo base_url('node_modules/socket.io-client/dist/socket.io.js');?>"></script>
		<!-- Custom -->
		<script src="<?php echo base_url(); ?>assets/javascripts/custom/global.js"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/custom/ajax.js"></script>
		
		<script src="<?php echo base_url(); ?>assets/javascripts/bootstrap.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/raphael.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/selectivizr-min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/jquery.mousewheel.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/jquery.vmap.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/jquery.vmap.sampledata.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/jquery.vmap.world.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/jquery.bootstrap.wizard.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/fullcalendar.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/gcal.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/jquery.dataTables.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/datatable-editable.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/jquery.easy-pie-chart.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/excanvas.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/jquery.isotope.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/isotope_extras.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/modernizr.custom.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/jquery.fancybox.pack.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/select2.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/styleswitcher.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/wysiwyg.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/summernote.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/jquery.inputmask.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/jquery.validate.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/bootstrap-fileupload.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/bootstrap-datepicker.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/bootstrap-timepicker.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/bootstrap-colorpicker.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/bootstrap-switch.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/typeahead.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/daterange-picker.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/date.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/morris.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/skycons.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/fitvids.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/jquery.sparkline.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/main.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/javascripts/respond.js" type="text/javascript"></script>
		
		<!--------------- TYPING/MOVING TITLE ----------------------->
		<script type="text/javascript">
			var rev = "fwd";
			function titlebar(val) {
				var msg = "AMBULANCE MANAGEMENT SYSTEM";
				var res = " ";
				var speed = 100;
				var pos = val;
				var le = msg.length;
				
				if(rev == "fwd") {
					if(pos < le) {
						pos = pos+1;
						scroll = msg.substr(0,pos);
						document.title = scroll;
						timer = window.setTimeout("titlebar("+pos+")",speed);
					}
					else {
						rev = "bwd";
						timer = window.setTimeout("titlebar("+pos+")",speed);
					}
				}	
				else{
					if(pos > 0) {
						pos = pos-1;
						var ale = le-pos;
						scrol = msg.substr(ale,le);
						document.title = scrol;
						timer = window.setTimeout("titlebar("+pos+")",speed);
					}
					else {
						rev = "fwd";
						timer = window.setTimeout("titlebar("+pos+")",speed);
					}
				}
			}
			
			titlebar(1);
		</script>
                <!--notifikasi-->
                 <script type="text/javascript">
                 	
                 </script>


                <?php 

                if ($this->session->flashdata('notif_node')) {
                    $msg = $this->session->flashdata('notif_node');
                        
                 ?>
                       <script type="text/javascript">
                            
                            console.log('<?php echo $msg ?>');  
                            notifikasi(<?php echo $msg ?>);
                         
                        </script>
                <?php } ?>
                        <script>
                            initNotif();
                        </script>       
	</head>