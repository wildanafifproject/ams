<?php

class M_category extends CI_Model {

	public $tb = 'tm_category';
	public $fd = 'category_id';
	
	function get_name_by_id($id) {
        $this->db->select('category_name');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$category_name = $row->category_name;
			}    

			return $category_name;
		}
		else {
			return "";
		}	
    }
	
	function get_status_by_id($id) {
        $this->db->select('category_status');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$category_status = $row->category_status;
			}    

			return $category_status;
		}
		else {
			return 0;
		}	
    }
}		