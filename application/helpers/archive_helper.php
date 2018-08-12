<?php
	function get_time_response($time_confirmed, $time_booked) {
		$time_response = "00:00:00";
		if($time_confirmed != "" && $time_booked != "") {
			$time_response = sum_the_date($time_confirmed, $time_booked);
		}
		
		return $time_response;
	}
	
	function get_min_collect_data($time_set_crew, $time_booked) {
		$min_collect_data = "00:00:00";
		if($time_set_crew != "" && $time_booked != "") {
			$min_collect_data = sum_the_date($time_set_crew, $time_booked);
		}
		
		return $min_collect_data;
	}
	
	function get_min_leave_from_time_notification($time_to_patient, $time_set_crew) {
		$min_leave_from_time_notification = "00:00:00";
		if($time_to_patient != "" && $time_set_crew != "") {
			$min_leave_from_time_notification = sum_the_date($time_to_patient, $time_set_crew);
		}
		
		return $min_leave_from_time_notification;
	}
	
	function get_min_leave_from_original_call($time_to_patient, $time_booked) {
		$min_leave_from_original_call = "00:00:00";
		if($time_to_patient != "" && $time_booked != "") {
			$min_leave_from_original_call = sum_the_date($time_to_patient, $time_booked);
		}
		
		return $min_leave_from_original_call;
	}
	
	function get_min_call_patient_from_original_call($time_call_patient, $time_booked) {
		$min_call_patient_from_original_call = "00:00:00";
		if($time_call_patient != "" && $time_booked != "") {
			$min_call_patient_from_original_call = sum_the_date($time_call_patient, $time_booked);
		}
		
		return $min_call_patient_from_original_call;
	}
	
	function get_min_arrived_patient($time_arrived_patient, $time_call_patient) {
		$min_arrived_patient = "00:00:00";
		if($time_arrived_patient != "" && $time_call_patient != "") {
			$min_arrived_patient = sum_the_date($time_arrived_patient, $time_call_patient);
		}
		
		return $min_arrived_patient;
	}
	
	function get_min_arrived_patient_from_original_call($time_arrived_patient, $time_booked) {
		$min_arrived_patient_from_original_call = "00:00:00";
		if($time_arrived_patient != "" && $time_booked != "") {
			$min_arrived_patient_from_original_call = sum_the_date($time_arrived_patient, $time_booked);
		}
		
		return $min_arrived_patient_from_original_call;
	}
	
	function get_min_spent_patient($time_to_hospital, $time_arrived_patient) {
		$min_spent_patient = "00:00:00";
		if($time_to_hospital != "" && $time_arrived_patient != "") {
			$min_spent_patient = sum_the_date($time_to_hospital, $time_arrived_patient);
		}
		
		return $min_spent_patient;
	}
	
	function get_min_arrived_hospital($time_arrived_hospital, $time_to_hospital) {
		$min_arrived_hospital = "00:00:00";
		if($time_arrived_hospital != "" && $time_to_hospital != "") {
			$min_arrived_hospital = sum_the_date($time_arrived_hospital, $time_to_hospital);
		}
		
		return $min_arrived_hospital;
	}
	
	function get_min_spent_trip($time_arrived_hospital, $time_to_patient) {
		$min_spent_trip = "00:00:00";
		if($time_arrived_hospital != "" && $time_to_patient != "") {
			$min_spent_trip = sum_the_date($time_arrived_hospital, $time_to_patient);
		}
		
		return $min_spent_trip;
	}
	
	function get_min_arrived_hospital_from_original_call($time_arrived_hospital, $time_booked) {
		$min_arrived_hospital_from_original_call = "00:00:00";
		if($time_arrived_hospital != "" && $time_booked != "") {
			$min_arrived_hospital_from_original_call = sum_the_date($time_arrived_hospital, $time_booked);
		}
		
		return $min_arrived_hospital_from_original_call;
	}
	
	function get_min_spent_hospital($time_back_hospital, $time_arrived_hospital) {
		$min_spent_hospital = "00:00:00";
		if($time_back_hospital != "" && $time_arrived_hospital != "") {
			$min_spent_hospital = sum_the_date($time_back_hospital, $time_arrived_hospital);
		}
		
		return $min_spent_hospital;
	}
	
	function get_min_arrived_back_hospital($time_complete, $time_complete) {
		$min_arrived_back_hospital = "00:00:00";
		if($time_complete != "" && $time_complete != "") {
			$min_arrived_back_hospital = sum_the_date($time_complete, $time_complete);
		}
		
		return $min_arrived_back_hospital;
	}
	
	function get_min_arrived_back_hospital_from_original_call($time_complete, $time_booked) {
		$min_arrived_back_hospital_from_original_call = "00:00:00";
		if($time_booked != "" && $time_booked != "") {
			$min_arrived_back_hospital_from_original_call = sum_the_date($time_complete, $time_booked);
		}
		
		return $min_arrived_back_hospital_from_original_call;
	}
?>