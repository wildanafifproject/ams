<?php

class M_unit extends CI_Model {

	public $tb = 'tm_unit';
	public $fd = 'unit_id';
	
	function get_name_by_id($id) {
        $this->db->select('unit_name');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$unit_name = $row->unit_name;
			}    

			return $unit_name;
		}
		else {
			return "";
		}	
    }
	
	function get_status_by_id($id) {
        $this->db->select('unit_status');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$unit_status = $row->unit_status;
			}    

			return $unit_status;
		}
		else {
			return 0;
		}	
    }
}		