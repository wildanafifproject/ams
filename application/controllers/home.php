<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct() {
    	parent::__construct();
	}

	public function index() {
		// set view
		$this->load->view('v_header');
		$this->load->view('v_top');
		$this->load->view('v_home');
		$this->load->view('v_bottom');
		$this->load->view('v_footer');
	}
}