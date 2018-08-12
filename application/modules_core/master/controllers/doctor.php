<?php if(!defined('BASEPATH')) exit('Akses langsung tidak di perkenankan');

class Doctor extends CI_Controller {

	public $tabel = 'tm_doctor';
	public $field = 'doctor_id';
	
    public function __construct() {
    	parent::__construct();
		
		if ($this->session->userdata('login') == TRUE) {	
			$this->load->helper('message');
			$this->load->helper('status');
			$this->load->helper('image');
			
			$this->load->model('m_doctor');
			$this->load->model('m_hospital');
			$this->load->model('setting/m_specialist');
			
			// set nav active
			$this->session->set_userdata('nav_active', 'master');
			
			// set sub active
			$this->session->set_userdata('sub_active', 'doctor');
		}
		else {
			get_redirecting('login');
		}
	}

    function index() {
		// set data
		if($this->session->userdata('user_authority') == 1) { 
			$data['list'] = $this->m_global->get_by_id($this->tabel, 'hospital_id', $this->session->userdata('hospital_id'));	
		}
		else {
			$data['list'] = $this->m_global->get_all($this->tabel);
		}
		
		// set view
		$this->load->view('../v_header');
		$this->load->view('../v_top');
		$this->load->view('doctor/v_list', $data);
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
		$this->load->view('doctor/v_add', $data);
		$this->load->view('../v_bottom');
		$this->load->view('../v_footer');
    }
	
	function insert_data() {
		// cek validate form
		$valid = simple_decrypt($this->input->post('valid'));
		if($valid != 1) {
			get_redirecting('master/doctor');
		}
		
		// get from post
		$code		= $this->input->post('code');
		$name		= $this->input->post('name');
		$phone		= $this->input->post('phone');
		$email		= $this->input->post('email');
		$address	= $this->input->post('address');
		$hospital	= $this->input->post('hospital');
		$specialist	= $this->input->post('specialist');
		$status		= $this->input->post('status');
		
		// set session
		$this->session->set_flashdata('name', $name);
		$this->session->set_flashdata('phone', $phone);
		$this->session->set_flashdata('email', $email);
		$this->session->set_flashdata('address', $address);
		$this->session->set_flashdata('hospital', $hospital);
		$this->session->set_flashdata('specialist', $specialist);
		$this->session->set_flashdata('status', $status);
		
		// cek exist
		if($this->m_global->check_existing($this->tabel, 'doctor_code', $code, 'hospital_id', $hospital) == TRUE) {
			$this->session->set_flashdata('message', 'Code already exist.');
			$this->session->set_flashdata('status', get_notify_status(9));
			
			get_redirecting('master/doctor/add-data');
		}
		
		// config upload
		$file 						= "";	
		$upload_path				= "./assets/uploads/doctor";
		$config['upload_path']   	= $upload_path;
		$config['allowed_types'] 	= "jpg|jpeg|png"; 
		$config['max_size']     	= "2000";
		
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload()) {
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('message', $error['error']);
			$this->session->set_flashdata('status', get_notify_status(0));
		}
		else {
			$data = array('upload_data' => $this->upload->data());
			$file = $data['upload_data']['file_name'];
			
			$params =  $upload_path .'/'. $file;
			$res 	= thumbnail($params, 'thumb'); 
		}
		
		// set array
		$data = array(
			'doctor_status'		=> $status,
			'doctor_image'		=> $file,
			'doctor_code'		=> $code,
			'doctor_name'		=> handling_characters($name),
			'doctor_phone'		=> $phone,
			'doctor_email'		=> $email,
			'doctor_address'	=> (($address == "")?NULL:nl2br($address)),
			'hospital_id'		=> $hospital,
			'specialist_id'		=> $specialist,
			'last_user'			=> $this->session->userdata('user_id')
		);
		
		// cek result
		$result = $this->m_crud->insert($this->tabel, $data);
		if($result == 0) {
			$this->session->set_flashdata('message', get_notification('insert', 0));
			$this->session->set_flashdata('status', get_notify_status(0));
		}
		else {
			$this->session->set_flashdata('message', get_notification('insert', 1));
			$this->session->set_flashdata('status', get_notify_status(1));
		}

		get_redirecting('master/doctor');
    }
	
	function edit_data() {
		// get data
		$id = simple_decrypt($this->uri->segment(4));
		
		// cek id
		if($id == "") {
            get_redirecting('master/doctor');
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
				if($this->session->userdata('user_authority') == 1) { 
					$data['hospital'] = $this->m_global->get_by_double_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', $this->session->userdata('hospital_id'), 'hospital_id', 'ASC');
				}
				else {
					$data['hospital'] = $this->m_global->get_by_id_and_order('tm_hospital', 'hospital_status', 1, 'hospital_id', 'ASC'); 
				}
				
				// set view
				$this->load->view('../v_header');
				$this->load->view('../v_top');
				$this->load->view('doctor/v_edit', $data);
				$this->load->view('../v_bottom');
				$this->load->view('../v_footer');
			}
		}
    }
	
	function update_data() {
		// cek validate form
		$valid = simple_decrypt($this->input->post('valid'));
		if($valid != 1) {
			get_redirecting('master/doctor');
		}
		
		// get from post
		$id			= simple_decrypt($this->input->post('id'));
		$code		= $this->input->post('code');
		$name		= $this->input->post('name');
		$phone		= $this->input->post('phone');
		$email		= $this->input->post('email');
		$address	= $this->input->post('address');
		$hospital	= $this->input->post('hospital');
		$specialist	= $this->input->post('specialist');
		$status		= $this->input->post('status');
		
		// cek old
		$old_code = $this->m_doctor->get_code_by_id($id);
		
		// cek exist
		if($old_code != $code) {
			if($this->m_global->check_existing($this->tabel, 'doctor_code', $code, 'hospital_id', $hospital) == TRUE) {
				$this->session->set_flashdata('message', 'Code already exist.');
				$this->session->set_flashdata('status', get_notify_status(9));
				
				get_redirecting('master/doctor/edit-data/'. simple_encrypt($id));
			}
		}
		
		// cek old
		$old_hospital = $this->m_doctor->get_hospital_by_id($id);
		
		// cek exist
		if($old_hospital != $hospital) {
			if($this->m_global->check_existing($this->tabel, 'doctor_code', $code, 'hospital_id', $hospital) == TRUE) {
				$this->session->set_flashdata('message', 'Code already exist.');
				$this->session->set_flashdata('status', get_notify_status(9));
				
				get_redirecting('master/doctor/edit-data/'. simple_encrypt($id));
			}
		}
		
		// config upload
		$file 						= "";	
		$upload_path				= "./assets/uploads/doctor";
		$config['upload_path']   	= $upload_path;
		$config['allowed_types'] 	= "jpg|jpeg|png"; 
		$config['max_size']     	= "2000";
		
		$this->load->library('upload', $config);

		$img = $this->m_doctor->get_file_by_id($id);
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
			'doctor_status'		=> $status,
			'doctor_image'		=> $file,
			'doctor_code'		=> $code,
			'doctor_name'		=> handling_characters($name),
			'doctor_phone'		=> $phone,
			'doctor_email'		=> $email,
			'doctor_address'	=> (($address == "")?NULL:nl2br($address)),
			'hospital_id'		=> $hospital,
			'specialist_id'		=> $specialist,
			'last_user'			=> $this->session->userdata('user_id')
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
		
		get_redirecting('master/doctor');
    }
}