<?php
	function get_status($status) {
		switch($status) {
			case 1 : 
				$status = "Active";
			break;
			case 0 : 
				$status = "Not Active";
			break;
		}
		
		return $status;
	}
	
	function get_yes_no($status) {
		switch($status) {
			case 1 : 
				$status = "Yes";
			break;
			case 0 : 
				$status = "No";
			break;
		}
		
		return $status;
	}
	
	function get_true_false($status) {
		switch($status) {
			case 1 : 
				$status = "True";
			break;
			case 0 : 
				$status = "False";
			break;
		}
		
		return $status;
	}
	
	function get_authority($status) {
		switch($status) {
			case 2 : 
				$status = "SACC";
			break;
			case 1 : 
				$status = "Operator";
			break;
			case 0 : 
				$status = "Administrator";
			break;
		}
		
		return $status;
	}
	
	function get_transaction($status) {
		switch($status) {
			case 14 : 
				$status = "Already";
			break;
			case 13 : 
				$status = "Arrive at hospitals";
			break;
			case 12 : 
				$status = "Arrive at location";
			break;
			case 11 : 
				$status = "Call patient";
			break;
			case 9 : 
				$status = "Completed";
			break;
			case 8 : 
				$status = "Back to hospitals";
			break;
			case 7 : 
				$status = "Go to hospitals";
			break;
			case 6 : 
				$status = "Go to patient";
			break;
			case 5 : 
				$status = "Accept order";
			break;
			case 4 : 
				$status = "Set Crew";
			break;
			case 3 : 
				$status = "Rejected";
			break;
			case 2 : 
				$status = "Canceled";
			break;
			case 1 : 
				$status = "Confirmed";
			break;
			case 0 : 
				$status = "Booked";
			break;
		}
		
		return $status;
	}
	
	function get_notify($status) {
		switch($status) {
			case 14 : 
				$status = "Already";
			break;
			case 13 : 
				$status = "Ambulance arrived to hospital";
			break;
			case 12 : 
				$status = "Ambulance arrived to patient";
			break;
			case 11 : 
				$status = "Call patient";
			break;
			case 9 : 
				$status = "Completed";
			break;
			case 8 : 
				$status = "Back to hospitals";
			break;
			case 7 : 
				$status = "Ambulance is on the way to hospital";
			break;
			case 6 : 
				$status = "Ambulance go to patient";
			break;
			case 5 : 
				$status = "Accept order";
			break;
			case 4 : 
				$status = "Set Crew";
			break;
			case 3 : 
				$status = "Rejected";
			break;
			case 2 : 
				$status = "Canceled";
			break;
			case 1 : 
				$status = "Waiting ambulance";
			break;
			case 0 : 
				$status = "Booked";
			break;
		}
		
		return $status;
	}
	
	function get_ambulance($status) {
		switch($status) {
			case 0 : 
				$status = "Available";
			break;
			case 1 : 
				$status = "On Trip";
			break;
			case 2 : 
				$status = "Out of service";
			break;
		}
		
		return $status;
	}
	
	function get_member($status) {
		switch($status) {
			case 0 : 
				$status = "Not Active";
			break;
			case 1 : 
				$status = "Active";
			break;
			case 2 : 
				$status = "Pending";
			break;
		}
		
		return $status;
	}
	
	function get_color($status) {
		switch($status) { 
			case 0 :
				$color = "success";
			break;
			case 1 :
				$color = "primary";
			break;
			case 2 :
				$color = "danger";
			break;
			case 3 :
				$color = "danger"; 
			break;
			case 4 :
				$color = "warning"; 
			break;
			case 5 :
				$color = "warning"; 
			break;
			case 6 :
				$color = "warning"; 
			break;
			case 7 :
				$color = "warning"; 
			break;
			case 8 :
				$color = "warning"; 
			break;
			case 9 :
				$color = "default";
			break;
			case 11 :
				$color = "warning"; 
			break;
			case 12 :
				$color = "warning"; 
			break;
			case 13 :
				$color = "warning"; 
			break;
			default :
				$color = "default"; 
			break;
		}
		
		return $color;
	} 
?>