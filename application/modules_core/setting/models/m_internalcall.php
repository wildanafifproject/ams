<?php

class M_internalcall extends CI_Model {

	public $tb = 'tm_internalcall';
	public $fd = 'internalcall_id';
	
	function get_name_by_id($id) {
        $this->db->select('internalcall_name');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$internalcall_name = $row->internalcall_name;
			}    

			return $internalcall_name;
		}
		else {
			return "";
		}	
    }
	
	function get_status_by_id($id) {
        $this->db->select('internalcall_status');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$internalcall_status = $row->internalcall_status;
			}    

			return $internalcall_status;
		}
		else {
			return 0;
		}	
    }
}		