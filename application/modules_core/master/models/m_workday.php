<?php

class M_workday extends CI_Model {

	public $tb = 'tp_workday';
	public $fd = 'workday_id';
	
	function get_name_by_id($id) {
        $this->db->select('workday_name');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$workday_name = $row->workday_name;
			}    

			return $workday_name;
		}
		else {
			return "";
		}	
    }
	
	function get_date_by_id($id) {
        $this->db->select('workday_date');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$workday_date = $row->workday_date;
			}    

			return $workday_date;
		}
		else {
			return "";
		}	
    }
	
	function get_status_by_id($id) {
        $this->db->select('workday_status');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$workday_status = $row->workday_status;
			}    

			return $workday_status;
		}
		else {
			return 0;
		}	
    }
	
	function get_hospital_by_id($id) {
        $this->db->select('hospital_id');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$hospital_id = $row->hospital_id;
			}    

			return $hospital_id;
		}
		else {
			return 0;
		}	
    }
	
	function get_workroster_by_id($id) {
        $this->db->select('workroster_id');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$workroster_id = $row->workroster_id;
			}    

			return $workroster_id;
		}
		else {
			return 0;
		}	
    }
	
	function get_report_all() {
		$this->db->select('*');
		$this->db->from($this->tb);
		
		if($this->session->userdata('from') != ""){
			$this->db->where('workday_date >=', date("Y-m-d", strtotime($this->session->userdata('from'))));
		}
		else{
			$this->db->where('MONTH(workday_date)', date("m"));
			$this->db->where('YEAR(workday_date)', date("Y"));
		}
		
		if($this->session->userdata('to') != ""){
			$this->db->where('workday_date <=', date("Y-m-d", strtotime($this->session->userdata('to'))));
		}
		else{
			$this->db->where('MONTH(workday_date)', date("m"));
			$this->db->where('YEAR(workday_date)', date("Y"));
		}
		
		if($this->session->userdata('hospital') != ""){
			$this->db->where('hospital_id', $this->session->userdata('hospital'));
		}
		
		$this->db->order_by('workday_date', 'DESC');
		$this->db->order_by('hospital_id', 'ASC');
		$query = $this->db->get();
        return $query->result();
	}
}		