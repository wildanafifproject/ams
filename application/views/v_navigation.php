<div class="container-fluid main-nav clearfix">
    <div class="nav-collapse">
        <?php
			$nav_dashboard = ""; $nav_emergency = ""; $nav_nonemergency = ""; $nav_archive = ""; $nav_hospital = "";	$nav_setting = "";	$nav_master = ""; $nav_report = "";  $nav_statistic = "";
			$drop_setting = ' class="dropdown"'; $drop_master = ' class="dropdown"'; $drop_report = ' class="dropdown"'; 
			
			switch($this->session->userdata('nav_active')) {
				case "dashboard" :
					$nav_dashboard = ' class="current""';
				break;
				case "emergency" :
					$nav_emergency = ' class="current""';
				break;
				case "non_emergency" :
					$nav_nonemergency = ' class="current""';
				break;
				case "archive" :
					$nav_archive = ' class="current""';
				break;
				case "hospital" :
					$nav_hospital = ' class="current""';
				break;
				case "setting" :
					$nav_setting = ' class="current""';
					$drop_setting = ' class="dropdown current"'; 
				break;	
				case "master" :
					$nav_master = ' class="current""';
					$drop_master = ' class="dropdown current"'; 
				break;
				case "report" :
					$nav_report = ' class="current""';
					$drop_report = ' class="dropdown current"'; 
				break;
				case "statistic" :
					$nav_statistic= ' class="current""';
				break;
			}
			
			$sub_setting_user = "";	$sub_setting_area = ""; $sub_setting_location = ""; $sub_setting_case = ""; $sub_setting_type = ""; $sub_setting_transfer = ""; $sub_setting_forward = ""; $sub_setting_source = ""; $sub_setting_center = ""; $sub_setting_internal = "";  $sub_setting_facility = ""; $sub_setting_unit = ""; $sub_setting_specialist = "";
			$sub_master_hospital = ""; $sub_master_ambulance = ""; $sub_master_motorbike = ""; $sub_master_driver = ""; $sub_master_doctor = ""; $sub_master_nurse = ""; $sub_master_workroster = "";	$sub_master_workday = "";  
			$sub_report_emergency = "";	$sub_report_nonemergency = "";	$sub_report_crew = ""; $sub_report_daily = "";$sub_report_complaint = "";
			switch($this->session->userdata('sub_active')) {
				case "user" :
					$sub_setting_user = ' class="current""';
				break;
				case "area" :
					$sub_setting_area = ' class="current""';
				break;
				case "location" :
					$sub_setting_location = ' class="current""';
				break;
				case "case" :
					$sub_setting_case = ' class="current""';
				break;
				case "type" :
					$sub_setting_type = ' class="current""';
				break;
				case "transfer" :
					$sub_setting_transfer = ' class="current""';
				break;
				case "forward" :
					$sub_setting_forward = ' class="current""';
				break;
				case "source" :
					$sub_setting_source = ' class="current""';
				break;
				case "center" :
					$sub_setting_center = ' class="current""';
				break;
				case "internal" :
					$sub_setting_internal = ' class="current""';
				break;
				case "facility" :
					$sub_setting_facility = ' class="current""';
				break;
				case "unit" :
					$sub_setting_unit = ' class="current""';
				break;
				case "specialist" :
					$sub_setting_specialist = ' class="current""';
				break;
				
				case "hospital" :
					$sub_master_hospital = ' class="current""';
				break;
				case "ambulance" :
					$sub_master_ambulance = ' class="current""';
				break;
				case "motorbike" :
					$sub_master_motorbike = ' class="current""';
				break;
				case "driver" :
					$sub_master_driver = ' class="current""';
				break;
				case "doctor" :
					$sub_master_doctor = ' class="current""';
				break;
				case "nurse" :
					$sub_master_nurse = ' class="current""';
				break;
				case "workroster" :
					$sub_master_workroster = ' class="current""';
				break;
				case "workday" :
					$sub_master_workday = ' class="current""';
				break;
				
				case "emergency" :
					$sub_report_emergency = ' class="current""';
				break;
				case "non_emergency" :
					$sub_report_nonemergency = ' class="current""';
				break;
				case "crew" :
					$sub_report_crew = ' class="current""';
				case "daily" :
					$sub_report_daily= ' class="current""';
				break;
				case "complaint" :
					$sub_report_complaint= ' class="current""';
				break;
			}	
		?>
		<ul class="nav">
            <li>
                <a <?php echo $nav_dashboard; ?> href="javascript:void(0);" OnClick="link_to('dashboard');">
					<span aria-hidden="true" class="icon-home"></span>DASHBOARD
				</a>
            </li>
			<li>
				<a <?php echo $nav_emergency; ?> href="javascript:void(0);" OnClick="link_to('emergency');">
					<span aria-hidden="true" class="icon-ambulance"></span>EMERGENCY
				</a>
			</li>
			<li>
				<a <?php echo $nav_nonemergency; ?> href="javascript:void(0);" OnClick="link_to('non-emergency');">
					<span aria-hidden="true" class="icon-truck"></span>NON EMERGENCY
				</a>
			</li>
			<li>
				<a <?php echo $nav_archive; ?> href="javascript:void(0);" OnClick="link_to('archives');">
					<span aria-hidden="true" class="icon-th-list"></span>ARCHIVE
				</a>
			</li>
			<?php if($this->session->userdata('user_authority') == 1) { ?>
			<li>
				<a <?php echo $nav_hospital; ?> href="javascript:void(0);" OnClick="link_to('hospitals');">
					<span aria-hidden="true" class="icon-building"></span>HOSPITALS
				</a>
			</li>
			<?php } ?>
			
			<?php if($this->session->userdata('user_authority') == 0) { ?>
			<li <?php echo $drop_setting; ?>>
				<a <?php echo $nav_setting; ?> data-toggle="dropdown" href="javascript:void(0);">
					<span aria-hidden="true" class="icon-gears"></span>SETTINGS<b class="caret"></b>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a <?php echo $sub_setting_user; ?> href="javascript:void(0);" OnClick="link_to('user');">
							<p>USER</p>
						</a>
					</li>
					<li>
						<a <?php echo $sub_setting_area; ?> href="javascript:void(0);" OnClick="link_to('setting/area');">
							<p>AREA</p>
						</a>
					</li>
					<li>
						<a <?php echo $sub_setting_location; ?> href="javascript:void(0);" OnClick="link_to('setting/location');">
							<p>AREA DETAIL</p>
						</a>
					</li>
					<li>
						<a <?php echo $sub_setting_case; ?> href="javascript:void(0);" OnClick="link_to('setting/cases');">
							<p>CASE</p>
						</a>
					</li>
					<li>
						<a <?php echo $sub_setting_type; ?> href="javascript:void(0);" OnClick="link_to('setting/type');">
							<p>CASE TYPE</p>
						</a>
					</li>
					<li>
						<a <?php echo $sub_setting_transfer; ?> href="javascript:void(0);" OnClick="link_to('setting/transfer');">
							<p>TYPE TRANSFER</p>
						</a>
					</li>
					<li>
						<a <?php echo $sub_setting_forward; ?> href="javascript:void(0);" OnClick="link_to('setting/forward');">
							<p>FORWARD TO</p>
						</a>
					</li>
					<li>
						<a <?php echo $sub_setting_source; ?> href="javascript:void(0);" OnClick="link_to('setting/source');">
							<p>SOURCE CALL</p>
						</a>
					</li>
					<li>
						<a <?php echo $sub_setting_center; ?> href="javascript:void(0);" OnClick="link_to('setting/call-center');">
							<p>CALL CENTER</p>
						</a>
					</li>
					<li>
						<a <?php echo $sub_setting_internal; ?> href="javascript:void(0);" OnClick="link_to('setting/internal-call');">
							<p>INTERNAL CALL</p>
						</a>
					</li>
					<li>
						<a <?php echo $sub_setting_facility; ?> href="javascript:void(0);" OnClick="link_to('setting/facility');">
							<p>FACILITIES</p>
						</a>
					</li>
					<li>
						<a <?php echo $sub_setting_unit; ?> href="javascript:void(0);" OnClick="link_to('setting/unit');">
							<p>LOCATION</p>
						</a>
					</li>
					<li>
						<a <?php echo $sub_setting_specialist; ?> href="javascript:void(0);" OnClick="link_to('setting/specialist');">
							<p>SPECIALIST</p>
						</a>
					</li>
				</ul>
            </li>
			<?php } ?>
			
			<li <?php echo $drop_master; ?>>
				<a <?php echo $nav_master; ?> data-toggle="dropdown" href="javascript:void(0);">
					<span aria-hidden="true" class="icon-wrench"></span>MASTERS<b class="caret"></b>
				</a>
				<ul class="dropdown-menu">
					<?php if($this->session->userdata('user_authority') == 0) { ?>
					<li>
						<a <?php echo $sub_master_hospital; ?> href="javascript:void(0);" OnClick="link_to('master/hospital');">
							<p>HOSPITAL</p>
						</a>
					</li>
					<?php } ?>
					<li>
						<a <?php echo $sub_master_ambulance; ?> href="javascript:void(0);" OnClick="link_to('master/ambulance');">
							<p>AMBULANCE</p>
						</a>
					</li>
					<li>
						<a <?php echo $sub_master_motorbike; ?> href="javascript:void(0);" OnClick="link_to('master/motor-bike');">
							<p>MOTOR BIKE</p>
						</a>
					</li>
					<li>
						<a <?php echo $sub_master_driver; ?> href="javascript:void(0);" OnClick="link_to('master/driver');">
							<p>DRIVER</p>
						</a>
					</li>
					<li>
						<a <?php echo $sub_master_doctor; ?> href="javascript:void(0);" OnClick="link_to('master/doctor');">
							<p>DOCTORS</p>
						</a>
					</li>
					<li>
						<a <?php echo $sub_master_nurse; ?> href="javascript:void(0);" OnClick="link_to('master/nurse');">
							<p>NURSES</p>
						</a>
					</li>
					<?php if($this->session->userdata('user_authority') == 0) { ?>
					<li>
						<a <?php echo $sub_master_workroster; ?> href="javascript:void(0);" OnClick="link_to('master/work-roster');">
							<p>WORK ROSTER</p>
						</a>
					</li>
					<?php } ?>
					<li>
						<a <?php echo $sub_master_workday; ?> href="javascript:void(0);" OnClick="link_to('master/work-day');">
							<p>WORK DAY</p>
						</a>
					</li>
				</ul>
            </li>
			
			<li <?php echo $drop_report; ?>>
				<a <?php echo $nav_report; ?> data-toggle="dropdown" href="javascript:void(0);">
					<span aria-hidden="true" class="icon-calendar"></span>REPORTS<b class="caret"></b>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a <?php echo $sub_report_emergency; ?> href="javascript:void(0);" OnClick="link_to('report/emergency');">
							<p>EMERGENCY</p>
						</a>
					</li>
					<li>
						<a <?php echo $sub_report_nonemergency; ?> href="javascript:void(0);" OnClick="link_to('report/non-emergency');">
							<p>NON EMERGENCY</p>
						</a>
					</li>
					<li>
						<a <?php echo $sub_report_crew; ?> href="javascript:void(0);" OnClick="link_to('report/crew');">
							<p>CREW</p>
						</a>
					</li>

					<?php
						if($this->session->userdata('user_authority') != 1){ ?>
							<li>
						<a <?php echo $sub_report_daily; ?> href="javascript:void(0);" OnClick="link_to('report/daily');">
							<p>DAILY</p>
						</a>
					</li>
					<?php }
					?>
					<li>
						<a <?php echo $sub_report_complaint; ?> href="javascript:void(0);" OnClick="link_to('complaint');">
							<p>COMPLAINT</p>
						</a>
					</li>
				</ul>
            </li>
            <li>
                <a <?php echo $nav_statistic; ?> href="javascript:void(0);" OnClick="link_to('archives/statistic');">
					<span aria-hidden="true" class="icon-bar-chart"></span>STATISTIC
				</a>
            </li>
        </ul>
    </div>
</div>