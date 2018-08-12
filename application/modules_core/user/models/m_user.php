<?php

class M_user extends CI_Model {

	public $tb = 'tm_user';
	public $fd = 'user_id';
	
	function get_name_by_id($id) {
        $this->db->select('user_fullname');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$user_fullname = $row->user_fullname;
			}    

			return $user_fullname;
		}
		else {
			return "";
		}	
    }
	
	function get_username_by_id($id) {
        $this->db->select('user_name');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$user_name = $row->user_name;
			}    

			return $user_name;
		}
		else {
			return "";
		}	
    }
	
	function get_password_by_id($id) {
        $this->db->select('user_password');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$user_password = $row->user_password;
			}    

			return $user_password;
		}
		else {
			return "";
		}	
    }
	
	function set_password($id, $pass) {
		$this->db->trans_begin();
		
		$this->db->set('user_password', $pass);
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
	
	function get_file_by_id($id) {
        $this->db->select('user_image');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$user_image = $row->user_image;
			}    

			return $user_image;
		}
		else {
			return "";
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
			return "";
		}	
    }
}		