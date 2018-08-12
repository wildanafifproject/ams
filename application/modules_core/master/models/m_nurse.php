<?php

class M_nurse extends CI_Model {

	public $tb = 'tm_nurse';
	public $fd = 'nurse_id';
	
	function get_code_by_id($id) {
        $this->db->select('nurse_code');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$nurse_code = $row->nurse_code;
			}    

			return $nurse_code;
		}
		else {
			return "";
		}	
    }
	
	function get_name_by_id($id) {
        $this->db->select('nurse_name');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$nurse_name = $row->nurse_name;
			}    

			return $nurse_name;
		}
		else {
			return "";
		}	
    }
	
	function get_phone_by_id($id) {
        $this->db->select('nurse_phone');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$nurse_phone = $row->nurse_phone;
			}    

			return $nurse_phone;
		}
		else {
			return "";
		}	
    }
	
	function get_file_by_id($id) {
        $this->db->select('nurse_image');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$nurse_image = $row->nurse_image;
			}    

			return $nurse_image;
		}
		else {
			return "";
		}	
    }
	
	function get_status_by_id($id) {
        $this->db->select('nurse_status');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$nurse_status = $row->nurse_status;
			}    

			return $nurse_status;
		}
		else {
			return 0;
		}	
    }
	
	function get_hospital_by_id($id) {
        $this->db->select('hospital_id');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$hospital_id = $row->hospital_id;
			}    

			return $hospital_id;
		}
		else {
			return 0;
		}	
    }
}		