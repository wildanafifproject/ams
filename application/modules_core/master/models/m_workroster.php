<?php

class M_workroster extends CI_Model {

	public $tb = 'tm_workroster';
	public $fd = 'workroster_id';
	
	function get_name_by_id($id) {
        $this->db->select('workroster_name');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$workroster_name = $row->workroster_name;
			}    

			return $workroster_name;
		}
		else {
			return "";
		}	
    }
	
	function get_start_by_id($id) {
        $this->db->select('workroster_start');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$workroster_start = $row->workroster_start;
			}    

			return $workroster_start;
		}
		else {
			return "";
		}	
    }
	
	function get_end_by_id($id) {
        $this->db->select('workroster_end');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$workroster_end = $row->workroster_end;
			}    

			return $workroster_end;
		}
		else {
			return "";
		}	
    }
	
	function get_status_by_id($id) {
        $this->db->select('workroster_status');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$workroster_status = $row->workroster_status;
			}    

			return $workroster_status;
		}
		else {
			return 0;
		}	
    }
}		