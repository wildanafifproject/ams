<?php

class M_nonemergency extends CI_Model {

	public $tb = 'tp_nonemergency';
	public $fd = 'nonemergency_id';
	
	function get_callreference_by_id($id) {
        $this->db->select('nonemergency_callreference');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$nonemergency_callreference = $row->nonemergency_callreference;
			}    

			return $nonemergency_callreference;
		}
		else {
			return "";
		}	
    }
	
	function get_phone_by_id($id) {
        $this->db->select('nonemergency_phone');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$nonemergency_phone = $row->nonemergency_phone;
			}    

			return $nonemergency_phone;
		}
		else {
			return "";
		}	
    }
	
	function get_patientname_by_id($id) {
        $this->db->select('nonemergency_infoname');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$nonemergency_infoname = $row->nonemergency_infoname;
			}    

			return $nonemergency_infoname;
		}
		else {
			return "";
		}	
    }
	
	function get_callername_by_id($id) {
        $this->db->select('nonemergency_infoname');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$nonemergency_infoname = $row->nonemergency_infoname;
			}    

			return $nonemergency_infoname;
		}
		else {
			return "";
		}	
    }
	
	function get_callerphone_by_id($id) {
        $this->db->select('nonemergency_callerphone');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$nonemergency_callerphone = $row->nonemergency_callerphone;
			}    

			return $nonemergency_callerphone;
		}
		else {
			return "";
		}	
    }
	
	function get_patienttotal_by_id($id) {
        $this->db->select('nonemergency_patienttotal');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$nonemergency_patienttotal = $row->nonemergency_patienttotal;
			}    

			return $nonemergency_patienttotal;
		}
		else {
			return 0;
		}	
    }
	
	function get_patientunconscious_by_id($id) {
        $this->db->select('nonemergency_patientunconscious');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$nonemergency_patientunconscious = $row->nonemergency_patientunconscious;
			}    

			return $nonemergency_patientunconscious;
		}
		else {
			return 0;
		}	
    }
	
	function get_fromlatitude_by_id($id) {
        $this->db->select('nonemergency_fromlatitude');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$nonemergency_fromlatitude = $row->nonemergency_fromlatitude;
			}    

			return $nonemergency_fromlatitude;
		}
		else {
			return "";
		}	
    }
	
	function get_fromlongitude_by_id($id) {
        $this->db->select('nonemergency_fromlongitude');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$nonemergency_fromlongitude = $row->nonemergency_fromlongitude;
			}    

			return $nonemergency_fromlongitude;
		}
		else {
			return "";
		}	
    }
	
	function get_tolatitude_by_id($id) {
        $this->db->select('nonemergency_tolatitude');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$nonemergency_tolatitude = $row->nonemergency_tolatitude;
			}    

			return $nonemergency_tolatitude;
		}
		else {
			return "";
		}	
    }
	
	function get_tolongitude_by_id($id) {
        $this->db->select('nonemergency_tolongitude');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$nonemergency_tolongitude = $row->nonemergency_tolongitude;
			}    

			return $nonemergency_tolongitude;
		}
		else {
			return "";
		}	
    }
	
	function get_status_by_id($id) {
        $this->db->select('nonemergency_status');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$nonemergency_status = $row->nonemergency_status;
			}    

			return $nonemergency_status;
		}
		else {
			return 0;
		}	
    }
	
	function get_source_by_id($id) {
        $this->db->select('source_id');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$source_id = $row->source_id;
			}    

			return $source_id;
		}
		else {
			return 0;
		}	
    }
	
	function get_forward_by_id($id) {
        $this->db->select('forward_id');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$forward_id = $row->forward_id;
			}    

			return $forward_id;
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
	
	function get_location_by_id($id) {
        $this->db->select('location_id');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$location_id = $row->location_id;
			}    

			return $location_id;
		}
		else {
			return 0;
		}	
    }
	
	function get_ambulance_by_id($id) {
        $this->db->select('ambulance_id');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$ambulance_id = $row->ambulance_id;
			}    

			return $ambulance_id;
		}
		else {
			return 0;
		}	
    }
	
	function get_member_by_id($id) {
        $this->db->select('member_id');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$member_id = $row->member_id;
			}    

			return $member_id;
		}
		else {
			return 0;
		}	
    }
	
	function get_fromhospital_by_id($id) {
        $this->db->select('nonemergency_fromhospital');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$nonemergency_fromhospital = $row->nonemergency_fromhospital;
			}    

			return $nonemergency_fromhospital;
		}
		else {
			return 0;
		}	
    }
	
	function get_tohospital_by_id($id) {
        $this->db->select('nonemergency_tohospital');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$nonemergency_tohospital = $row->nonemergency_tohospital;
			}    

			return $nonemergency_tohospital;
		}
		else {
			return 0;
		}	
    }
	
	function get_archive() {
		$this->db->select('*');
		$this->db->from($this->tb);
		
		if($this->session->userdata('from') != ""){
			$this->db->where('nonemergency_date >=', date("Y-m-d", strtotime($this->session->userdata('from'))));
		}
		else{
			$this->db->where('MONTH(nonemergency_date)', date("m"));
			$this->db->where('YEAR(nonemergency_date)', date("Y"));
		}
		
		if($this->session->userdata('to') != ""){
			$this->db->where('nonemergency_date <=', date("Y-m-d", strtotime($this->session->userdata('to'))));
		}
		else{
			$this->db->where('MONTH(nonemergency_date)', date("m"));
			$this->db->where('YEAR(nonemergency_date)', date("Y"));
		}
		
		if($this->session->userdata('hospital') != ""){
			$this->db->where('nonemergency_fromhospital', $this->session->userdata('hospital'));
		}
		else {
			if($this->session->userdata('user_authority') == 1) { 
				$this->db->where('nonemergency_fromhospital', $this->session->userdata('hospital_id'));
			}
		}
		
		$this->db->order_by('nonemergency_id', 'DESC');
		$this->db->order_by('nonemergency_fromarea', 'ASC');
		$query = $this->db->get();
        return $query->result();
	}
	
	function get_dashboard() {
		$this->db->select('*');
		$this->db->from($this->tb);
		
		if($this->session->userdata('user_authority') == 1) { 
			$this->db->where('nonemergency_fromhospital', $this->session->userdata('hospital_id'));
		}
		
		if($this->session->userdata('from_nonemergency') != ""){
			$this->db->where('nonemergency_infodate >=', date("Y-m-d", strtotime($this->session->userdata('from_nonemergency'))));
		}
		else{
			$this->db->where('MONTH(nonemergency_date)', date("m"));
			$this->db->where('YEAR(nonemergency_date)', date("Y"));
		}
		
		if($this->session->userdata('to_nonemergency') != ""){
			$this->db->where('nonemergency_infodate <=', date("Y-m-d", strtotime($this->session->userdata('to_nonemergency'))));
		}
		else{
			$this->db->where('MONTH(nonemergency_date)', date("m"));
			$this->db->where('YEAR(nonemergency_date)', date("Y"));
		}
		
		$this->db->where_in('nonemergency_status', array(0,1,4,5,6,7,8,11,12,13,14));
		
		$this->db->order_by('nonemergency_id', 'DESC');
		$this->db->order_by('nonemergency_fromarea', 'ASC');
		$query = $this->db->get();
        return $query->result();
	}
	
	function get_report_all() {
		$this->db->select('*');
		$this->db->from($this->tb);
		
		if($this->session->userdata('user_authority') == 1) { 
			$this->db->where('nonemergency_fromhospital', $this->session->userdata('hospital_id'));
		}
		
		if($this->session->userdata('from') != ""){
			$this->db->where('nonemergency_date >=', date("Y-m-d", strtotime($this->session->userdata('from'))));
		}
		else{
			$this->db->where('MONTH(nonemergency_date)', date("m"));
			$this->db->where('YEAR(nonemergency_date)', date("Y"));
		}
		
		if($this->session->userdata('to') != ""){
			$this->db->where('nonemergency_date <=', date("Y-m-d", strtotime($this->session->userdata('to'))));
		}
		else{
			$this->db->where('MONTH(nonemergency_date)', date("m"));
			$this->db->where('YEAR(nonemergency_date)', date("Y"));
		}
		
		$this->db->order_by('nonemergency_date', 'DESC');
		$this->db->order_by('nonemergency_fromarea', 'ASC');
		$query = $this->db->get();
        return $query->result();
	}

	function getStatistic($fromDate='',$toDate='',$hospital_id)
	{
		$this->db->select('*,COUNT(*) AS total_pemakaian');
		$this->db->from($this->tb);
		
		if(!empty($fromDate)){
			$this->db->where('nonemergency_date >=', date("Y-m-d", strtotime($fromDate)));
		}
		else{
			$this->db->where('MONTH(nonemergency_date)', date("m"));
			$this->db->where('YEAR(nonemergency_date)', date("Y"));
		}
		
		if(!empty($toDate)){
			$this->db->where('nonemergency_date <=', date("Y-m-d", strtotime($toDate)));
		}
		else{
			$this->db->where('MONTH(nonemergency_date)', date("m"));
			$this->db->where('YEAR(nonemergency_date)', date("Y"));
		}
		
		if(!empty($hospital_id)){
			$this->db->where('nonemergency_fromhospital', $hospital_id);
		}
		
		$this->db->group_by('MONTH(nonemergency_date), YEAR(nonemergency_date)');
		
		$this->db->order_by('nonemergency_date', 'ASC');
		$query = $this->db->get();
        return $query->result();
	}

	//batas
	function get_total_cancel_nonemergency_case($fromDate='',$toDate='',$hospital_id)
	{
		
		if(!empty($fromDate)){
			$this->db->where('nonemergency_date >=', date("Y-m-d", strtotime($fromDate)));
		}
		else{
			$this->db->where('MONTH(nonemergency_date)', date("m"));
			$this->db->where('YEAR(nonemergency_date)', date("Y"));
		}
		
		if(!empty($toDate)){
			$this->db->where('nonemergency_date <=', date("Y-m-d", strtotime($toDate)));
		}
		else{
			$this->db->where('MONTH(nonemergency_date)', date("m"));
			$this->db->where('YEAR(nonemergency_date)', date("Y"));
		}
		
		if(!empty($hospital_id)){
			$this->db->where('nonemergency_fromhospital', $hospital_id);
		}
		
		$this->db->where('nonemergency_status',2);
        $this->db->from($this->tb);
        return $this->db->count_all_results();
	}
	function get_total_nonemergency_case($fromDate='',$toDate='',$hospital_id)
	{
		
		if(!empty($fromDate)){
			$this->db->where('nonemergency_date >=', date("Y-m-d", strtotime($fromDate)));
		}
		else{
			$this->db->where('MONTH(nonemergency_date)', date("m"));
			$this->db->where('YEAR(nonemergency_date)', date("Y"));
		}
		
		if(!empty($toDate)){
			$this->db->where('nonemergency_date <=', date("Y-m-d", strtotime($toDate)));
		}
		else{
			$this->db->where('MONTH(nonemergency_date)', date("m"));
			$this->db->where('YEAR(nonemergency_date)', date("Y"));
		}
		
		if(!empty($hospital_id)){
			$this->db->where('nonemergency_fromhospital', $hospital_id);
		}
		
		$this->db->where('nonemergency_status',9);
        $this->db->from($this->tb);
        return $this->db->count_all_results();
	}
}		