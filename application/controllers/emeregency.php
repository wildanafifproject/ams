<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emeregency extends CI_Controller {

	public $tabel = 'tp_emergency';
	public $field = 'emergency_id';
	
	public function __construct() {
    	parent::__construct();


		
		if ($this->session->userdata('login') == TRUE) {	
			// $this->load->model('m_emeregency');
			// $this->load->model('setting/m_source');
			// $this->load->model('setting/m_forward');
			// $this->load->model('setting/m_area');
			// $this->load->model('setting/m_location');
			// $this->load->model('setting/m_source');
			
			// $this->load->helper('transaction');
			// $this->load->helper('message');
			// $this->load->helper('status');
			
			// set nav active
			$this->session->set_userdata('nav_active', 'emeregency');
			
			// set sub active
			$this->session->unset_userdata('sub_active');
		}
		else {
			get_redirecting('login');
		}
	}

	public function index() {
		
		// set data
		// $data['code'] = generate_call_reference();
		
		// // set view
		// $this->load->view('v_header');
		// $this->load->view('v_top');
		// $this->load->view('main/v_emeregency', $data);
		// $this->load->view('v_bottom');
		// $this->load->view('v_footer');
	}
	
	function process_data() {
		// cek validate form
		$valid = simple_decrypt($this->input->post('valid'));
		if($valid != 1) {
			get_redirecting('master/ambulance');
		}
		
		// get from post
		$source	= $this->input->post('source');
		$forward			= $this->input->post('forward');
		$call_name			= $this->input->post('call_name');
		$call_phone			= $this->input->post('call_phone');
		$other_phone		= $this->input->post('other_phone');
		$street				= $this->input->post('street');
		$area				= $this->input->post('area');
		$location			= $this->input->post('location');
		$other_info			= $this->input->post('other_info');
		$total_patient		= $this->input->post('total_patient');
		$total_unconscious	= $this->input->post('total_unconscious');
		$note				= $this->input->post('note');
		$category			= $this->input->post('category');
		$sub_category		= $this->input->post('sub_category');
		$description		= $this->input->post('description');
		$chkAmbulance		= $this->input->post('chkAmbulance');
		$chkMotorbike		= $this->input->post('chkMotorbike');
		
		if($chkAmbulance == "") {
			// set session
			$this->session->set_flashdata('source', $source);
			$this->session->set_flashdata('call_name', $call_name);
			$this->session->set_flashdata('call_phone', $call_phone);
			$this->session->set_flashdata('other_phone', $other_phone);
			$this->session->set_flashdata('street', $street);
			$this->session->set_flashdata('area', $area);
			$this->session->set_flashdata('location', $location);
			$this->session->set_flashdata('other_info', $other_info);
			$this->session->set_flashdata('total_patient', $total_patient);
			$this->session->set_flashdata('total_unconscious', $total_unconscious);
			$this->session->set_flashdata('note', $note);
			$this->session->set_flashdata('category', $category);
			$this->session->set_flashdata('sub_category', $sub_category);
			
			$this->session->set_flashdata('message', 'Please select one of the ambulance.');
			$this->session->set_flashdata('status', get_notify_status(2));
			
			get_redirecting('emeregency');
		}
		
		// set array
		$data = array(
			'emergency_status'					=> 1, 
			'emergency_date'					=> get_ymd(),
			'emergency_time'					=> get_his(),
			'emergency_callreference'			=> generate_call_reference(),
			'emergency_callername'				=> strip_tags($call_name),
			'emergency_callerphone'				=> $call_phone,
			'emergency_callerother'				=> (($other_phone == "")?NULL:$other_phone),
			'emergency_infostreet'				=> (($street == "")?NULL:nl2br($street)),
			'emergency_infootherinformation'	=> (($other_info == "")?NULL:nl2br($other_info)),
			'emergency_patienttotal'			=> $total_patient,
			'emergency_patientunconscious'		=> $total_unconscious,
			'emergency_patientnote'				=> (($note == "")?NULL:nl2br($note)),
			'source_id'							=> $source,
			'forward_id'						=> $forward,
			'area_id'							=> $area,
			'location_id'						=> $location,
			'ambulance_id'						=> $chkAmbulance,
			'motorbike_id'						=> (($chkMotorbike == "")?NULL:$chkMotorbike),
			'last_user'							=> $this->session->userdata('user_id')
		);
		
		// cek result
		$result = $this->m_crud->insert_id($this->tabel, $data);
		if($result == 0) {
			$this->session->set_flashdata('message', get_notification('insert', 0));
			$this->session->set_flashdata('status', get_notify_status(0));
		}
		else {
			// insert detail
			$detail = array(
				'subcategory_id'	=> $sub_category,
				'note'				=> (($description == "")?NULL:$description),
				'emergency_id'		=> $result
			);
			
			$this->m_crud->insert('td_emergency', $detail);
			
			$this->session->set_flashdata('message', get_notification('insert', 1));
			$this->session->set_flashdata('status', get_notify_status(1));
		}

		get_redirecting('emeregency');
	}	
		
	function prints() {
		// set data
		echo "Lorem ipsum";
	}
}