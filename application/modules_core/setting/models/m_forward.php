<?php

class M_forward extends CI_Model {

	public $tb = 'tm_forward';
	public $fd = 'forward_id';
	
	function get_name_by_id($id) {
        $this->db->select('forward_name');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$forward_name = $row->forward_name;
			}    

			return $forward_name;
		}
		else {
			return "";
		}	
    }
	
	function get_status_by_id($id) {
        $this->db->select('forward_status');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$forward_status = $row->forward_status;
			}    

			return $forward_status;
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