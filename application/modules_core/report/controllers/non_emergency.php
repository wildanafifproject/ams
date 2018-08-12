<?php if(!defined('BASEPATH')) exit('Akses langsung tidak di perkenankan');

class Non_emergency extends CI_Controller {

	public $tabel = 'tp_nonemergency';
	public $field = 'nonemergency_id';
	
    public function __construct() {
    	parent::__construct();
		
		if ($this->session->userdata('login') == TRUE) {	
			$this->load->model('non_emergency/m_nonemergency');
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
			
			$this->load->helper('message');
			$this->load->helper('status');
			
			// set nav active
			$this->session->set_userdata('nav_active', 'report');
			
			// set sub active
			$this->session->set_userdata('sub_active', 'non_emergency');
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
			
			get_redirecting('report/non-emergency');
		}
		
		// set session
		$this->session->set_userdata('from', $data['start']);
		$this->session->set_userdata('to', $data['end']);
		
		// set data
		$data['list'] = $this->m_nonemergency->get_report_all();
		
		// reset session default_map
		$this->session->unset_userdata('default_zoom');
		$this->session->unset_userdata('default_map');
		$this->session->unset_userdata('default_report');
		$this->session->unset_userdata('default_ambulance');
		$this->session->unset_userdata('default_zoom');
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
		
		// set view
		$this->load->view('../v_header');
		$this->load->view('../v_top');
		$this->load->view('non_emergency/v_list', $data);
		$this->load->view('../v_bottom');
		$this->load->view('../v_footer');
    }
	
	function detail_data() {
		// get data
		$id = simple_decrypt($this->uri->segment(4));
		
		// cek id
		if($id == "") {
            get_redirecting('report/non-emergency');
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
				if($this->session->userdata('user_authority') == 0) { 
					$this->load->view('non_emergency/v_edit', $data);
				}else{
					$this->load->view('non_emergency/v_detail', $data);
				}
				// $this->load->view('non_emergency/v_edit', $data);
				$this->load->view('../v_bottom');
				$this->load->view('../v_footer');
			}
		}
    }

    function update_data()
    {
    	$data = $this->input->post();
    	$id	= simple_decrypt($this->input->post('id'));
    	$dataUpdate = array(
    		'nonemergency_date' => (($data['nonemergency_date'] == "")?NULL:convert_to_ymd($data['nonemergency_date'])), 
    		'nonemergency_time' => (($data['nonemergency_time']  == "")?NULL:convert_to_his($data['nonemergency_time'])),
    		'nonemergency_infoname' => $data['nonemergency_infoname'],
    		'nonemergency_infophone' => $data['nonemergency_infophone'],
    		'nonemergency_infodate' => (($data['nonemergency_infodate'] == "")?NULL:convert_to_ymd($data['nonemergency_infodate'])), 
    		'nonemergency_infotime' => (($data['nonemergency_infotime']  == "")?NULL:convert_to_his($data['nonemergency_infotime'])),
    		'nonemergency_infodiagnosis' => $data['nonemergency_infodiagnosis'],
    		'nonemergency_infoconsultant' => $data['nonemergency_infoconsultant'],
    		'nonemergency_inforeason' => $data['nonemergency_inforeason'],
    		'nonemergency_requestnote' => $data['nonemergency_requestnote'],
    		'nonemergency_requestname' => $data['nonemergency_requestname'],
    		'nonemergency_requestdepartment' => $data['nonemergency_requestdepartment'],
    		'nonemergency_requesttittle' => $data['nonemergency_requesttittle']
    	);
    	$result = $this->m_crud->update($this->tabel, $this->field, $dataUpdate, $id);
    	//print_r($data);
    	if($result == 0) {
			$this->session->set_flashdata('message', get_notification('update', 0));
			$this->session->set_flashdata('status', get_notify_status(0));
			get_redirecting('report/non-emergency');
		}else{
			$this->session->set_flashdata('message', get_notification('update', 1));
			$this->session->set_flashdata('status', get_notify_status(1));
			get_redirecting('report/non-emergency');
		}
    	# code...
    }
    function set_status()
    {
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
					'time_to_patient' 		=> $datetime
					
				);
			break;
			// call patient
			case 11 :
				$data = array(
					'time_call_patient' 	=> $datetime					
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
					'time_to_hospital' 		=> $datetime
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
					'time_complete'			=> $datetime
				);				
			break;
		}
		
		// cek result
		$result = $this->m_crud->update($this->tabel, $this->field, $data, $id);
		if($result == 0) {
			$this->session->set_flashdata('message', get_notification('update', 0));
			$this->session->set_flashdata('status', get_notify_status(0));
			get_redirecting('report/non-emergency/detail-data/'. simple_encrypt($id));
		}else{
			get_redirecting('report/non-emergency/detail-data/'. simple_encrypt($id));
		}
    }
	function delete($emergency_id='')
	{
		$id = simple_decrypt($emergency_id);
		$data = $this->m_global->get_by_id2($this->tabel, $this->field, $id);	
		$this->m_global->insertData('temp_nonemergency',$data);
		$data = $this->m_global->deleteData($this->tabel, $this->field, $id);
		get_redirecting('report/non-emergency');
		# code...
	}
	function prints() {
		// set data
		echo "Lorem ipsum";
	}
}