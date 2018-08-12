<?php if(!defined('BASEPATH')) exit('Akses langsung tidak di perkenankan');

class Work_roster extends CI_Controller {

	public $tabel = 'tm_workroster';
	public $field = 'workroster_id';
	
    public function __construct() {
    	parent::__construct();
		
		if ($this->session->userdata('login') == TRUE) {	
			$this->load->helper('message');
			$this->load->helper('status');
			
			$this->load->model('m_workroster');
			$this->load->model('m_hospital');
			
			// set nav active
			$this->session->set_userdata('nav_active', 'master');
			
			// set sub active
			$this->session->set_userdata('sub_active', 'workroster');	
		}
		else {
			get_redirecting('login');
		}
	}

    function index() {
		// set data
		$data['list'] = $this->m_global->get_all($this->tabel);
		
		// set view
		$this->load->view('../v_header');
		$this->load->view('../v_top');
		$this->load->view('workroster/v_list', $data);
		$this->load->view('../v_bottom');
		$this->load->view('../v_footer');
    }
	
	function add_data() {
		// set view
		$this->load->view('../v_header');
		$this->load->view('../v_top');
		$this->load->view('workroster/v_add');
		$this->load->view('../v_bottom');
		$this->load->view('../v_footer');
    }
	
	function insert_data() {
		// cek validate form
		$valid = simple_decrypt($this->input->post('valid'));
		if($valid != 1) {
			get_redirecting('master/work-roster');
		}
		
		// get from post
		$name			= $this->input->post('name');
		$start			= $this->input->post('start');
		$end			= $this->input->post('end');
		$description	= $this->input->post('description');
		$status			= $this->input->post('status');
		
		// cek time
		if(strtotime($start) > strtotime($end)) {
			// set session
			$this->session->set_flashdata('name', $name);
			$this->session->set_flashdata('description', $description);
			
			$this->session->set_flashdata('message', 'Error format time.');
			$this->session->set_flashdata('status', get_notify_status(2));
			
			get_redirecting('master/work-roster/add-data');
		}
		
		// set array
		$data = array(
			'workroster_status'			=> $status,
			'workroster_name'			=> handling_characters($name),
			'workroster_start'			=> convert_to_his($start),
			'workroster_end'			=> convert_to_his($end),
			'workroster_description'	=> (($description == "")?NULL:nl2br($description)),
			'last_user'					=> $this->session->userdata('user_id')
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

		get_redirecting('master/work-roster');
    }
	
	function edit_data() {
		// get data
		$id = simple_decrypt($this->uri->segment(4));
		
		// cek id
		if($id == "") {
            get_redirecting('master/work-roster');
        } 
        else {
			// set data
			$data['detail'] = $this->m_global->get_by_id($this->tabel, $this->field, $id);
			
			// cek resut
			if($data['detail'] == null) {
                get_redirecting('error');
            }
			else {
				// set view
				$this->load->view('../v_header');
				$this->load->view('../v_top');
				$this->load->view('workroster/v_edit', $data);
				$this->load->view('../v_bottom');
				$this->load->view('../v_footer');
			}
		}
    }
	
	function update_data() {
		// cek validate form
		$valid = simple_decrypt($this->input->post('valid'));
		if($valid != 1) {
			get_redirecting('master/work-roster');
		}
		
		// get from post
		$id				= simple_decrypt($this->input->post('id'));
		$name			= $this->input->post('name');
		$start			= $this->input->post('start');
		$end			= $this->input->post('end');
		$description	= $this->input->post('description');
		$status			= $this->input->post('status');
		
		// cek time
		if(strtotime($start) > strtotime($end)) {
			// set session
			$this->session->set_flashdata('name', $name);
			$this->session->set_flashdata('description', $description);
			
			$this->session->set_flashdata('message', 'Error format time.');
			$this->session->set_flashdata('status', get_notify_status(2));
			
			get_redirecting('master/work-roster/edit-data/'. simple_encrypt($id));
		}
		
		// set array
		$data = array(
			'workroster_status'			=> $status,
			'workroster_name'			=> handling_characters($name),
			'workroster_start'			=> convert_to_his($start),
			'workroster_end'			=> convert_to_his($end),
			'workroster_description'	=> (($description == "")?NULL:nl2br($description)),
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
		
		get_redirecting('master/work-roster');
    }
}