<?php

class M_patient extends CI_Model {

	public $tb = 'tm_patient';
	public $fd = 'patient_id';
	
	function get_name_by_id($id) {
        $this->db->select('patient_name');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$patient_name = $row->patient_name;
			}    

			return $patient_name;
		}
		else {
			return "";
		}	
    }
	
	function get_dob_by_id($id) {
        $this->db->select('patient_dob');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$patient_dob = $row->patient_dob;
			}    

			return $patient_dob;
		}
		else {
			return "";
		}	
    }
	
	function get_phone_by_id($id) {
        $this->db->select('patient_phone');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$patient_phone = $row->patient_phone;
			}    

			return $patient_phone;
		}
		else {
			return "";
		}	
    }
	
	function get_id_by_phone($id) {
        $this->db->select('patient_id');
		$this->db->from($this->tb);
		$this->db->where('patient_phone', $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$patient_id = $row->patient_id;
			}    

			return $patient_id;
		}
		else {
			return 0;
		}	
    }
	
	function get_id_by_phone_name_dob($phone, $name, $dob) {
        $this->db->select('patient_id');
		$this->db->from($this->tb);
		$this->db->where('patient_phone', $phone); 
		$this->db->where('patient_name', $name); 
		$this->db->where('patient_dob', $dob); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$patient_id = $row->patient_id;
			}    

			return $patient_id;
		}
		else {
			return 0;
		}	
    }
	
	function get_name_by_phone($id) {
        $this->db->select('patient_name');
		$this->db->from($this->tb);
		$this->db->where('patient_phone', $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$patient_name = $row->patient_name;
			}    

			return $patient_name;
		}
		else {
			return "";
		}	
    }
	
	function get_dob_by_phone_name($phone, $name) {
        $this->db->select('patient_dob');
		$this->db->from($this->tb);
		$this->db->where('patient_phone', $phone); 
		$this->db->where('patient_name', $name); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$patient_dob = $row->patient_dob;
			}    

			return $patient_dob;
		}
		else {
			return "";
		}	
    }
}		