<?php

class M_transfer extends CI_Model {

	public $tb = 'tm_transfer';
	public $fd = 'transfer_id';
	
	function get_name_by_id($id) {
        $this->db->select('transfer_name');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$transfer_name = $row->transfer_name;
			}    

			return $transfer_name;
		}
		else {
			return "";
		}	
    }
	
	function get_status_by_id($id) {
        $this->db->select('transfer_status');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$transfer_status = $row->transfer_status;
			}    

			return $transfer_status;
		}
		else {
			return 0;
		}	
    }
}		