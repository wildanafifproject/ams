<?php if(!defined('BASEPATH')) exit('Akses langsung tidak di perkenankan');

class Work_day extends CI_Controller {

	public $tabel = 'tp_workday';
	public $field = 'workday_id';
	
    public function __construct() {
    	parent::__construct();
		
		if ($this->session->userdata('login') == TRUE) {	
			$this->load->helper('message');
			$this->load->helper('status');
			
			$this->load->model('m_workday');
			$this->load->model('m_workroster');
			$this->load->model('m_driver');
			$this->load->model('m_doctor');
			$this->load->model('m_nurse');
			$this->load->model('m_hospital');
			
			// set nav active
			$this->session->set_userdata('nav_active', 'master');
			
			// set sub active
			$this->session->set_userdata('sub_active', 'workday');
		}
		else {
			get_redirecting('login');
		}
	}

    function index() {
		// get from post
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
			
			get_redirecting('master/work-day');
		}
		
		// set session
		$this->session->set_userdata('from', $data['start']);
		$this->session->set_userdata('to', $data['end']);
		
		if($this->session->userdata('user_authority') == 1) {	
			$this->session->set_userdata('hospital', $this->session->userdata('hospital_id'));
		} else {
			$this->session->set_userdata('hospital', $hospital);	
		}	
		
		// set data
		$data['list'] = $this->m_workday->get_report_all();
		
		// set view
		$this->load->view('../v_header');
		$this->load->view('../v_top');
		$this->load->view('workday/v_list', $data);
		$this->load->view('../v_bottom');
		$this->load->view('../v_footer');
    }
	
	function add_data() {
		// set data
		if($this->session->userdata('user_authority') == 1) { 
			$data['hospital'] = $this->m_global->get_by_double_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', $this->session->userdata('hospital_id'), 'hospital_id', 'ASC');
		}
		else {
			$data['hospital'] = $this->m_global->get_by_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', 'ASC'); 
		}
		
		// set view
		$this->load->view('../v_header');
		$this->load->view('../v_top');
		$this->load->view('workday/v_add', $data);
		$this->load->view('../v_bottom');
		$this->load->view('../v_footer');
    }
	
	function insert_data() {
		// cek validate form
		$valid = simple_decrypt($this->input->post('valid'));
		if($valid != 1) {
			get_redirecting('master/work-day');
		}
		
		// get from post
		$start			= $this->input->post('start');
		$end			= $this->input->post('end');
		$workroster		= $this->input->post('workroster');
		$hospital		= $this->input->post('hospital');
		$status			= $this->input->post('status');
		
		$doctor			= $this->input->post('doctor');
		$nurse			= $this->input->post('nurse');
		$driver			= $this->input->post('driver');
		
		// cek time
		if(strtotime($start) > strtotime($end)) {
			// set session
			$this->session->set_flashdata('hospital', $hospital);
			$this->session->set_flashdata('workroster', $workroster);
			
			$this->session->set_flashdata('message', 'Error format date.');
			$this->session->set_flashdata('status', get_notify_status(2));
			
			get_redirecting('master/work-day/add-data');
		}
		
		// looping date
		$result = 0;
		$diff = diff_date($start, $end);
		for($i=0; $i<=$diff; $i++) {
			$date = next_date($start, $i);
			// cek exist
			if($this->m_global->check_existings('tp_workday', 'hospital_id', $hospital, 'workroster_id', $workroster, 'workday_date', $date) == FALSE) {
				// set array
				$data = array(
					'workday_status'	=> $status,
					'workday_date'		=> $date,
					'workroster_id'		=> $workroster,
					'hospital_id'		=> $hospital,
					'last_user'			=> $this->session->userdata('user_id')
				);
				
				// cek result
				$result = $this->m_crud->insert_id($this->tabel, $data);
			
				// insert doctor
				if(!empty($doctor)) {
					foreach($doctor as $row) {
						if($row != "") {
							$data_doctor = array(
								'doctor_id'	 => $row,
								'workday_id' => $result
							);
							
							$this->m_crud->insert_id('td_workdoctor', $data_doctor);
						}
					}
				}
				
				// insert nurse
				if(!empty($nurse)) {
					foreach($nurse as $row) {
						if($row != "") {
							$data_nurse = array(
								'nurse_id'	 => $row,
								'workday_id' => $result
							);
							
							$this->m_crud->insert_id('td_worknurse', $data_nurse);
						}
					}
				}	
				
				// insert driver
				if(!empty($driver)) {
					foreach($driver as $row) {
						if($row != "") {
							$data_driver = array(
								'driver_id'	 => $row,
								'workday_id' => $result
							);
							
							$this->m_crud->insert_id('td_workdriver', $data_driver);
						}
					}
				}	
			}
		}
		
		if($result == 0) {
			$this->session->set_flashdata('message', get_notification('insert', 0));
			$this->session->set_flashdata('status', get_notify_status(0));
		}
		else {
			$this->session->set_flashdata('message', get_notification('insert', 1));
			$this->session->set_flashdata('status', get_notify_status(1));
		}

		get_redirecting('master/work-day');
    }
	
	function edit_data() {
		// get data
		$id = simple_decrypt($this->uri->segment(4));
		
		// cek id
		if($id == "") {
            get_redirecting('master/work-day');
        } 
        else {
			// set data
			$data['detail'] = $this->m_global->get_by_id($this->tabel, $this->field, $id);
			
			// cek resut
			if($data['detail'] == null) {
                get_redirecting('error');
            }
			else {
				// set data
				$arr_doctor = array();
				$ls_doctor = $this->m_global->get_by_id('td_workdoctor', 'workday_id', $id);
				foreach($ls_doctor as $row) {
					$arr_doctor[] = $row->doctor_id; 
				}
				
				$arr_nurse = array();
				$ls_nurse = $this->m_global->get_by_id('td_worknurse', 'workday_id', $id);
				foreach($ls_nurse as $row) {
					$arr_nurse[] = $row->nurse_id; 
				}
				
				$arr_driver = array();
				$ls_driver = $this->m_global->get_by_id('td_workdriver', 'workday_id', $id);
				foreach($ls_driver as $row) {
					$arr_driver[] = $row->driver_id; 
				}
				
				$data['arr_doctor'] = $arr_doctor;
				$data['arr_nurse'] 	= $arr_nurse;
				$data['arr_driver'] = $arr_driver;
				
				// set data
				if($this->session->userdata('user_authority') == 1) { 
					$data['hospital'] = $this->m_global->get_by_double_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', $this->session->userdata('hospital_id'), 'hospital_id', 'ASC');
				}
				else {
					$data['hospital'] = $this->m_global->get_by_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', 'ASC'); 
				}
				
				// set view
				$this->load->view('../v_header');
				$this->load->view('../v_top');
				$this->load->view('workday/v_edit', $data);
				$this->load->view('../v_bottom');
				$this->load->view('../v_footer');
			}
		}
    }
	
	function update_data() {
		// cek validate form
		$valid = simple_decrypt($this->input->post('valid'));
		if($valid != 1) {
			get_redirecting('master/work-day');
		}
		
		// get from post
		$id				= simple_decrypt($this->input->post('id'));
		$date			= $this->input->post('date');
		$workroster		= $this->input->post('workroster');
		$hospital		= $this->input->post('hospital');
		$status			= $this->input->post('status');
		
		$doctor			= $this->input->post('doctor');
		$nurse			= $this->input->post('nurse');
		$driver			= $this->input->post('driver');
		
		// cek exist
		$date = convert_to_ymd($date);
		
		$old_hospital 	= $this->m_workday->get_hospital_by_id($id);
		$old_workroster = $this->m_workday->get_workroster_by_id($id);
		$old_date 		= $this->m_workday->get_date_by_id($id);
		
		
		if(($old_hospital != $hospital) || ($old_workroster != $workroster) || ($old_date != $date)) {
			if($this->m_global->check_existings('tp_workday', 'hospital_id', $hospital, 'workroster_id', $workroster, 'workday_date', $date) == TRUE) {
				$this->session->set_flashdata('message', 'Work day already exist in that hospital.');
				$this->session->set_flashdata('status', get_notify_status(9));
				
				get_redirecting('master/work-day/edit-data/'. simple_encrypt($id));
			}
		}
		
		// set array
		$data = array(
			'workday_status'	=> $status,
			'workday_date'		=> $date,
			'workroster_id'		=> $workroster,
			'hospital_id'		=> $hospital,
			'last_user'			=> $this->session->userdata('user_id')
		);
		
		// cek result
		$result = $this->m_crud->update($this->tabel, $this->field, $data, $id); 
		if($result == 0) {
			$this->session->set_flashdata('message', get_notification('update', 0));
			$this->session->set_flashdata('status', get_notify_status(0));
		}
		else {
			// insert doctor
			$this->m_crud->delete('td_workdoctor', 'workday_id', $id);
			if(!empty($doctor)) {
				foreach($doctor as $row) {
					if($row != "") {
						$data_doctor = array(
							'doctor_id'	 => $row,
							'workday_id' => $id
						);
						
						$this->m_crud->insert_id('td_workdoctor', $data_doctor);
					}
				}
			}
			
			// insert nurse
			$this->m_crud->delete('td_worknurse', 'workday_id', $id);
			if(!empty($nurse)) {
				foreach($nurse as $row) {
					if($row != "") {
						$data_nurse = array(
							'nurse_id'	 => $row,
							'workday_id' => $id
						);
						
						$this->m_crud->insert_id('td_worknurse', $data_nurse);
					}
				}
			}	
			
			// insert driver
			$this->m_crud->delete('td_workdriver', 'workday_id', $id);
			if(!empty($driver)) {
				foreach($driver as $row) {
					if($row != "") {
						$data_driver = array(
							'driver_id'	 => $row,
							'workday_id' => $id
						);
						
						$this->m_crud->insert_id('td_workdriver', $data_driver);
					}
				}
			}
		
			$this->session->set_flashdata('message', get_notification('update', 1));
			$this->session->set_flashdata('status', get_notify_status(1));
		}		
		
		get_redirecting('master/work-day');
    }
}