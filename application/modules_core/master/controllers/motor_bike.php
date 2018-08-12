<?php if(!defined('BASEPATH')) exit('Akses langsung tidak di perkenankan');

class Motor_bike extends CI_Controller {

	public $tabel = 'tm_motorbike';
	public $field = 'motorbike_id';
	
    public function __construct() {
    	parent::__construct();
		
		if ($this->session->userdata('login') == TRUE) {	
			$this->load->helper('message');
			$this->load->helper('status');
			$this->load->helper('image');
			
			$this->load->model('m_motorbike');
			$this->load->model('m_hospital');
			$this->load->model('setting/m_area');
			
			// set nav active
			$this->session->set_userdata('nav_active', 'master');
			
			// set sub active
			$this->session->set_userdata('sub_active', 'motorbike');
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
		$this->load->view('motorbike/v_list', $data);
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
		$this->load->view('motorbike/v_add', $data);
		$this->load->view('../v_bottom');
		$this->load->view('../v_footer');
    }
	
	function insert_data() {
		// cek validate form
		$valid = simple_decrypt($this->input->post('valid'));
		if($valid != 1) {
			get_redirecting('master/motor-bike');
		}
		
		// get from post
		$username	= $this->input->post('username');
		$password	= $this->input->post('password');
		$code		= $this->input->post('code');
		$plat		= $this->input->post('plat');
		$hospital	= $this->input->post('hospital');
		$area		= $this->input->post('area');
		$status		= $this->input->post('status');
		$check		= $this->input->post('check');
		
		// set session
		$this->session->set_flashdata('code', $code);
		$this->session->set_flashdata('plat', $plat);
		$this->session->set_flashdata('hospital', $hospital);
		$this->session->set_flashdata('status', $status);
		
		// cek exist
		if($this->m_global->check_exist($this->tabel, 'motorbike_username', $username) == TRUE) {
			$this->session->set_flashdata('message', 'Username already exist.');
			$this->session->set_flashdata('status', get_notify_status(9));
			
			get_redirecting('master/motor-bike/add-data');
		}
		
		// cek exist
		if($this->m_global->check_exist($this->tabel, 'motorbike_no', $code) == TRUE) {
			$this->session->set_flashdata('message', 'motorbike No. already exist.');
			$this->session->set_flashdata('status', get_notify_status(9));
			
			get_redirecting('master/motor-bike/add-data');
		}
		
		// cek exist
		if($this->m_global->check_exist($this->tabel, 'motorbike_police', $plat) == TRUE) {
			$this->session->set_flashdata('message', 'motorbike Police No. already exist.');
			$this->session->set_flashdata('status', get_notify_status(9));
			
			get_redirecting('master/motor-bike/add-data');
		}
		
		// config upload
		$file 						= "";	
		$upload_path				= "./assets/uploads/motorbike";
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
			'motorbike_image'		=> $file,
			'motorbike_username'	=> usernaming($username),
			'motorbike_password'	=> $password,
			'motorbike_status'		=> $status,
			'motorbike_no'			=> $code,
			'motorbike_police'		=> $plat,
			'hospital_id'			=> $hospital,
			'area_id'				=> $area,
			'is_login'				=> $check,
			'last_user'				=> $this->session->userdata('user_id')
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

		get_redirecting('master/motor-bike');
    }
	
	function edit_data() {
		// get data
		$id = simple_decrypt($this->uri->segment(4));
		
		// cek id
		if($id == "") {
            get_redirecting('master/motor-bike');
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
				$this->load->view('motorbike/v_edit', $data);
				$this->load->view('../v_bottom');
				$this->load->view('../v_footer');
			}
		}
    }
	
	function update_data() {
		// cek validate form
		$valid = simple_decrypt($this->input->post('valid'));
		if($valid != 1) {
			get_redirecting('master/motor-bike');
		}
		
		// get from post
		$id			= simple_decrypt($this->input->post('id'));
		$code		= $this->input->post('code');
		$plat		= $this->input->post('plat');
		$hospital	= $this->input->post('hospital');
		$area		= $this->input->post('area');
		$status		= $this->input->post('status');
		$check		= $this->input->post('check');
		
		// cek old
		$old_code = $this->m_motorbike->get_code_by_id($id);
		
		// cek exist
		if($old_code != $code) {
			if($this->m_global->check_exist($this->tabel, 'motorbike_no', $code) == TRUE) {
				$this->session->set_flashdata('message', 'motorbike No. already exist.');
				$this->session->set_flashdata('status', get_notify_status(9));
				
				get_redirecting('master/motor-bike/edit-data/'. simple_encrypt($id));
			}
		}
		
		// cek old
		$old_plat = $this->m_motorbike->get_plat_by_id($id);
		
		// cek exist
		if($old_plat != $plat) {
			if($this->m_global->check_exist($this->tabel, 'motorbike_police', $plat) == TRUE) {
				$this->session->set_flashdata('message', 'motorbike Police No. already exist.');
				$this->session->set_flashdata('status', get_notify_status(9));
				
				get_redirecting('master/motor-bike/edit-data/'. simple_encrypt($id));
			}
		}
		
		// config upload
		$file 						= "";	
		$upload_path				= "./assets/uploads/motorbike";
		$config['upload_path']   	= $upload_path;
		$config['allowed_types'] 	= "jpg|jpeg|png"; 
		$config['max_size']     	= "2000";
		
		$this->load->library('upload', $config);

		$img = $this->m_motorbike->get_file_by_id($id);
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
			'motorbike_image'	=> $file,
			'motorbike_status'	=> $status,
			'motorbike_police'	=> $plat,
			'motorbike_no'		=> $code,
			'hospital_id'		=> $hospital,
			'area_id'			=> $area,
			'is_login'			=> $check,
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
		
		get_redirecting('master/motor-bike');
    }
	
	function update_password() {
		// cek validate form
		$valid = simple_decrypt($this->input->post('valid'));
		if($valid != 1) {
			get_redirecting('master/motor-bike');
		}
		
		// get from post
		$id		= simple_decrypt($this->input->post('id'));
		$npass	= $this->input->post('password');
		$cpass	= $this->input->post('confirm_password');		
        
		if($npass != $cpass) {
			$this->session->set_flashdata("message", "Password doesn't match");
			$this->session->set_flashdata('status', get_notify_status(0));
			
			get_redirecting('motor-bike/edit-data/'. simple_encrypt($id));
		}
		else {
			// cek result
			$result = $this->m_motorbike->set_password($id, $npass);
			if($result == 0) {
				$this->session->set_flashdata('message', get_notification('update', 0));
				$this->session->set_flashdata('status', get_notify_status(0));
			}
			else {
				$this->session->set_flashdata('message', get_notification('update', 1));
				$this->session->set_flashdata('status', get_notify_status(1));
			}
		}
		
		get_redirecting('master/motor-bike');
    }
}