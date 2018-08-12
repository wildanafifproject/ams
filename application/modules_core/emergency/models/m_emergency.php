<?php

class M_emergency extends CI_Model {

	public $tb = 'tp_emergency';
	public $fd = 'emergency_id';
	
	function get_callreference_by_id($id) {
        $this->db->select('emergency_callreference');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$emergency_callreference = $row->emergency_callreference;
			}    

			return $emergency_callreference;
		}
		else {
			return "";
		}	
    }
	
	function get_phone_by_id($id) {
        $this->db->select('emergency_phone');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$emergency_phone = $row->emergency_phone;
			}    

			return $emergency_phone;
		}
		else {
			return "";
		}	
    }
	
	function get_callername_by_id($id) {
        $this->db->select('emergency_callername');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$emergency_callername = $row->emergency_callername;
			}    

			return $emergency_callername;
		}
		else {
			return "";
		}	
    }
	
	function get_callerphone_by_id($id) {
        $this->db->select('emergency_callerphone');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$emergency_callerphone = $row->emergency_callerphone;
			}    

			return $emergency_callerphone;
		}
		else {
			return "";
		}	
    }
	
	function get_patienttotal_by_id($id) {
        $this->db->select('emergency_patienttotal');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$emergency_patienttotal = $row->emergency_patienttotal;
			}    

			return $emergency_patienttotal;
		}
		else {
			return 0;
		}	
    }
	
	function get_patientunconscious_by_id($id) {
        $this->db->select('emergency_patientunconscious');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$emergency_patientunconscious = $row->emergency_patientunconscious;
			}    

			return $emergency_patientunconscious;
		}
		else {
			return 0;
		}	
    }
	
	function get_infolatitude_by_id($id) {
        $this->db->select('emergency_infolatitude');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$emergency_infolatitude = $row->emergency_infolatitude;
			}    

			return $emergency_infolatitude;
		}
		else {
			return "";
		}	
    }
	
	function get_infolongitude_by_id($id) {
        $this->db->select('emergency_infolongitude');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$emergency_infolongitude = $row->emergency_infolongitude;
			}    

			return $emergency_infolongitude;
		}
		else {
			return "";
		}	
    }
	
	function get_status_by_id($id) {
        $this->db->select('emergency_status');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$emergency_status = $row->emergency_status;
			}    

			return $emergency_status;
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
	
	function get_motorbike_by_id($id) {
        $this->db->select('motorbike_id');
		$this->db->from($this->tb);
		$this->db->where($this->fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$motorbike_id = $row->motorbike_id;
			}    

			return $motorbike_id;
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
	
	function get_archive() {
		$this->db->select('*');
		$this->db->from($this->tb);
		
		if($this->session->userdata('from') != ""){
			$this->db->where('emergency_date >=', date("Y-m-d", strtotime($this->session->userdata('from'))));
		}
		else{
			$this->db->where('MONTH(emergency_date)', date("m"));
			$this->db->where('YEAR(emergency_date)', date("Y"));
		}
		
		if($this->session->userdata('to') != ""){
			$this->db->where('emergency_date <=', date("Y-m-d", strtotime($this->session->userdata('to'))));
		}
		else{
			$this->db->where('MONTH(emergency_date)', date("m"));
			$this->db->where('YEAR(emergency_date)', date("Y"));
		}
		
		if($this->session->userdata('hospital') != ""){
			$this->db->where('hospital_id', $this->session->userdata('hospital'));
		}
		else {
			if($this->session->userdata('user_authority') == 1) { 
				$this->db->where('hospital_id', $this->session->userdata('hospital_id'));
			}
		}
		
		$this->db->order_by('emergency_id', 'DESC');
		$this->db->order_by('area_id', 'ASC');
		$query = $this->db->get();
        return $query->result();
	}
	
	function get_dashboard() {
		$this->db->select('*');
		$this->db->from($this->tb);
		
		if($this->session->userdata('call_ref') != ""){
			$this->db->where('emergency_id', $this->session->userdata('call_ref'));
		}
		
		if($this->session->userdata('hospital_emergency') != ""){
			$this->db->where('hospital_id', $this->session->userdata('hospital_emergency'));
		}
		else {
			if($this->session->userdata('user_authority') == 1) { 
				$this->db->where('hospital_id', $this->session->userdata('hospital_id'));
			}
		}
		
		$this->db->where_in('emergency_status', array(0,1,4,5,6,7,8,11,12,13));
		
		$this->db->order_by('emergency_id', 'DESC');
		$this->db->order_by('area_id', 'ASC');
		$query = $this->db->get();
        return $query->result();
	}
	
	function get_report_all() {
		$this->db->select('*');
		$this->db->from($this->tb);
		
		if($this->session->userdata('user_authority') == 1) { 
			$this->db->where('hospital_id', $this->session->userdata('hospital_id'));
		}
			
		if($this->session->userdata('from') != ""){
			$this->db->where('emergency_date >=', date("Y-m-d", strtotime($this->session->userdata('from'))));
		}
		else{
			$this->db->where('MONTH(emergency_date)', date("m"));
			$this->db->where('YEAR(emergency_date)', date("Y"));
		}
		
		if($this->session->userdata('to') != ""){
			$this->db->where('emergency_date <=', date("Y-m-d", strtotime($this->session->userdata('to'))));
		}
		else{
			$this->db->where('MONTH(emergency_date)', date("m"));
			$this->db->where('YEAR(emergency_date)', date("Y"));
		}
		
		$this->db->order_by('emergency_date', 'DESC');
		$this->db->order_by('area_id', 'ASC');
		$query = $this->db->get();
        return $query->result();
	}
	function getStatistic($fromDate='',$toDate='',$hospital_id)
	{
		$this->db->select('*,COUNT(*) AS total_pemakaian');
		$this->db->from($this->tb);
		
		if(!empty($fromDate)){
			$this->db->where('emergency_date >=', date("Y-m-d", strtotime($fromDate)));
		}
		else{
			$this->db->where('MONTH(emergency_date)', date("m"));
			$this->db->where('YEAR(emergency_date)', date("Y"));
		}
		
		if(!empty($toDate)){
			$this->db->where('emergency_date <=', date("Y-m-d", strtotime($toDate)));
		}
		else{
			$this->db->where('MONTH(emergency_date)', date("m"));
			$this->db->where('YEAR(emergency_date)', date("Y"));
		}
		
		if(!empty($hospital_id)){
			$this->db->where('hospital_id', $hospital_id);
		}
		
		$this->db->group_by('MONTH(emergency_date), YEAR(emergency_date)');
		
		$this->db->order_by('emergency_date', 'ASC');
		$query = $this->db->get();
        return $query->result();
	}

	// batas
	function get_total_cancel_emergency_case($fromDate='',$toDate='',$hospital_id) {
       	if(!empty($fromDate)){
			$this->db->where('emergency_date >=', date("Y-m-d", strtotime($fromDate)));
		}
		else{
			$this->db->where('MONTH(emergency_date)', date("m"));
			$this->db->where('YEAR(emergency_date)', date("Y"));
		}
		
		if(!empty($toDate)){
			$this->db->where('emergency_date <=', date("Y-m-d", strtotime($toDate)));
		}
		else{
			$this->db->where('MONTH(emergency_date)', date("m"));
			$this->db->where('YEAR(emergency_date)', date("Y"));
		}
		
		if(!empty($hospital_id)){
			$this->db->where('hospital_id', $hospital_id);
		}
		$this->db->where('emergency_status',2);
        $this->db->from($this->tb);
        return $this->db->count_all_results();
    }
	function get_total_emergency_case($fromDate='',$toDate='',$hospital_id) {
       	if(!empty($fromDate)){
			$this->db->where('emergency_date >=', date("Y-m-d", strtotime($fromDate)));
		}
		else{
			$this->db->where('MONTH(emergency_date)', date("m"));
			$this->db->where('YEAR(emergency_date)', date("Y"));
		}
		
		if(!empty($toDate)){
			$this->db->where('emergency_date <=', date("Y-m-d", strtotime($toDate)));
		}
		else{
			$this->db->where('MONTH(emergency_date)', date("m"));
			$this->db->where('YEAR(emergency_date)', date("Y"));
		}
		
		if(!empty($hospital_id)){
			$this->db->where('hospital_id', $hospital_id);
		}
		$this->db->where('emergency_status',9);
        $this->db->from($this->tb);
        return $this->db->count_all_results();
    }

    function getData($fromDate='',$toDate='',$hospital_id)
	{
		$this->db->select('*');
		$this->db->from($this->tb);
		
		if(!empty($fromDate)){
			$this->db->where('emergency_date >=', date("Y-m-d", strtotime($fromDate)));
		}
		else{
			$this->db->where('MONTH(emergency_date)', date("m"));
			$this->db->where('YEAR(emergency_date)', date("Y"));
		}
		
		if(!empty($toDate)){
			$this->db->where('emergency_date <=', date("Y-m-d", strtotime($toDate)));
		}
		else{
			$this->db->where('MONTH(emergency_date)', date("m"));
			$this->db->where('YEAR(emergency_date)', date("Y"));
		}
		
		if(!empty($hospital_id)){
			$this->db->where('hospital_id', $hospital_id);
		}
		$this->db->where('emergency_status',9);
		$this->db->order_by('emergency_date', 'ASC');
		$query = $this->db->get();
        return $query->result();
	}
	function countingAvgDate($totalPreAvg, $totalData)
	{
		$dt = explode(':', $totalPreAvg);
		$jam = $dt[0]*3600;
		$min = $dt[1]*60;
		$tmInSec = ($dt[2]+$jam+$min)/count($totalData);
		$hours = floor($tmInSec / 3600);
		$minutes = floor(($tmInSec / 60) % 60);
		$seconds = $tmInSec % 60;

		return "$hours:$minutes:$seconds";
	}
	function getAvgCrewNotifToDepart($fromDate='',$toDate='',$hospital_id)
	{
		$data = $this->getData($fromDate,$toDate,$hospital_id);
		$totalCall = 0;
		$totalPreAvg = '00:00:00';
		$totalRmoPreAvg = '00:00:00';
		foreach ($data as $key => $value) {
			$totalPreAvg = sum_the_time($totalPreAvg, sum_the_date($value->time_to_patient, $value->emergency_time));

			if(!is_null($value->time_call_patient)){
				$totalCall++;
				$totalRmoPreAvg = sum_the_time($totalRmoPreAvg, sum_the_date($value->time_call_patient, $value->time_to_patient));
			}
			
		}

		$retData = array(
			'notif_to_depart' => $this->countingAvgDate($totalPreAvg, count($data)),
			'rmo_to_patient' => $this->countingAvgDate($totalRmoPreAvg, $totalCall)
		);
		return $retData;
		

		
		//echo "<br>".$totalPreAvg;
		# code...
	}

}		