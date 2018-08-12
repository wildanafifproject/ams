<?php

class M_source extends CI_Model {

	public $tb = 'tm_source';
	public $fd = 'source_id';
	
	function get_name_by_id($id) {
        $this->db->select('source_name');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$source_name = $row->source_name;
			}    

			return $source_name;
		}
		else {
			return "";
		}	
    }
	
	function get_status_by_id($id) {
        $this->db->select('source_status');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$source_status = $row->source_status;
			}    

			return $source_status;
		}
		else {
			return 0;
		}	
    }
}		