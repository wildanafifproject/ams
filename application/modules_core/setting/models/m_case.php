<?php

class M_case extends CI_Model {

	public $tb = 'tm_case';
	public $fd = 'case_id';
	
	function get_name_by_id($id) {
        $this->db->select('case_name');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$case_name = $row->case_name;
			}    

			return $case_name;
		}
		else {
			return "";
		}	
    }
	
	function get_status_by_id($id) {
        $this->db->select('case_status');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$case_status = $row->case_status;
			}    

			return $case_status;
		}
		else {
			return 0;
		}	
    }
}		