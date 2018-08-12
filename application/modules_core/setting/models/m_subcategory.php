<?php

class M_subcategory extends CI_Model {

	public $tb = 'tm_subcategory';
	public $fd = 'subcategory_id';
	
	function get_name_by_id($id) {
        $this->db->select('subcategory_name');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$subcategory_name = $row->subcategory_name;
			}    

			return $subcategory_name;
		}
		else {
			return "";
		}	
    }
	
	function get_status_by_id($id) {
        $this->db->select('subcategory_status');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$subcategory_status = $row->subcategory_status;
			}    

			return $subcategory_status;
		}
		else {
			return 0;
		}	
    }
	
	function get_category_by_id($id) {
        $this->db->select('category_id');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$category_id = $row->category_id;
			}    

			return $category_id;
		}
		else {
			return 0;
		}	
    }
}		