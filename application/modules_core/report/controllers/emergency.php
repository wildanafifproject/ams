<?php if(!defined('BASEPATH')) exit('Akses langsung tidak di perkenankan');

class Emergency extends CI_Controller {

	public $tabel = 'tp_emergency';
	public $field = 'emergency_id';
	
    public function __construct() {
    	parent::__construct();
		
		if ($this->session->userdata('login') == TRUE) {	
			$this->load->model('emergency/m_emergency');
			$this->load->model('setting/m_source');
			$this->load->model('setting/m_forward');
			$this->load->model('setting/m_area');
			$this->load->model('setting/m_location');
			$this->load->model('master/m_hospital');
			$this->load->model('master/m_ambulance');
			$this->load->model('master/m_motorbike');
			
			$this->load->helper('message');
			$this->load->helper('status');
			
			// set nav active
			$this->session->set_userdata('nav_active', 'report');
			
			// set sub active
			$this->session->set_userdata('sub_active', 'emergency');
		}
		else {
			get_redirecting('login');
		}
	}

    function index() {
		// get from post
		$start		= $this->input->post('start');
		$end		= $this->input->post('end');
		
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
		$this->session->set_userdata('from', $data['start']);
		$this->session->set_userdata('to', $data['end']);
		
		// set data
		$data['list'] = $this->m_emergency->get_report_all();
		
		// reset session default_map
		$this->session->unset_userdata('default_map');
		$this->session->unset_userdata('default_report');
		$this->session->unset_userdata('default_ambulance');
		$this->session->unset_userdata('default_zoom');
		$this->session->unset_userdata('default_lat');
		$this->session->unset_userdata('default_lon');
		$this->session->unset_userdata('default_add');
		$this->session->unset_userdata('default_srh');
		
		// set view
		$this->load->view('../v_header');
		$this->load->view('../v_top');
		$this->load->view('emergency/v_list', $data);
		$this->load->view('../v_bottom');
		$this->load->view('../v_footer');
    }
	
	function detail_data() {
		// get data
		$id = simple_decrypt($this->uri->segment(4));
		
		// cek id
		if($id == "") {
            get_redirecting('report/emergency');
        } 
        else {
			// set data
			$data['detail'] = $this->m_global->get_by_id($this->tabel, $this->field, $id);
			
			// cek resut
			if($data['detail'] == null) {
                get_redirecting('error');
            }
			else {
				// set default_map
				$this->session->set_userdata('default_map', 1);
				$this->session->set_userdata('default_zoom', 14);
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
				if($this->session->userdata('user_authority') == 0) { 
					$this->load->view('emergency/v_edit', $data);
				}else{
					$this->load->view('emergency/v_detail', $data);
				}
				
				$this->load->view('../v_bottom');
				$this->load->view('../v_footer');
			}
		}
    }
	
	function prints() {
		// set data
		echo "Lorem ipsum";
	}
	function update_data()
	{
		$data = $this->input->post();
		$id = simple_decrypt($this->input->post('id'));
		//print_r($data);
		$dataUpdate = array(
			'emergency_date' => convert_to_ymd($data['emergency_date']) ,
			'emergency_time' => $data['emergency_time'],
			'emergency_callername' => $data['emergency_callername'],
			'emergency_callerphone' => $data['emergency_callerphone'],
			'emergency_callerother' => $data['emergency_callerother'],
			'emergency_patienttotal' => $data['emergency_patienttotal'],
			'emergency_patientunconscious' => $data['emergency_patientunconscious'],
			'emergency_patientnote' => $data['emergency_patientnote'],
			'emergency_patientname' => $data['emergency_patientname'],
			'emergency_patientdob' => (($data['emergency_patientdob'] == "")?NULL:convert_to_ymd($data['emergency_patientdob'])),
			'emergency_infootherinformation' => $data['emergency_infootherinformation'],
		);
		$result = $this->m_crud->update('tp_emergency', 'emergency_id',$dataUpdate, $id);		
		if($result == 0) {
			$this->session->set_flashdata('message', get_notification('update', 0));
			$this->session->set_flashdata('status', get_notify_status(0));
			get_redirecting('report/emergency');
		}else{
			$this->session->set_flashdata('message', get_notification('update', 1));
			$this->session->set_flashdata('status', get_notify_status(1));
			get_redirecting('report/emergency');
		}
		# code...
	}
	public function set_status()
	{
		// cek validate form
		$valid = simple_decrypt($this->input->post('valid'));
		if($valid != 1) {
			get_redirecting('dashboard');
		}
		
		// get from post
		$id			= simple_decrypt($this->input->post('emergency_status'));
		$time		= $this->input->post('time');
		$status		= $this->input->post('status');
		
		$datetime	= $this->input->post('datetime_emergency') .' '. $time;
		
		// set array
		$kirim_fcm = 0;
		switch($status) {
			// go to patient
			case 6 :
				$data = array(
					'time_to_patient' 	=> $datetime
				);
				
				$kirim_fcm = 1;
			break;
			// call patient
			case 11 :
				$data = array(
					'time_call_patient' => $datetime
				);
			break;
			// arrived patient
			case 12 :
				$data = array(
					'time_arrived_patient' 	=> $datetime
				);
			break;
			// go to hospital
			case 7 :
				$data = array(
					'time_to_hospital' 	=> $datetime
				);
			break;
			// arrived hospital
			case 13 :
				$data = array(
					'time_arrived_hospital' => $datetime
				);
			break;
			// back to hospital
			case 8 :
				$data = array(
					'time_back_hospital'	=> $datetime
				);
			break;
			// complete
			case 9 :
				$data = array(
					'time_complete'		=> $datetime
				);
				
			break;
		}
		
		// cek result
		$result = $this->m_crud->update($this->tabel, $this->field, $data, $id);
		if($result == 0) {
			$this->session->set_flashdata('message', get_notification('update', 0));
			$this->session->set_flashdata('status', get_notify_status(0));
			get_redirecting('report/emergency/detail-data/'. simple_encrypt($id));
		}else{
			get_redirecting('report/emergency/detail-data/'. simple_encrypt($id));
		}
	}
	function delete($emergency_id='')
	{
		$id = simple_decrypt($emergency_id);
		$data = $this->m_global->get_by_id2($this->tabel, $this->field, $id);
		$this->m_global->insertData('temp_emergency',$data);
		$data = $this->m_global->deleteData($this->tabel, $this->field, $id);
		get_redirecting('report/emergency');
		# code...
	}
}