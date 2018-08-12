<?php if(!defined('BASEPATH')) exit('Akses langsung tidak di perkenankan');

class Category extends CI_Controller {

	public $tabel = 'tm_category';
	public $field = 'category_id';
	
    public function __construct() {
    	parent::__construct();
		
		if ($this->session->userdata('login') == TRUE) {	
			if($this->session->userdata('user_authority') == 0) { 
				$this->load->helper('message');
				$this->load->helper('status');
				
				$this->load->model('m_category');
				
				// set nav active
				$this->session->set_userdata('nav_active', 'setting');
				
				// set sub active
				$this->session->set_userdata('sub_active', 'category');
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
		// set data
		$data['list'] = $this->m_global->get_all($this->tabel);
		
		// set view
		$this->load->view('../v_header');
		$this->load->view('../v_top');
		$this->load->view('category/v_list', $data);
		$this->load->view('../v_bottom');
		$this->load->view('../v_footer');
    }
	
	function add_data() {
		// set view
		$this->load->view('../v_header');
		$this->load->view('../v_top');
		$this->load->view('category/v_add');
		$this->load->view('../v_bottom');
		$this->load->view('../v_footer');
    }
	
	function insert_data() {
		// cek validate form
		$valid = simple_decrypt($this->input->post('valid'));
		if($valid != 1) {
			get_redirecting('setting/category');
		}
		
		// get from post
		$name	= $this->input->post('name');
		$status	= $this->input->post('status');
		$check	= $this->input->post('check');
		
		// set array
		$data = array(
			'category_status'	=> $status,
			'category_name'		=> handling_characters($name),
			'is_emeregency'		=> $check,
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

		get_redirecting('setting/category');
    }
	
	function edit_data() {
		// get data
		$id = simple_decrypt($this->uri->segment(4));
		
		// cek id
		if($id == "") {
            get_redirecting('setting/category');
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
				$this->load->view('category/v_edit', $data);
				$this->load->view('../v_bottom');
				$this->load->view('../v_footer');
			}
		}
    }
	
	function update_data() {
		// cek validate form
		$valid = simple_decrypt($this->input->post('valid'));
		if($valid != 1) {
			get_redirecting('setting/category');
		}
		
		// get from post
		$id		= simple_decrypt($this->input->post('id'));
		$name	= $this->input->post('name');
		$status	= $this->input->post('status');
		$check	= $this->input->post('check');
		
		// set array
		$data = array(
			'category_status'	=> $status,
			'category_name'		=> handling_characters($name),
			'is_emeregency'		=> $check,
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
		
		get_redirecting('setting/category');
    }
}