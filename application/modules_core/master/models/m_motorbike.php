<?php

class M_motorbike extends CI_Model {

	public $tb = 'tm_motorbike';
	public $fd = 'motorbike_id';
	
	function get_code_by_id($id) {
        $this->db->select('motorbike_no');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$motorbike_no = $row->motorbike_no;
			}    

			return $motorbike_no;
		}
		else {
			return "";
		}	
    }
	
	function get_plat_by_id($id) {
        $this->db->select('motorbike_police');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$motorbike_police = $row->motorbike_police;
			}    

			return $motorbike_police;
		}
		else {
			return "";
		}	
    }
	
	function get_device_by_id($id) {
        $this->db->select('motorbike_device');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$motorbike_device = $row->motorbike_device;
			}    

			return $motorbike_device;
		}
		else {
			return "";
		}	
    }
	
	function get_latitude_by_id($id) {
        $this->db->select('motorbike_tracklatitude');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$motorbike_tracklatitude = $row->motorbike_tracklatitude;
			}    

			return $motorbike_tracklatitude;
		}
		else {
			return "";
		}	
    }
	
	function get_longitude_by_id($id) {
        $this->db->select('motorbike_tracklongitude');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$motorbike_tracklongitude = $row->motorbike_tracklongitude;
			}    

			return $motorbike_tracklongitude;
		}
		else {
			return "";
		}	
    }
	
	function get_rotation_by_id($id) {
        $this->db->select('motorbike_trackrotation');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$motorbike_trackrotation = $row->motorbike_trackrotation;
			}    

			return $motorbike_trackrotation;
		}
		else {
			return "";
		}	
    }

	function get_file_by_id($id) {
        $this->db->select('motorbike_image');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$motorbike_image = $row->motorbike_image;
			}    

			return $motorbike_image;
		}
		else {
			return "";
		}	
    }
	
	function get_status_by_id($id) {
        $this->db->select('motorbike_status');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$motorbike_status = $row->motorbike_status;
			}    

			return $motorbike_status;
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
	
	function get_password_by_id($id) {
        $this->db->select('motorbike_password');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$motorbike_password = $row->motorbike_password;
			}    

			return $motorbike_password;
		}
		else {
			return "";
		}	
    }
	
	function set_password($id, $pass) {
		$this->db->trans_begin();
		
		$this->db->set('motorbike_password', $pass);
		$this->db->where($this->fd, $id);
		$this->db->update($this->tb);
		
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return 0;
		}
		else {
			$this->db->trans_commit();
			return 1;
		}
	}
	
	function get_is_login_by_id($id) {
        $this->db->select('is_login');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$is_login = $row->is_login;
			}    

			return $is_login;
		}
		else {
			return 0;
		}	
    }
}		