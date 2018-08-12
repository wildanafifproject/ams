<?php

class M_member extends CI_Model {

	public $tb = 'tm_member';
	public $fd = 'member_id';
	
	function get_code_by_id($id) {
        $this->db->select('member_no');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$member_no = $row->member_no;
			}    

			return $member_no;
		}
		else {
			return "";
		}	
    }
	
	function get_device_by_id($id) {
        $this->db->select('device_token');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$this->db->where('is_login', 1); 
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
	
	function get_socmed_by_id($id) {
        $this->db->select('socmed_token');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$socmed_token = $row->socmed_token;
			}    

			return $socmed_token;
		}
		else {
			return "";
		}	
    }
	
	function get_activation_by_id($id) {
        $this->db->select('activation_token');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$activation_token = $row->activation_token;
			}    

			return $activation_token;
		}
		else {
			return "";
		}	
    }
	
	function get_activation_code_by_id($id) {
        $this->db->select('activation_code');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$activation_code = $row->activation_code;
			}    

			return $activation_code;
		}
		else {
			return "";
		}	
    }
	
	function get_file_by_id($id) {
        $this->db->select('member_image');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$member_image = $row->member_image;
			}    

			return $member_image;
		}
		else {
			return "";
		}	
    }
	
	function get_status_by_id($id) {
        $this->db->select('member_status');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$member_status = $row->member_status;
			}    

			return $member_status;
		}
		else {
			return 0;
		}	
    }
	
	function get_password_by_id($id) {
        $this->db->select('member_password');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$member_password = $row->member_password;
			}    

			return $member_password;
		}
		else {
			return "";
		}	
    }
	
	function set_password($id, $pass) {
		$this->db->trans_begin();
		
		$this->db->set('member_password', $pass);
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