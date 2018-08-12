<?php if(!defined('BASEPATH')) exit('Akses langsung tidak di perkenankan');

class Hospitals extends CI_Controller {

	public $tabel = 'tm_hospital';
	public $field = 'hospital_id';
	
    public function __construct() {
    	parent::__construct();
		
		if ($this->session->userdata('login') == TRUE) {	
			if($this->session->userdata('user_authority') == 1) { 
				$this->load->helper('message');
				$this->load->helper('status');
				$this->load->helper('image');
				
				$this->load->model('master/m_hospital');
				$this->load->model('setting/m_facility');
				$this->load->model('setting/m_specialist');
				
				// set nav active
				$this->session->set_userdata('nav_active', 'hospital');
				
				// set sub active
				$this->session->unset_userdata('sub_active');
			}
			else {
				get_redirecting('error');
			}	
		}
		else {
			get_redirecting('login');
		}
	}

    function index() {
		// get data
		$id = $this->session->userdata('hospital_id');
		
		// cek id
		if($id == "") {
            get_redirecting('master/hospital');
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
				$arr_facility = array();
				$ls_facility  = $this->m_global->get_by_id('td_facility', 'hospital_id', $id);
				foreach($ls_facility as $row) {
					$arr_facility[] = $row->facility_id; 
				}
				
				// set data
				$arr_specialist = array();
				$ls_specialist  = $this->m_global->get_by_id('td_specialist', 'hospital_id', $id);
				foreach($ls_specialist as $row) {
					$arr_specialist[] = $row->specialist_id; 
				}
				
				$data['arr_facility']   = $arr_facility;
				$data['arr_specialist'] = $arr_specialist;
				
				// set view
				$this->load->view('../v_header');
				$this->load->view('../v_top');
				$this->load->view('v_edit', $data);
				$this->load->view('../v_bottom');
				$this->load->view('../v_footer');
			}
		}
    }
	
	function update_data() {
		// cek validate form
		$valid = simple_decrypt($this->input->post('valid'));
		if($valid != 1) {
			get_redirecting('hospitals');
		}
		
		// get from post
		$id			= simple_decrypt($this->input->post('id'));
		$code		= $this->input->post('code');
		$name		= $this->input->post('name');
		$email		= $this->input->post('email');
		$phone		= $this->input->post('phone');
		$identity	= $this->input->post('identity');
		$latitude	= $this->input->post('latitude');
		$longitude	= $this->input->post('longitude');
		$address	= $this->input->post('address');
		$facility	= $this->input->post('facility');
		$specialist	= $this->input->post('specialist');
		$status		= $this->input->post('status');
		
		// cek old
		$old_code = $this->m_hospital->get_code_by_id($id);
		
		// cek exist
		if($old_code != $code) {
			if($this->m_global->check_exist($this->tabel, 'hospital_no', $code) == TRUE) {
				$this->session->set_flashdata('message', 'Hospital No. already exist.');
				$this->session->set_flashdata('status', get_notify_status(9));
				
				get_redirecting('hospitals');
			}
		}
		
		// config upload
		$file 						= "";	
		$upload_path				= "./assets/uploads/hospital";
		$config['upload_path']   	= $upload_path;
		$config['allowed_types'] 	= "jpg|jpeg|png"; 
		$config['max_size']     	= "2000";
		
		$this->load->library('upload', $config);

		$img = $this->m_hospital->get_file_by_id($id);
		if ( ! $this->upload->do_upload()) {
			$file = $img;	
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('message', $error['error']);
			$this->session->set_flashdata('status', get_notify_status(0));
		}
		else {
			$data = array('upload_data' => $this->upload->data());
			$file = $data['upload_data']['file_name'];
			
			$params =  $upload_path .'/'. $file;
			$res 	= thumbnail($params, 'thumb'); 
			
			// delete image
			if($img != "") {
				$filestring = realpath(APPPATH .'.'. $upload_path .'/'. $img);
				@unlink ($filestring);
				
				$filethumb = realpath(APPPATH .'.'. $upload_path .'/thumb'.'/'. $img);
				@unlink ($filethumb);
			}
		}
		
		// set array
		$data = array(
			'hospital_status'		=> $status,
			'hospital_image'		=> $file,
			'hospital_no'			=> $code,
			'hospital_name'			=> handling_characters($name),
			'hospital_email'		=> $email,
			'hospital_phone'		=> (($phone == "")?NULL:$phone),
			'hospital_identity'		=> (($identity == "")?NULL:$identity),
			'hospital_latitude'		=> (($latitude == "")?NULL:$latitude),
			'hospital_longitude'	=> (($longitude == "")?NULL:$longitude),
			'hospital_address'		=> (($address == "")?NULL:nl2br($address)),
			'last_user'				=> $this->session->userdata('user_id')
		);
		
		// cek result
		$result = $this->m_crud->update($this->tabel, $this->field, $data, $id); 
		if($result == 0) {
			$this->session->set_flashdata('message', get_notification('update', 0));
			$this->session->set_flashdata('status', get_notify_status(0));
		}
		else {
			// insert facility
			$this->m_crud->delete('td_facility', 'hospital_id', $id);
			if(!empty($facility)) {
				foreach($facility as $row) {
					if($row != "") {
						$data_facility = array(
							'facility_id'	=> $row,
							'hospital_id' 	=> $id
						);
						
						$this->m_crud->insert_id('td_facility', $data_facility);
					}
				}
			}
			
			// insert specialist
			$this->m_crud->delete('td_specialist', 'hospital_id', $id);
			if(!empty($specialist)) {
				foreach($specialist as $row) {
					if($row != "") {
						$data_specialist = array(
							'specialist_id'	=> $row,
							'hospital_id' 	=> $id
						);
						
						$this->m_crud->insert_id('td_specialist', $data_specialist);
					}
				}
			}
		
			$this->session->set_flashdata('message', get_notification('update', 1));
			$this->session->set_flashdata('status', get_notify_status(1));
		}		
		
		get_redirecting('hospitals');
    }
}