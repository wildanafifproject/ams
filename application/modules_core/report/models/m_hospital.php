<?php

class M_hospital extends CI_Model {

	public $tb = 'tm_hospital';
	public $fd = 'hospital_id';
	
	function get_code_by_id($id) {
        $this->db->select('hospital_no');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$hospital_no = $row->hospital_no;
			}    

			return $hospital_no;
		}
		else {
			return "";
		}	
    }
	
	function get_name_by_id($id) {
        $this->db->select('hospital_name');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$hospital_name = $row->hospital_name;
			}    

			return $hospital_name;
		}
		else {
			return "";
		}	
    }
	
	function get_phone_by_id($id) {
        $this->db->select('hospital_phone');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$hospital_phone = $row->hospital_phone;
			}    

			return $hospital_phone;
		}
		else {
			return "";
		}	
    }
	
	function get_email_by_id($id) {
        $this->db->select('hospital_email');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$hospital_email = $row->hospital_email;
			}    

			return $hospital_email;
		}
		else {
			return "";
		}	
    }
	
	function get_latitude_by_id($id) {
        $this->db->select('hospital_latitude');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$hospital_latitude = $row->hospital_latitude;
			}    

			return $hospital_latitude;
		}
		else {
			return "";
		}	
    }
	
	function get_longitude_by_id($id) {
        $this->db->select('hospital_longitude');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$hospital_longitude = $row->hospital_longitude;
			}    

			return $hospital_longitude;
		}
		else {
			return "";
		}	
    }
	
	function get_address_by_id($id) {
        $this->db->select('hospital_address');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$hospital_address = $row->hospital_address;
			}    

			return $hospital_address;
		}
		else {
			return "";
		}	
    }
	
	function get_file_by_id($id) {
        $this->db->select('hospital_image');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$hospital_image = $row->hospital_image;
			}    

			return $hospital_image;
		}
		else {
			return "";
		}	
    }
	
	function get_status_by_id($id) {
        $this->db->select('hospital_status');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$hospital_status = $row->hospital_status;
			}    

			return $hospital_status;
		}
		else {
			return 0;
		}	
    }
	
	function get_area_by_id($id) {
        $this->db->select('area_id');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$area_id = $row->area_id;
			}    

			return $area_id;
		}
		else {
			return 0;
		}	
    }
}		