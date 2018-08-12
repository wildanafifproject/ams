<?php

class M_specialist extends CI_Model {

	public $tb = 'tm_specialist';
	public $fd = 'specialist_id';
	
	function get_name_by_id($id) {
        $this->db->select('specialist_name');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$specialist_name = $row->specialist_name;
			}    

			return $specialist_name;
		}
		else {
			return "";
		}	
    }
	
	function get_status_by_id($id) {
        $this->db->select('specialist_status');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$specialist_status = $row->specialist_status;
			}    

			return $specialist_status;
		}
		else {
			return 0;
		}	
    }
}		