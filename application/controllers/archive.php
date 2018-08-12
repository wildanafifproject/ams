<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Archive extends CI_Controller {

	public function __construct() {
    	parent::__construct();
		
		if ($this->session->userdata('login') == TRUE) {	
			$this->load->helper('message');
			$this->load->helper('status');
			
			// set nav active
			$this->session->set_userdata('nav_active', 'archive');
			
			// set sub active
			$this->session->unset_userdata('sub_active');
		}
		else {
			get_redirecting('login');
		}
	}

	public function index() {
		// set view
		$this->load->view('v_header');
		$this->load->view('v_top');
		$this->load->view('main/v_archive');
		$this->load->view('v_bottom');
		$this->load->view('v_footer');
	}
}