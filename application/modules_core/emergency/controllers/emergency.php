<?php if(!defined('BASEPATH')) exit('Akses langsung tidak di perkenankan');

class Emergency extends CI_Controller {

	public $tabel = 'tp_emergency';
	public $field = 'emergency_id';
	
    public function __construct() {
    	parent::__construct();
		
		if ($this->session->userdata('login') == TRUE) {	
			$this->load->helper('message');
			$this->load->helper('status');
			$this->load->helper('transaction');
			$this->load->helper('api');
			$this->load->helper('fcm');

			$this->load->library('firebaseMessaging');
			
			$this->load->model('m_emergency');
			$this->load->model('setting/m_source');
			$this->load->model('setting/m_forward');
			$this->load->model('setting/m_category');
			$this->load->model('setting/m_subcategory');
			$this->load->model('setting/m_area');
			$this->load->model('setting/m_location');
			$this->load->model('master/m_hospital');
			$this->load->model('master/m_ambulance');
			$this->load->model('master/m_motorbike');
			$this->load->model('master/m_patient');
			
			// set nav active
			$this->session->set_userdata('nav_active', 'emergency');
			
			// set sub active
			$this->session->unset_userdata('sub_active');
		}
		else {
			get_redirecting('login');
		}
	}

	function notif($value='')
	{
		$frb = new FirebaseMessaging();
		$frb->custom_emergency(16);
	}

    function index() {
		// set data
		$data['code'] = generate_code_v2(0);
		
		// reset session default_map
		$this->session->unset_userdata('default_zoom');
		$this->session->unset_userdata('default_map');
		$this->session->unset_userdata('default_report');
		$this->session->unset_userdata('default_ambulance');
		$this->session->unset_userdata('default_lat');
		$this->session->unset_userdata('default_lon');
		$this->session->unset_userdata('default_add');
		$this->session->unset_userdata('default_srh');
		
		// set data
		$arr_hospital = array();
		if($this->session->userdata('user_authority') == 1) { 
			$hospital 	= $this->m_global->get_by_double_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', $this->session->userdata('hospital_id'), 'hospital_id', 'ASC');
			$area_id 	= $this->m_hospital->get_area_by_id($this->session->userdata('hospital_id'));
			$area		= $this->m_global->get_by_id('tm_area', 'area_id', $area_id);
		}
		else {
			$hospital 	= $this->m_global->get_by_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', 'ASC');
			$area 		= $this->m_global->get_by_id_and_order('tm_area', 'area_status', 1, 'area_id', 'ASC');			
		}
		
		foreach($hospital as $row) {
			$arr_hospital[] = $row->hospital_id; 	
		}
			
		if(!empty($arr_hospital)) {
			$data['forward'] = $this->m_global->get_by_status_arr('tm_forward', 'hospital_id', $arr_hospital);
		}
		else {
			$data['forward'] = NULL;
		}
		
		$data['area'] = $area;
		
		// set view
		$this->load->view('../v_header');
		$this->load->view('../v_top');
		$this->load->view('v_emergency', $data);
		$this->load->view('../v_bottom');
		$this->load->view('../v_footer');
    }
    function process_dataa() {        
        $this->session->set_flashdata('notif_node', 3);
        get_redirecting('dashboard');
    }
	function process_data() {
		// cek validate form
		$valid = simple_decrypt($this->input->post('valid'));
		if($valid != 1) {
			get_redirecting('dashboard');
		}
		
		// get from post
		$source				= $this->input->post('source');
		$forward			= $this->input->post('forward');
		$call_name			= $this->input->post('call_name');
		$call_phone			= $this->input->post('call_phone');
		$other_phone		= $this->input->post('other_phone');
		$latitude			= $this->input->post('street_latitude');
		$longitude			= $this->input->post('street_longitude');
		$address			= $this->input->post('street_address');
		$search				= $this->input->post('street_search');
		$area				= $this->input->post('area');
		$location			= $this->input->post('location');
		$other_info			= $this->input->post('other_info');
		$total_patient		= $this->input->post('total_patient');
		$total_unconscious	= $this->input->post('total_unconscious');
		$note				= $this->input->post('note');
		$name_patient		= $this->input->post('patient_name');
		$dob_patient		= $this->input->post('patient_dob');
		$category			= $this->input->post('category');
		$sub_category		= $this->input->post('sub_category');
		$description		= $this->input->post('description');
		$chkAmbulance		= $this->input->post('chkAmbulance');
		$chkMotorbike		= $this->input->post('chkMotorbike');
		$time_start_form	= $this->input->post('time_start_form');
		
		for($i=0; $i<count($description); $i++) {
			if(isset($description[$i]) != "") {
				$desc = $description[$i];
			}	
		}
		
		if($chkAmbulance == "") {
			// set session
			$this->session->set_flashdata('source', $source);
			$this->session->set_flashdata('forward', $forward);
			$this->session->set_flashdata('call_name', $call_name);
			$this->session->set_flashdata('call_phone', $call_phone);
			$this->session->set_flashdata('other_phone', $other_phone);
			$this->session->set_flashdata('other_info', $other_info);
			$this->session->set_flashdata('total_patient', $total_patient);
			$this->session->set_flashdata('total_unconscious', $total_unconscious);
			$this->session->set_flashdata('note', $note);
			$this->session->set_flashdata('name_patient', $name_patient);
			$this->session->set_flashdata('dob_patient', (($dob_patient == "")?NULL:convert_to_dmy($dob_patient)));
			$this->session->set_flashdata('category', $category);
			$this->session->set_flashdata('sub_category', $sub_category);
			$this->session->set_flashdata('description', $description);
			
			$this->session->set_flashdata('message', 'Please select one of the ambulance.');
			$this->session->set_flashdata('status', get_notify_status(2));
			
			get_redirecting('emergency');
		}
		
		// set array
		$data = array(
			'emergency_status'					=> 1,
			'time_confirmed'					=> get_ymdhis(),	
			'emergency_date'					=> get_ymd(),
			'emergency_time'					=> get_his(),
			'emergency_callreference'			=> generate_code_v2(0),
			'emergency_callername'				=> strip_tags($call_name),
			'emergency_callerphone'				=> $call_phone,
			'emergency_callerother'				=> (($other_phone == "")?NULL:$other_phone),
			'emergency_infolatitude'			=> (($latitude == "")?NULL:$latitude),
			'emergency_infolongitude'			=> (($longitude == "")?NULL:$longitude),
			'emergency_infostreet'				=> (($address == "")?NULL:nl2br($address)),
			'emergency_infosearch'				=> (($search == "")?NULL:$search),
			'emergency_infootherinformation'	=> (($other_info == "")?NULL:nl2br($other_info)),
			'emergency_patientname'				=> (($name_patient == "")?NULL:$name_patient),
			'emergency_patientdob'				=> (($dob_patient == "")?NULL:convert_to_ymd($dob_patient)),
			'emergency_patienttotal'			=> $total_patient,
			'emergency_patientunconscious'		=> $total_unconscious,
			'emergency_patientnote'				=> (($note == "")?NULL:nl2br($note)),
			'source_id'							=> $source,
			'forward_id'						=> $forward,
			'hospital_id'						=> $this->m_forward->get_hospital_by_id($forward),
			'area_id'							=> $area,
			'location_id'						=> $location,
			'ambulance_id'						=> $chkAmbulance,
			'motorbike_id'						=> (($chkMotorbike == "")?NULL:$chkMotorbike),
			'category_id'						=> $category,
			'subcategory_id'					=> $sub_category,
			'case_note'							=> (($desc == "")?NULL:$desc),
			'last_user'							=> $this->session->userdata('user_id'),
			'time_start_form'					=> $time_start_form
		);
		
		// cek result
		$result = $this->m_crud->insert_id($this->tabel, $data);
		if($result == 0) {
			$this->session->set_flashdata('message', get_notification('insert', 0));
			$this->session->set_flashdata('status', get_notify_status(0));
		}
		else {
			// check patient
			$data_patient = array(
				'patient_phone'	=> $call_phone,
				'patient_name'	=> (($name_patient == "")?NULL:$name_patient),
				'patient_dob'	=> (($dob_patient == "")?get_ymd():convert_to_ymd($dob_patient)),
				'last_user'		=> $this->session->userdata('user_id')
			);
				
			if($this->m_global->check_existings('tm_patient', 'patient_phone', $call_phone, 'patient_name', $name_patient,  'patient_dob', convert_to_ymd($dob_patient))) {
				$patient_id = $this->m_patient->get_id_by_phone_name_dob($call_phone, $name_patient, convert_to_ymd($dob_patient));	
				$this->m_crud->update('tm_patient', 'patient_id', $data_patient, $patient_id);
			}
			else {
				$this->m_crud->insert('tm_patient', $data_patient);
			}
			
			// set status ambulance
			$this->m_global->set_status('tm_ambulance', 'ambulance_id', $chkAmbulance, 'ambulance_status', 1);
			
			// set distance eta emergency
			$member_id = $this->m_emergency->get_member_by_id($result);
			if($member_id != "") {
				// current location patient
				$from_latitude 	= $latitude;
				$from_longitude = $longitude;
				
				// update distance eta to forward
				$hospital		= $this->m_forward->get_hospital_by_id($forward);
				$to_latitude 	= $this->m_hospital->get_latitude_by_id($hospital);
				$to_longitude 	= $this->m_hospital->get_longitude_by_id($hospital); 
						
				$distance_eta = get_distance_eta($from_latitude, $from_longitude, $to_latitude, $to_longitude);
				update_distance_eta_emergency($result, $distance_eta);	
			}
			
			// send notif ambulance
			$token_ambuulance[] = $this->m_ambulance->get_device_by_id($chkAmbulance);
			$message = "Confirmed emergency order from : ". $name_patient;
			send_firebase_datanotification($token_ambuulance, "", $message, $result, NULL, 90, ''); 
			
			$this->session->set_flashdata('message', get_notification('insert', 1));
			$this->session->set_flashdata('status', get_notify_status(1));
            $this->session->set_flashdata('notif_node', $this->m_forward->get_hospital_by_id($forward));
            $this->load->library('fcm');
        	$dataFcm = array(
			    "id" => $result,
			    "type"=>" Emergency",
			    "hospitalId"=>  $this->m_forward->get_hospital_by_id($forward),
			    "ambulanceId"=> $chkAmbulance,
			    "patientName"=> $name_patient
		    );
		    $this->fcm->sendNotif($chkAmbulance, $dataFcm);
		    $this->session->set_flashdata('update_firebase', $chkAmbulance);
		}

		redirect(base_url('dashboard'));
    }
	
	function edit_data() {
		// get data
		$id = simple_decrypt($this->uri->segment(3));
		
		// cek id
		if($id == "") {
            get_redirecting('dashboard');
        } 
        else {
			// set data
			$data['detail'] = $this->m_global->get_by_id($this->tabel, $this->field, $id);
			
			// cek resut
			if($data['detail'] == null) {
                get_redirecting('error');
            }
			else {
				// cek status
				if($this->m_emergency->get_status_by_id($id) != 0) {
					get_redirecting('dashboard');		
				}	
				
				// set default_map
				$this->session->set_userdata('default_zoom', 14);
				$this->session->set_userdata('default_map', 1);
				
				foreach($data['detail'] as $row) {
					$default_lat = $row->emergency_infolatitude;
					$default_lon = $row->emergency_infolongitude;
					$default_add = $row->emergency_infostreet;
					$default_srh = $row->emergency_infosearch;
				}
				
				if($default_lat == "") { $default_lat = lat_default; }
				if($default_lon == "") { $default_lon = lon_default; }
				
				$this->session->set_userdata('default_lat', $default_lat);
				$this->session->set_userdata('default_lon', $default_lon);
				$this->session->set_userdata('default_add', $default_add);
				$this->session->set_userdata('default_srh', $default_srh);
				
				// set data
				$data['code'] = generate_code(0);
				
				// set data
				$arr_hospital = array();
				if($this->session->userdata('user_authority') == 1) { 
					$hospital 	= $this->m_global->get_by_double_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', $this->session->userdata('hospital_id'), 'hospital_id', 'ASC');
					$area_id 	= $this->m_hospital->get_area_by_id($this->session->userdata('hospital_id'));
					$area		= $this->m_global->get_by_id('tm_area', 'area_id', $area_id);
				}
				else {
					$hospital	= $this->m_global->get_by_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', 'ASC'); 
					$area 		= $this->m_global->get_by_id_and_order('tm_area', 'area_status', 1, 'area_id', 'ASC');
				}
				
				foreach($hospital as $row) {
					$arr_hospital[] = $row->hospital_id; 	
				}
					
				if(!empty($arr_hospital)) {
					$data['forward'] = $this->m_global->get_by_status_arr('tm_forward', 'hospital_id', $arr_hospital);
				}
				else {
					$data['forward'] = NULL;
				}
				
				$data['area'] = $area;
				
				// set view
				$this->load->view('../v_header');
				$this->load->view('../v_top');
				$this->load->view('emergency/v_edit', $data);
				$this->load->view('../v_bottom');
				$this->load->view('../v_footer');
			}
		}
    }
	
	function update_data() {
		// cek validate form
		$valid = simple_decrypt($this->input->post('valid'));
		if($valid != 1) {
			get_redirecting('dashboard');
		}
		
		// get from post
		$id					= simple_decrypt($this->input->post('id'));
		$source				= $this->input->post('source');
		$forward			= $this->input->post('forward');
		$call_name			= $this->input->post('call_name');
		$call_phone			= $this->input->post('call_phone');
		$other_phone		= $this->input->post('other_phone');
		$latitude			= $this->input->post('street_latitude');
		$longitude			= $this->input->post('street_longitude');
		$address			= $this->input->post('street_address');
		$search				= $this->input->post('street_search');
		$area				= $this->input->post('area');
		$location			= $this->input->post('location');
		$other_info			= $this->input->post('other_info');
		$total_patient		= $this->input->post('total_patient');
		$total_unconscious	= $this->input->post('total_unconscious');
		$note				= $this->input->post('note');
		$name_patient		= $this->input->post('patient_name');
		$dob_patient		= $this->input->post('patient_dob');
		$category			= $this->input->post('category');
		$sub_category		= $this->input->post('sub_category');
		$description		= $this->input->post('description');
		$chkAmbulance		= $this->input->post('chkAmbulance');
		$chkMotorbike		= $this->input->post('chkMotorbike');
		
		for($i=0; $i<count($description); $i++) {
			if(isset($description[$i]) != "") {
				$desc = $description[$i];
			}	
		}
		
		if($chkAmbulance == "") {
			$this->session->set_flashdata('message', 'Please select one of the ambulance.');
			$this->session->set_flashdata('status', get_notify_status(2));
			
			get_redirecting('emergency/edit-data/'. simple_encrypt($id));
		}
		
		// cek status
		if($this->m_emergency->get_status_by_id($id) != 0) {
			$this->session->set_flashdata('message', get_notification('update', 0));
			$this->session->set_flashdata('status', get_notify_status(0));
			
			get_redirecting('dashboard');		
		}	
		
		// set array
		$data = array(
			'emergency_status'					=> 1, 
			'emergency_callreference'			=> generate_code(0),
			'time_confirmed'					=> get_ymdhis(),
			'emergency_callername'				=> strip_tags($call_name),
			'emergency_callerphone'				=> $call_phone,
			'emergency_callerother'				=> (($other_phone == "")?NULL:$other_phone),
			'emergency_infolatitude'			=> (($latitude == "")?NULL:$latitude),
			'emergency_infolongitude'			=> (($longitude == "")?NULL:$longitude),
			'emergency_infostreet'				=> (($address == "")?NULL:nl2br($address)),
			'emergency_infosearch'				=> (($search == "")?NULL:$search),
			'emergency_infootherinformation'	=> (($other_info == "")?NULL:nl2br($other_info)),
			'emergency_patientname'				=> (($name_patient == "")?NULL:$name_patient),
			'emergency_patientdob'				=> (($dob_patient == "")?NULL:convert_to_ymd($dob_patient)),
			'emergency_patienttotal'			=> $total_patient,
			'emergency_patientunconscious'		=> $total_unconscious,
			'emergency_patientnote'				=> (($note == "")?NULL:nl2br($note)),
			'source_id'							=> $source,
			'forward_id'						=> $forward,
			'hospital_id'						=> $this->m_forward->get_hospital_by_id($forward),
			'area_id'							=> $area,
			'location_id'						=> $location,
			'ambulance_id'						=> $chkAmbulance,
			'motorbike_id'						=> (($chkMotorbike == "")?NULL:$chkMotorbike),
			'category_id'						=> $category,
			'subcategory_id'					=> $sub_category,
			'case_note'							=> (($desc == "")?NULL:$desc),
			'last_user'							=> $this->session->userdata('user_id')
		);
		
		// cek result
		$result = $this->m_crud->update($this->tabel, $this->field, $data, $id);
		if($result == 0) {
			$this->session->set_flashdata('message', get_notification('update', 0));
			$this->session->set_flashdata('status', get_notify_status(0));
		}
		else {
			// reset session default_map
			$this->session->unset_userdata('default_map');
			$this->session->unset_userdata('default_report');
			$this->session->unset_userdata('default_ambulance');
			$this->session->unset_userdata('default_lat');
			$this->session->unset_userdata('default_lon');
			$this->session->unset_userdata('default_add');
			$this->session->unset_userdata('default_srh');
			
			// check patient
			$data_patient = array(
				'patient_phone'	=> $call_phone,
				'patient_name'	=> (($name_patient == "")?NULL:$name_patient),
				'patient_dob'	=> (($dob_patient == "")?NULL:convert_to_ymd($dob_patient)),
				'last_user'		=> $this->session->userdata('user_id')
			);
				
			if($this->m_global->check_existings('tm_patient', 'patient_phone', $call_phone, 'patient_name', $name_patient,  'patient_dob', convert_to_ymd($dob_patient))) {
				$patient_id = $this->m_patient->get_id_by_phone_name_dob($call_phone, $name_patient, convert_to_ymd($dob_patient));	
				$this->m_crud->update('tm_patient', 'patient_id', $data_patient, $patient_id);
			}
			else {
				$this->m_crud->insert('tm_patient', $data_patient);
			}
			
			// set status ambulance
			$this->m_global->set_status('tm_ambulance', 'ambulance_id', $chkAmbulance, 'ambulance_status', 1);
			
			// set status ambulance
			if($chkMotorbike != "") {
				$this->m_global->set_status('tm_motorbike', 'motorbike_id', $chkMotorbike, 'motorbike_status', 1);
			}
			
			// set distance eta emergency
			$member_id = $this->m_emergency->get_member_by_id($id);
			if($member_id != "") {
				// current location patient
				$from_latitude 	= $latitude;
				$from_longitude = $longitude;
				
				// update distance eta to forward
				$hospital		= $this->m_forward->get_hospital_by_id($forward);
				$to_latitude 	= $this->m_hospital->get_latitude_by_id($hospital);
				$to_longitude 	= $this->m_hospital->get_longitude_by_id($hospital); 
						
				$distance_eta = get_distance_eta($from_latitude, $from_longitude, $to_latitude, $to_longitude);
				update_distance_eta_emergency($id, $distance_eta);	
			}
			
			// send notif ambulance
			$token_ambuulance[] = $this->m_ambulance->get_device_by_id($chkAmbulance);
			$message = "Confirmed emergency order from : ". $name_patient;
			send_firebase_datanotification($token_ambuulance, "", $message, $id, NULL, 90, '');
			
			$this->session->set_flashdata('message', get_notification('update', 1));
			$this->session->set_flashdata('status', get_notify_status(1));
		}

		get_redirecting('dashboard');
    }
	
	function editing_data() {
		// get data
		$id = simple_decrypt($this->uri->segment(3));
		
		// cek id
		if($id == "") {
            get_redirecting('dashboard');
        } 
        else {
			// set data
			$data['detail'] = $this->m_global->get_by_id($this->tabel, $this->field, $id);
			
			// cek resut
			if($data['detail'] == null) {
                get_redirecting('error');
            }
			else {
				// cek status
				if($this->m_emergency->get_status_by_id($id) != 1) {
					get_redirecting('dashboard');		
				}
				
				// set default_map
				$this->session->set_userdata('default_map', 1);
				
				foreach($data['detail'] as $row) {
					$default_lat = $row->emergency_infolatitude;
					$default_lon = $row->emergency_infolongitude;
					$default_add = $row->emergency_infostreet;
					$default_srh = $row->emergency_infosearch;
				}
				
				if($default_lat == "") { $default_lat = lat_default; }
				if($default_lon == "") { $default_lon = lon_default; }
				
				$this->session->set_userdata('default_lat', $default_lat);
				$this->session->set_userdata('default_lon', $default_lon);
				$this->session->set_userdata('default_add', $default_add);
				$this->session->set_userdata('default_srh', $default_srh);
				
				// set data
				$arr_hospital = array();
				if($this->session->userdata('user_authority') == 1) { 
					$hospital 	= $this->m_global->get_by_double_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', $this->session->userdata('hospital_id'), 'hospital_id', 'ASC');
					$area_id 	= $this->m_hospital->get_area_by_id($this->session->userdata('hospital_id'));
					$area		= $this->m_global->get_by_id('tm_area', 'area_id', $area_id);
				}
				else {
					$hospital 	= $this->m_global->get_by_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', 'ASC'); 
					$area 		= $this->m_global->get_by_id_and_order('tm_area', 'area_status', 1, 'area_id', 'ASC');
				}
				
				foreach($hospital as $row) {
					$arr_hospital[] = $row->hospital_id; 	
				}
					
				if(!empty($arr_hospital)) {
					$data['forward'] = $this->m_global->get_by_status_arr('tm_forward', 'hospital_id', $arr_hospital);
				}
				else {
					$data['forward'] = NULL;
				}
				
				$data['area'] = $area;
				
				// set view
				$this->load->view('../v_header');
				$this->load->view('../v_top');
				$this->load->view('emergency/v_editing', $data);
				$this->load->view('../v_bottom');
				$this->load->view('../v_footer');
			}
		}
    }
	
	function updating_data() {
		// cek validate form
		$valid = simple_decrypt($this->input->post('valid'));
		if($valid != 1) {
			get_redirecting('dashboard');
		}
		
		// get from post
		$id					= simple_decrypt($this->input->post('id'));
		$forward			= $this->input->post('forward');
		$call_name			= $this->input->post('call_name');
		$call_phone			= $this->input->post('call_phone');
		$other_phone		= $this->input->post('other_phone');
		$latitude			= $this->input->post('street_latitude');
		$longitude			= $this->input->post('street_longitude');
		$address			= $this->input->post('street_address');
		$search				= $this->input->post('street_search');
		$total_patient		= $this->input->post('total_patient');
		$total_unconscious	= $this->input->post('total_unconscious');
		$note				= $this->input->post('note');
		$name_patient		= $this->input->post('patient_name');
		$dob_patient		= $this->input->post('patient_dob');
		$category			= $this->input->post('category');
		$sub_category		= $this->input->post('sub_category');
		$description		= $this->input->post('description');
		
		for($i=0; $i<count($description); $i++) {
			if(isset($description[$i]) != "") {
				$desc = $description[$i];
			}	
		}
		
		// cek status
		if($this->m_emergency->get_status_by_id($id) != 1) {
			$this->session->set_flashdata('message', get_notification('update', 0));
			$this->session->set_flashdata('status', get_notify_status(0));
			
			get_redirecting('dashboard');		
		}	
		
		// set array
		$data = array(
			'emergency_callername'				=> strip_tags($call_name),
			'emergency_callerphone'				=> $call_phone,
			'emergency_callerother'				=> (($other_phone == "")?NULL:$other_phone),
			'emergency_infolatitude'			=> (($latitude == "")?NULL:$latitude),
			'emergency_infolongitude'			=> (($longitude == "")?NULL:$longitude),
			'emergency_infostreet'				=> (($address == "")?NULL:nl2br($address)),
			'emergency_infosearch'				=> (($search == "")?NULL:$search),
			'emergency_patientname'				=> (($name_patient == "")?NULL:$name_patient),
			'emergency_patientdob'				=> (($dob_patient == "")?NULL:convert_to_ymd($dob_patient)),
			'emergency_patienttotal'			=> $total_patient,
			'emergency_patientunconscious'		=> $total_unconscious,
			'emergency_patientnote'				=> (($note == "")?NULL:nl2br($note)),
			'forward_id'						=> $forward,
			'hospital_id'						=> $this->m_forward->get_hospital_by_id($forward),
			'category_id'						=> $category,
			'subcategory_id'					=> $sub_category,
			'case_note'							=> (($desc == "")?NULL:$desc),
			'last_user'							=> $this->session->userdata('user_id')
		);
		
		// cek result
		$result = $this->m_crud->update($this->tabel, $this->field, $data, $id);
		if($result == 0) {
			$this->session->set_flashdata('message', get_notification('update', 0));
			$this->session->set_flashdata('status', get_notify_status(0));
		}
		else {
			// reset session default_map
			$this->session->unset_userdata('default_map');
			$this->session->unset_userdata('default_report');
			$this->session->unset_userdata('default_ambulance');
			$this->session->unset_userdata('default_lat');
			$this->session->unset_userdata('default_lon');
			$this->session->unset_userdata('default_add');
			$this->session->unset_userdata('default_srh');
			
			// set distance eta emergency
			$member_id = $this->m_emergency->get_member_by_id($id);
			if($member_id != "") {
				// current location patient
				$from_latitude 	= $latitude;
				$from_longitude = $longitude;
				
				// update distance eta to forward
				$hospital		= $this->m_forward->get_hospital_by_id($forward);
				$to_latitude 	= $this->m_hospital->get_latitude_by_id($hospital);
				$to_longitude 	= $this->m_hospital->get_longitude_by_id($hospital); 
						
				$distance_eta = get_distance_eta($from_latitude, $from_longitude, $to_latitude, $to_longitude);
				update_distance_eta_emergency($id, $distance_eta);	
			}
			
			// send notif ambulance
			$token_ambuulance[] = $this->m_ambulance->get_device_by_id($this->m_emergency->get_ambulance_by_id($id));
			$message = "Confirmed emergency order from : ". $name_patient;
			send_firebase_datanotification($token_ambuulance, "", $message, $id, NULL, 90, '');
			
			$this->session->set_flashdata('message', get_notification('update', 1));
			$this->session->set_flashdata('status', get_notify_status(1));
		}

		get_redirecting('dashboard');
    }
	
	function detail_data() {
		// get data
		$id = simple_decrypt($this->uri->segment(3));
		
		// cek id
		if($id == "") {
            get_redirecting('emergency');
        } 
        else {
			// set data
			$data['detail'] = $this->m_global->get_by_id($this->tabel, $this->field, $id);
			
			// cek resut
			if($data['detail'] == null) {
                get_redirecting('error');
            }
			else {
				// cek status
				$status = $this->m_emergency->get_status_by_id($id);
				if($status == 5 || $status == 4 || $status == 6 || $status == 7 || $status == 8 || $status == 11 || $status == 12 || $status == 13) {
					// set default_map
					$this->session->set_userdata('default_zoom', 14);	
					$this->session->set_userdata('default_map', 1);
					$this->session->set_userdata('default_report', 1);
					$status = $this->m_emergency->get_status_by_id($id);
					
					foreach($data['detail'] as $row) {
						if($status == 7) {
							$default_lat = $this->m_hospital->get_latitude_by_id($row->hospital_id);
							$default_lon = $this->m_hospital->get_longitude_by_id($row->hospital_id);
						}
						else if($status == 13) {
							$default_lat = $this->m_hospital->get_latitude_by_id($row->hospital_id);
							$default_lon = $this->m_hospital->get_longitude_by_id($row->hospital_id);
						}
						else if($status == 8) {
							$hospital_back	= $this->m_ambulance->get_hospital_by_id($row->ambulance_id);		
							$default_lat 	= $this->m_hospital->get_latitude_by_id($hospital_back);
							$default_lon 	= $this->m_hospital->get_longitude_by_id($hospital_back); 
						}
						else {
							$default_lat = $row->emergency_infolatitude;
							$default_lon = $row->emergency_infolongitude;
						}
					}
				
					if($default_lat == "") { $default_lat = lat_default; }
					if($default_lon == "") { $default_lon = lon_default; }
					
					$this->session->set_userdata('default_lat', $default_lat);
					$this->session->set_userdata('default_lon', $default_lon);
					
					$arr = array(1,4,5,6,7,8,11,12,13);
					if (in_array($status, $arr)) { 
						$this->session->set_userdata('default_ambulance', 1);
							
						foreach($data['detail'] as $row) {
							if($status == 1) {
								$ambulance_lat = "";
								$ambulance_lon = "";
							}
							else if($status == 5) {
								$ambulance_lat = $this->m_ambulance->get_latitude_by_id($row->ambulance_id);
								$ambulance_lon = $this->m_ambulance->get_longitude_by_id($row->ambulance_id);
							}
							else if($status == 4) {
								$ambulance_lat = $this->m_ambulance->get_latitude_by_id($row->ambulance_id);
								$ambulance_lon = $this->m_ambulance->get_longitude_by_id($row->ambulance_id);
							}
							else if($status == 6) {
								$ambulance_lat = $this->m_ambulance->get_latitude_by_id($row->ambulance_id);
								$ambulance_lon = $this->m_ambulance->get_longitude_by_id($row->ambulance_id);
							}
							else if($status == 11) {
								$ambulance_lat = $this->m_ambulance->get_latitude_by_id($row->ambulance_id);
								$ambulance_lon = $this->m_ambulance->get_longitude_by_id($row->ambulance_id);
							}
							else if($status == 12) {
								$ambulance_lat = $this->m_ambulance->get_latitude_by_id($row->ambulance_id);
								$ambulance_lon = $this->m_ambulance->get_longitude_by_id($row->ambulance_id);
							}
							else if($status == 7) {
								$ambulance_lat = $this->m_ambulance->get_latitude_by_id($row->ambulance_id);
								$ambulance_lon = $this->m_ambulance->get_longitude_by_id($row->ambulance_id);
							}
							else if($status == 13) {
								$ambulance_lat = $this->m_ambulance->get_latitude_by_id($row->ambulance_id);
								$ambulance_lon = $this->m_ambulance->get_longitude_by_id($row->ambulance_id);
							}
							else if($status == 8) {
								$ambulance_lat = $this->m_ambulance->get_latitude_by_id($row->ambulance_id);
								$ambulance_lon = $this->m_ambulance->get_longitude_by_id($row->ambulance_id);
							}
						
							if($ambulance_lat == "") { $ambulance_lat = $this->m_hospital->get_latitude_by_id($row->hospital_id); }
							if($ambulance_lon == "") { $ambulance_lon = $this->m_hospital->get_longitude_by_id($row->hospital_id); }
						}
						
						$this->session->set_userdata('ambulance_lat', $ambulance_lat);
						$this->session->set_userdata('ambulance_lon', $ambulance_lon);	
					}
					
					// set data
					$arr_hospital = array();
					if($this->session->userdata('user_authority') == 1) { 
						$hospital 	= $this->m_global->get_by_double_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', $this->session->userdata('hospital_id'), 'hospital_id', 'ASC');
						$area_id 	= $this->m_hospital->get_area_by_id($this->session->userdata('hospital_id'));
						$area		= $this->m_global->get_by_id('tm_area', 'area_id', $area_id);
					}
					else {
						$hospital 	= $this->m_global->get_by_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', 'ASC'); 
						$area 		= $this->m_global->get_by_id_and_order('tm_area', 'area_status', 1, 'area_id', 'ASC');
					}
					
					foreach($hospital as $row) {
						$arr_hospital[] = $row->hospital_id; 	
					}
						
					if(!empty($arr_hospital)) {
						$data['forward'] = $this->m_global->get_by_status_arr('tm_forward', 'hospital_id', $arr_hospital);
					}
					else {
						$data['forward'] = NULL;
					}
					
					// set view
					$this->load->view('../v_header');
					$this->load->view('../v_top');
					$this->load->view('emergency/v_detail', $data);
					$this->load->view('../v_bottom');
					$this->load->view('../v_footer');
				}	
				else {
					get_redirecting('dashboard');
				}		
			}
		}
    }
	
	function set_status() {
		// cek validate form
		$valid = simple_decrypt($this->input->post('valid'));
		if($valid != 1) {
			get_redirecting('dashboard');
		}
		
		// get from post
		$id			= simple_decrypt($this->input->post('emergency_status'));
		$time		= $this->input->post('time');
		$status		= $this->input->post('status');
		
		$datetime	= get_ymd() .' '. $time;
		
		// set array
		$kirim_fcm = 0;
		switch($status) {
			// go to patient
			case 6 :
				$data = array(
					'time_to_patient' 	=> $datetime,
					'emergency_status' 	=> $status
				);
				
				$kirim_fcm = 1;
			break;
			// call patient
			case 11 :
				$data = array(
					'time_call_patient' => $datetime,
					'emergency_status' 	=> $status
				);
			break;
			// arrived patient
			case 12 :
				$data = array(
					'time_arrived_patient' 	=> $datetime,
					'emergency_status' 		=> $status
				);
				
				$kirim_fcm = 1;
			break;
			// go to hospital
			case 7 :
				$data = array(
					'time_to_hospital' 	=> $datetime,
					'emergency_status' 	=> $status
				);
				
				$kirim_fcm = 1;
			break;
			// arrived hospital
			case 13 :
				$data = array(
					'time_arrived_hospital' => $datetime,
					'emergency_status' 		=> $status
				);
				
				$kirim_fcm = 1;
			break;
			// back to hospital
			case 8 :
				$data = array(
					'time_back_hospital'	=> $datetime,
					'emergency_status' 		=> $status
				);
			break;
			// complete
			case 9 :
				$data = array(
					'time_complete'		=> $datetime,
					'emergency_status' 	=> $status
				);
				
				// update ambulance
				$data_ambulance = array(
					'ambulance_distance'		 => NULL,
					'ambulance_eta' 			 => NULL,
					'ambulance_distancehospital' => NULL,
					'ambulance_etahospital' 	 => NULL,
					'ambulance_trackdatetime' 	 => NULL,
					'ambulance_tracklatitude' 	 => NULL,
					'ambulance_tracklongitude' 	 => NULL,
					'ambulance_trackrotation' 	 => NULL,
					'ambulance_status' 	 		 => 0,
				);
				
				$ambulance = $this->m_emergency->get_ambulance_by_id($id);
				$this->m_crud->update('tm_ambulance', 'ambulance_id', $data_ambulance, $ambulance);
			break;
		}
		
		// cek result
		$result = $this->m_crud->update($this->tabel, $this->field, $data, $id);
		if($result == 0) {
			$this->session->set_flashdata('message', get_notification('update', 0));
			$this->session->set_flashdata('status', get_notify_status(0));
		}
		else {
			// send FCM
			if($kirim_fcm == 1) {
				$member_id = $this->m_emergency->get_member_by_id($id);
				$device = $this->load->model('member/m_member')->get_device_by_id($member_id);
				if($device != "") {
					$token[] = array();
					$token[] = $device;
					
					$title 		= "";
					$message 	= get_notify($status);
					
					// send notif
					if($status == 13) {
						send_firebase_datanotification($token, $title, $message, $id, NULL, 50, '.activity.FeedbackActivity');
					}
					else {
						send_firebase_datanotification($token, $title, $message, $id, NULL, 0, '.activity.OrderActivity');
					}
				}
			}
				
			$this->session->set_flashdata('message', get_notification('update', 1));
			$this->session->set_flashdata('status', get_notify_status(1));
		}

		get_redirecting('emergency/detail-data/'. simple_encrypt($id));
    }
	
	function set_cancel() {
		// cek validate form
		$valid = simple_decrypt($this->input->post('valid'));
		if($valid != 1) {
			get_redirecting('dashboard');
		}
		
		// get from post
		$id			= simple_decrypt($this->input->post('emergency_cancel'));
		$reason		= $this->input->post('reason');
		
		// cek status
		$status = $this->m_emergency->get_status_by_id($id);
		if($status == 12) {
			$this->session->set_flashdata('message', 'Ambulance is on progress.');
			$this->session->set_flashdata('status', get_notify_status(2));
			
			get_redirecting('dashboard');		
		}	
		
		// set array
		$data = array(
			'emergency_status' 	=> 3,
			'time_reject' 		=> get_ymdhis(),
			'reason_reject' 	=> (($reason == "")?NULL:nl2br($reason)),
			'last_user'			=> $this->session->userdata('user_id')
		);
				
		// cek result
		$result = $this->m_crud->update($this->tabel, $this->field, $data, $id);
		if($result == 0) {
			$this->session->set_flashdata('message', get_notification('update', 0));
			$this->session->set_flashdata('status', get_notify_status(0));
		}
		else {
			// update ambulance
			$data_ambulance = array(
				'ambulance_distance'		 => "",
				'ambulance_eta' 			 => "",
				'ambulance_distancehospital' => "",
				'ambulance_etahospital' 	 => "",
				'ambulance_status' 	 		 => 0,
			);
			
			$ambulance = $this->m_emergency->get_ambulance_by_id($id);
			$this->m_crud->update('tm_ambulance', 'ambulance_id', $data_ambulance, $ambulance);
			
			// send FCM
			$member_id = $this->m_emergency->get_member_by_id($id);
			if($member_id != 0) {
				$device = $this->load->model('member/m_member')->get_device_by_id($member_id);
				if($device != "") {
					$token[] = array();
					$token[] = $device;
					
					$title 		= "";
					$message 	= get_notify($status);
					
					// send notif
					send_firebase_datanotification($token, $title, $message, $id, NULL, 70, '.activity.OrderActivity');
				}
			}
			
			$this->session->set_flashdata('message', get_notification('update', 1));
			$this->session->set_flashdata('status', get_notify_status(1));
		}

		get_redirecting('dashboard');
    }
	
	function prints() {
		// set data
		echo "Lorem ipsum";
	}
	
	function set_crew() {
		// cek validate form
		$valid = simple_decrypt($this->input->post('valid'));
		if($valid != 1) {
			get_redirecting('dashboard');
		}
		
		// get from post
		$id 	= simple_decrypt($this->input->post('emergency'));
		$driver = $this->input->post('driver');
		$doctor = $this->input->post('doctor');
		$nurse 	= $this->input->post('nurse');
		
		// insert driver
		$data_driver = array();
		if(!empty($driver)) {
			foreach($driver as $row) {
				if($row != "") {
					$data_driver = array(
						'driver_id'		=> $row,
						'emergency_id' 	=> $id
					);
					
					$this->m_crud->insert('td_emergencydriver', $data_driver);
				}
			}
		}
			
		// insert doctor
		$data_doctor= array();
		if(!empty($doctor)) {
			foreach($doctor as $row) {
				if($row != "") {
					$data_doctor = array(
						'doctor_id'		=> $row,
						'emergency_id' 	=> $id
					);
					
					$this->m_crud->insert('td_emergencydoctor', $data_doctor);
				}
			}
		}

		// insert nurse
		$data_nurse = array();
		if(!empty($nurse)) {
			foreach($nurse as $row) {
				if($row != "") {
					$data_nurse = array(
						'nurse_id'		=> $row,
						'emergency_id' 	=> $id
					);
					
					$this->m_crud->insert('td_emergencynurse', $data_nurse);
				}
			}
		}	
				
		$data = array(
			'time_set_crew' 	=> get_ymdhis(),
			'emergency_status' 	=> 4
		);
		
		$result = $this->m_crud->update('tp_emergency', 'emergency_id', $data, $id);
		if($result == 0) {
			$this->session->set_flashdata('message', get_notification('update', 0));
			$this->session->set_flashdata('status', get_notify_status(0));
		}
		else {
			$this->session->set_flashdata('message', get_notification('update', 1));
			$this->session->set_flashdata('status', get_notify_status(1));
		}

		get_redirecting('dashboard');
	}
	
	function accept_data() {
		// get data
		$id = simple_decrypt($this->uri->segment(3));
		
		// cek id
		if($id == "") {
            get_redirecting('dashboard');
        } 
        else {
			// set data
			$data['detail'] = $this->m_global->get_by_id($this->tabel, $this->field, $id);
			
			// cek resut
			if($data['detail'] == null) {
                get_redirecting('error');
            }
			else {
				// cek status
				if($this->m_emergency->get_status_by_id($id) != 1) {
					get_redirecting('dashboard');		
				}	
				
				$data = array(
					'time_waiting' 		=> get_ymdhis(),
					'emergency_status' 	=> 5
				);
				
				$updateData = $this->m_crud->update('tp_emergency', 'emergency_id', $data, $id);
				
				// update ambulance
				$ambulance_id 		= $this->m_emergency->get_ambulance_by_id($id); 
				$hospital_id		= $this->m_emergency->get_hospital_by_id($id); 
				$hospital_latitude 	= $this->m_hospital->get_latitude_by_id($hospital_id);
				$hospital_longitude = $this->m_hospital->get_longitude_by_id($hospital_id); 
				
				$data_ambulance = array(
					'ambulance_tracklatitude' 	=> $hospital_latitude,
					'ambulance_tracklongitude' 	=> $hospital_longitude,
					'ambulance_trackrotation' 	=> 0,
					'ambulance_trackdatetime' 	=> get_ymdhis()
				);
				
				$this->m_crud->update('tm_ambulance', 'ambulance_id', $data_ambulance, $ambulance_id);
				
				// current location ambulance
				$from_latitude 	= $hospital_latitude;
				$from_longitude = $hospital_longitude;
				
				// update distance eta to patient
				$to_latitude 	= $this->m_emergency->get_infolatitude_by_id($id);
				$to_longitude 	= $this->m_emergency->get_infolongitude_by_id($id); 
				
				$distance_eta = get_distance_eta($from_latitude, $from_longitude, $to_latitude, $to_longitude);
				update_distance_eta_ambulance($ambulance_id, $distance_eta);
				
				// update distance eta to forward
				$hospital_forward_latitude 	= $hospital_latitude;
				$hospital_forward_longitude = $hospital_longitude; 
				
				$distance_forward = get_distance_eta($to_latitude, $to_longitude, $hospital_forward_latitude, $hospital_forward_longitude);
				
				// update distance eta to hospital
				$hospital_back				= $this->m_ambulance->get_hospital_by_id($ambulance_id);		
				$hospital_back_latitude 	= $this->m_hospital->get_latitude_by_id($hospital_back);
				$hospital_back_longitude 	= $this->m_hospital->get_longitude_by_id($hospital_back); 
				
				$distance_back = get_distance_eta($hospital_forward_latitude, $hospital_forward_longitude, $hospital_back_latitude, $hospital_back_longitude);
				update_distance_eta_hospital_ambulance($ambulance_id, $distance_eta, $distance_forward, $distance_back);
				
				// send FCM
				$member_id = $this->m_emergency->get_member_by_id($id);
				$device = $this->load->model('member/m_member')->get_device_by_id($member_id);
				if($device != "") {
					$token[] = array();
					$token[] = $device;
					
					$title 		= "";
					$message 	= get_notify(5);
					
					// send notif
					send_firebase_datanotification($token, $title, $message, $id, NULL, 0, '.activity.OrderActivity');
				}
			}
		}
		
		get_redirecting('dashboard');
    }
	
	function set_data() {
		// cek validate form
		$valid = simple_decrypt($this->input->post('valid'));
		if($valid != 1) {
			get_redirecting('dashboard');
		}
		
		// get from post
		$id		 = simple_decrypt($this->input->post('id'));
		$forward = $this->input->post('forward');
		$note	 = $this->input->post('note');
		
		$hospital_id = $this->m_forward->get_hospital_by_id($forward);
		
		// set array
		$data = array(
			'forward_id'			=> $forward,
			'hospital_id'			=> $hospital_id,
			'emergency_patientnote'	=> (($note == "")?NULL:nl2br($note)),
			'last_user'				=> $this->session->userdata('user_id')
		);
		
		// cek result
		$result = $this->m_crud->update($this->tabel, $this->field, $data, $id);
		if($result == 0) {
			$this->session->set_flashdata('message', get_notification('update', 0));
			$this->session->set_flashdata('status', get_notify_status(0));
		}
		else {
			// update ambulance
			$ambulance_id 		= $this->m_emergency->get_ambulance_by_id($id); 
			$hospital_latitude 	= $this->m_hospital->get_latitude_by_id($hospital_id);
			$hospital_longitude = $this->m_hospital->get_longitude_by_id($hospital_id); 
			
			$data_ambulance = array(
				'ambulance_tracklatitude' 	=> $hospital_latitude,
				'ambulance_tracklongitude' 	=> $hospital_longitude,
				'ambulance_trackrotation' 	=> 0,
				'ambulance_trackdatetime' 	=> get_ymdhis()
			);
			
			$this->m_crud->update('tm_ambulance', 'ambulance_id', $data_ambulance, $ambulance_id);
			
			// current location ambulance
			$from_latitude 	= $hospital_latitude;
			$from_longitude = $hospital_longitude;
			
			// update distance eta to patient
			$to_latitude 	= $this->m_emergency->get_infolatitude_by_id($id);
			$to_longitude 	= $this->m_emergency->get_infolongitude_by_id($id); 
			
			$distance_eta = get_distance_eta($from_latitude, $from_longitude, $to_latitude, $to_longitude);
			update_distance_eta_ambulance($ambulance_id, $distance_eta);
			
			// update distance eta to forward
			$hospital_forward_latitude 	= $hospital_latitude;
			$hospital_forward_longitude = $hospital_longitude; 
			
			$distance_forward = get_distance_eta($to_latitude, $to_longitude, $hospital_forward_latitude, $hospital_forward_longitude);
			
			// update distance eta to hospital
			$hospital_back				= $this->m_ambulance->get_hospital_by_id($ambulance_id);		
			$hospital_back_latitude 	= $this->m_hospital->get_latitude_by_id($hospital_back);
			$hospital_back_longitude 	= $this->m_hospital->get_longitude_by_id($hospital_back); 
			
			$distance_back = get_distance_eta($hospital_forward_latitude, $hospital_forward_longitude, $hospital_back_latitude, $hospital_back_longitude);
			update_distance_eta_hospital_ambulance($ambulance_id, $distance_eta, $distance_forward, $distance_back);
				
			$this->session->set_flashdata('message', get_notification('update', 1));
			$this->session->set_flashdata('status', get_notify_status(1));
		}

		get_redirecting('emergency/detail-data/'. simple_encrypt($id));
    }
}