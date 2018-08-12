<?php
/**
* 
*/
class Complaint extends CI_Controller
{
	private $dir_upload = './assets/uploads/complaint/';
	
	
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('login') == TRUE) {	
			$this->load->helper('message');
			$this->load->helper('status');
			$this->load->helper('image');
			$this->load->model('m_hospital');
			
			
			// set nav active
			$this->session->set_userdata('nav_active', 'report');
			
			// set sub active
			$this->session->set_userdata('sub_active', 'complaint');	
		}
		else {
			get_redirecting('login');
		}
		
	}
	function index()
	{
		if($this->session->userdata('user_authority') == 1) { 
			$data['list'] = $this->m_global->get_by_id_and_order('tp_complaint', 'hospital_id', $this->session->userdata('hospital_id'),'complaint_id','DESC');	
		}
		else {
			$data['list'] = $this->m_global->get_order('tp_complaint','complaint_id','DESC');
		}
		$this->load->model('m_hospital');
		// set view
		$this->load->view('../v_header');
		$this->load->view('../v_top');
		$this->load->view('v_list', $data);
		$this->load->view('../v_bottom');
		$this->load->view('../v_footer');
	}
	function add()
	{
		if(!isset($_POST['complaint'])){
			$this->load->view('../v_header');
			$this->load->view('../v_top');
			$this->load->view('/v_add');
			$this->load->view('../v_bottom');
			$this->load->view('../v_footer');
		}else{
			$data = $this->input->post();
			$this->load->library('Image_upload');
			$upload=$this->image_upload->upload('file',$this->dir_upload,"complaint_".time());
			if (!$upload['error']) {
				$params['file']=$upload['file_name'];
			}
			
			$params['description'] = $data['description'];
			$params['type'] = $data['type'];
			$params['name'] = $data['name'];
			if(is_null( $this->session->userdata('hospital_id'))){
				$params['hospital_id'] = '';
			}else{
				$params['hospital_id'] = $this->session->userdata('hospital_id');
			}			

			$result = $this->m_crud->insert('tp_complaint', $params);
			if($result == 0) {
				$this->session->set_flashdata('message', get_notification('insert', 0));
				$this->session->set_flashdata('status', get_notify_status(0));
			}
			else {
				$this->session->set_flashdata('message', get_notification('insert', 1));
				$this->session->set_flashdata('status', get_notify_status(1));
			}

			get_redirecting('complaint');
		}
		
	}
	function edit_data($complaint_id='')
	{
		$id = simple_decrypt($complaint_id);
		
		// cek id
		if($id == "") {
            get_redirecting('complaint');
        } 

        if(!isset($_POST['complaint'])){
        	$data['data'] =  $this->m_global->get_by_id2('tp_complaint','complaint_id',$id);
			$this->load->view('../v_header');
			$this->load->view('../v_top');
			$this->load->view('/v_edit',$data);
			$this->load->view('../v_bottom');
			$this->load->view('../v_footer');
		}else{
			// cek result
			$params['answer'] = $this->input->post('answer');
			$params['status'] = 1;
			$result = $this->m_crud->update('tp_complaint', 'complaint_id', $params, $id); 
			if($result == 0) {
				$this->session->set_flashdata('message', get_notification('update', 0));
				$this->session->set_flashdata('status', get_notify_status(0));
			}
			else {
				$this->session->set_flashdata('message', get_notification('update', 1));
				$this->session->set_flashdata('status', get_notify_status(1));
			}		
			
			get_redirecting('complaint');
		}
		
	}
}