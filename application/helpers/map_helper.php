<?php 
	function get_latitude_from_latlng($latlng) {
		$latitude = "";
		
		$arr_latlng = (explode(",", $latlng));
		$lat_kiri =  $arr_latlng[0];
		$arr_lat = (explode(".", $lat_kiri));
		$lat_before_dot = $arr_lat[0];
		$lat_after_dot = $arr_lat[1];
		$lat_after_dot = substr($lat_after_dot, 0, 5);
		$latitude = $lat_before_dot.".".$lat_after_dot;
		
		return $latitude;
	}
	
	function get_longitude_from_latlng($latlng) {
		$longitude = "";
		
		$arr_latlng = (explode(",", $latlng));
		$lng_kiri =  $arr_latlng[1];
		$lng_kiri = rtrim($lng_kiri);
		$arr_lng = (explode(".", $lng_kiri));
		$lng_before_dot = $arr_lng[0];
		$lng_after_dot = $arr_lng[1];
		$lng_after_dot = substr($lng_after_dot, 0, 5);
		$longitude = $lng_before_dot.".".$lng_after_dot;
		
		return $longitude;
	}
	
	function simple_latlng($latitude_longitude) {
		$arr_latlng = (explode(",", $latitude_longitude));
		$lat_kiri =  $arr_latlng[0];
		$arr_lat = (explode(".", $lat_kiri));
		$lat_before_dot = $arr_lat[0];
		$lat_after_dot = $arr_lat[1];
		$lat_after_dot = substr($lat_after_dot, 0, 6);
		$lat_fix_atas_kiri = $lat_before_dot.".".$lat_after_dot;
		
		$lng_kiri =  $arr_latlng[1];
		$lng_kiri = rtrim($lng_kiri);
		$arr_lng = (explode(".", $lng_kiri));
		$lng_before_dot = $arr_lng[0];
		$lng_after_dot = $arr_lng[1];
		$lng_after_dot = substr($lng_after_dot, 0, 6);
		$lng_fix_atas_kiri = $lng_before_dot.".".$lng_after_dot;
		
		$latlng =  $lat_fix_atas_kiri.','.$lng_fix_atas_kiri;
		
		return $latlng;
	}
	
	function check_in_geofence($latlng_location, $latlng, $distance) {
		// fix nilai lat dan lon
		$fix_lat = get_latitude_from_latlng($latlng_location);
		$fix_lng = get_longitude_from_latlng($latlng_location);
				
		// batasan lat long
		$latlng = str_replace(" ", "", $latlng);
		$latlng = str_replace("_", "-", $latlng);
		
		$path_top_right 	= get_position('path_top_right', $latlng, $distance);
		$path_bottom_right 	= get_position('path_bottom_right', $latlng, $distance);
		$path_bottom_left 	= get_position('path_bottom_left', $latlng, $distance);
		$path_top_left 		= get_position('path_top_left', $latlng, $distance);
			
		// fix nilai batas masing-masing
		$fix_lat_top_right 		= get_latitude_from_latlng($path_top_right);
		$fix_lng_top_right 		= get_longitude_from_latlng($path_top_right);
		$fix_lat_bottom_right 	= get_latitude_from_latlng($path_bottom_right);
		$fix_lng_bottom_right 	= get_longitude_from_latlng($path_bottom_right);
		$fix_lat_top_left 		= get_latitude_from_latlng($path_top_left);
		$fix_lng_top_left 		= get_longitude_from_latlng($path_top_left);
		$fix_lat_bottom_left 	= get_latitude_from_latlng($path_bottom_left);
		$fix_lng_bottom_left 	= get_longitude_from_latlng($path_bottom_left);

		// cek top right
		if(($fix_lat <= $fix_lat_top_right) && ($fix_lng <= $fix_lng_top_right)) {
			$in_top_right = 1;
		}
		else {
			$in_top_right = 0;
		}
		
		// cek top left
		if(($fix_lat <= $fix_lat_top_left) && ($fix_lng >= $fix_lng_top_left)) {
			$in_top_left = 1;
		}
		else {
			$in_top_left = 0;
		}
		
		// cek bottom right
		if(($fix_lat >= $fix_lat_bottom_right) && ($fix_lng <= $fix_lng_bottom_right)) {
			$in_bottom_right = 1;
		}
		else {
			$in_bottom_right = 0;
		}
		
		// cek bottom left
		if(($fix_lat >= $fix_lat_bottom_left) && ($fix_lng >= $fix_lng_bottom_left)) {
			$in_bottom_left = 1;
		}
		else {
			$in_bottom_left = 0;
		}
		
		if(($in_top_right == 1) && ($in_top_left == 1) && ($in_bottom_right == 1) && ($in_bottom_left == 1)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
	
	function bpot_getDueCoords($latitude, $longitude, $bearing, $distance, $distance_unit = "km", $return_as_array = FALSE) {
		if ($distance_unit == "m") {
			// Distance is in miles.
			$radius = 3963.1676;
		}
		else {
			// distance is in km.
			$radius = 6378.1;
		}
	  
		//	New latitude in degrees.
		$new_latitude = rad2deg(asin(sin(deg2rad($latitude)) * cos($distance / $radius) + cos(deg2rad($latitude)) * sin($distance / $radius) * cos(deg2rad($bearing))));
				
		//	New longitude in degrees.
		$new_longitude = rad2deg(deg2rad($longitude) + atan2(sin(deg2rad($bearing)) * sin($distance / $radius) * cos(deg2rad($latitude)), cos($distance / $radius) - sin(deg2rad($latitude)) * sin(deg2rad($new_latitude))));
		
		if ($return_as_array) {
		  //  Assign new latitude and longitude to an array to be returned to the caller.
		  $coord = array();
		  $coord['lat'] = $new_latitude;
		  $coord['lng'] = $new_longitude;
		}
		else {
		  $coord = $new_latitude . "," . $new_longitude;
		}
		
		return $coord; 
	}
	
	function get_position($status, $latlng, $distance) {
		$latlng = simple_latlng($latlng);
		$lat 	= get_latitude_from_latlng($latlng);
		$lng 	= get_longitude_from_latlng($latlng);
		
		switch($status) {
			case "path_top_right" :
				$latlng = bpot_getDueCoords($lat, $lng, 45, $distance);
			break;
			case "path_bottom_right" :
				$latlng = bpot_getDueCoords($lat, $lng, 135, $distance);
			break;
			case "path_bottom_left" :
				$latlng = bpot_getDueCoords($lat, $lng, 225, $distance);
			break;
			case "path_top_left" :
				$latlng = bpot_getDueCoords($lat, $lng, 315, $distance);
			break;
		}	
		
		return $latlng;
	}
	
	function get_address($latlng) {
		$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.$latlng.'&sensor=false';
		$json = @file_get_contents($url);
		$data=json_decode($json);
		$status = $data->status;
		
		if($status=="OK")
		return $data->results[0]->formatted_address;
			else
		return false;
	}
	
	
	function getRhumbLineBearing($lat1, $lon1, $lat2, $lon2) {
		 //difference in longitudinal coordinates
		 $dLon = deg2rad($lon2) - deg2rad($lon1);
	 
		 //difference in the phi of latitudinal coordinates
		 $dPhi = log(tan(deg2rad($lat2) / 2 + pi() / 4) / tan(deg2rad($lat1) / 2 + pi() / 4));
	 
		 //we need to recalculate $dLon if it is greater than pi
		 if(abs($dLon) > pi()) {
			  if($dLon > 0) {
				   $dLon = (2 * pi() - $dLon) * -1;
			  }
			  else {
				   $dLon = 2 * pi() + $dLon;
			  }
		 }
		 //return the angle, normalized
		 return (rad2deg(atan2($dLon, $dPhi)) + 360) % 360;
	}

	function getCompassDirection($bearing) {
		 $tmp = round($bearing / 45);
		 switch($tmp) {
			case 1:
				$direction = "NE";
				break;
			case 2:
				$direction = "E";
				break;
			case 3:
				$direction = "SE";
				break;
			case 4:
				$direction = "S";
				break;
			case 5:
				$direction = "SW";
				break;
			case 6:
				$direction = "W";
				break;
			case 7:
			   $direction = "NW";
				break;
			default:
				$direction = "N";
		 }
		 return $direction;
	}

	function getCompassArah($direction) {
		 $arah = "";
		 switch($direction) {
				case "NE":
				   $arah = "Timur Laut";
				   break;
				case "E":
				   $arah = "Timur";
				   break;
				case "SE":
				   $arah = "Tenggara";
				   break;
				case "S":
				   $arah = "Selatan";
				   break;
				case "SW":
				   $arah = "Barat Daya";
				   break;
				case "W":
				   $arah = "Barat";
				   break;
				case "NW":
				   $arah = "Barat Laut";
				   break;
				default:
				   $arah = "Utara";
		 }
		 return $arah;
	}
	
	function get_distance($latitude_from, $longitude_from, $latitude_to, $longitude_to) {
		if(($latitude_from == 0) || ($longitude_from == 0) || ($latitude_to == 0) || ($longitude_to == 0)) {
			$distance = 0;
		}
		else {
			$distance = distance($latitude_from, $longitude_from, $latitude_to, $longitude_to, 'K');
		}
		
		return $distance;
	}
	
	function distance($lat1, $lon1, $lat2, $lon2, $unit) {
	  $theta = $lon1 - $lon2;
	  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	  $dist = acos($dist);
	  $dist = rad2deg($dist);
	  $miles = $dist * 60 * 1.1515;
	  $unit = strtoupper($unit);

	  if ($unit == "K") {
		return ($miles * 1.609344);
	  } else if ($unit == "N") {
		  return ($miles * 0.8684);
		} else {
			return $miles;
		  }
	}
?>