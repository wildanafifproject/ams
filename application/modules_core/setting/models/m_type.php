<?php

class M_type extends CI_Model {

	public $tb = 'tm_type';
	public $fd = 'type_id';
	
	function get_name_by_id($id) {
        $this->db->select('type_name');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$type_name = $row->type_name;
			}    

			return $type_name;
		}
		else {
			return "";
		}	
    }
	
	function get_status_by_id($id) {
        $this->db->select('type_status');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$type_status = $row->type_status;
			}    

			return $type_status;
		}
		else {
			return 0;
		}	
    }
	
	function get_case_by_id($id) {
        $this->db->select('case_id');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$case_id = $row->case_id;
			}    

			return $case_id;
		}
		else {
			return 0;
		}	
    }
}		