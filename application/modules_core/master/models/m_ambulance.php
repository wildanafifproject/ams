<?php

class M_ambulance extends CI_Model {

	public $tb = 'tm_ambulance';
	public $fd = 'ambulance_id';
	
	function get_code_by_id($id) {
        $this->db->select('ambulance_no');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$ambulance_no = $row->ambulance_no;
			}    

			return $ambulance_no;
		}
		else {
			return "";
		}	
    }
	
	function get_plat_by_id($id) {
        $this->db->select('ambulance_police');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$ambulance_police = $row->ambulance_police;
			}    

			return $ambulance_police;
		}
		else {
			return "";
		}	
    }
	
	function get_device_by_id($id) {
        $this->db->select('device_token');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$device_token = $row->device_token;
			}    

			return $device_token;
		}
		else {
			return "";
		}	
    }
	
	function get_latitude_by_id($id) {
        $this->db->select('ambulance_tracklatitude');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$ambulance_tracklatitude = $row->ambulance_tracklatitude;
			}    

			return $ambulance_tracklatitude;
		}
		else {
			return "";
		}	
    }
	
	function get_longitude_by_id($id) {
        $this->db->select('ambulance_tracklongitude');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$ambulance_tracklongitude = $row->ambulance_tracklongitude;
			}    

			return $ambulance_tracklongitude;
		}
		else {
			return "";
		}	
    }
	
	function get_rotation_by_id($id) {
        $this->db->select('ambulance_trackrotation');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$ambulance_trackrotation = $row->ambulance_trackrotation;
			}    

			return $ambulance_trackrotation;
		}
		else {
			return "";
		}	
    }
	
	function get_file_by_id($id) {
        $this->db->select('ambulance_image');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$ambulance_image = $row->ambulance_image;
			}    

			return $ambulance_image;
		}
		else {
			return "";
		}	
    }
	
	function get_status_by_id($id) {
        $this->db->select('ambulance_status');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$ambulance_status = $row->ambulance_status;
			}    

			return $ambulance_status;
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
        $this->db->select('ambulance_password');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$ambulance_password = $row->ambulance_password;
			}    

			return $ambulance_password;
		}
		else {
			return "";
		}	
    }
	
	function set_password($id, $pass) {
		$this->db->trans_begin();
		
		$this->db->set('ambulance_password', $pass);
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
	
	function get_dashboard() {
		$this->db->select('*');
		$this->db->from($this->tb);
		
		if($this->session->userdata('user_authority') == 1) { 
			$this->db->where('hospital_id', $this->session->userdata('hospital_id'));
		}
		
		if($this->session->userdata('hospital_ambulance') != ""){
			$this->db->where('hospital_id', $this->session->userdata('hospital_ambulance'));
		}
		
		$this->db->order_by('area_id', 'ASC');
		$this->db->order_by('hospital_id', 'ASC');
		$query = $this->db->get();
        return $query->result();
	}
	
	function get_booking_by_area_date_time($area, $date, $time) {
		$prev = convert_to_his($time);
		$next = next_time($prev, 2);
		
		$this->db->select('*');
		$this->db->from('tp_bookingambulance');
		
		$this->db->where('area_id', $area);
		$this->db->where("bookingambulance_date = '$date' AND bookingambulance_time > '$prev' AND bookingambulance_time < '$next'");
		$this->db->where('bookingambulance_status', 1);
		
		$this->db->order_by('area_id', 'ASC');
		$this->db->order_by('ambulance_id', 'ASC');
		$query = $this->db->get();
        return $query->result();
	}
	
	function get_booking_by_nonemergency($id) {
		$this->db->select('bookingambulance_id');
		$this->db->from('tp_bookingambulance');
		$this->db->where('nonemergency_id', $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$bookingambulance_id = $row->bookingambulance_id;
			}    

			return $bookingambulance_id;
		}
		else {
			return 0;
		}
	}
}		