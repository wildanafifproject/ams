<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends CI_Controller {

	public function __construct() {
    	parent::__construct();
	}

	public function index() {
		// set view
		$this->load->view('../v_header');
		$this->load->view('v_error');
		$this->load->view('../v_footer');
	}
}