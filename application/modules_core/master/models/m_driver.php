<?php

class M_driver extends CI_Model {

	public $tb = 'tm_driver';
	public $fd = 'driver_id';
	
	function get_code_by_id($id) {
        $this->db->select('driver_code');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$driver_code = $row->driver_code;
			}    

			return $driver_code;
		}
		else {
			return "";
		}	
    }
	
	function get_name_by_id($id) {
        $this->db->select('driver_name');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$driver_name = $row->driver_name;
			}    

			return $driver_name;
		}
		else {
			return "";
		}	
    }
	
	function get_phone_by_id($id) {
        $this->db->select('driver_phone');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$driver_phone = $row->driver_phone;
			}    

			return $driver_phone;
		}
		else {
			return "";
		}	
    }
	
	function get_file_by_id($id) {
        $this->db->select('driver_image');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$driver_image = $row->driver_image;
			}    

			return $driver_image;
		}
		else {
			return "";
		}	
    }
	
	function get_status_by_id($id) {
        $this->db->select('driver_status');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$driver_status = $row->driver_status;
			}    

			return $driver_status;
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