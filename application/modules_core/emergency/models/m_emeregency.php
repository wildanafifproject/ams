<?php

class M_emeregency extends CI_Model {

	public $tb = 'tp_emergency';
	public $fd = 'emergency_id';
	
	function get_callreference_by_id($id) {
        $this->db->select('emergency_callreference');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$emergency_callreference = $row->emergency_callreference;
			}    

			return $emergency_callreference;
		}
		else {
			return "";
		}	
    }
	
	function get_phone_by_id($id) {
        $this->db->select('emergency_phone');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$emergency_phone = $row->emergency_phone;
			}    

			return $emergency_phone;
		}
		else {
			return "";
		}	
    }
	
	function get_callername_by_id($id) {
        $this->db->select('emergency_callername');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$emergency_callername = $row->emergency_callername;
			}    

			return $emergency_callername;
		}
		else {
			return "";
		}	
    }
	
	function get_callerphone_by_id($id) {
        $this->db->select('emergency_callerphone');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$emergency_callerphone = $row->emergency_callerphone;
			}    

			return $emergency_callerphone;
		}
		else {
			return "";
		}	
    }
	
	function get_patienttotal_by_id($id) {
        $this->db->select('emergency_patienttotal');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$emergency_patienttotal = $row->emergency_patienttotal;
			}    

			return $emergency_patienttotal;
		}
		else {
			return 0;
		}	
    }
	
	function get_patientunconscious_by_id($id) {
        $this->db->select('emergency_patientunconscious');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$emergency_patientunconscious = $row->emergency_patientunconscious;
			}    

			return $emergency_patientunconscious;
		}
		else {
			return 0;
		}	
    }
	
	function get_status_by_id($id) {
        $this->db->select('emeregency_status');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$emeregency_status = $row->emeregency_status;
			}    

			return $emeregency_status;
		}
		else {
			return 0;
		}	
    }
	
	function get_source_by_id($id) {
        $this->db->select('source_id');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$source_id = $row->source_id;
			}    

			return $source_id;
		}
		else {
			return 0;
		}	
    }
	
	function get_forward_by_id($id) {
        $this->db->select('forward_id');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$forward_id = $row->forward_id;
			}    

			return $forward_id;
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
	
	function get_location_by_id($id) {
        $this->db->select('location_id');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$location_id = $row->location_id;
			}    

			return $location_id;
		}
		else {
			return 0;
		}	
    }
	
	function get_ambulance_by_id($id) {
        $this->db->select('ambulance_id');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$ambulance_id = $row->ambulance_id;
			}    

			return $ambulance_id;
		}
		else {
			return 0;
		}	
    }
}		