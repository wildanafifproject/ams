<?php

class M_doctor extends CI_Model {

	public $tb = 'tm_doctor';
	public $fd = 'doctor_id';
	
	function get_code_by_id($id) {
        $this->db->select('doctor_code');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$doctor_code = $row->doctor_code;
			}    

			return $doctor_code;
		}
		else {
			return "";
		}	
    }
	
	function get_name_by_id($id) {
        $this->db->select('doctor_name');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$doctor_name = $row->doctor_name;
			}    

			return $doctor_name;
		}
		else {
			return "";
		}	
    }
	
	function get_phone_by_id($id) {
        $this->db->select('doctor_phone');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$doctor_phone = $row->doctor_phone;
			}    

			return $doctor_phone;
		}
		else {
			return "";
		}	
    }
	
	function get_email_by_id($id) {
        $this->db->select('doctor_email');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$doctor_email = $row->doctor_email;
			}    

			return $doctor_email;
		}
		else {
			return "";
		}	
    }
	
	function get_file_by_id($id) {
        $this->db->select('doctor_image');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$doctor_image = $row->doctor_image;
			}    

			return $doctor_image;
		}
		else {
			return "";
		}	
    }
	
	function get_status_by_id($id) {
        $this->db->select('doctor_status');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$doctor_status = $row->doctor_status;
			}    

			return $doctor_status;
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
	
	function get_specialist_by_id($id) {
        $this->db->select('specialist_id');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$specialist_id = $row->specialist_id;
			}    

			return $specialist_id;
		}
		else {
			return 0;
		}	
    }
}		