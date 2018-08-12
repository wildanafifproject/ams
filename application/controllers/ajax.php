<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

	public function __construct() {
    	parent::__construct();
		$this->load->helper('status');	
		
		$this->load->model('../m_crud');
		$this->load->model('../m_global');
	}
	
	function driver_by_hospital() {
        $id = $this->input->post('hospital') ;
       
		$result = $this->m_global->get_by_double_id_order('tm_driver', 'hospital_id', $id, 'driver_status', 1, 'driver_name', 'ASC');
		echo '<option value="" selected>Select driver</option>';
		foreach($result as $row ) {
			echo "<option value='". $row->driver_id ."'>". strip_tags($row->driver_name) ."</option>";
		}
    }
	
	function doctor_by_hospital() {
        $id = $this->input->post('hospital') ;
       
		$result = $this->m_global->get_by_double_id_order('tm_doctor', 'hospital_id', $id, 'doctor_status', 1, 'doctor_name', 'ASC');
		echo '<option value="" selected>Select doctor</option>';
		foreach($result as $row ) {
			echo "<option value='". $row->doctor_id ."'>". strip_tags($row->doctor_name) ."</option>";
		}
    }
	
	function nurse_by_hospital() {
        $id = $this->input->post('hospital') ;
       
		$result = $this->m_global->get_by_double_id_order('tm_nurse', 'hospital_id', $id, 'nurse_status', 1, 'nurse_name', 'ASC');
		echo '<option value="" selected>Select nurse</option>';
		foreach($result as $row ) {
			echo "<option value='". $row->nurse_id ."'>". strip_tags($row->nurse_name) ."</option>";
		}
    }
	
	function location_by_area() {
        $id = $this->input->post('area') ;
       
		$result = $this->m_global->get_by_double_id_order('tm_location', 'area_id', $id, 'location_status', 1, 'location_name', 'ASC');
		echo '<option value="" selected>View all</option>';
		foreach($result as $row ) {
			echo "<option value='". $row->location_id ."'>". strip_tags($row->location_name) ."</option>";
		}
    }
	
	function div_loading() {
		$str = "";
		$str .= '
				<div>
					<center>
						<div class="overlay">
							<img src="'. base_url() .'assets/images/fancybox_loading.gif" />
						</div>
					</center>	
				</div>
			';
			
		echo $str;
	}
	
	function ambulance_by_area() {
		$str = "";	$list = "";	$ls = "";
		$id  = $this->input->post('area');
		
		$str .= '
			<div class="widget-content padded clearfix">
					<table class="table table-bordered table-striped">
						<thead>
							<th width="10%" style="text-align: center;">&nbsp;</th>
							<th width="25%" style="text-align: center;">Hospital Code</th>
							<th width="23%" style="text-align: center;">Police Number</th>
							<th style="text-align: center;">Case Type</th>
							<th width="18%" style="text-align: center;">Status</th>
						</thead>
						<tbody>
		';
		
		$result = $this->m_global->get_by_triple_id_order('tm_ambulance', 'ambulance_status', 0, 'is_login', 1, 'area_id', $id, 'ambulance_id', 'ASC');
		if(!empty($result)) {
			foreach($result as $row) {
				$list .= '
					<tr>
						<td align="center">
							<label class="checkbox-inline">
								<input type="checkbox" class="checkboxAmbulance" id="chkAmbulance'. $row->ambulance_id .'" value="'. $row->ambulance_id .'" name="chkAmbulance" OnChange="change_ambulance('. $row->ambulance_id .');"><span></span>
							</label>
						</td>
						<td align="center">'. $this->load->model('master/m_hospital')->get_code_by_id($row->hospital_id) .'</td>
						<td align="center">'. $row->ambulance_police .'</td>
						<td align="center">-</td>
						<td align="center">
							<span class="label label-'. get_color($row->ambulance_status) .'">'. get_ambulance($row->ambulance_status) .'</span>
						</td>
					</tr>
				';
			}
		}
		else {
			$list .= '
				<tr>
					<td align="center" colspan="5">No data found</td>
				</tr>
			';
		}
		
		$str .= $list;
		$str .= '
						</tbody>
					</table>
				</div>
		';
			
		echo $str;
	}
	
	function motorbike_by_area() {
		$str = "";	$list = "";	$ls = "";
		$id  = $this->input->post('area');
		
		$str .= '
			<div class="widget-content padded clearfix">
					<table class="table table-bordered table-striped">
						<thead>
							<th width="10%" style="text-align: center;">&nbsp;</th>
							<th width="25%" style="text-align: center;">Hospital Code</th>
							<th width="23%" style="text-align: center;">Police Number</th>
							<th style="text-align: center;">Case Type</th>
							<th width="18%" style="text-align: center;">Status</th>
						</thead>
						<tbody>
		';
		
		$result = $this->m_global->get_by_triple_id_order('tm_motorbike', 'motorbike_status', 0, 'is_login', 1, 'area_id', $id, 'motorbike_id', 'ASC');
		if(!empty($result)) {
			foreach($result as $row) {
				$list .= '
					<tr>
						<td align="center">
							<label class="checkbox-inline">
								<input type="checkbox" class="checkboxMotorbike" id="chkMotorbike'. $row->motorbike_id .'" value="'. $row->motorbike_id .'" name="chkMotorbike" OnChange="change_motorbike('. $row->motorbike_id .');"><span></span>
							</label>
						</td>
						<td align="center">'. $this->load->model('master/m_hospital')->get_code_by_id($row->hospital_id) .'</td>
						<td align="center">'. $row->motorbike_police .'</td>
						<td align="center">-</td>
						<td align="center">
							<span class="label label-'. get_color($row->motorbike_status) .'">'. get_ambulance($row->motorbike_status) .'</span>
						</td>
					</tr>
				';
			}
		}
		else {
			$list .= '
				<tr>
					<td align="center" colspan="5">No data found</td>
				</tr>
			';
		}
		
		$str .= $list;
		$str .= '
						</tbody>
					</table>
				</div>
		';
			
		echo $str;
	}
	
	function notif_emergency() {
		$str = "";
		
		$booked = $this->m_global->get_by_id_and_order('tp_emergency', 'emergency_status', 0, 'emergency_id', 'DESC');
		if(!empty($booked)) {
			foreach($booked as $row) {
				$str .= '
					<li>
						<a href="javascript:void(0);" onClick=link_to("emergency/edit-data/'. simple_encrypt($row->emergency_id) .'");>
							<div class="notifications label label-success">'. strip_tags($row->emergency_callername) .'</div>
							<p>From : </p>
						</a>
					</li>
				';
			}	
		}
		
		$confirmed = $this->m_global->get_by_id_and_order('tp_emergency', 'emergency_status', 1, 'emergency_id', 'DESC');
		if(!empty($confirmed)) {
			foreach($confirmed as $row) {
				$str .= '
					<li>
						<a href="javascript:void(0);" onClick=link_to("emergency/editing-data/'. simple_encrypt($row->emergency_id) .'");>
							<div class="notifications label label-primary">'. strip_tags($row->emergency_callername) .'</div>
							<p>From : </p>
						</a>
					</li>
				';
			}	
		}
		
		$process = $this->m_global->get_by_status_arr('tp_emergency', 'emergency_status', array(5,6,7,8));
		if(!empty($process)) {
			foreach($process as $row) {
				$str .= '
					<li>
						<a href="javascript:void(0);" onClick=link_to("emergency/detail-data/'. simple_encrypt($row->emergency_id) .'");>
							<div class="notifications label label-warning">'. strip_tags($row->emergency_callername) .'</div>
							<p>From : </p>
						</a>
					</li>
				';
			}	
		}
		
		echo $str;
	}
	
	function count_emergency() {
		$str = "";	$count = 0;
		
		$booked 	= $this->m_global->get_by_id_and_order('tp_emergency', 'emergency_status', 0, 'emergency_id', 'DESC');
		$confirmed 	= $this->m_global->get_by_id_and_order('tp_emergency', 'emergency_status', 1, 'emergency_id', 'DESC');
		$process 	= $this->m_global->get_by_status_arr('tp_emergency', 'emergency_status', array(5,6,7,8));
		
		$count	 	= count($booked) + count($confirmed) + count($process);
		if($count > 0) {
			$str = '<p class="counter">'. $count .'</p>';
		}
		
		echo $str;
	}
	
	function notif_nonemergency() {
		$str = "";
		
		$booked = $this->m_global->get_by_id_and_order('tp_nonemergency', 'nonemergency_status', 0, 'nonemergency_id', 'DESC');
		if(!empty($booked)) {
			foreach($booked as $row) {
				$str .= '
					<li>
						<a href="javascript:void(0);" onClick=link_to("non-emergency/edit-data/'. simple_encrypt($row->nonemergency_id) .'");>
							<div class="notifications label label-success">'. strip_tags($row->nonemergency_infoname) .'</div>
							<p>From : </p>
						</a>
					</li>
				';
			}	
		}
		
		$confirmed = $this->m_global->get_by_id_and_order('tp_nonemergency', 'nonemergency_status', 1, 'nonemergency_id', 'DESC');
		if(!empty($confirmed)) {
			foreach($confirmed as $row) {
				$str .= '
					<li>
						<a href="javascript:void(0);" onClick=link_to("non-emergency/editing-data/'. simple_encrypt($row->nonemergency_id) .'");>
							<div class="notifications label label-primary">'. strip_tags($row->nonemergency_infoname) .'</div>
							<p>From : </p>
						</a>
					</li>
				';
			}	
		}
		
		$process = $this->m_global->get_by_status_arr('tp_nonemergency', 'nonemergency_status', array(5,6,7,8));
		if(!empty($process)) {
			foreach($process as $row) {
				$str .= '
					<li>
						<a href="javascript:void(0);" onClick=link_to("non-emergency/detail-data/'. simple_encrypt($row->nonemergency_id) .'");>
							<div class="notifications label label-warning">'. strip_tags($row->nonemergency_infoname) .'</div>
							<p>From : </p>
						</a>
					</li>
				';
			}	
		}
		
		echo $str;
	}
	
	function count_nonemergency() {
		$str = "";	$count = 0;
		
		$booked 	= $this->m_global->get_by_id_and_order('tp_nonemergency', 'nonemergency_status', 0, 'nonemergency_id', 'DESC');
		$confirmed 	= $this->m_global->get_by_id_and_order('tp_nonemergency', 'nonemergency_status', 1, 'nonemergency_id', 'DESC');
		$process 	= $this->m_global->get_by_status_arr('tp_nonemergency', 'nonemergency_status', array(5,6,7,8));
		
		$count	 	= count($booked) + count($confirmed) + count($process);
		if($count > 0) {
			$str = '<p class="counter">'. $count .'</p>';
		}
		
		echo $str;
	}
	
	function ambulance_by_avaibility() {
		$str = "";	$list = "";	$ls = "";
		
		$id  	= $this->input->post('area');
		$date  	= $this->input->post('date');
		$time  	= $this->input->post('time');
		
		$date  		= convert_to_ymd($date);
		$time  		= convert_to_h($time);
		$time  		= $time .":00:00";
		$next_time 	= next_time($time, 2);
		$prev_time 	= prev_time($time, 2);
		
		$arr_booking = array();
		$booking_ambulance = $this->load->model('master/m_ambulance')->get_booking_by_area_date_time($id, $date, $next_time, $prev_time);
		foreach($booking_ambulance as $row) {
			$arr_booking[] = $row->ambulance_id;
		}
		
		$arr_available = array();
		$result = $this->m_global->get_by_triple_id_order('tm_ambulance', 'ambulance_status', 0, 'is_login', 1, 'area_id', $id, 'ambulance_id', 'ASC');
		foreach($result as $row) {
			if (!in_array($row->ambulance_id, $arr_booking)) {
				$arr_available[] = array(
					'ambulance_id'		=> $row->ambulance_id,
					'hospital_code' 	=> $this->load->model('master/m_hospital')->get_code_by_id($row->hospital_id),
					'police_number'		=> $row->ambulance_police,
					'ambulance_status'	=> $row->ambulance_status
				);
			}
		}
		
		$str .= '
			<div class="widget-content padded clearfix">
					<table class="table table-bordered table-striped">
						<thead>
							<th width="10%" style="text-align: center;">&nbsp;</th>
							<th width="25%" style="text-align: center;">Hospital Code</th>
							<th width="23%" style="text-align: center;">Police Number</th>
							<th style="text-align: center;">Case Type</th>
							<th width="18%" style="text-align: center;">Status</th>
						</thead>
						<tbody>
		';
		
		if(count($arr_available) > 0) {
			for($i=0; $i<count($arr_available); $i++) {
				$list .= '
					<tr>
						<td align="center">
							<label class="checkbox-inline">
								<input type="checkbox" class="checkboxAmbulance" id="chkAmbulance'. $arr_available[$i]['ambulance_id'] .'" value="'. $arr_available[$i]['ambulance_id'] .'" name="chkAmbulance" OnChange="change_ambulance('. $arr_available[$i]['ambulance_id'] .');"><span></span>
							</label>
						</td>
						<td align="center">'. $arr_available[$i]['hospital_code'] .'</td>
						<td align="center">'. $arr_available[$i]['police_number'] .'</td>
						<td align="center">-</td>
						<td align="center">
							<span class="label label-'. get_color($arr_available[$i]['ambulance_status']) .'">'. get_ambulance($arr_available[$i]['ambulance_status']) .'</span>
						</td>
					</tr>
				';
			}
		}
		else {
			$list .= '
				<tr>
					<td align="center" colspan="5">No data found</td>
				</tr>
			';
		}
		
		$str .= $list;
		$str .= '
						</tbody>
					</table>
				</div>
		';
			
		echo $str;
	}
	
	function ambulance_default() {
		$str = "";	$list = "";	
		
		$str .= '
			<div class="widget-content padded clearfix">
					<table class="table table-bordered table-striped">
						<thead>
							<th width="10%" style="text-align: center;">&nbsp;</th>
							<th width="25%" style="text-align: center;">Hospital Code</th>
							<th width="23%" style="text-align: center;">Police Number</th>
							<th style="text-align: center;">Case Type</th>
							<th width="18%" style="text-align: center;">Status</th>
						</thead>
						<tbody>
		';
		
		$list .= '
			<tr>
				<td align="center" colspan="5">No data found</td>
			</tr>
		';
		
		$str .= $list;
		$str .= '
						</tbody>
					</table>
				</div>
		';
			
		echo $str;
	}
	
	function motorbike_default() {
		$str = "";	$list = "";	
		
		$str .= '
			<div class="widget-content padded clearfix">
					<table class="table table-bordered table-striped">
						<thead>
							<th width="10%" style="text-align: center;">&nbsp;</th>
							<th width="25%" style="text-align: center;">Hospital Code</th>
							<th width="23%" style="text-align: center;">Police Number</th>
							<th style="text-align: center;">Case Type</th>
							<th width="18%" style="text-align: center;">Status</th>
						</thead>
						<tbody>
		';
		
		$list .= '
			<tr>
				<td align="center" colspan="5">No data found</td>
			</tr>
		';
		
		$str .= $list;
		$str .= '
						</tbody>
					</table>
				</div>
		';
			
		echo $str;
	}
	
	function get_patient_name() {
        $str = "[";
		
		$result = $this->m_global->get_by_id_and_order('tm_patient', 'patient_status', 1, 'patient_name', 'ASC');
		
		$i=0;
		foreach($result as $row ) {
			$i=$i+1;
			$str .= '"'. $row->patient_name .'"';
			
			if($i<count($result)) {
				$str .= ",";
			}
		}
		
		$str .= "]";
		echo $str;
	}
	
	function ambulance_crew_driver() {
		$ambulance  = simple_decrypt($this->input->post('ambulance'));
		$id = $this->load->model('master/m_ambulance')->get_hospital_by_id($ambulance);
		
		$date = get_ymd();
		$time = get_his();
		$result = $this->m_global->get_by_triple_id_order('tp_workday', 'workday_status', 1, 'hospital_id', $id, 'workday_date', $date, 'workday_id', 'DESC');
		
		$str_driver = "";
		if(!empty($result)) {
			foreach($result as $row) {
				$detail_roster = $this->m_global->get_by_id('tm_workroster', 'workroster_id', $row->workroster_id);
				foreach($detail_roster as $rws) {
					$start 	= $rws->workroster_start;
					$end 	= $rws->workroster_end;
					
					if((strtotime($time ) > strtotime($start )) && (strtotime($time ) < strtotime($end ))) {
						$ls_driver = $this->m_global->get_by_id_order('td_workdriver', 'workday_id', $row->workday_id, 'id', 'ASC');
						foreach($ls_driver as $rows) {
							$str_driver .= '<option value="'. $rows->driver_id .'">'. strip_tags($this->load->model('master/m_driver')->get_name_by_id($rows->driver_id)) .'</option>';
						}
					}
				}
			}
		}
		
		echo $str_driver;
	}
	
	function ambulance_crew_doctor() {
		$ambulance  = simple_decrypt($this->input->post('ambulance'));
		$id = $this->load->model('master/m_ambulance')->get_hospital_by_id($ambulance);
		
		$date = get_ymd();
		$time = get_his();
		$result = $this->m_global->get_by_triple_id_order('tp_workday', 'workday_status', 1, 'hospital_id', $id, 'workday_date', $date, 'workday_id', 'DESC');
		
		$str_doctor = "";
		if(!empty($result)) {
			foreach($result as $row) {
				$detail_roster = $this->m_global->get_by_id('tm_workroster', 'workroster_id', $row->workroster_id);
				foreach($detail_roster as $rws) {
					$start 	= $rws->workroster_start;
					$end 	= $rws->workroster_end;
					
					if((strtotime($time ) > strtotime($start )) && (strtotime($time ) < strtotime($end ))) {
						$ls_doctor = $this->m_global->get_by_id_order('td_workdoctor', 'workday_id', $row->workday_id, 'id', 'ASC');
						foreach($ls_doctor as $rows) {
							$str_doctor .= '<option value="'. $rows->doctor_id .'">'. strip_tags($this->load->model('master/m_doctor')->get_name_by_id($rows->doctor_id)) .'</option>';
						}
					}
				}
			}
		}
		
		echo $str_doctor;
	}
	
	function ambulance_crew_nurse() {
		$ambulance  = simple_decrypt($this->input->post('ambulance'));
		$id = $this->load->model('master/m_ambulance')->get_hospital_by_id($ambulance);
		
		$date = get_ymd();
		$time = get_his();
		$result = $this->m_global->get_by_triple_id_order('tp_workday', 'workday_status', 1, 'hospital_id', $id, 'workday_date', $date, 'workday_id', 'DESC');
		
		$str_nurse = "";
		if(!empty($result)) {
			foreach($result as $row) {
				$detail_roster = $this->m_global->get_by_id('tm_workroster', 'workroster_id', $row->workroster_id);
				foreach($detail_roster as $rws) {
					$start 	= $rws->workroster_start;
					$end 	= $rws->workroster_end;
					
					if((strtotime($time ) > strtotime($start )) && (strtotime($time ) < strtotime($end ))) {
						$ls_nurse = $this->m_global->get_by_id_order('td_worknurse', 'workday_id', $row->workday_id, 'id', 'ASC');
						foreach($ls_nurse as $rows) {
							$str_nurse .= '<option value="'. $rows->nurse_id .'">'. strip_tags($this->load->model('master/m_nurse')->get_name_by_id($rows->nurse_id)) .'</option>';
						}
					}
				}
			}
		}
		
		echo $str_nurse;
	}
	
	function detail_crew() {
		$str = "";	$list = "";	
		
		$type  	= $this->input->post('type');
		$id  	= simple_decrypt($this->input->post('order'));

		$arr_driver = array();
		$arr_doctor = array();
		$arr_nurse 	= array();
		
		$count = 0;
		
		if($type == 1) {
			$ls_driver = $this->m_global->get_by_id_order('td_emergencydriver', 'emergency_id', $id, 'id', 'ASC');
			$ls_doctor = $this->m_global->get_by_id_order('td_emergencydoctor', 'emergency_id', $id, 'id', 'ASC');
			$ls_nurse  = $this->m_global->get_by_id_order('td_emergencynurse', 'emergency_id', $id, 'id', 'ASC');
		}
		else {
			$ls_driver = $this->m_global->get_by_id_order('td_nonemergencydriver', 'nonemergency_id', $id, 'id', 'ASC');
			$ls_doctor = $this->m_global->get_by_id_order('td_nonemergencydoctor', 'nonemergency_id', $id, 'id', 'ASC');
			$ls_nurse  = $this->m_global->get_by_id_order('td_nonemergencynurse', 'nonemergency_id', $id, 'id', 'ASC');
		}
		
		foreach($ls_driver as $rows) {
			$arr_driver[] = strip_tags($this->load->model('master/m_driver')->get_name_by_id($rows->driver_id));
		}
		
		foreach($ls_doctor as $rows) {
			$arr_doctor[] = strip_tags($this->load->model('master/m_doctor')->get_name_by_id($rows->doctor_id));
		}

		foreach($ls_nurse as $rows) {
			$arr_nurse[]  = strip_tags($this->load->model('master/m_nurse')->get_name_by_id($rows->nurse_id));
		}
		
		if($count > count($arr_driver)) { $count = $count; } else { $count = count($arr_driver); }
		if($count > count($arr_doctor)) { $count = $count; } else { $count = count($arr_doctor); }
		if($count > count($arr_nurse))  { $count = $count; } else { $count = count($arr_nurse); }
		
		if($count > 0) {
			for($i=0; $i<$count; $i++) {
				$list .= '
					<tr>
						<td align="center">'. ((isset($arr_driver[$i]) == 0)?"-":$arr_driver[$i]) .'</td>
						<td align="center">'. ((isset($arr_doctor[$i]) == 0)?"-":$arr_doctor[$i]) .'</td>
						<td align="center">'. ((isset($arr_nurse[$i]) == 0)?"-":$arr_nurse[$i]) .'</td>
					</tr>
				';
			}
		}
		else {
			$list .= '
				<tr>
					<td align="center" colspan="3">No data found</td>
				</tr>
			';
		}
		
		
		$str .= '
			<div class="widget-content padded clearfix">
					<table class="table table-bordered table-striped">
						<thead>
							<th style="text-align: center;">Driver</th>
							<th width="33%" style="text-align: center;">Doctors</th>
							<th width="33%" style="text-align: center;">Nurses</th>
						</thead>
						<tbody>
		';
		
		$str .= $list;
		$str .= '
						</tbody>
					</table>
				</div>
		';
			
		echo $str;
	}
}