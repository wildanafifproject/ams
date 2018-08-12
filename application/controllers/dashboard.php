<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct() {
    	parent::__construct();
		
		if ($this->session->userdata('login') == TRUE) {	
			$this->load->helper('message');
			$this->load->helper('status');
			
			// set nav active
			$this->session->set_userdata('nav_active', 'dashboard');
			
			// set sub active
			$this->session->unset_userdata('sub_active');
		}
		else {
			get_redirecting('login');
		}
	}

	public function index() {
		// get from post
		$call_ref			= $this->input->post('call_ref');
		$hospital_emergency	= $this->input->post('hospital_emergency');
		$hospital_ambulance	= $this->input->post('hospital_ambulance');
		$start				= $this->input->post('start');
		$end				= $this->input->post('end');
		
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
			
			get_redirecting('dashboard');
		}
		
		$this->session->set_userdata('call_ref', simple_decrypt($call_ref));
		$this->session->set_userdata('hospital_emergency', $hospital_emergency);
		$this->session->set_userdata('hospital_ambulance', $hospital_ambulance);
		$this->session->set_userdata('from_nonemergency', $data['start']);
		$this->session->set_userdata('to_nonemergency', $data['end']);
		
		// set data
		$data['call_ref'] = $this->m_global->get_by_status_arr('tp_emergency', 'emergency_status', array(0,1,4,5,6,7,8,11,12,13)); 
		if($this->session->userdata('user_authority') == 1) { 
			$data['hospital'] 		= $this->m_global->get_by_double_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', $this->session->userdata('hospital_id'), 'hospital_id', 'ASC');
			$data['emergency'] 		= $this->load->model('emergency/m_emergency')->get_dashboard();	
			$data['nonemergency'] 	= $this->load->model('non_emergency/m_nonemergency')->get_dashboard();	
			$data['ambulance'] 		= $this->load->model('master/m_ambulance')->get_dashboard();
		}
		else {
			$data['hospital'] 		= $this->m_global->get_by_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', 'ASC');
			$data['emergency'] 		= $this->load->model('emergency/m_emergency')->get_dashboard();
			$data['nonemergency'] 	= $this->load->model('non_emergency/m_nonemergency')->get_dashboard();	
			$data['ambulance'] 		= $this->load->model('master/m_ambulance')->get_dashboard();
		}
		
		// set view
		$this->load->view('v_header');
		$this->load->view('v_top');
		$this->load->view('main/v_dashboard', $data);
		$this->load->view('v_bottom');
		$this->load->view('v_footer');
	}
}