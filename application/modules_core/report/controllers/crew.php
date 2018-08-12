<?php if(!defined('BASEPATH')) exit('Akses langsung tidak di perkenankan');

class Crew extends CI_Controller {

	public function __construct() {
    	parent::__construct();
		
		if ($this->session->userdata('login') == TRUE) {	
			$this->load->model('emergency/m_emergency');
			$this->load->model('non_emergency/m_nonemergency');
			$this->load->model('master/m_hospital');
			$this->load->model('master/m_driver');
			$this->load->model('master/m_doctor');
			$this->load->model('master/m_nurse');
			$this->load->model('master/m_ambulance');
			$this->load->model('master/m_motorbike');
			
			$this->load->helper('message');
			$this->load->helper('status');
			
			// set nav active
			$this->session->set_userdata('nav_active', 'report');
			
			// set sub active
			$this->session->set_userdata('sub_active', 'crew');
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
			
			get_redirecting('report/emergency');
		}
		
		// set session
		$this->session->set_userdata('type', $type);
		$this->session->set_userdata('from', $data['start']);
		$this->session->set_userdata('to', $data['end']);
		$this->session->set_userdata('hospital', $hospital);
		
		// set data
		$list = array();
		$emergency 		= $this->m_emergency->get_archive();
		$nonemergency 	= $this->m_nonemergency->get_archive();
		
		if(!empty($emergency)) {
			foreach($emergency as $row) {
				$code 		= $this->m_emergency->get_callreference_by_id($row->emergency_id);
				$ambulance 	= $this->m_ambulance->get_plat_by_id($row->ambulance_id);
				$hospi 		= $this->m_hospital->get_name_by_id($row->hospital_id);
				
				$ls_driver = $this->m_global->get_by_id('td_emergencydriver', 'emergency_id', $row->emergency_id);
				foreach($ls_driver as $rows) {
					if($this->session->userdata('type') != NULL) {
						if($this->session->userdata('type') == 1) {
							$list[] = array(
								"code"		=> $code,
								"ambulance"	=> $ambulance,
								"hospi"		=> $hospi,
								"hospital"	=> $hospital,
								"type"		=> 1,
								"crew"		=> "Driver",
								"name"		=> $this->m_driver->get_name_by_id($rows->driver_id)
							);	
						}
					}
					else {
						$list[] = array(
							"code"		=> $code,
							"ambulance"	=> $ambulance,
							"hospi"		=> $hospi,
							"hospital"	=> $hospital,
							"type"		=> 1,
							"crew"		=> "Driver",
							"name"		=> $this->m_driver->get_name_by_id($rows->driver_id)
						);
					}
				}
				
				$ls_doctor = $this->m_global->get_by_id('td_emergencydoctor', 'emergency_id', $row->emergency_id);
				foreach($ls_doctor as $rows) {
					if($this->session->userdata('type') != NULL) {
						if($this->session->userdata('type') == 2) {
							$list[] = array(
								"code"		=> $code,
								"ambulance"	=> $ambulance,
								"hospi"		=> $hospi,
								"hospital"	=> $hospital,
								"type"		=> 2,
								"crew"		=> "Doctor",
								"name"		=> $this->m_doctor->get_name_by_id($rows->doctor_id)
							);	
						}
					}
					else {
						$list[] = array(
							"code"		=> $code,
							"ambulance"	=> $ambulance,
							"hospi"		=> $hospi,
							"hospital"	=> $hospital,
							"type"		=> 2,
							"crew"		=> "Doctor",
							"name"		=> $this->m_doctor->get_name_by_id($rows->doctor_id)
						);
					}
				}

				$ls_nurse = $this->m_global->get_by_id('td_emergencynurse', 'emergency_id', $row->emergency_id);
				foreach($ls_nurse as $rows) {
					if($this->session->userdata('type') != NULL) {
						if($this->session->userdata('type') == 3) {
							$list[] = array(
								"code"		=> $code,
								"ambulance"	=> $ambulance,
								"hospi"		=> $hospi,
								"hospital"	=> $hospital,
								"type"		=> 3,
								"crew"		=> "Nurse",
								"name"		=> $this->m_nurse->get_name_by_id($rows->nurse_id)
							);	
						}
					}
					else {
						$list[] = array(
							"code"		=> $code,
							"ambulance"	=> $ambulance,
							"hospi"		=> $hospi,
							"hospital"	=> $hospital,
							"type"		=> 3,
							"crew"		=> "Nurse",
							"name"		=> $this->m_doctor->get_name_by_id($rows->nurse_id)
						);
					}
				}				
			}	
		}
		
		if(!empty($nonemergency)) {
			foreach($nonemergency as $row) {
				$code 		= $this->m_nonemergency->get_callreference_by_id($row->nonemergency_id);
				$ambulance 	= $this->m_ambulance->get_plat_by_id($row->ambulance_id);
				$hospi 		= $this->m_hospital->get_name_by_id($row->nonemergency_fromhospital);
				
				$ls_driver = $this->m_global->get_by_id('td_nonemergencydriver', 'nonemergency_id', $row->nonemergency_id);
				foreach($ls_driver as $rows) {
					if($this->session->userdata('type') != NULL) {
						if($this->session->userdata('type') == 1) {
							$list[] = array(
								"code"		=> $code,
								"ambulance"	=> $ambulance,
								"hospi"		=> $hospi,
								"hospital"	=> $hospital,
								"type"		=> 1,
								"crew"		=> "Driver",
								"name"		=> $this->m_driver->get_name_by_id($rows->driver_id)
							);	
						}
					}
					else {
						$list[] = array(
							"code"		=> $code,
							"ambulance"	=> $ambulance,
							"hospi"		=> $hospi,
							"hospital"	=> $hospital,
							"type"		=> 1,
							"crew"		=> "Driver",
							"name"		=> $this->m_driver->get_name_by_id($rows->driver_id)
						);
					}
				}
				
				$ls_doctor = $this->m_global->get_by_id('td_nonemergencydoctor', 'nonemergency_id', $row->nonemergency_id);
				foreach($ls_doctor as $rows) {
					if($this->session->userdata('type') != NULL) {
						if($this->session->userdata('type') == 2) {
							$list[] = array(
								"code"		=> $code,
								"ambulance"	=> $ambulance,
								"hospi"		=> $hospi,
								"hospital"	=> $hospital,
								"type"		=> 2,
								"crew"		=> "Doctor",
								"name"		=> $this->m_doctor->get_name_by_id($rows->doctor_id)
							);	
						}
					}
					else {
						$list[] = array(
							"code"		=> $code,
							"ambulance"	=> $ambulance,
							"hospi"		=> $hospi,
							"hospital"	=> $hospital,
							"type"		=> 2,
							"crew"		=> "Doctor",
							"name"		=> $this->m_doctor->get_name_by_id($rows->doctor_id)
						);
					}
				}

				$ls_nurse = $this->m_global->get_by_id('td_nonemergencynurse', 'nonemergency_id', $row->nonemergency_id);
				foreach($ls_nurse as $rows) {
					if($this->session->userdata('type') != NULL) {
						if($this->session->userdata('type') == 3) {
							$list[] = array(
								"code"		=> $code,
								"ambulance"	=> $ambulance,
								"hospi"		=> $hospi,
								"hospital"	=> $hospital,
								"type"		=> 3,
								"crew"		=> "Nurse",
								"name"		=> $this->m_nurse->get_name_by_id($rows->nurse_id)
							);	
						}
					}
					else {
						$list[] = array(
							"code"		=> $code,
							"ambulance"	=> $ambulance,
							"hospi"		=> $hospi,
							"hospital"	=> $hospital,
							"type"		=> 3,
							"crew"		=> "Nurse",
							"name"		=> $this->m_nurse->get_name_by_id($rows->nurse_id)
						);
					}
				}				
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
		$this->load->view('crew/v_list', $data);
		$this->load->view('../v_bottom');
		$this->load->view('../v_footer');
    }
	
	function export_to_excel() {
		// set data
		$list = array();
		$emergency 		= $this->m_emergency->get_archive();
		$nonemergency 	= $this->m_nonemergency->get_archive();
		
		$type		= $this->session->userdata('type');
		$hospital	= $this->session->userdata('hospital');
		
		if(!empty($emergency)) {
			foreach($emergency as $row) {
				$code 		= $this->m_emergency->get_callreference_by_id($row->emergency_id);
				$ambulance 	= $this->m_ambulance->get_plat_by_id($row->ambulance_id);
				$hospi 		= $this->m_hospital->get_name_by_id($row->hospital_id);
				
				$ls_driver = $this->m_global->get_by_id('td_emergencydriver', 'emergency_id', $row->emergency_id);
				foreach($ls_driver as $rows) {
					if($this->session->userdata('type') != NULL) {
						if($this->session->userdata('type') == 1) {
							$list[] = array(
								"code"		=> $code,
								"ambulance"	=> $ambulance,
								"hospi"		=> $hospi,
								"hospital"	=> $hospital,
								"type"		=> 1,
								"crew"		=> "Driver",
								"name"		=> $this->m_driver->get_name_by_id($rows->driver_id)
							);	
						}
					}
					else {
						$list[] = array(
							"code"		=> $code,
							"ambulance"	=> $ambulance,
							"hospi"		=> $hospi,
							"hospital"	=> $hospital,
							"type"		=> 1,
							"crew"		=> "Driver",
							"name"		=> $this->m_driver->get_name_by_id($rows->driver_id)
						);
					}
				}
				
				$ls_doctor = $this->m_global->get_by_id('td_emergencydoctor', 'emergency_id', $row->emergency_id);
				foreach($ls_doctor as $rows) {
					if($this->session->userdata('type') != NULL) {
						if($this->session->userdata('type') == 2) {
							$list[] = array(
								"code"		=> $code,
								"ambulance"	=> $ambulance,
								"hospi"		=> $hospi,
								"hospital"	=> $hospital,
								"type"		=> 2,
								"crew"		=> "Doctor",
								"name"		=> $this->m_doctor->get_name_by_id($rows->doctor_id)
							);	
						}
					}
					else {
						$list[] = array(
							"code"		=> $code,
							"ambulance"	=> $ambulance,
							"hospi"		=> $hospi,
							"hospital"	=> $hospital,
							"type"		=> 2,
							"crew"		=> "Doctor",
							"name"		=> $this->m_doctor->get_name_by_id($rows->doctor_id)
						);
					}
				}

				$ls_nurse = $this->m_global->get_by_id('td_emergencynurse', 'emergency_id', $row->emergency_id);
				foreach($ls_nurse as $rows) {
					if($this->session->userdata('type') != NULL) {
						if($this->session->userdata('type') == 3) {
							$list[] = array(
								"code"		=> $code,
								"ambulance"	=> $ambulance,
								"hospi"		=> $hospi,
								"hospital"	=> $hospital,
								"type"		=> 3,
								"crew"		=> "Nurse",
								"name"		=> $this->m_nurse->get_name_by_id($rows->nurse_id)
							);	
						}
					}
					else {
						$list[] = array(
							"code"		=> $code,
							"ambulance"	=> $ambulance,
							"hospi"		=> $hospi,
							"hospital"	=> $hospital,
							"type"		=> 3,
							"crew"		=> "Nurse",
							"name"		=> $this->m_doctor->get_name_by_id($rows->nurse_id)
						);
					}
				}				
			}	
		}
		
		if(!empty($nonemergency)) {
			foreach($nonemergency as $row) {
				$code 		= $this->m_nonemergency->get_callreference_by_id($row->nonemergency_id);
				$ambulance 	= $this->m_ambulance->get_plat_by_id($row->ambulance_id);
				$hospi 		= $this->m_hospital->get_name_by_id($row->nonemergency_fromhospital);
				
				$ls_driver = $this->m_global->get_by_id('td_nonemergencydriver', 'nonemergency_id', $row->nonemergency_id);
				foreach($ls_driver as $rows) {
					if($this->session->userdata('type') != NULL) {
						if($this->session->userdata('type') == 1) {
							$list[] = array(
								"code"		=> $code,
								"ambulance"	=> $ambulance,
								"hospi"		=> $hospi,
								"hospital"	=> $hospital,
								"type"		=> 1,
								"crew"		=> "Driver",
								"name"		=> $this->m_driver->get_name_by_id($rows->driver_id)
							);	
						}
					}
					else {
						$list[] = array(
							"code"		=> $code,
							"ambulance"	=> $ambulance,
							"hospi"		=> $hospi,
							"hospital"	=> $hospital,
							"type"		=> 1,
							"crew"		=> "Driver",
							"name"		=> $this->m_driver->get_name_by_id($rows->driver_id)
						);
					}
				}
				
				$ls_doctor = $this->m_global->get_by_id('td_nonemergencydoctor', 'nonemergency_id', $row->nonemergency_id);
				foreach($ls_doctor as $rows) {
					if($this->session->userdata('type') != NULL) {
						if($this->session->userdata('type') == 2) {
							$list[] = array(
								"code"		=> $code,
								"ambulance"	=> $ambulance,
								"hospi"		=> $hospi,
								"hospital"	=> $hospital,
								"type"		=> 2,
								"crew"		=> "Doctor",
								"name"		=> $this->m_doctor->get_name_by_id($rows->doctor_id)
							);	
						}
					}
					else {
						$list[] = array(
							"code"		=> $code,
							"ambulance"	=> $ambulance,
							"hospi"		=> $hospi,
							"hospital"	=> $hospital,
							"type"		=> 2,
							"crew"		=> "Doctor",
							"name"		=> $this->m_doctor->get_name_by_id($rows->doctor_id)
						);
					}
				}

				$ls_nurse = $this->m_global->get_by_id('td_nonemergencynurse', 'nonemergency_id', $row->nonemergency_id);
				foreach($ls_nurse as $rows) {
					if($this->session->userdata('type') != NULL) {
						if($this->session->userdata('type') == 3) {
							$list[] = array(
								"code"		=> $code,
								"ambulance"	=> $ambulance,
								"hospi"		=> $hospi,
								"hospital"	=> $hospital,
								"type"		=> 3,
								"crew"		=> "Nurse",
								"name"		=> $this->m_nurse->get_name_by_id($rows->nurse_id)
							);	
						}
					}
					else {
						$list[] = array(
							"code"		=> $code,
							"ambulance"	=> $ambulance,
							"hospi"		=> $hospi,
							"hospital"	=> $hospital,
							"type"		=> 3,
							"crew"		=> "Nurse",
							"name"		=> $this->m_nurse->get_name_by_id($rows->nurse_id)
						);
					}
				}				
			}
		}

		$data['list'] = $list;
		
		// set view
		$this->load->view('crew/v_excel',$data);
    }
}