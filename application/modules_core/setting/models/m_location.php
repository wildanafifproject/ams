<?php

class M_location extends CI_Model {

	public $tb = 'tm_location';
	public $fd = 'location_id';
	
	function get_name_by_id($id) {
        $this->db->select('location_name');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$location_name = $row->location_name;
			}    

			return $location_name;
		}
		else {
			return "";
		}	
    }
	
	function get_status_by_id($id) {
        $this->db->select('location_status');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$location_status = $row->location_status;
			}    

			return $location_status;
		}
		else {
			return 0;
		}	
    }
	
	function get_area_by_id($id) {
        $this->db->select('area_id');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$area_id = $row->area_id;
			}    

			return $area_id;
		}
		else {
			return 0;
		}	
    }
}		