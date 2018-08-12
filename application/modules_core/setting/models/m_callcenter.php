<?php

class M_callcenter extends CI_Model {

	public $tb = 'tm_callcenter';
	public $fd = 'callcenter_id';
	
	function get_name_by_id($id) {
        $this->db->select('callcenter_name');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$callcenter_name = $row->callcenter_name;
			}    

			return $callcenter_name;
		}
		else {
			return "";
		}	
    }
	
	function get_status_by_id($id) {
        $this->db->select('callcenter_status');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$callcenter_status = $row->callcenter_status;
			}    

			return $callcenter_status;
		}
		else {
			return 0;
		}	
    }
}		