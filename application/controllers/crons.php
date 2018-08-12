<?php 

class Crons extends CI_Controller {

	public function __construct() {
    	parent::__construct();
		
		$this->load->helper('status');
	}

	public function index() {
		// init variabel
		$date  = get_ymd();
		$time1 = get_hi();
		$time1 = $time1 .":00";
		$time2 = date("H:i:s", strtotime('+ 1 minute', strtotime($time1)));
		$time2 = convert_to_hi($time2);
		$time2 = $time2 .":00";
		
		$arr_nonemergency = array();
		$nonemergency_1 = $this->m_global->get_by_triple_id_order('tp_nonemergency', 'nonemergency_status', 1, 'nonemergency_infodate', $date, 'nonemergency_infotime', $time1, 'nonemergency_id', 'ASC');
		foreach($nonemergency_1 as $row) {
			// set status
			$this->m_global->set_status('tp_nonemergency', 'nonemergency_id', $row->nonemergency_id, 'nonemergency_status', 14);
			
			// set array
			$arr_nonemergency[] = array(
				'id' 		=> $row->nonemergency_id,
				'code' 		=> $row->nonemergency_callreference,
				'name' 		=> strip_tags($row->nonemergency_infoname),
				'date' 		=> convert_to_dmy($row->nonemergency_infodate),
				'time' 		=> convert_to_his($row->nonemergency_infotime),
				'member' 	=> $row->member_id
			);
		}

		$nonemergency_2 = $this->m_global->get_by_triple_id_order('tp_nonemergency', 'nonemergency_status', 1, 'nonemergency_infodate', $date, 'nonemergency_infotime', $time2, 'nonemergency_id', 'ASC');
		foreach($nonemergency_2 as $row) {
			// set status
			$this->m_global->set_status('tp_nonemergency', 'nonemergency_id', $row->nonemergency_id, 'nonemergency_status', 14);
			
			// set array
			$arr_nonemergency[] = array(
				'id' 		=> $row->nonemergency_id,
				'code' 		=> $row->nonemergency_callreference,
				'name' 		=> strip_tags($row->nonemergency_infoname),
				'date' 		=> convert_to_dmy($row->nonemergency_infodate),
				'time' 		=> convert_to_his($row->nonemergency_infotime),
				'member' 	=> $row->member_id
			);
		}	

		// send FCM
		$this->load->helper('fcm');
		for($i=0; $i<count($arr_nonemergency); $i++) {
			$device = $this->load->model('member/m_member')->get_device_by_id($arr_nonemergency[$i]['member']);
			if($device != "") {
				$token[] = $device;
				
				$title = "";
				$message = get_notify(14);
				
				// send notif
				send_firebase_datanotification($token, $title, $message, $arr_nonemergency[$i]['id'], NULL, 9, '');
			}
			
			$ambulance_id = $this->load->model('non_emergency/m_nonemergency')->get_ambulance_by_id($arr_nonemergency[$i]['id']);
			$device_ambulance = $this->load->model('master/m_ambulance')->get_device_by_id($ambulance_id);
			
			if($device_ambulance != "") {
				$token_ambulance[] = $device_ambulance;
				
				$title = "";
				$patient_name = $this->load->model('non_emergency/m_nonemergency')->get_patientname_by_id($arr_nonemergency[$i]['id']);
				$message = get_notify(14) ." order from : ". $patient_name;
				
				// send notif
				send_firebase_datanotification($token_ambulance, $title, $message, $arr_nonemergency[$i]['id'], NULL, 99, '');
			}
		}
	}
	
	function send_notification() {
		$this->load->helper('status');
		
		// get from post
		$token 	= $this->input->post('token');
		$status = $this->input->post('status');
		
		if($token == "") {
			$result = "";
		}
		else {
			// load helper
			$this->load->helper('fcm');
			
			// set variabel
			$device_token[] = $token;
			$title 		= "Ambulance Siloam One Health";
			$message 	= get_notify($status);
			
			// send notif
			$result = send_firebase_datanotification($device_token, $title, $message, 999, NULL, 1, ".activity.OrderNonEmergencyActivity");
		}
		 
		// set data
		$data['token']  = $token;
		$data['status']  = $status;
		$data['result'] = $result;
		 
		// set view
		$this->load->view('../v_header');
		$this->load->view('../v_top');
		$this->load->view('main/v_notif', $data);
		$this->load->view('../v_bottom');
		$this->load->view('../v_footer');
	}
	
	function send_fcm() {
		// get from post
		$token = $this->input->post('token');
		if($token == "") {
			$result = "";
		}
		else {
			// load helper
			$this->load->helper('fcm');
			
			// set variabel
			$device_token[] = $token;
			$title = "Ini judul";
			$message = "Ini pesan nya dari Data";
			
			// send notif
			$result = send_firebase_datanotification($device_token, $title, $message, 666, NULL, 50, '.activity.OrderNonEmergencyActivity');
		}
		 
		// set data
		$data['token']  = $token;
		$data['result'] = $result;
		 
		// set view
		$this->load->view('../v_header');
		$this->load->view('../v_top');
		$this->load->view('main/v_notifdata', $data);
		$this->load->view('../v_bottom');
		$this->load->view('../v_footer');   
	}
}