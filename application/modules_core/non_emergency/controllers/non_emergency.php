<?php if(!defined('BASEPATH')) exit('Akses langsung tidak di perkenankan');

class Non_emergency extends CI_Controller {

	public $tabel = 'tp_nonemergency';
	public $field = 'nonemergency_id';
	
    public function __construct() {
    	parent::__construct();
		
		if ($this->session->userdata('login') == TRUE) {	
			$this->load->helper('message');
			$this->load->helper('status');
			$this->load->helper('transaction');
			$this->load->helper('api');
			$this->load->helper('fcm');
			
			$this->load->model('m_nonemergency');
			$this->load->model('setting/m_transfer');
			$this->load->model('setting/m_callcenter');
			$this->load->model('setting/m_internalcall');
			$this->load->model('setting/m_category');
			$this->load->model('setting/m_subcategory');
			$this->load->model('setting/m_unit');
			$this->load->model('setting/m_area');
			$this->load->model('setting/m_location');
			$this->load->model('master/m_hospital');
			$this->load->model('master/m_ambulance');
			$this->load->model('master/m_motorbike');
			
			// set nav active
			$this->session->set_userdata('nav_active', 'non_emergency');
			
			// set sub active
			$this->session->unset_userdata('sub_active');
		}
		else {
			get_redirecting('login');
		}
	}

    function index() {
		// set data
		$data['code'] = generate_code_v2(1);
				
		// reset session default_map
		$this->session->unset_userdata('default_zoom');
		
		$this->session->unset_userdata('default_map');
		$this->session->unset_userdata('default_report');
		$this->session->unset_userdata('default_lat');
		$this->session->unset_userdata('default_lon');
		$this->session->unset_userdata('default_add');
		$this->session->unset_userdata('default_srh');
			
		$this->session->unset_userdata('default_map2');
		$this->session->unset_userdata('default_report2');
		$this->session->unset_userdata('default_lat2');
		$this->session->unset_userdata('default_lon2');
		$this->session->unset_userdata('default_add2');
		$this->session->unset_userdata('default_srh2');
		
		// set data
		if($this->session->userdata('user_authority') == 1) { 
			$data['hospital'] 	= $this->m_global->get_by_double_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', $this->session->userdata('hospital_id'), 'hospital_id', 'ASC');
			$area_id 			= $this->m_hospital->get_area_by_id($this->session->userdata('hospital_id'));
			$area				= $this->m_global->get_by_id('tm_area', 'area_id', $area_id);
		}
		else {
			$data['hospital'] 	= $this->m_global->get_by_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', 'ASC'); 
			$area 				= $this->m_global->get_by_id_and_order('tm_area', 'area_status', 1, 'area_id', 'ASC');		
		}
		
		$data['area'] = $area;
		
		// set view
		$this->load->view('../v_header');
		$this->load->view('../v_top');
		$this->load->view('v_nonemergency', $data);
		$this->load->view('../v_bottom');
		$this->load->view('../v_footer');
    }
	
	function process_data() {
		// cek validate form
		$valid = simple_decrypt($this->input->post('valid'));
		if($valid != 1) {
			get_redirecting('non-emergency');
		}
		
		// get from post
		$callcenter			= $this->input->post('callcenter');
		$internalcall		= $this->input->post('internalcall');
		$patient_name		= $this->input->post('patient_name');
		$phone_no			= $this->input->post('phone_no');
		$date				= $this->input->post('date');
		$time				= $this->input->post('time');
		$diagnosis			= $this->input->post('diagnosis');
		$consultant			= $this->input->post('consultant');
		$reason				= $this->input->post('reason');
		$transfer			= $this->input->post('transfer');
		$name_request		= $this->input->post('name_request');
		$department_request	= $this->input->post('department_request');
		$title_request		= $this->input->post('title_request');
		$note				= $this->input->post('note');
		$from_radio			= $this->input->post('from_radio');	
		$from_hospital		= $this->input->post('from_hospital');
		$from_unit			= $this->input->post('from_unit');
		$from_bed			= $this->input->post('from_bed');
		$from_latitude		= $this->input->post('street_latitude');
		$from_longitude		= $this->input->post('street_longitude');
		$from_address		= $this->input->post('street_address');
		$from_search		= $this->input->post('street_search');
		$from_area			= $this->input->post('from_area');
		$from_location		= $this->input->post('from_location');
		$to_radio			= $this->input->post('to_radio');	
		$to_hospital		= $this->input->post('to_hospital');
		$to_unit			= $this->input->post('to_unit');
		$to_bed				= $this->input->post('to_bed');
		$to_latitude		= $this->input->post('street_latitude2');
		$to_longitude		= $this->input->post('street_longitude2');
		$to_address			= $this->input->post('street_address2');
		$to_search			= $this->input->post('street_search2');
		$to_area			= $this->input->post('to_area');
		$to_location		= $this->input->post('to_location');
		$category			= $this->input->post('category');
		$sub_category		= $this->input->post('sub_category');
		$sub_category_case	= $this->input->post('sub_category_case');
		$description		= $this->input->post('description');
		$chkAmbulance		= $this->input->post('chkAmbulance');
		$chkMotorbike		= $this->input->post('chkMotorbike');
		$sub_category_case	= $this->input->post('sub_category_case');
		$time_start_form	= $this->input->post('time_start_form');
		
		for($i=0; $i<count($description); $i++) {
			if(isset($description[$i]) != "") {
				$desc = $description[$i];
			}	
		}
		
		if($from_radio == 1) {
			$from_unit 		= NULL;
			$from_bed 		= NULL;
			
			if($from_search == "") {
				$field_require = 0;
				$field_message = "Please select input external location";
			}
			else {
				$field_require = 1;
			}
		}
		else {
			$from_latitude  = $this->m_hospital->get_latitude_by_id($from_hospital);
			$from_longitude = $this->m_hospital->get_longitude_by_id($from_hospital);
						
			$from_address	= $this->m_hospital->get_address_by_id($from_hospital);
			$from_search	= $from_address;
			
			if($from_unit == "") {
				$field_require = 0;
				$field_message = "Please select pick up from internal location";
			}
			else {
				$field_require = 1;
			}
		}
		
		if($to_radio == 1) {
			$to_unit 		= NULL;
			$to_bed 		= NULL;
			
			if($to_search == "") {
				$field_require = 0;
				$field_message = "Please select input external location";
			}
			else {
				$field_require = 1;
			}
		}
		else {
			$to_latitude  = $this->m_hospital->get_latitude_by_id($to_hospital);
			$to_longitude = $this->m_hospital->get_longitude_by_id($to_hospital);
			
			$to_address		= $this->m_hospital->get_address_by_id($to_hospital);
			$to_search		= $to_address;
			$to_area		= NULL;
			$to_location	= NULL;
			
			if($to_unit == "") {
				$field_require = 0;
				$field_message = "Please select destination internal location";
			}
			else {
				$field_require = 1;
			}
		}
		
		// set session
		$this->session->set_flashdata('callcenter', $callcenter);
		$this->session->set_flashdata('internalcall', $internalcall);
		$this->session->set_flashdata('patient_name', $patient_name);
		$this->session->set_flashdata('phone_no', $phone_no);
		$this->session->set_flashdata('date', (($date == "")?NULL:convert_to_dmy($date)));
		$this->session->set_flashdata('time', (($time == "")?NULL:convert_to_his($time)));
		$this->session->set_flashdata('diagnosis', $diagnosis);
		$this->session->set_flashdata('consultant', $consultant);
		$this->session->set_flashdata('reason', $reason);
		$this->session->set_flashdata('transfer', $transfer);
		$this->session->set_flashdata('name_request', $name_request);
		$this->session->set_flashdata('department_request', $department_request);
		$this->session->set_flashdata('title_request', $title_request);
		$this->session->set_flashdata('note', $note);
		$this->session->set_flashdata('from_radio', $from_radio);
		$this->session->set_flashdata('from_hospital', $from_hospital);
		$this->session->set_flashdata('from_unit', $from_unit);
		$this->session->set_flashdata('from_bed', $from_bed);
		$this->session->set_flashdata('to_radio', $to_radio);
		$this->session->set_flashdata('to_hospital', $to_hospital);
		$this->session->set_flashdata('to_unit', $to_unit);
		$this->session->set_flashdata('to_bed', $to_bed);
		$this->session->set_flashdata('category', $category);
		$this->session->set_flashdata('sub_category', $sub_category);
		$this->session->set_flashdata('sub_category_case', $sub_category_case);
		$this->session->set_flashdata('description', $description);
		
		if($chkAmbulance == "") {
			$this->session->set_flashdata('message', 'Please select one of the ambulance.');
			$this->session->set_flashdata('status', get_notify_status(2));
			
			get_redirecting('non-emergency');
		}
		else {
			if($field_require == 0) {
				$this->session->set_flashdata('message', $field_message);
				$this->session->set_flashdata('status', get_notify_status(2));
				
				get_redirecting('non-emergency');
			}
		}
		
		// set array
		$data = array(
			'nonemergency_status'				=> 1, 
			'nonemergency_callreference'		=> generate_code_v2(1),
			'time_confirmed'					=> get_ymdhis(),			
			'nonemergency_date'					=> get_ymd(),
			'nonemergency_time'					=> get_his(),
			'nonemergency_infoname'				=> strip_tags($patient_name),
			'nonemergency_infophone'			=> $phone_no,
			'nonemergency_infodate'				=> (($date == "")?NULL:convert_to_ymd($date)),
			'nonemergency_infotime'				=> (($time == "")?NULL:convert_to_hi($time).":00"),
			'nonemergency_infodiagnosis'		=> (($diagnosis == "")?NULL:$diagnosis),
			'nonemergency_infoconsultant'		=> (($consultant == "")?NULL:$consultant),
			'nonemergency_inforeason'			=> (($reason == "")?NULL:$reason),
			'transfer_id'						=> (($transfer == "")?NULL:$transfer),
			'nonemergency_requestname'			=> $name_request,
			'nonemergency_requestdepartment'	=> (($department_request == "")?NULL:$department_request),
			'nonemergency_requesttittle'		=> (($title_request == "")?NULL:$title_request),
			'nonemergency_requestnote'			=> (($note == "")?NULL:nl2br($note)),
			'callcenter_id'						=> (($callcenter == "")?NULL:$callcenter),
			'internalcall_id'					=> (($internalcall == "")?NULL:$internalcall),
			'nonemergency_from'					=> $from_radio,
			'nonemergency_fromhospital'			=> (($from_hospital == "")?NULL:$from_hospital),
			'nonemergency_fromunit'				=> (($from_unit == "")?NULL:$from_unit),
			'nonemergency_frombed'				=> (($from_bed == "")?NULL:$from_bed),
			'nonemergency_fromlatitude'			=> (($from_latitude == "")?NULL:$from_latitude),
			'nonemergency_fromlongitude'		=> (($from_longitude == "")?NULL:$from_longitude),
			'nonemergency_fromstreet'			=> (($from_address == "")?NULL:nl2br($from_address)),
			'nonemergency_fromsearch'			=> (($from_search == "")?NULL:$from_search),
			'nonemergency_fromarea'				=> $from_area,
			'nonemergency_fromlocation'			=> $from_location,
			'nonemergency_to'					=> $to_radio,
			'nonemergency_tohospital'			=> (($to_hospital == "")?NULL:$to_hospital),
			'nonemergency_tounit'				=> (($to_unit == "")?NULL:$to_unit),
			'nonemergency_tobed'				=> (($to_bed == "")?NULL:$to_bed),
			'nonemergency_tolatitude'			=> (($to_latitude == "")?NULL:$to_latitude),
			'nonemergency_tolongitude'			=> (($to_longitude == "")?NULL:$to_longitude),
			'nonemergency_tostreet'				=> (($to_address == "")?NULL:nl2br($to_address)),
			'nonemergency_tosearch'				=> (($to_search == "")?NULL:$to_search),
			'nonemergency_toarea'				=> (($to_area == "")?NULL:$to_area),
			'nonemergency_tolocation'			=> (($to_location == "")?NULL:$to_location),
			'ambulance_id'						=> $chkAmbulance,
			'motorbike_id'						=> (($chkMotorbike == "")?NULL:$chkMotorbike),
			'category_id'						=> $category,
			'subcategory_id'					=> $sub_category,
			'case_note'							=> (($desc == "")?NULL:$desc),
			'subcategory_case'					=> $sub_category_case,
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
			// set booking ambulance
			$data_booking = array(
				'bookingambulance_date'	=> (($date == "")?NULL:convert_to_ymd($date)),
				'bookingambulance_time'	=> (($time == "")?NULL:convert_to_his($time)),
				'area_id'				=> $from_area,
				'ambulance_id'			=> $chkAmbulance,
				'nonemergency_id'		=> $result
			);
			
			$this->m_crud->insert('tp_bookingambulance', $data_booking);
			
			// send notif ambulance
			$token_ambuulance[] = $this->m_ambulance->get_device_by_id($chkAmbulance);
			$message = "Confirmed non emergency order from : ". $patient_name;
			send_firebase_datanotification($token_ambuulance, "", $message, $result, NULL, 91, '');
			$this->session->set_flashdata('notif_node', $from_hospital);
			$this->session->set_flashdata('message', get_notification('insert', 1));
			$this->session->set_flashdata('status', get_notify_status(1));
		}

		get_redirecting('dashboard');
    }
	
	function edit_data() {
		// get data
		$id = simple_decrypt($this->uri->segment(3));
		
		// cek id
		if($id == "") {
            get_redirecting('non-emergency');
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
				if($this->m_nonemergency->get_status_by_id($id) != 0) {
					get_redirecting('dashboard');		
				}	
				
				// set default_map
				$this->session->set_userdata('default_zoom', 14);
				$this->session->set_userdata('default_map', 1);
				
				foreach($data['detail'] as $row) {
					$default_lat = $row->nonemergency_fromlatitude;
					$default_lon = $row->nonemergency_fromlongitude;
					$default_add = $row->nonemergency_fromstreet;
					$default_srh = $row->nonemergency_fromsearch;
				
					$default_lat2 = $row->nonemergency_tolatitude;
					$default_lon2 = $row->nonemergency_tolongitude;
					$default_add2 = $row->nonemergency_tostreet;
					$default_srh2 = $row->nonemergency_tosearch;
				}
				
				if($default_lat == "") { $default_lat = lat_default; }
				if($default_lon == "") { $default_lon = lon_default; }
				
				$this->session->set_userdata('default_lat', $default_lat);
				$this->session->set_userdata('default_lon', $default_lon);
				$this->session->set_userdata('default_add', $default_add);
				$this->session->set_userdata('default_srh', $default_srh);
				
				$this->session->set_userdata('default_map2', 1);
				
				if($default_lat2 == "") { $default_lat2 = lat_default; }
				if($default_lon2 == "") { $default_lon2 = lon_default; }
				
				$this->session->set_userdata('default_lat2', $default_lat2);
				$this->session->set_userdata('default_lon2', $default_lon2);
				$this->session->set_userdata('default_add2', $default_add2);
				$this->session->set_userdata('default_srh2', $default_srh2);
				
				// set data
				$data['code'] = generate_code(1);
		
				// set data
				if($this->session->userdata('user_authority') == 1) { 
					$data['hospital'] 	= $this->m_global->get_by_double_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', $this->session->userdata('hospital_id'), 'hospital_id', 'ASC');
					$area_id 			= $this->m_hospital->get_area_by_id($this->session->userdata('hospital_id'));
					$area				= $this->m_global->get_by_id('tm_area', 'area_id', $area_id);
				}
				else {
					$data['hospital'] 	= $this->m_global->get_by_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', 'ASC'); 
					$area 				= $this->m_global->get_by_id_and_order('tm_area', 'area_status', 1, 'area_id', 'ASC');		
				}
				
				$data['area'] = $area;
				
				// set view
				$this->load->view('../v_header');
				$this->load->view('../v_top');
				$this->load->view('non_emergency/v_edit', $data);
				$this->load->view('../v_bottom');
				$this->load->view('../v_footer');	
			}
		}
    }
	
	function update_data() {
		// cek validate form
		$valid = simple_decrypt($this->input->post('valid'));
		if($valid != 1) {
			get_redirecting('non-emergency');
		}
		
		// get from post
		$id					= simple_decrypt($this->input->post('id'));
		$callcenter			= $this->input->post('callcenter');
		$internalcall		= $this->input->post('internalcall');
		$patient_name		= $this->input->post('patient_name');
		$phone_no			= $this->input->post('phone_no');
		$date				= $this->input->post('date');
		$time				= $this->input->post('time');
		$diagnosis			= $this->input->post('diagnosis');
		$consultant			= $this->input->post('consultant');
		$reason				= $this->input->post('reason');
		$transfer			= $this->input->post('transfer');
		$name_request		= $this->input->post('name_request');
		$department_request	= $this->input->post('department_request');
		$title_request		= $this->input->post('title_request');
		$note				= $this->input->post('note');
		$from_radio			= $this->input->post('from_radio');	
		$from_hospital		= $this->input->post('from_hospital');
		$from_unit			= $this->input->post('from_unit');
		$from_bed			= $this->input->post('from_bed');
		$from_latitude		= $this->input->post('street_latitude');
		$from_longitude		= $this->input->post('street_longitude');
		$from_address		= $this->input->post('street_address');
		$from_search		= $this->input->post('street_search');
		$from_area			= $this->input->post('from_area');
		$from_location		= $this->input->post('from_location');
		$to_radio			= $this->input->post('to_radio');	
		$to_hospital		= $this->input->post('to_hospital');
		$to_unit			= $this->input->post('to_unit');
		$to_bed				= $this->input->post('to_bed');
		$to_latitude		= $this->input->post('street_latitude2');
		$to_longitude		= $this->input->post('street_longitude2');
		$to_address			= $this->input->post('street_address2');
		$to_search			= $this->input->post('street_search2');
		$to_area			= $this->input->post('to_area');
		$to_location		= $this->input->post('to_location');
		$category			= $this->input->post('category');
		$sub_category		= $this->input->post('sub_category');
		$sub_category_case	= $this->input->post('sub_category_case');
		$description		= $this->input->post('description');
		$chkAmbulance		= $this->input->post('chkAmbulance');
		$chkMotorbike		= $this->input->post('chkMotorbike');
		
		for($i=0; $i<count($description); $i++) {
			if(isset($description[$i]) != "") {
				$desc = $description[$i];
			}	
		}
		
		if($from_radio == 1) {
			$from_unit 		= NULL;
			$from_bed 		= NULL;
			
			if($from_search == "") {
				$field_require = 0;
				$field_message = "Please select input external location";
			}
			else {
				$field_require = 1;
			}
		}
		else {
			$from_latitude  = $this->m_hospital->get_latitude_by_id($from_hospital);
			$from_longitude = $this->m_hospital->get_longitude_by_id($from_hospital);
						
			$from_address	= $this->m_hospital->get_address_by_id($from_hospital);
			$from_search	= $from_address;
			
			if($from_unit == "") {
				$field_require = 0;
				$field_message = "Please select input internal location";
			}
			else {
				$field_require = 1;
			}
		}
		
		if($to_radio == 1) {
			$to_unit 		= NULL;
			$to_bed 		= NULL;
			
			if($to_search == "") {
				$field_require = 0;
				$field_message = "Please select input external location";
			}
			else {
				$field_require = 1;
			}
		}
		else {
			$to_latitude  = $this->m_hospital->get_latitude_by_id($to_hospital);
			$to_longitude = $this->m_hospital->get_longitude_by_id($to_hospital);
			
			$to_address		= $this->m_hospital->get_address_by_id($to_hospital);
			$to_search		= $to_address;
			$to_area		= NULL;
			$to_location	= NULL;
			
			if($to_unit == "") {
				$field_require = 0;
				$field_message = "Please select input internal location";
			}
			else {
				$field_require = 1;
			}
		}
		
		if($chkAmbulance == "") {
			$this->session->set_flashdata('message', 'Please select one of the ambulance.');
			$this->session->set_flashdata('status', get_notify_status(2));
			
			get_redirecting('non-emergency/edit-data/'. simple_encrypt($id));
		}
		else {
			if($field_require == 0) {
				$this->session->set_flashdata('message', $field_message);
				$this->session->set_flashdata('status', get_notify_status(2));
				
				get_redirecting('non-emergency/edit-data/'. simple_encrypt($id));
			}
		}
		
		// set array
		$data = array(
			'nonemergency_status'				=> 1,
			'nonemergency_callreference'		=> generate_code(1),
			'time_confirmed'					=> get_ymdhis(),			
			'nonemergency_infoname'				=> strip_tags($patient_name),
			'nonemergency_infophone'			=> $phone_no,
			'nonemergency_infodate'				=> (($date == "")?NULL:convert_to_ymd($date)),
			'nonemergency_infotime'				=> (($time == "")?NULL:convert_to_hi($time).":00"),
			'nonemergency_infodiagnosis'		=> (($diagnosis == "")?NULL:$diagnosis),
			'nonemergency_infoconsultant'		=> (($consultant == "")?NULL:$consultant),
			'nonemergency_inforeason'			=> (($reason == "")?NULL:$reason),
			'transfer_id'						=> (($transfer == "")?NULL:$transfer),
			'nonemergency_requestname'			=> $name_request,
			'nonemergency_requestdepartment'	=> (($department_request == "")?NULL:$department_request),
			'nonemergency_requesttittle'		=> (($title_request == "")?NULL:$title_request),
			'nonemergency_requestnote'			=> (($note == "")?NULL:nl2br($note)),
			'callcenter_id'						=> (($callcenter == "")?NULL:$callcenter),
			'internalcall_id'					=> (($internalcall == "")?NULL:$internalcall),
			'nonemergency_from'					=> $from_radio,
			'nonemergency_fromhospital'			=> (($from_hospital == "")?NULL:$from_hospital),
			'nonemergency_fromunit'				=> (($from_unit == "")?NULL:$from_unit),
			'nonemergency_frombed'				=> (($from_bed == "")?NULL:$from_bed),
			'nonemergency_fromlatitude'			=> (($from_latitude == "")?NULL:$from_latitude),
			'nonemergency_fromlongitude'		=> (($from_longitude == "")?NULL:$from_longitude),
			'nonemergency_fromstreet'			=> (($from_address == "")?NULL:nl2br($from_address)),
			'nonemergency_fromsearch'			=> (($from_search == "")?NULL:$from_search),
			'nonemergency_fromarea'				=> $from_area,
			'nonemergency_fromlocation'			=> $from_location,
			'nonemergency_to'					=> $to_radio,
			'nonemergency_tohospital'			=> (($to_hospital == "")?NULL:$to_hospital),
			'nonemergency_tounit'				=> (($to_unit == "")?NULL:$to_unit),
			'nonemergency_tobed'				=> (($to_bed == "")?NULL:$to_bed),
			'nonemergency_tolatitude'			=> (($to_latitude == "")?NULL:$to_latitude),
			'nonemergency_tolongitude'			=> (($to_longitude == "")?NULL:$to_longitude),
			'nonemergency_tostreet'				=> (($to_address == "")?NULL:nl2br($to_address)),
			'nonemergency_tosearch'				=> (($to_search == "")?NULL:$to_search),
			'nonemergency_toarea'				=> (($to_area == "")?NULL:$to_area),
			'nonemergency_tolocation'			=> (($to_location == "")?NULL:$to_location),
			'ambulance_id'						=> $chkAmbulance,
			'motorbike_id'						=> (($chkMotorbike == "")?NULL:$chkMotorbike),
			'category_id'						=> $category,
			'subcategory_id'					=> $sub_category,
			'case_note'							=> (($desc == "")?NULL:$desc),
			'subcategory_case'					=> $sub_category_case,
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
			$this->session->unset_userdata('default_lat');
			$this->session->unset_userdata('default_lon');
			$this->session->unset_userdata('default_add');
			$this->session->unset_userdata('default_srh');
			
			$this->session->unset_userdata('default_map2');
			$this->session->unset_userdata('default_report2');
			$this->session->unset_userdata('default_lat2');
			$this->session->unset_userdata('default_lon2');
			$this->session->unset_userdata('default_add2');
			$this->session->unset_userdata('default_srh2');
			
			// set distance eta emergency
			$member_id = $this->m_nonemergency->get_member_by_id($id);
			if($member_id != "") {
				$distance_eta = get_distance_eta($from_latitude, $from_longitude, $to_latitude, $to_longitude);
				update_distance_eta_nonemergency($id, $distance_eta);	
			}
			
			// set booking ambulance
			$data_booking = array(
				'bookingambulance_date'	=> (($date == "")?NULL:convert_to_ymd($date)),
				'bookingambulance_time'	=> (($time == "")?NULL:convert_to_his($time)),
				'area_id'				=> $from_area,
				'ambulance_id'			=> $chkAmbulance,
				'nonemergency_id'		=> $id
			);
			
			$this->m_crud->insert('tp_bookingambulance', $data_booking);
			
			// send notif ambulance
			$token_ambuulance[] = $this->m_ambulance->get_device_by_id($chkAmbulance);
			$message = "Confirmed non emergency order from : ". $patient_name;
			send_firebase_datanotification($token_ambuulance, "", $message, $id, NULL, 91, '');
			
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
				if($this->m_nonemergency->get_status_by_id($id) == 1 || $this->m_nonemergency->get_status_by_id($id) == 14) {
					// set default_map
					$this->session->set_userdata('default_zoom', 14);
					$this->session->set_userdata('default_map', 1);
					
					foreach($data['detail'] as $row) {
						$default_lat = $row->nonemergency_fromlatitude;
						$default_lon = $row->nonemergency_fromlongitude;
						$default_add = $row->nonemergency_fromstreet;
						$default_srh = $row->nonemergency_fromsearch;
					
						$default_lat2 = $row->nonemergency_tolatitude;
						$default_lon2 = $row->nonemergency_tolongitude;
						$default_add2 = $row->nonemergency_tostreet;
						$default_srh2 = $row->nonemergency_tosearch;
					}
					
					if($default_lat == "") { $default_lat = lat_default; }
					if($default_lon == "") { $default_lon = lon_default; }
					
					$this->session->set_userdata('default_lat', $default_lat);
					$this->session->set_userdata('default_lon', $default_lon);
					$this->session->set_userdata('default_add', $default_add);
					$this->session->set_userdata('default_srh', $default_srh);
					
					$this->session->set_userdata('default_map2', 1);
					
					if($default_lat2 == "") { $default_lat2 = lat_default; }
					if($default_lon2 == "") { $default_lon2 = lon_default; }
					
					$this->session->set_userdata('default_lat2', $default_lat2);
					$this->session->set_userdata('default_lon2', $default_lon2);
					$this->session->set_userdata('default_add2', $default_add2);
					$this->session->set_userdata('default_srh2', $default_srh2);
					
					// set data
					if($this->session->userdata('user_authority') == 1) { 
						$data['hospital']	 = $this->m_global->get_by_double_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', $this->session->userdata('hospital_id'), 'hospital_id', 'ASC');
						$area_id 			= $this->m_hospital->get_area_by_id($this->session->userdata('hospital_id'));
						$area				= $this->m_global->get_by_id('tm_area', 'area_id', $area_id);
					}
					else {
						$data['hospital'] 	= $this->m_global->get_by_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', 'ASC'); 
						$area 				= $this->m_global->get_by_id_and_order('tm_area', 'area_status', 1, 'area_id', 'ASC');	
					}
					
					$data['area'] = $area;
					
					// set view
					$this->load->view('../v_header');
					$this->load->view('../v_top');
					$this->load->view('non_emergency/v_editing', $data);
					$this->load->view('../v_bottom');
					$this->load->view('../v_footer');
				}
				else {
					get_redirecting('dashboard');		
				}	
			}	
		}
    }
	
	function updating_data() {
		// cek validate form
		$valid = simple_decrypt($this->input->post('valid'));
		if($valid != 1) {
			get_redirecting('non-emergency');
		}
		
		// get from post
		$id					= simple_decrypt($this->input->post('id'));
		$callcenter			= $this->input->post('callcenter');
		$internalcall		= $this->input->post('internalcall');
		$patient_name		= $this->input->post('patient_name');
		$phone_no			= $this->input->post('phone_no');
		$date				= $this->input->post('date');
		$time				= $this->input->post('time');
		$diagnosis			= $this->input->post('diagnosis');
		$consultant			= $this->input->post('consultant');
		$reason				= $this->input->post('reason');
		$transfer			= $this->input->post('transfer');
		$name_request		= $this->input->post('name_request');
		$department_request	= $this->input->post('department_request');
		$title_request		= $this->input->post('title_request');
		$note				= $this->input->post('note');
		$from_radio			= $this->input->post('from_radio');	
		$from_hospital		= $this->input->post('from_hospital');
		$from_unit			= $this->input->post('from_unit');
		$from_bed			= $this->input->post('from_bed');
		$from_latitude		= $this->input->post('street_latitude');
		$from_longitude		= $this->input->post('street_longitude');
		$from_address		= $this->input->post('street_address');
		$from_search		= $this->input->post('street_search');
		$from_area			= $this->input->post('from_area');
		$from_location		= $this->input->post('from_location');
		$to_radio			= $this->input->post('to_radio');	
		$to_hospital		= $this->input->post('to_hospital');
		$to_unit			= $this->input->post('to_unit');
		$to_bed				= $this->input->post('to_bed');
		$to_latitude		= $this->input->post('street_latitude2');
		$to_longitude		= $this->input->post('street_longitude2');
		$to_address			= $this->input->post('street_address2');
		$to_search			= $this->input->post('street_search2');
		$to_area			= $this->input->post('to_area');
		$to_location		= $this->input->post('to_location');
		$category			= $this->input->post('category');
		$sub_category		= $this->input->post('sub_category');
		$sub_category_case	= $this->input->post('sub_category_case');
		$description		= $this->input->post('description');
		
		for($i=0; $i<count($description); $i++) {
			if(isset($description[$i]) != "") {
				$desc = $description[$i];
			}	
		}
		
		if($from_radio == 1) {
			$from_unit 		= NULL;
			$from_bed 		= NULL;
			
			if($from_search == "") {
				$field_require = 0;
				$field_message = "Please select input external location";
			}
			else {
				$field_require = 1;
			}
		}
		else {
			$from_latitude  = $this->m_hospital->get_latitude_by_id($from_hospital);
			$from_longitude = $this->m_hospital->get_longitude_by_id($from_hospital);
						
			$from_address	= $this->m_hospital->get_address_by_id($from_hospital);
			$from_search	= $from_address;
			
			if($from_unit == "") {
				$field_require = 0;
				$field_message = "Please select input internal location";
			}
			else {
				$field_require = 1;
			}
		}
		
		if($to_radio == 1) {
			$to_unit 		= NULL;
			$to_bed 		= NULL;
			
			if($to_search == "") {
				$field_require = 0;
				$field_message = "Please select input external location";
			}
			else {
				$field_require = 1;
			}
		}
		else {
			$to_latitude  = $this->m_hospital->get_latitude_by_id($to_hospital);
			$to_longitude = $this->m_hospital->get_longitude_by_id($to_hospital);
			
			$to_address		= $this->m_hospital->get_address_by_id($to_hospital);
			$to_search		= $to_address;
			$to_area		= NULL;
			$to_location	= NULL;
			
			if($to_unit == "") {
				$field_require = 0;
				$field_message = "Please select input internal location";
			}
			else {
				$field_require = 1;
			}
		}
		
		if($field_require == 0) {
			$this->session->set_flashdata('message', $field_message);
			$this->session->set_flashdata('status', get_notify_status(2));
				
			get_redirecting('non-emergency/edit-data/'. simple_encrypt($id));
		}
		
		// set array
		$data = array(
			'nonemergency_infoname'				=> strip_tags($patient_name),
			'nonemergency_infophone'			=> $phone_no,
			'nonemergency_infodate'				=> (($date == "")?NULL:convert_to_ymd($date)),
			'nonemergency_infotime'				=> (($time == "")?NULL:convert_to_hi($time).":00"),
			'nonemergency_infodiagnosis'		=> (($diagnosis == "")?NULL:$diagnosis),
			'nonemergency_infoconsultant'		=> (($consultant == "")?NULL:$consultant),
			'nonemergency_inforeason'			=> (($reason == "")?NULL:$reason),
			'transfer_id'						=> (($transfer == "")?NULL:$transfer),
			'nonemergency_requestname'			=> $name_request,
			'nonemergency_requestdepartment'	=> (($department_request == "")?NULL:$department_request),
			'nonemergency_requesttittle'		=> (($title_request == "")?NULL:$title_request),
			'nonemergency_requestnote'			=> (($note == "")?NULL:nl2br($note)),
			'callcenter_id'						=> (($callcenter == "")?NULL:$callcenter),
			'internalcall_id'					=> (($internalcall == "")?NULL:$internalcall),
			'nonemergency_from'					=> $from_radio,
			'nonemergency_fromhospital'			=> (($from_hospital == "")?NULL:$from_hospital),
			'nonemergency_fromunit'				=> (($from_unit == "")?NULL:$from_unit),
			'nonemergency_frombed'				=> (($from_bed == "")?NULL:$from_bed),
			'nonemergency_fromlatitude'			=> (($from_latitude == "")?NULL:$from_latitude),
			'nonemergency_fromlongitude'		=> (($from_longitude == "")?NULL:$from_longitude),
			'nonemergency_fromstreet'			=> (($from_address == "")?NULL:nl2br($from_address)),
			'nonemergency_fromsearch'			=> (($from_search == "")?NULL:$from_search),
			'nonemergency_to'					=> $to_radio,
			'nonemergency_tohospital'			=> (($to_hospital == "")?NULL:$to_hospital),
			'nonemergency_tounit'				=> (($to_unit == "")?NULL:$to_unit),
			'nonemergency_tobed'				=> (($to_bed == "")?NULL:$to_bed),
			'nonemergency_tolatitude'			=> (($to_latitude == "")?NULL:$to_latitude),
			'nonemergency_tolongitude'			=> (($to_longitude == "")?NULL:$to_longitude),
			'nonemergency_tostreet'				=> (($to_address == "")?NULL:nl2br($to_address)),
			'nonemergency_tosearch'				=> (($to_search == "")?NULL:$to_search),
			'nonemergency_toarea'				=> (($to_area == "")?NULL:$to_area),
			'nonemergency_tolocation'			=> (($to_location == "")?NULL:$to_location),
			'category_id'						=> $category,
			'subcategory_id'					=> $sub_category,
			'case_note'							=> (($desc == "")?NULL:$desc),
			'subcategory_case'					=> $sub_category_case,
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
			$this->session->unset_userdata('default_lat');
			$this->session->unset_userdata('default_lon');
			$this->session->unset_userdata('default_add');
			$this->session->unset_userdata('default_srh');
			
			$this->session->unset_userdata('default_map2');
			$this->session->unset_userdata('default_report2');
			$this->session->unset_userdata('default_lat2');
			$this->session->unset_userdata('default_lon2');
			$this->session->unset_userdata('default_add2');
			$this->session->unset_userdata('default_srh2');
			
			// set distance eta emergency
			$member_id = $this->m_nonemergency->get_member_by_id($id);
			if($member_id != "") {
				$distance_eta = get_distance_eta($from_latitude, $from_longitude, $to_latitude, $to_longitude);
				update_distance_eta_nonemergency($id, $distance_eta);	
			}
			
			// send notif ambulance
			$token_ambuulance[] = $this->m_ambulance->get_device_by_id($this->m_nonemergency->get_ambulance_by_id($id));
			$message = "Confirmed non emergency order from : ". $patient_name;
			send_firebase_datanotification($token_ambuulance, "", $message, $id, NULL, 91, '');
			
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
            get_redirecting('non-emergency');
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
				$status = $this->m_nonemergency->get_status_by_id($id);
				if($status == 5 || $status == 4 || $status == 6 || $status == 7 || $status == 8 || $status == 11 || $status == 12 || $status == 13) {
					// set default_map
					$this->session->set_userdata('default_zoom', 14);
					$this->session->set_userdata('default_map', 1);
					$this->session->set_userdata('default_report', 1);
					
					$status = $this->m_nonemergency->get_status_by_id($id);
					foreach($data['detail'] as $row) {
						if($status == 7) {
							$default_lat = $this->m_hospital->get_latitude_by_id($row->nonemergency_tohospital);
							$default_lon = $this->m_hospital->get_longitude_by_id($row->nonemergency_tohospital);
						}
						else if($status == 13) {
							$default_lat = $this->m_hospital->get_latitude_by_id($row->nonemergency_tohospital);
							$default_lon = $this->m_hospital->get_longitude_by_id($row->nonemergency_tohospital);
						}
						else if($status == 8) {
							$hospital_back	= $this->m_ambulance->get_hospital_by_id($row->ambulance_id);		
							$default_lat 	= $this->m_hospital->get_latitude_by_id($hospital_back);
							$default_lon 	= $this->m_hospital->get_longitude_by_id($hospital_back); 
						}
						else {
							$default_lat = $row->nonemergency_fromlatitude;
							$default_lon = $row->nonemergency_fromlongitude;
						}
					}
				
					if($default_lat == "") { $default_lat = lat_default; }
					if($default_lon == "") { $default_lon = lon_default; }
					
					$this->session->set_userdata('default_lat', $default_lat);
					$this->session->set_userdata('default_lon', $default_lon);
					
					$arr = array(5,6,7,8,9,11,12,13);
					if (in_array($status, $arr)) { 
						$this->session->set_userdata('default_ambulance', 1);
							
						foreach($data['detail'] as $row) {
							if($status == 9) {
								$ambulance_lat = "";
								$ambulance_lon = "";
							}
							else if($status == 5) {
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
						
							if($ambulance_lat == "") { $ambulance_lat = $row->nonemergency_tolatitude; }
							if($ambulance_lon == "") { $ambulance_lon = $row->nonemergency_tolongitude; }
						}
						
						$this->session->set_userdata('ambulance_lat', $ambulance_lat);
						$this->session->set_userdata('ambulance_lon', $ambulance_lon);	
					}
					else {
						foreach($data['detail'] as $row) {
							$default_lat2 = $row->nonemergency_tolatitude;
							$default_lon2 = $row->nonemergency_tolongitude;
						}
						
						$this->session->set_userdata('default_map2', 1);
						$this->session->set_userdata('default_report2', 1);
						
						if($default_lat2 == "") { $default_lat2 = lat_default; }
						if($default_lon2 == "") { $default_lon2 = lon_default; }
						
						$this->session->set_userdata('default_lat2', $default_lat2);
						$this->session->set_userdata('default_lon2', $default_lon2);
					}
					
					// set view
					$this->load->view('../v_header');
					$this->load->view('../v_top');
					$this->load->view('non_emergency/v_detail', $data);
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
		$id			= simple_decrypt($this->input->post('nonemergency_status'));
		$date		= $this->input->post('date');
		$time		= $this->input->post('time');
		$status		= $this->input->post('status');
		
		$datetime	= convert_to_ymd($date) .' '. $time;
		
		// set array
		$kirim_fcm = 0;
		switch($status) {
			// go to patient
			case 6 :
				$data = array(
					'time_to_patient' 		=> $datetime,
					'nonemergency_status' 	=> $status
				);
				
				$kirim_fcm = 1;
			break;
			// call patient
			case 11 :
				$data = array(
					'time_call_patient' 	=> $datetime,
					'nonemergency_status' 	=> $status
				);
			break;
			// arrived patient
			case 12 :
				$data = array(
					'time_arrived_patient' 	=> $datetime,
					'nonemergency_status' 	=> $status
				);
				
				$kirim_fcm = 1;
			break;
			// go to hospital
			case 7 :
				$data = array(
					'time_to_hospital' 		=> $datetime,
					'nonemergency_status' 	=> $status
				);
				
				$kirim_fcm = 1;
			break;
			// arrived hospital
			case 13 :
				$data = array(
					'time_arrived_hospital' => $datetime,
					'nonemergency_status' 	=> $status
				);
				
				$kirim_fcm = 1;
			break;
			// back to hospital
			case 8 :
				$data = array(
					'time_back_hospital'	=> $datetime,
					'nonemergency_status' 	=> $status
				);
			break;
			// complete
			case 9 :
				$data = array(
					'time_complete'			=> $datetime,
					'nonemergency_status' 	=> $status
				);
				
				// update ambulance
				$data_ambulance = array(
					'ambulance_distance'		 => "",
					'ambulance_eta' 			 => "",
					'ambulance_distancehospital' => "",
					'ambulance_etahospital' 	 => "",
					'ambulance_status' 			 => 0,
				);
				
				$ambulance = $this->m_nonemergency->get_ambulance_by_id($id);
				$this->m_crud->update('tm_ambulance', 'ambulance_id', $data_ambulance, $ambulance);
			
				// reset booking
				$this->m_global->set_status('tp_bookingambulance', 'nonemergency_id', $id, 'bookingambulance_status', 0);
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
				$member_id = $this->m_nonemergency->get_member_by_id($id);
				$device = $this->load->model('member/m_member')->get_device_by_id($member_id);
				if($device != "") {
					$token[] = array();
					$token[] = $device;
					
					$title 		= "";
					$message 	= get_notify($status);
					
					// send notif
					if($status == 13) {
						send_firebase_datanotification($token, $title, $message, $id, NULL, 51, '.activity.FeedbackActivity');
					}
					else {
						send_firebase_datanotification($token, $title, $message, $id, NULL, 1, '.activity.OrderNonEmergencyActivity');
					}
				}
			}
		
			$this->session->set_flashdata('message', get_notification('update', 1));
			$this->session->set_flashdata('status', get_notify_status(1));
		}

		get_redirecting('non-emergency/detail-data/'. simple_encrypt($id));
    }
	
	function set_cancel() {
		// cek validate form
		$valid = simple_decrypt($this->input->post('valid'));
		if($valid != 1) {
			get_redirecting('dashboard');
		}
		
		// get from post
		$id			= simple_decrypt($this->input->post('nonemergency_cancel'));
		$reason		= $this->input->post('reason');
		
		// cek status
		$status = $this->m_nonemergency->get_status_by_id($id);
		if($status == 12) {
			$this->session->set_flashdata('message', 'Ambulance is on progress.');
			$this->session->set_flashdata('status', get_notify_status(2));
			
			get_redirecting('dashboard');		
		}	
		
		// set array
		$data = array(
			'nonemergency_status' 	=> 3,
			'ambulance_id' 			=> NULL,
			'time_reject' 			=> get_ymdhis(),
			'reason_reject' 		=> (($reason == "")?NULL:nl2br($reason)),
			'last_user'				=> $this->session->userdata('user_id')
		);
				
		// cek result
		$result = $this->m_crud->update($this->tabel, $this->field, $data, $id);
		if($result == 0) {
			$this->session->set_flashdata('message', get_notification('update', 0));
			$this->session->set_flashdata('status', get_notify_status(0));
		}
		else {
			// reset booking
			$this->m_global->set_status('tp_bookingambulance', 'nonemergency_id', $id, 'bookingambulance_status', 0);
			
			// send FCM
			$member_id = $this->m_nonemergency->get_member_by_id($id);
			if($member_id != 0) {
				$device = $this->load->model('member/m_member')->get_device_by_id($member_id);
				if($device != "") {
					$token[] = array();
					$token[] = $device;
					
					$title 		= "";
					$message 	= get_notify($status);
					
					// send notif
					send_firebase_datanotification($token, $title, $message, $id, NULL, 71, '.activity.OrderNonEmergencyActivity');
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
		$id 	= simple_decrypt($this->input->post('nonemergency'));
		$driver = $this->input->post('driver');
		$doctor = $this->input->post('doctor');
		$nurse 	= $this->input->post('nurse');
		
		// insert driver
		$data_driver = array();
		if(!empty($driver)) {
			foreach($driver as $row) {
				if($row != "") {
					$data_driver = array(
						'driver_id'			=> $row,
						'nonemergency_id' 	=> $id
					);
					
					$this->m_crud->insert('td_nonemergencydriver', $data_driver);
				}
			}
		}
			
		// insert doctor
		$data_doctor= array();
		if(!empty($doctor)) {
			foreach($doctor as $row) {
				if($row != "") {
					$data_doctor = array(
						'doctor_id'			=> $row,
						'nonemergency_id' 	=> $id
					);
					
					$this->m_crud->insert('td_nonemergencydoctor', $data_doctor);
				}
			}
		}

		// insert nurse
		$data_nurse = array();
		if(!empty($nurse)) {
			foreach($nurse as $row) {
				if($row != "") {
					$data_nurse = array(
						'nurse_id'			=> $row,
						'nonemergency_id' 	=> $id
					);
					
					$this->m_crud->insert('td_nonemergencynurse', $data_nurse);
				}
			}
		}	
				
		$data = array(
			'time_set_crew' 		=> get_ymdhis(),
			'nonemergency_status' 	=> 4
		);
		
		$result = $this->m_crud->update('tp_nonemergency', 'nonemergency_id', $data, $id);
		if($result == 0) {
			$this->session->set_flashdata('message', get_notification('update', 0));
			$this->session->set_flashdata('status', get_notify_status(0));
		}
		else {
			// set status ambulance
			$ambulance_id = $this->m_nonemergency->get_ambulance_by_id($id);	
			$this->m_global->set_status('tm_ambulance', 'ambulance_id', $ambulance_id, 'ambulance_status', 1);
			
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
				if($this->m_nonemergency->get_status_by_id($id) == 1 || $this->m_nonemergency->get_status_by_id($id) == 14) {
						$data = array(
						'time_waiting' 			=> get_ymdhis(),
						'nonemergency_status' 	=> 5
					);
					
					$updateData = $this->m_crud->update('tp_nonemergency', 'nonemergency_id', $data, $id);
					
					// update ambulance
					$ambulance_id 		= $this->m_nonemergency->get_ambulance_by_id($id); 
					$hospital_id		= $this->m_nonemergency->get_fromhospital_by_id($id); 
					$hospital_latitude 	= $this->m_hospital->get_latitude_by_id($hospital_id);
					$hospital_longitude = $this->m_hospital->get_longitude_by_id($hospital_id); 
					
					$data_ambulance = array(
						'ambulance_tracklatitude' 	=> $hospital_latitude,
						'ambulance_tracklongitude' 	=> $hospital_longitude,
						'ambulance_trackrotation' 	=> 0,
						'ambulance_trackdatetime' 	=> get_ymdhis(),
						'ambulance_status'		 	=> 1
					);
					
					$this->m_crud->update('tm_ambulance', 'ambulance_id', $data_ambulance, $ambulance_id);
					
					// current location ambulance
					$from_latitude 	= $hospital_latitude;
					$from_longitude = $hospital_longitude;
					
					// update distance eta to patient
					$to_latitude 	= $this->m_nonemergency->get_fromlatitude_by_id($id);
					$to_longitude 	= $this->m_nonemergency->get_fromlongitude_by_id($id); 
											   
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
					$member_id = $this->m_nonemergency->get_member_by_id($id);
					$device = $this->load->model('member/m_member')->get_device_by_id($member_id);
					if($device != "") {
						$token[] = array();
						$token[] = $device;
						
						$title 		= "";
						$message 	= get_notify(5);
						
						// send notif
						send_firebase_datanotification($token, $title, $message, $id, NULL, 1, '.activity.OrderNonEmergencyActivity');
					}	
				}	
				else {
					get_redirecting('dashboard');	
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
		$note	 = $this->input->post('note');
		
		// set array
		$data = array(
			'nonemergency_requestnote'	=> (($note == "")?NULL:nl2br($note)),
			'last_user'					=> $this->session->userdata('user_id')
		);
		
		// cek result
		$result = $this->m_crud->update($this->tabel, $this->field, $data, $id);
		if($result == 0) {
			$this->session->set_flashdata('message', get_notification('update', 0));
			$this->session->set_flashdata('status', get_notify_status(0));
		}
		else {
			$this->session->set_flashdata('message', get_notification('update', 1));
			$this->session->set_flashdata('status', get_notify_status(1));
		}

		get_redirecting('non-emergency/detail-data/'. simple_encrypt($id));
    }
}