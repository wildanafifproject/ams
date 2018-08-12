<?php

class M_facility extends CI_Model {

	public $tb = 'tm_facility';
	public $fd = 'facility_id';
	
	function get_name_by_id($id) {
        $this->db->select('facility_name');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$facility_name = $row->facility_name;
			}    

			return $facility_name;
		}
		else {
			return "";
		}	
    }
	
	function get_status_by_id($id) {
        $this->db->select('facility_status');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$facility_status = $row->facility_status;
			}    

			return $facility_status;
		}
		else {
			return 0;
		}	
    }
}		