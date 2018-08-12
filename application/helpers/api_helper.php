<?php
	function getHeaders($header_name=null) {
		$CI=& get_instance();
		$keys=array_keys($_SERVER);
		$headervals="";//ini baris baru
		if(is_null($header_name)) {
			$headers=preg_grep("/^HTTP_(.*)/si", $keys);
		} else {
			$header_name_safe=str_replace("-", "_", strtoupper(preg_quote($header_name)));
			$headers=preg_grep("/^HTTP_${header_name_safe}$/si", $keys);
		}

		foreach($headers as $header) {
			if(is_null($header_name)){
				$headervals[substr($header, 5)]=$_SERVER[$header];
			} else {
				//return $_SERVER[$header];//inibaris lama
				$headervals = $_SERVER[$header]; //inibaisbaru
			}
		}

		return $headervals;
	}

	function checking_header($token) {
		$request = getHeaders('X-Client-Code');
		
		if($request != $token) {
			return FALSE;
		}
		else {
			return TRUE;
		}
	}
	
	function getDistanceAndTime($orig,$dest){
		$CI=& get_instance();
		
		$url 	= 'https://maps.googleapis.com/maps/api/distancematrix/json?origins='.$orig.'&destinations='.$dest.'&language=en-ID&sensor=false';
		$data 	= file_get_contents($url);
		$result = json_decode($data);
		
		$hasil = array();
		foreach($result->rows[0]->elements as $road) {
			if($road->status != "NOT_FOUND") {
				$distance = $road->distance->text;
				$duration = $road->duration->text;
			} 
			else {
				$distance = "km";
				$duration = "";
			}	
			
			$hasil[] = array(
				'distance' 	=> $distance,
				'time' 		=> $duration
			);
		}
		
		return $hasil;
	}

	function setDirections($user_latitude, $user_longitude, $destination_latitude, $destination_longitude) {
		$latPatient 	= $user_latitude;
		$longPatient 	= $user_longitude;
		$latAmbulance 	= $destination_latitude;
		$longAmbulance 	= $destination_longitude;
		$origin 		= $latAmbulance.','.$longAmbulance;
		$destination 	= $latPatient.','.$longPatient;
		$directions 	= getDistanceAndTime($origin, $destination);
		
		return $directions;
	}
	
	function get_distance_and_eta($current_latitude, $current_longitude, $to_latitude, $to_longitude) {
		// get distance
		$directions = setDirections($current_latitude, $current_longitude, $to_latitude, $to_longitude);

		$distance 	= $directions[0]["distance"];
		$eta 		= $directions[0]["time"];
		
		$result = $distance ." - ". $eta;
		return $result;
	}
	
	function update_distance_eta_emergency($id, $str) {
		$CI =& get_instance();
		
		$arr = (explode("+", $str));
		if(count($arr) == 2) {
			$distance 	= $arr[0]; 
			$eta	  	= $arr[1];
		}
		else {
			$distance 	= "-"; 
			$eta 	 	= "-";
		}
		
		$data = array(
			'emergency_distance'=> $distance,
			'emergency_eta'		=> $eta,
		);
		
		$CI->load->model('m_crud')->update('tp_emergency', 'emergency_id', $data, $id);
	}
	
	function update_distance_eta_nonemergency($id, $str) {
		$CI =& get_instance();
		
		$arr = (explode("+", $str));
		if(count($arr) == 2) {
			$distance 	= $arr[0]; 
			$eta	  	= $arr[1];
		}
		else {
			$distance 	= "-"; 
			$eta 	 	= "-";
		}
		
		$data = array(
			'nonemergency_distance' => $distance,
			'nonemergency_eta'		=> $eta,
		);
		
		$CI->load->model('m_crud')->update('tp_nonemergency', 'nonemergency_id', $data, $id);
	}
	
	function update_distance_eta_ambulance($id, $str) {
		$CI =& get_instance();
		
		$arr = (explode("+", $str));
		if(count($arr) == 2) {
			$distance 	= $arr[0]; 
			$eta	  	= $arr[1];
		}
		else {
			$distance 	= "-"; 
			$eta 	 	= "-";
		}
		
		$data = array(
			'ambulance_distance'=> $distance,
			'ambulance_eta' 	=> $eta
		);
		
		$CI->load->model('m_crud')->update('tm_ambulance', 'ambulance_id', $data, $id);
	}
	
	function update_distance_eta_hospital_ambulance($id, $str1, $str2, $str3) {
		$CI =& get_instance();
		
		if($str1 != "") {
			$arr1 = (explode("+", $str1));
			if(count($arr1) == 2) {
				$distance1 	= $arr1[0]; 
				$eta1	  	= $arr1[1];
			}
			else {
				$distance1 	= "0 km"; 
				$eta1 	 	= "";
			}
		}
		else {
			$distance1 	= "0 km"; 
			$eta1 	 	= "";
		}
		
		if($str2 != "") {
			$arr2 = (explode("+", $str2));
			if(count($arr2) == 2) {
				$distance2 	= $arr2[0]; 
				$eta2	  	= $arr2[1];
			}
			else {
				$distance2 	= "0 km"; 
				$eta2 	 	= "";
			}
		}
		else {
			$distance2 	= "0 km"; 
			$eta2 	 	= "";
		}
		
		if($str3 != "") {
			$arr3 = (explode("+", $str3));
			if(count($arr3) == 2) {
				$distance3 	= $arr3[0]; 
				$eta3	  	= $arr3[1];
			}                    
			else {
				$distance3 	= "0 km"; 
				$eta3 	 	= "";
			}
		}
		else {
			$distance3 	= "0 km"; 
			$eta3 	 	= "";
		}
		
		$count_distance = count_distance($distance1, $distance2);
		$distance 		= count_distance($count_distance, $distance3);
		
		$count_eta 	= count_eta($eta1, $eta2);
		$eta 		= count_eta($count_eta, $eta3);
		
		$data = array(
			'ambulance_distancehospital' => $distance,
			'ambulance_etahospital' 	 => $eta
		);
		
		$CI->load->model('m_crud')->update('tm_ambulance', 'ambulance_id', $data, $id);
	}
	
	function get_unit($distance) {
		if (strpos($distance, 'km') !== false) {
			$result = "km";
		}
		else {
			$result = "m";
		}
		
		return $result;
	}
	
	function get_value($distance) {
		if (strpos($distance, 'km') !== false) {
			$distance = str_replace("km", "", $distance);
			$distance = str_replace(" ", "", $distance); 
			
			$dis = $distance;
		}
		else {
			$distance = str_replace("m", "", $distance);
			$dis = $distance;
		}
		
		return $dis;
	}
	
	function get_distance_eta($from_latitude, $from_longitude, $to_latitude, $to_longitude) {
		if(($from_latitude == "-") && ($from_longitude == "-") && ($to_latitude == "-") && ($to_longitude == "-")) {
			$distance = null; 
			$eta 	  = null;
		}
		else {
			$go 	 		= get_distance_and_eta($from_latitude, $from_longitude, $to_latitude, $to_longitude);
			$arr_go  		= (explode("-", $go));
			
			if(count($arr_go) == 2) {
				$distance 	= $arr_go[0]; 
				$eta	  	= $arr_go[1];
			}
			else {
				$distance 	= null; 
				$eta 	 	= null;
			}
		}
		
		$result = $distance .' + '. $eta;
		return $result;
	}
	
	function count_distance($from_distance, $to_distance) {
		$from_distance_unit 		= get_unit($from_distance);
		$from_distance_value_result = get_value($from_distance);
		
		$to_distance_unit 			= get_unit($to_distance);
		$to_distance_value_result 	= get_value($to_distance);
		
		if (($from_distance_unit == "km" && $to_distance_unit == "km")) {
			$distance = doubleval($from_distance_value_result) + doubleval($to_distance_value_result);
			$distance = $distance ." km";
		} 
		else if (($from_distance_unit == "m" && $to_distance_unit == "km")) {
			$distance = doubleval($from_distance_value_result) + (doubleval($to_distance_value_result) * 1000);
			$distance = $distance / 1000;
			$distance = $distance ." km";
		} 
		else if (($from_distance_unit == "km" && $to_distance_unit == "m")) {
			$distance = (doubleval($from_distance_value_result) * 1000) + doubleval($to_distance_value_result);
			$distance = $distance / 1000;
			$distance = $distance ." km";
		}
		else {
			$distance = doubleval($from_distance_value_result) + doubleval($to_distance_value_result);
			$distance = $distance / 1000;
			$distance = $distance ." km";
		}
		
		return $distance;
	}
	
	function count_eta($from_eta, $to_eta) {
		$arr_from_eta  		= (explode(" hour", $from_eta));
		
		if(count($arr_from_eta) == 2) {
			$from_eta_hour 	= $arr_from_eta[0]; 
			$from_eta_mins	= str_replace("mins", "", $arr_from_eta[1]);
			$from_eta_mins	= str_replace(" ", "", $from_eta_mins);
		}
		else {
			$from_eta_hour 	= 0; 
			$from_eta_mins	= str_replace(" mins", "", $arr_from_eta[0]);	
			$from_eta_mins	= str_replace(" ", "", $from_eta_mins);
		}
		
		if($from_eta_hour > 0) {
			$from_temp_min = 60;
			$from_temp_min = $from_temp_min * $from_eta_hour;
			$from_eta_mins = $from_eta_mins + $from_temp_min;
			
			$from_hour = floor($from_eta_mins/60);
			$from_mins = $from_eta_mins - $from_temp_min;
		}
		else {
			$from_hour = $from_eta_hour;
			$from_mins = $from_eta_mins;
		}
		
		$arr_to_eta  		= (explode(" hour", $to_eta));
		
		if(count($arr_to_eta) == 2) {
			$to_eta_hour 	= $arr_to_eta[0]; 
			$to_eta_mins	= str_replace("mins", "", $arr_to_eta[1]);
			$to_eta_mins	= str_replace(" ", "", $to_eta_mins);
		}
		else {
			$to_eta_hour 	= 0; 
			$to_eta_mins	= str_replace(" mins", "", $arr_to_eta[0]);	
			$to_eta_mins	= str_replace(" ", "", $to_eta_mins);
		}
		
		if($to_eta_hour > 0) {
			$to_temp_min = 60;
			$to_temp_min = $to_temp_min * $to_eta_hour;
			$to_eta_mins = $to_eta_mins + $to_temp_min;
			
			$to_hour = floor($to_eta_mins/60);
			$to_mins = $to_eta_mins - $to_temp_min;
		}
		else {
			$to_hour  = $to_eta_hour;
			$to_mins  = $to_eta_mins;
		}
		
		$total_hour = $from_hour + $to_hour;
		$total_mins = $from_mins + $to_mins;
		
		if($total_hour > 0) {
			$selisih_mins = 0;
			if($total_mins > 60) {
				$mins_hours 	= floor($total_mins / 60);
				$total_hour 	= $total_hour + $mins_hours;
				$selisih_mins  	= $total_mins % 60;
			}
			else {
				$selisih_mins  	= $total_mins;
			}
			
			$total_mins = $selisih_mins;
		}
		else {
			$total_hour  = $total_hour;
			$total_mins  = $total_mins;
		}
		
		if($total_hour > 0) { $total_hour = $total_hour ." hour "; } else { $total_hour = ""; }
		$total_mins = $total_mins ." mins";
		
		$eta = $total_hour . $total_mins;
		return $eta;
	}
?>