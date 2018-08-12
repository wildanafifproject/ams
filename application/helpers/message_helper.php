<?php
	function get_notification($operation, $status) {
		$notification = "";
		
		switch($status) {
			case 0 : 
				$status = "Failed";
			break;
			case 1 : 
				$status = "Success";
			break;
			case 2 : 
				$status = "Data is incomplete";
			break;
			case 9 : 
				$status = "Data already exists";
			break;
			default : 
				$status = "";
			break;	
		}
		
		switch($operation) {
			case "insert" : 
				$operation = "insert";
				$notification = $status. ' '.$operation.' data';
			break;
			case "update" : 
				$operation = "update";
				$notification = $status. ' '.$operation.' data';
			break;		
			case "delete" : 
				$operation = "delete";
				$notification = $status. ' '.$operation.' data';
			break;
			case "finish" : 
				$operation = "finished";
				$notification = $status. ' '.$operation.' data';
			break;
			default : 
				$notification = $status. ' '.$operation;
			break;	
		}
		
		return $notification;
	}
	
	function get_notify_status($status) {
		switch($status) {
			case 0 : 
				$status = "DANGER";
			break;
			case 1 : 
				$status = "SUCCESS";
			break;
			case 2 : 
				$status = "WARNING";
			break;
			case 9 : 
				$status = "INFO";
			break;
			default : 
				$status = "";
			break;
		}	
		
		return $status;
	}	
?>