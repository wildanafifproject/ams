<?php if(!defined('BASEPATH')) exit('Akses langsung tidak di perkenankan');

class Archives extends CI_Controller {

	public function __construct() {
    	parent::__construct();
		
		if ($this->session->userdata('login') == TRUE) {	
			$this->load->helper('message');
			$this->load->helper('status');
			$this->load->helper('archive');
			
			$this->load->model('emergency/m_emergency');
			$this->load->model('non_emergency/m_nonemergency');
			$this->load->model('master/m_ambulance');
			
			// set nav active
			$this->session->set_userdata('nav_active', 'archive');
			
			// set sub active
			$this->session->unset_userdata('sub_active');
		}
		else {
			get_redirecting('login');
		}
	}

    function index() {
		// get from post
		$type		= $this->input->post('type');
		$start		= $this->input->post('start');
		$end		= $this->input->post('end');
		$hospital	= $this->input->post('hospital');
		
		if($start != "") { 
			$data['start'] = convert_to_dmy($start); 
		} 
		else { 
			$data['start'] = get_date_in_month(0, date("m"), date("Y")); 
		}
		
		if($end != "") { 
			$data['end'] = convert_to_dmy($end); 
		} 
		else { 
			$data['end'] = get_date_in_month(1, date("m"), date("Y")); 
		}
		
		// cek time
		if(strtotime($data['start']) > strtotime($data['end'])) {
			$this->session->set_flashdata('message', 'Error format date.');
			$this->session->set_flashdata('status', get_notify_status(2));
			
			get_redirecting('archives');
		}
		
		// set session
		$this->session->set_userdata('type', $type);
		$this->session->set_userdata('from', $data['start']);
		$this->session->set_userdata('to', $data['end']);
		$this->session->set_userdata('hospital', $hospital);
		
		// set data
		$list = array();
		if($type == 1) {
			$emergency 		= $this->m_emergency->get_archive();
			$nonemergency 	= NULL;
		}
		elseif($type == 2) {
			$emergency 		= NULL;
			$nonemergency 	= $this->m_nonemergency->get_archive();
		}
		else {
			$emergency 		= $this->m_emergency->get_archive();
			$nonemergency 	= $this->m_nonemergency->get_archive();
		}
		
		if(!empty($emergency)) {
			foreach($emergency as $row) {
				$arr_nul = array(0,2,3);
				if (in_array($row->emergency_status, $arr_nul)) {
					$ambulance 	= "-";
				}
				else {
					$ambulance 	= $this->m_ambulance->get_plat_by_id($row->ambulance_id);
				}
				
				$time_booked		= $row->emergency_date .' '. $row->emergency_time;
				$time_cancel 		= (($row->time_cancel != "")?$row->time_cancel:$row->time_reject);
				$time_confirmed 	= $row->time_confirmed;
				$time_response 		= get_time_response($time_confirmed, $time_booked);
				
				if($row->reason_cancel == "") {
					$reason = strip_tags($row->reason_cancel);
				}
				else {
					$reason = strip_tags($row->reason_reject);
				}
				
				$list[] = array(
					"encrypt_id"    => simple_encrypt($row->emergency_id),
					"label_type"	=> 'emergency',
					"type"			=> 1,
					"ambulance"		=> $ambulance,
					"area"			=> $this->load->model('setting/m_area')->get_name_by_id($row->area_id),
					"time_booked"	=> $time_booked,
					"time_cancel"	=> $time_cancel,
					"time_response"	=> $time_response,
					"time_to_patient" => $row->time_to_patient,
					"time_complete" => $row->time_complete,
					"id" 			=> $row->emergency_id,
					"code"			=> $row->emergency_callreference,
					"patient"		=> strip_tags($row->emergency_patientname),
					"from"			=> strip_tags($row->emergency_infostreet),
					"to"			=> strip_tags($this->load->model('master/m_hospital')->get_name_by_id($row->hospital_id)),
					"note"			=> strip_tags($row->emergency_patientnote),
					"reason"		=> $reason,
					"status"		=> get_transaction($row->emergency_status),
					"by"			=> $this->load->model('user/m_user')->get_name_by_id($row->last_user)
				);
			}
		}
		
		if(!empty($nonemergency)) {
			foreach($nonemergency as $row) {
				$arr_nul = array(0,2,3);
				if (in_array($row->nonemergency_status, $arr_nul)) {
					$ambulance 	= "-";
				}
				else {
					$ambulance 	= $this->m_ambulance->get_plat_by_id($row->ambulance_id);
				}
				
				$time_booked		= $row->nonemergency_date .' '. $row->nonemergency_time;
				$time_cancel 		= (($row->time_cancel != "")?$row->time_cancel:$row->time_reject);
				$time_confirmed 	= $row->time_confirmed;
				$time_response 		= get_time_response($time_confirmed, $time_booked);
				
				if($row->reason_cancel == "") {
					$reason = strip_tags($row->reason_cancel);
				}
				else {
					$reason = strip_tags($row->reason_reject);
				}
				
				$list[] = array(
					"encrypt_id"    => simple_encrypt($row->nonemergency_id),
					"label_type"	=> 'non-emergency',
					"type"			=> 2,
					"ambulance"		=> $ambulance,
					"area"			=> $this->load->model('setting/m_area')->get_name_by_id($row->nonemergency_fromarea),
					"time_booked"	=> $time_booked,
					"time_cancel"	=> $time_cancel,
					"time_response"	=> $time_response,					
					"time_to_patient" => $row->time_to_patient,
					"time_complete" => $row->time_complete,
					"id" 			=> $row->nonemergency_id,
					"code"			=> $row->nonemergency_callreference,
					"patient"		=> strip_tags($row->nonemergency_infoname),
					"from"			=> strip_tags($this->load->model('master/m_hospital')->get_name_by_id($row->nonemergency_fromhospital)),
					// "to"			=> strip_tags($this->load->model('master/m_hospital')->get_name_by_id($row->nonemergency_tohospital)),
					 "to"			=> $row->nonemergency_tosearch,
					"note"			=> strip_tags($row->nonemergency_requestnote),
					"reason"		=> $reason,
					"status"		=> get_transaction($row->nonemergency_status),
					"by"			=> $this->load->model('user/m_user')->get_name_by_id($row->last_user)
				);
			}
		}
		
		if($this->session->userdata('user_authority') == 1) { 
			$data['hospital'] = $this->m_global->get_by_double_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', $this->session->userdata('hospital_id'), 'hospital_id', 'ASC');
		}
		else {
			$data['hospital'] = $this->m_global->get_by_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', 'ASC');
		}
		
		$data['list'] = $list;
		
		// set view
		$this->load->view('../v_header');
		$this->load->view('../v_top');
		$this->load->view('v_list', $data);
		$this->load->view('../v_bottom');
		$this->load->view('../v_footer');
    }

    function statistic()
    {
    	$data['hospital']='';

    	$this->session->set_userdata('nav_active', 'statistic');
    	if($this->session->userdata('user_authority') == 1) { 
			$hospitalList = $this->m_global->get_by_double_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', $this->session->userdata('hospital_id'), 'hospital_id', 'ASC');
		}
		else {
			$hospitalList = $this->m_global->get_by_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', 'ASC');
		}
    	if(isset($_POST['statistic'])){
    		$data = $this->input->post();
    		$data['hospital_list'] = $hospitalList;
    		$startDate = get_date_in_month(0, $data['month_from'], $data['year_from']); 
    		$endDate = get_date_in_month(1, $data['month_to'], $data['year_to']); 
    		$data['statistic'] = $this->m_nonemergency->getStatistic($startDate,$endDate,$data['hospital']);
    		$data['statistic_nonemergency'] = $this->m_emergency->getStatistic($startDate,$endDate,$data['hospital']);

    		//batas
    		$data['total_emergency_case']=$this->m_emergency->get_total_emergency_case($startDate,$endDate,$data['hospital']);
    		$data['total_nonemergency_case']=$this->m_nonemergency->get_total_nonemergency_case($startDate,$endDate,$data['hospital']);
    		$data['total_cancel_emergency_case']=$this->m_emergency->get_total_cancel_emergency_case($startDate,$endDate,$data['hospital']);
    		$data['total_cancel_nonemergency_case']=$this->m_nonemergency->get_total_cancel_nonemergency_case($startDate,$endDate,$data['hospital']);
    		$data['notif_depart']=$this->m_emergency->getAvgCrewNotifToDepart($startDate,$endDate,$data['hospital']);
    		//print_r( $data['notif_depart']);
    		//echo sum_the_date('2018-7-11 14:00:00','2018-7-11 13:00:00');
    		$this->load->view('../v_header');
			$this->load->view('../v_top');
			$this->load->view('v_statistic2',$data);
			$this->load->view('../v_bottom');
			$this->load->view('../v_footer');

    	}else{
    		//$this->m_nonemergency->getStatistic("2018-01-10","2018-04-10","");
    		// set view
    		$data['hospital_list'] = $hospitalList;
			$this->load->view('../v_header');
			$this->load->view('../v_top');
			$this->load->view('v_statistic2',$data);
			$this->load->view('../v_bottom');
			$this->load->view('../v_footer');
    	}
    	
    }
	
	 function export_to_excel() {
		// set data
		$list 		= array();
		$type 		= $this->session->userdata('type');
		$hospital 	= $this->session->userdata('hospital');
		
		if($type == 1) {
			$emergency 		= $this->m_emergency->get_archive();
			$nonemergency 	= NULL;
		}
		elseif($type == 2) {
			$emergency 		= NULL;
			$nonemergency 	= $this->m_nonemergency->get_archive();
		}
		else {
			$emergency 		= $this->m_emergency->get_archive();
			$nonemergency 	= $this->m_nonemergency->get_archive();
		}
		
		if(!empty($emergency)) {
			foreach($emergency as $row) {
				$arr_nul = array(0,2,3);
				if (in_array($row->emergency_status, $arr_nul)) {
					$ambulance 	= "-";
				}
				else {
					$ambulance 	= $this->m_ambulance->get_plat_by_id($row->ambulance_id);
				}
  
				$time_booked			= $row->emergency_date .' '. $row->emergency_time;
				$time_confirmed 		= $row->time_confirmed;
				$time_set_order 		= $row->time_waiting;
				$time_set_crew 			= $row->time_set_crew;
				$time_to_patient 		= $row->time_to_patient;
				$time_call_patient 		= $row->time_call_patient;
				$time_arrived_patient 	= $row->time_arrived_patient;
				$time_to_hospital 		= $row->time_to_hospital;
				$time_arrived_hospital 	= $row->time_arrived_hospital;
				$time_back_hospital 	= $row->time_back_hospital;
				$time_complete 			= $row->time_complete;
				$time_cancel 			= (($row->time_cancel != "")?$row->time_cancel:$row->time_reject);
				
				$time_response 									= get_time_response($time_confirmed, $time_booked);
				$min_collect_data 								= get_min_collect_data($time_set_crew, $time_booked);
				$min_leave_from_time_notification 				= get_min_leave_from_time_notification($time_to_patient, $time_set_crew);
				$min_leave_from_original_call 					= get_min_leave_from_original_call($time_to_patient, $time_booked);
				$min_call_patient_from_original_call 			= get_min_call_patient_from_original_call($time_call_patient, $time_booked);
				$min_arrived_patient 							= get_min_arrived_patient($time_arrived_patient, $time_call_patient);
				$min_arrived_patient_from_original_call 		= get_min_arrived_patient_from_original_call($time_arrived_patient, $time_booked);
				$min_spent_patient 								= get_min_spent_patient($time_to_hospital, $time_arrived_patient);
				$min_arrived_hospital 							= get_min_arrived_hospital($time_arrived_hospital, $time_to_hospital);
				$min_spent_trip 								= get_min_spent_trip($time_arrived_hospital, $time_to_patient);
				$min_arrived_hospital_from_original_call 		= get_min_arrived_hospital_from_original_call($time_arrived_hospital, $time_booked);
				$min_spent_hospital 							= get_min_spent_hospital($time_back_hospital, $time_arrived_hospital);
				$min_arrived_back_hospital 						= get_min_arrived_back_hospital($time_complete, $time_complete);
				$min_arrived_back_hospital_from_original_call 	= get_min_arrived_back_hospital_from_original_call($time_complete, $time_booked);
				
				if(!is_null($row->reason_cancel)) {
					$reason = strip_tags($row->reason_cancel);
				}
				else {
					$reason = strip_tags($row->reason_reject);
				}
				
				$list[] = array(
					"type"											=> 1,
					"ambulance"										=> $ambulance,
					"area"											=> $this->load->model('setting/m_area')->get_name_by_id($row->area_id),
					"time_booked"									=> $time_booked,
					"time_confirmed" 								=> $time_confirmed,
					"time_set_order" 								=> $time_set_order,
					"time_set_crew" 								=> $time_set_crew,
					"time_to_patient" 								=> $time_to_patient,
					"time_call_patient" 							=> $time_call_patient,
					"time_arrived_patient" 							=> $time_arrived_patient,
					"time_to_hospital" 								=> $time_to_hospital,
					"time_arrived_hospital" 						=> $time_arrived_hospital,
					"time_back_hospital" 							=> $time_back_hospital,
					"time_complete" 								=> $time_complete,
					"time_cancel" 									=> $time_cancel,
					"time_response"									=> $time_response,
					"min_collect_data"								=> $min_collect_data,
					"min_leave_from_time_notification"				=> $min_leave_from_time_notification,
					"min_leave_from_original_call"					=> $min_leave_from_original_call,
					"min_call_patient_from_original_call"			=> $min_call_patient_from_original_call,
					"min_arrived_patient"							=> $min_arrived_patient,
					"min_arrived_patient_from_original_call"		=> $min_arrived_patient_from_original_call,
					"min_spent_patient"								=> $min_spent_patient,
					"min_arrived_hospital"							=> $min_arrived_hospital,
					"min_spent_trip"								=> $min_spent_trip,
					"min_arrived_hospital_from_original_call"		=> $min_arrived_hospital_from_original_call,
					"min_spent_hospital"							=> $min_spent_hospital,
					"min_arrived_back_hospital"						=> $min_arrived_back_hospital,
					"min_arrived_back_hospital_from_original_call"	=> $min_arrived_back_hospital_from_original_call,
					"id" 											=> $row->emergency_id,
					"code"											=> $row->emergency_callreference,
					"patient"										=> strip_tags($row->emergency_patientname),
					"from"											=> strip_tags($row->emergency_infostreet),
					"to"											=> strip_tags($this->load->model('master/m_hospital')->get_name_by_id($row->hospital_id)),
					"note"											=> strip_tags($row->emergency_patientnote),
					"reason"										=> $reason,
					"status"										=> get_transaction($row->emergency_status),
					"by"											=> $this->load->model('user/m_user')->get_name_by_id($row->last_user)
				);
			}
		}
		
		if(!empty($nonemergency)) {
			foreach($nonemergency as $row) {
				$arr_nul = array(0,2,3);
				if (in_array($row->nonemergency_status, $arr_nul)) {
					$ambulance 	= "-";
				}
				else {
					$ambulance 	= $this->m_ambulance->get_plat_by_id($row->ambulance_id);
				}
				
				$time_booked			= $row->nonemergency_date .' '. $row->nonemergency_time;
				$time_confirmed 		= $row->time_confirmed;
				$time_set_order 		= $row->time_waiting;
				$time_set_crew 			= $row->time_set_crew;
				$time_to_patient 		= $row->time_to_patient;
				$time_call_patient 		= $row->time_call_patient;
				$time_arrived_patient 	= $row->time_arrived_patient;
				$time_to_hospital 		= $row->time_to_hospital;
				$time_arrived_hospital 	= $row->time_arrived_hospital;
				$time_back_hospital 	= $row->time_back_hospital;
				$time_complete 			= $row->time_complete;
				$time_cancel 			= (($row->time_cancel != "")?$row->time_cancel:$row->time_reject);
				
				$time_response 									= get_time_response($time_confirmed, $time_booked);
				$min_collect_data 								= get_min_collect_data($time_set_crew, $time_booked);
				$min_leave_from_time_notification 				= get_min_leave_from_time_notification($time_to_patient, $time_set_crew);
				$min_leave_from_original_call 					= get_min_leave_from_original_call($time_to_patient, $time_booked);
				$min_call_patient_from_original_call 			= get_min_call_patient_from_original_call($time_call_patient, $time_booked);
				$min_arrived_patient 							= get_min_arrived_patient($time_arrived_patient, $time_call_patient);
				$min_arrived_patient_from_original_call 		= get_min_arrived_patient_from_original_call($time_arrived_patient, $time_booked);
				$min_spent_patient 								= get_min_spent_patient($time_to_hospital, $time_arrived_patient);
				$min_arrived_hospital 							= get_min_arrived_hospital($time_arrived_hospital, $time_to_hospital);
				$min_spent_trip 								= get_min_spent_trip($time_arrived_hospital, $time_to_patient);
				$min_arrived_hospital_from_original_call 		= get_min_arrived_hospital_from_original_call($time_arrived_hospital, $time_booked);
				$min_spent_hospital 							= get_min_spent_hospital($time_back_hospital, $time_arrived_hospital);
				$min_arrived_back_hospital 						= get_min_arrived_back_hospital($time_complete, $time_complete);
				$min_arrived_back_hospital_from_original_call 	= get_min_arrived_back_hospital_from_original_call($time_complete, $time_booked);
				
				if(!is_null($row->reason_cancel)) {
					$reason = strip_tags($row->reason_cancel);
				}
				else {
					$reason = strip_tags($row->reason_reject);
				}
				
				$list[] = array(
					"type"											=> 2,
					"ambulance"										=> $ambulance,
					"area"											=> $this->load->model('setting/m_area')->get_name_by_id($row->nonemergency_fromarea),
					"time_booked"									=> $time_booked,
					"time_confirmed" 								=> $time_confirmed,
					"time_set_order" 								=> $time_set_order,
					"time_set_crew" 								=> $time_set_crew,
					"time_to_patient" 								=> $time_to_patient,
					"time_call_patient" 							=> $time_call_patient,
					"time_arrived_patient" 							=> $time_arrived_patient,
					"time_to_hospital" 								=> $time_to_hospital,
					"time_arrived_hospital" 						=> $time_arrived_hospital,
					"time_back_hospital" 							=> $time_back_hospital,
					"time_complete" 								=> $time_complete,
					"time_cancel" 									=> $time_cancel,
					"time_response"									=> $time_response,
					"min_collect_data"								=> $min_collect_data,
					"min_leave_from_time_notification"				=> $min_leave_from_time_notification,
					"min_leave_from_original_call"					=> $min_leave_from_original_call,
					"min_call_patient_from_original_call"			=> $min_call_patient_from_original_call,
					"min_arrived_patient"							=> $min_arrived_patient,
					"min_arrived_patient_from_original_call"		=> $min_arrived_patient_from_original_call,
					"min_spent_patient"								=> $min_spent_patient,
					"min_arrived_hospital"							=> $min_arrived_hospital,
					"min_spent_trip"								=> $min_spent_trip,
					"min_arrived_hospital_from_original_call"		=> $min_arrived_hospital_from_original_call,
					"min_spent_hospital"							=> $min_spent_hospital,
					"min_arrived_back_hospital"						=> $min_arrived_back_hospital,
					"min_arrived_back_hospital_from_original_call"	=> $min_arrived_back_hospital_from_original_call,
					"id" 											=> $row->nonemergency_id,
					"code"											=> $row->nonemergency_callreference,
					"patient"										=> strip_tags($row->nonemergency_infoname),
					"from"											=> strip_tags($this->load->model('master/m_hospital')->get_name_by_id($row->nonemergency_fromhospital)),
					// "to"											=> strip_tags($this->load->model('master/m_hospital')->get_name_by_id($row->nonemergency_tohospital)),
					"to"											=> $row->nonemergency_tosearch,
					"note"											=> strip_tags($row->nonemergency_requestnote),
					"reason"										=> $reason,
					"status"										=> get_transaction($row->nonemergency_status),
					"by"											=> $this->load->model('user/m_user')->get_name_by_id($row->last_user)
				);
			}
		}
		
		$data['list'] = $list;
		
		// set view
		$this->load->view('v_excel',$data);
    }
}