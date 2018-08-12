<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Change_password extends CI_Controller {

	public $tabel = 'tm_user';
	public $field = 'user_id';
	
	public function __construct() {
    	parent::__construct();
		
		if ($this->session->userdata('login') == TRUE){	
			$this->load->helper('message');
			$this->load->helper('status');
			
			$this->load->model('user/m_user');
			$this->load->model('m_global');
			
			// set nav active
			$this->session->unset_userdata('nav_active');
			
			// set sub active
			$this->session->unset_userdata('sub_active');
		}
		else {
			get_redirecting('login');
		}
	}

	public function index() {
		// set data
		$data['detail'] = $this->m_global->get_by_id($this->tabel, $this->field, $this->session->userdata('user_id'));
		
		// set view
		$this->load->view('../v_header');
		$this->load->view('../v_top');
		$this->load->view('main/v_change_password', $data);
		$this->load->view('../v_bottom');
		$this->load->view('../v_footer');
	}
	
	function update_password() {
		// get from post
		$id		= $this->session->userdata('user_id');
		$opass	= $this->input->post('o_pass');
		$npass	= $this->input->post('n_pass');
		$cpass	= $this->input->post('c_pass');		
        
		// get password
		$password = $this->m_user->get_password_by_id($id);
		
		if($opass != $password) {
			$this->session->set_flashdata('message', 'Invalid Password');
			$this->session->set_flashdata('status', get_notify_status(0));
		}
		else {
			if($npass != $cpass) {
				$this->session->set_flashdata("message", "Password doesn't match");
				$this->session->set_flashdata('status', get_notify_status(0));
			}
			else {
				// cek result
				$result = $this->m_user->set_password($id, $npass);
				if($result == 0) {
					$this->session->set_flashdata('message', get_notification('update', 0));
					$this->session->set_flashdata('status', get_notify_status(0));
				}
				else {
					$this->session->set_flashdata('message', get_notification('update', 1));
					$this->session->set_flashdata('status', get_notify_status(1));
				}
			}
		}
		
		get_redirecting('change-password');
    }
}