<?php
/**
* 
*/
class Test extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}
	function index($value='')
	{
		$data['data']=$this->db->get('tm_ambulance')->result_array();
		$this->load->view('test',$data);
	}
}