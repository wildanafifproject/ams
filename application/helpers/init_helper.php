<?php
	function set_response($array) {
		if(!empty($array)) {
			$result = 1;
			
		}
		else {
			$result = 0;
		}
		
		return $result;
	}
	
	function set_return($response, $array) {
		$result = array(
			'response' 	=> $response,
			'data' 		=> $array
		);
		
		return $result;
	}
	
	function set_warning($code) {
		switch($code) {
			case 200 : 
				$message = "Success";	
			break;
			case 201 : 
				$message = "Hospitals no available";	
			break;
			case 202 : 
				$message = "Ambulance no available";	
			break;
			case 204 : 
				$message = "Wrong Email or Password";	
			break;
			case 205 : 
				$message = "Data failed to create";	
			break;
			case 206 : 
				$message = "Data failed to update";	
			break;
			case 207 : 
				$message = "File failed to upload";	
			break;
			case 208 : 
				$message = "No Data Exist";	
			break;
			case 209 : 
				$message = "Wrong Username or Password";	
			break;
			case 237 : 
				$message = "Your email or username is not registered. Create new account ?";	
			break;
			case 300 : 
				$message = "Logout success";	
			break;
			case 301 : 
				$message = "Areas no available";	
			break;
			case 302 : 
				$message = "Order already canceled by SRCC";	
			break;
			case 306 : 
				$message = "Logout failed";	
			break;
			case 400 : 
				$message = "We can't identity your location";	
			break;
			case 401 : 
				$message = "Wrong header token";	
			break;
			case 402 : 
				$message = "Missing / unknown parameter";	
			break;
			case 409 : 
				$message = "Email already registered!";	
			break;
			default : 
				$message = "Please try again";
			break;	
			case 506 : 
				$message = "Data failed to cancel";	
			break;
		}
	
		$result = array(
			'status'  => $code,
			'message' => $message
		);
		
		return $result;
	}
	
	function set_member($query) {
		$result = array();
		if(!empty($query)) {
			foreach($query as $row) {
				if($row->member_image == "") {
					$img = "no_images.png";
				}
				else {
					$img = "member/". $row->member_image;
				}
				
				if($row->member_identity == "") {
					$img_identity = "no_images.png";
				}
				else {
					$img_identity = "member_identity/". $row->member_identity;
				}
				
				$result = array(
					'id' 				=> $row->member_id,
					'firstname'			=> strip_tags($row->member_firstname),
					'lastname'			=> strip_tags($row->member_lastname),
					'address'			=> $row->member_address,
					'email'				=> $row->member_email,
					'password'			=> $row->member_password,
					'phone_number'		=> $row->member_phone,
					'age'				=> $row->member_age,
					'gender'			=> $row->member_gender,
					'role'				=> $row->member_role,
					'activation_code'	=> $row->activation_code,
					'device_token' 		=> $row->device_token,
					'is_login'			=> $row->is_login,
					'active'			=> get_member($row->member_status),
					'identity_photo'	=> base_url() ."assets/uploads/". $img_identity,
					'photo'				=> base_url() ."assets/uploads/". $img
				);
			}	
		}
		
		return $result;
	}	

	function set_contact($query) {
		$result = array();
		if(!empty($query)) {
			foreach($query as $row) {
				$result = array(
					'id' 				=> $row->contact_id,
					'firstname'			=> strip_tags($row->contact_firstname),
					'lastname'			=> strip_tags($row->contact_lastname),
					'relation'			=> $row->contact_relation,
					'email'				=> $row->contact_email,
					'phone_number'		=> $row->contact_phone
				);
			}	
		}
		
		return $result;
	}	
	
	function set_hospital($query) {
		$result = array();
		if(!empty($query)) {
			$response = 1;
			
			foreach($query as $row) {
				if($query->hospital_image == "") {
					$img = "no_images.png";
				}
				else {
					$img = "hospital/". $query->hospital_image;
				}
				
				$result = array(
					'id' 					=> $query->hospital_id,
					'name' 					=> $query->hospital_name,
					'alias'					=> $query->hospital_no,
					'identity' 				=> $query->hospital_identity,
					'latitude' 				=> $query->hospital_latitude,
					'longitude' 			=> $query->hospital_longitude,
					'address' 				=> $query->hospital_address,
					'email'					=> $query->hospital_email,
					'phone' 				=> $query->hospital_phone,
					'distance'			 	=> $query->hospital_distance,
					'eta' 					=> $query->hospital_eta,
					'acreditations' 		=> NULL,
					'facilities'			=> NULL,
					'imaging' 				=> NULL,
					'specialists' 			=> NULL,
					'emeergency_services' 	=> NULL,
					'center_of_exellences' 	=> NULL,
					'photo'					=> base_url() ."assets/uploads/". $img
				);
			}	
		}
		
		return $result;
	}	
	
	function set_area($query) {
		$result = array();
		if(!empty($query)) {
			$response = 1;
			
			foreach($query as $row) {
				$result[] = array(
					'id' 	=> $row->area_id,
					'name' 	=> $row->area_name,
				);
			}	
		}
		
		return $result;
	}
	
	function set_ambulance($query) {
		$result = array();
		if(!empty($query)) {
			foreach($query as $row) {
				if($row->ambulance_image == "") {
					$img = "no_images.png";
				}
				else {
					$img = "ambulance/". $row->ambulance_image;
				}
				
				$result = array(
					'id' 				=> $row->ambulance_id,
					'no'				=> $row->ambulance_no,
					'plat'				=> $row->ambulance_police,
					'datetime'			=> $row->ambulance_trackdatetime,
					'latitude'			=> $row->ambulance_tracklatitude,
					'longitude'			=> $row->ambulance_tracklongitude,
					'marker_rotation'	=> $row->ambulance_trackrotation,
					'distance'			=> $row->ambulance_distance,
					'eta' 				=> $row->ambulance_eta,
					'distancehospital'	=> $row->ambulance_distancehospital,
					'etahospital' 		=> $row->ambulance_etahospital,
					'username'			=> $row->ambulance_username,
					'password'			=> $row->ambulance_password,
					'device_token' 		=> $row->device_token,
					'is_login'			=> $row->is_login,
					'active'			=> get_ambulance($row->ambulance_status),
					'photo'				=> base_url() ."assets/uploads/". $img
				);
			}	
		}
		
		return $result;
	}
	
	function set_emergency_track_detail($query) {
		$CI =& get_instance();
		
		$result = array();
		if(!empty($query)) {
			foreach($query as $row) {
				$member_fname = $CI->load->model('m_api')->get_member_firstname_by_id($row->member_id);
				$member_lname = $CI->load->model('m_api')->get_member_lastname_by_id($row->member_id);
				$member_name  = $member_fname .' '. $member_lname;
				$member_phone = $CI->load->model('m_api')->get_member_phone_by_id($row->member_id);
				$member_image = $CI->load->model('m_api')->get_member_image_by_id($row->member_id);
				
				if($member_image == "") {
					$member_image = "no_images.png";
				}
				else {
					$member_image = "member/". $member_image;
				}
				
				$latitude_ambulance 	= "";
				$longitude_ambulance 	= "";
				$rotation_ambulance 	= "";
				$plat_ambulance 		= "";
				$distance_ambulance 	= "";
				$eta_ambulance 	= "";
				
				$detail_ambulance = $CI->load->model('m_global')->get_by_id('tm_ambulance', 'ambulance_id', $row->ambulance_id);
				foreach($detail_ambulance as $rows) {
					$latitude_ambulance 	= $rows->ambulance_tracklatitude;
					$longitude_ambulance 	= $rows->ambulance_tracklongitude;
					$rotation_ambulance 	= $rows->ambulance_trackrotation;
					$plat_ambulance			= $rows->ambulance_police;
					$distance_ambulance		= $rows->ambulance_distance;
					$eta_ambulance			= $rows->ambulance_eta;
				}
				
				$latitude_hospital 	= "";
				$longitude_hospital = "";
				$hospital 			= "";
				
				$detail_hospital = $CI->load->model('m_global')->get_by_id('tm_hospital', 'hospital_id', $row->hospital_id);
				foreach($detail_hospital as $rows) {
					$latitude_hospital 	= $rows->hospital_latitude;
					$longitude_hospital = $rows->hospital_longitude;
					$hospital			= strip_tags($rows->hospital_name);
				}
				
				$result = array(
					'id' 					=> $row->emergency_id,
					'callreference' 		=> $row->emergency_callreference,
					'date'					=> convert_to_ymd($row->emergency_date),
					'time'					=> convert_to_his($row->emergency_time),
					'callername'			=> strip_tags($row->emergency_callername),
					'callerphone'			=> $row->emergency_callerphone,
					'callerother'			=> $row->emergency_callerother,
					'latitude'				=> $row->emergency_infolatitude,
					'longitude'				=> $row->emergency_infolongitude,
					'address'				=> $row->emergency_infostreet,
					'otherinformation'		=> $row->emergency_infootherinformation,
					'patientname'			=> strip_tags($row->emergency_patientname),
					'patientdob'			=> (($row->emergency_patientdob == "")?"-":convert_to_ymd($row->emergency_patientdob)),
					'patienttotal'			=> $row->emergency_patienttotal,
					'patientunconscious'	=> $row->emergency_patientunconscious,
					'patientnote'			=> $row->emergency_patientnote,
					'distance'				=> $row->emergency_distance,
					'eta'					=> $row->emergency_eta,
					'time_confirmed'		=> (($row->time_confirmed == "")?"":convert_to_ymdhis($row->time_confirmed)),
					'time_waiting'			=> (($row->time_waiting == "")?"-":convert_to_ymdhis($row->time_waiting)),
					'time_set_crew'			=> (($row->time_set_crew == "")?"-":convert_to_ymdhis($row->time_set_crew)),
					'time_to_patient'		=> (($row->time_to_patient == "")?"-":convert_to_ymdhis($row->time_to_patient)),
					'time_call_patient'		=> (($row->time_call_patient == "")?"-":convert_to_ymdhis($row->time_call_patient)),
					'time_arrived_patient'	=> (($row->time_arrived_patient == "")?"-":convert_to_ymdhis($row->time_arrived_patient)),
					'time_to_hospital'		=> (($row->time_to_hospital == "")?"-":convert_to_ymdhis($row->time_to_hospital)),
					'time_arrived_hospital'	=> (($row->time_arrived_hospital == "")?"-":convert_to_ymdhis($row->time_arrived_hospital)),
					'time_back_hospital'	=> (($row->time_back_hospital == "")?"-":convert_to_ymdhis($row->time_back_hospital)),
					'time_complete'			=> (($row->time_complete == "")?"-":convert_to_ymdhis($row->time_complete)),
					'time_cancel'			=> (($row->time_cancel == "")?"-":convert_to_ymdhis($row->time_cancel)),
					'reason_cancel'			=> strip_tags($row->reason_cancel),
					'time_reject'			=> (($row->time_reject == "")?"-":convert_to_ymdhis($row->time_reject)),
					'reason_reject'			=> strip_tags($row->reason_reject),
					'case_type'				=> (($row->subcategory_id == "")?"-":$CI->load->model('m_api')->get_name_subcategory_by_id($row->subcategory_id)),
					'source'				=> (($row->source_id == "")?"-":$CI->load->model('m_api')->get_name_source_by_id($row->source_id)),
					'forward'				=> (($row->forward_id == "")?"-":$CI->load->model('m_api')->get_name_forward_by_id($row->forward_id)),
					'area'					=> (($row->area_id == "")?"-":$CI->load->model('m_api')->get_name_area_by_id($row->area_id)),
					'area_detail'			=> (($row->location_id == "")?"-":$CI->load->model('m_api')->get_name_location_by_id($row->location_id)),
					'latitude_hospital'		=> $latitude_hospital,
					'longitude_hospital'	=> $longitude_hospital,
					'hospital'				=> $hospital,
					'latitude_ambulance'	=> $latitude_ambulance,
					'longitude_ambulance'	=> $longitude_ambulance,
					'rotation_ambulance'	=> $rotation_ambulance,
					'ambulance'				=> $plat_ambulance,
					'distance_ambulance'	=> $distance_ambulance,
					'eta_ambulance'			=> $eta_ambulance,
					'status'				=> get_transaction($row->emergency_status),
					'member_name'			=> $member_name,
					'member_phone'			=> $member_phone,
					'member_image'			=> base_url() ."assets/uploads/". $member_image
				);
			}	
		}
		
		return $result;
	}
	
	function set_emergency($query) {
		$CI =& get_instance();
		
		$result = array();
		if(!empty($query)) {
			foreach($query as $row) {
				$member_fname = $CI->load->model('m_api')->get_member_firstname_by_id($row->member_id);
				$member_lname = $CI->load->model('m_api')->get_member_lastname_by_id($row->member_id);
				$member_name  = $member_fname .' '. $member_lname;
				$member_phone = $CI->load->model('m_api')->get_member_phone_by_id($row->member_id);
				$member_image = $CI->load->model('m_api')->get_member_image_by_id($row->member_id);
				
				if($member_image == "") {
					$member_image = "no_images.png";
				}
				else {
					$member_image = "member/". $member_image;
				}
				
				$result = array(
					'id' 					=> $row->emergency_id,
					'callreference' 		=> $row->emergency_callreference,
					'date'					=> convert_to_ymd($row->emergency_date),
					'time'					=> convert_to_his($row->emergency_time),
					'callername'			=> strip_tags($row->emergency_callername),
					'callerphone'			=> $row->emergency_callerphone,
					'callerother'			=> $row->emergency_callerother,
					'latitude'				=> $row->emergency_infolatitude,
					'longitude'				=> $row->emergency_infolongitude,
					'address'				=> $row->emergency_infostreet,
					'otherinformation'		=> $row->emergency_infootherinformation,
					'patientname'			=> strip_tags($row->emergency_patientname),
					'patientdob'			=> (($row->emergency_patientdob == "")?"-":convert_to_ymd($row->emergency_patientdob)),
					'patienttotal'			=> $row->emergency_patienttotal,
					'patientunconscious'	=> $row->emergency_patientunconscious,
					'patientnote'			=> $row->emergency_patientnote,
					'distance'				=> $row->emergency_distance,
					'eta'					=> $row->emergency_eta,
					'time_confirmed'		=> (($row->time_confirmed == "")?"":convert_to_ymdhis($row->time_confirmed)),
					'time_waiting'			=> (($row->time_waiting == "")?"-":convert_to_ymdhis($row->time_waiting)),
					'time_set_crew'			=> (($row->time_set_crew == "")?"-":convert_to_ymdhis($row->time_set_crew)),
					'time_to_patient'		=> (($row->time_to_patient == "")?"-":convert_to_ymdhis($row->time_to_patient)),
					'time_call_patient'		=> (($row->time_call_patient == "")?"-":convert_to_ymdhis($row->time_call_patient)),
					'time_arrived_patient'	=> (($row->time_arrived_patient == "")?"-":convert_to_ymdhis($row->time_arrived_patient)),
					'time_to_hospital'		=> (($row->time_to_hospital == "")?"-":convert_to_ymdhis($row->time_to_hospital)),
					'time_arrived_hospital'	=> (($row->time_arrived_hospital == "")?"-":convert_to_ymdhis($row->time_arrived_hospital)),
					'time_back_hospital'	=> (($row->time_back_hospital == "")?"-":convert_to_ymdhis($row->time_back_hospital)),
					'time_complete'			=> (($row->time_complete == "")?"-":convert_to_ymdhis($row->time_complete)),
					'time_cancel'			=> (($row->time_cancel == "")?"-":convert_to_ymdhis($row->time_cancel)),
					'reason_cancel'			=> strip_tags($row->reason_cancel),
					'time_reject'			=> (($row->time_reject == "")?"-":convert_to_ymdhis($row->time_reject)),
					'reason_reject'			=> strip_tags($row->reason_reject),
					'case_type'				=> (($row->subcategory_id == "")?"-":$CI->load->model('m_api')->get_name_subcategory_by_id($row->subcategory_id)),
					'source'				=> (($row->source_id == "")?"-":$CI->load->model('m_api')->get_name_source_by_id($row->source_id)),
					'forward'				=> (($row->forward_id == "")?"-":$CI->load->model('m_api')->get_name_forward_by_id($row->forward_id)),
					'hospital'				=> (($row->forward_id == "")?"-":$CI->load->model('m_api')->get_name_hospital_by_id($CI->load->model('m_api')->get_hospital_by_forward($row->forward_id))),
					'area'					=> (($row->area_id == "")?"-":$CI->load->model('m_api')->get_name_area_by_id($row->area_id)),
					'area_detail'			=> (($row->location_id == "")?"-":$CI->load->model('m_api')->get_name_location_by_id($row->location_id)),
					'ambulance'				=> (($row->ambulance_id == "")?"-":$CI->load->model('m_api')->get_plat_ambulance_by_id($row->ambulance_id)),
					'status'				=> get_transaction($row->emergency_status),
					'member_name'			=> $member_name,
					'member_phone'			=> $member_phone,
					'member_image'			=> base_url() ."assets/uploads/". $member_image
				);
			}	
		}
		
		return $result;
	}
	
	function set_emergency_track($query) {
		$CI =& get_instance();
		
		$result = array();
		if(!empty($query)) {
			foreach($query as $row) {
				$member_fname = $CI->load->model('m_api')->get_member_firstname_by_id($row->member_id);
				$member_lname = $CI->load->model('m_api')->get_member_lastname_by_id($row->member_id);
				$member_name  = $member_fname .' '. $member_lname;
				$member_phone = $CI->load->model('m_api')->get_member_phone_by_id($row->member_id);
				$member_image = $CI->load->model('m_api')->get_member_image_by_id($row->member_id);
				
				if($member_image == "") {
					$member_image = "no_images.png";
				}
				else {
					$member_image = "member/". $member_image;
				}
				
				$latitude_ambulance 	= "";
				$longitude_ambulance 	= "";
				$rotation_ambulance 	= "";
				$plat_ambulance 		= "";
				$distance_ambulance 	= "";
				$eta_ambulance 			= "";
				
				$detail_ambulance = $CI->load->model('m_global')->get_by_id('tm_ambulance', 'ambulance_id', $row->ambulance_id);
				foreach($detail_ambulance as $rows) {
					$latitude_ambulance 	= $rows->ambulance_tracklatitude;
					$longitude_ambulance 	= $rows->ambulance_tracklongitude;
					$rotation_ambulance 	= $rows->ambulance_trackrotation;
					$plat_ambulance			= $rows->ambulance_police;
					$distance_ambulance		= $rows->ambulance_distance;
					$eta_ambulance			= $rows->ambulance_eta;
				}
				
				$result = array(
					'id' 					=> $row->emergency_id,
					'date'					=> convert_to_ymd($row->emergency_date),
					'time'					=> convert_to_his($row->emergency_time),
					'callername'			=> strip_tags($row->emergency_callername),
					'callerphone'			=> $row->emergency_callerphone,
					'latitude'				=> $row->emergency_infolatitude,
					'longitude'				=> $row->emergency_infolongitude,
					'address'				=> $row->emergency_infostreet,
					'patientname'			=> strip_tags($row->emergency_patientname),
					'distance'				=> $row->emergency_distance,
					'eta'					=> $row->emergency_eta,
					'latitude_ambulance'	=> $latitude_ambulance,
					'longitude_ambulance'	=> $longitude_ambulance,
					'rotation_ambulance'	=> $rotation_ambulance,
					'ambulance'				=> $plat_ambulance,
					'distance_ambulance'	=> $distance_ambulance,
					'eta_ambulance'			=> $eta_ambulance,
					'status'				=> get_transaction($row->emergency_status),
					'member_name'			=> $member_name,
					'member_phone'			=> $member_phone,
					'member_image'			=> base_url() ."assets/uploads/". $member_image
				);
			}	
		}
		
		return $result;
	}
	
	function set_emergency_tracking($query) {
		$CI =& get_instance();
		
		$result = array();
		if(!empty($query)) {
			foreach($query as $row) {
				$member_fname = $CI->load->model('m_api')->get_member_firstname_by_id($row->member_id);
				$member_lname = $CI->load->model('m_api')->get_member_lastname_by_id($row->member_id);
				$member_name  = $member_fname .' '. $member_lname;
				$member_phone = $CI->load->model('m_api')->get_member_phone_by_id($row->member_id);
				$member_image = $CI->load->model('m_api')->get_member_image_by_id($row->member_id);
				
				if($member_image == "") {
					$member_image = "no_images.png";
				}
				else {
					$member_image = "member/". $member_image;
				}
				
				$result = array(
					'id' 				=> $row->emergency_id,
					'date'				=> convert_to_ymd($row->emergency_date),
					'time'				=> convert_to_his($row->emergency_time),
					'callername'		=> strip_tags($row->emergency_callername),
					'callerphone'		=> $row->emergency_callerphone,
					'latitude'			=> $row->emergency_infolatitude,
					'longitude'			=> $row->emergency_infolongitude,
					'address'			=> $row->emergency_infostreet,
					'patientname'		=> strip_tags($row->emergency_patientname),
					'distance'			=> $row->emergency_distance,
					'eta'				=> $row->emergency_eta,
					'ambulance'			=> (($row->ambulance_id == "")?"-":$CI->load->model('m_api')->get_plat_ambulance_by_id($row->ambulance_id)),
					'distance_ambulance'=> (($row->ambulance_id == "")?"-":$CI->load->model('m_api')->get_distance_ambulance_by_id($row->ambulance_id)),
					'eta_ambulance'		=> (($row->ambulance_id == "")?"-":$CI->load->model('m_api')->get_eta_ambulance_by_id($row->ambulance_id)),
					'status'				=> get_transaction($row->emergency_status),
					'member_name'			=> $member_name,
					'member_phone'			=> $member_phone,
					'member_image'			=> base_url() ."assets/uploads/". $member_image
				);
			}	
		}
		
		return $result;
	}
	
	function set_emergency_history($query) {
		$CI =& get_instance();
		
		$result = array();
		if(!empty($query)) {
			foreach($query as $row) {
				$member_fname = $CI->load->model('m_api')->get_member_firstname_by_id($row->member_id);
				$member_lname = $CI->load->model('m_api')->get_member_lastname_by_id($row->member_id);
				$member_name  = $member_fname .' '. $member_lname;
				$member_phone = $CI->load->model('m_api')->get_member_phone_by_id($row->member_id);
				$member_image = $CI->load->model('m_api')->get_member_image_by_id($row->member_id);
				
				if($member_image == "") {
					$member_image = "no_images.png";
				}
				else {
					$member_image = "member/". $member_image;
				}
				
				$result = array(
					'id' 					=> $row->emergency_id,
					'callreference' 		=> $row->emergency_callreference,
					'date'					=> convert_to_ymd($row->emergency_date),
					'time'					=> convert_to_his($row->emergency_time),
					'callername'			=> strip_tags($row->emergency_callername),
					'callerphone'			=> $row->emergency_callerphone,
					'latitude'				=> $row->emergency_infolatitude,
					'longitude'				=> $row->emergency_infolongitude,
					'address'				=> $row->emergency_infostreet,
					'patientname'			=> strip_tags($row->emergency_patientname),
					'time_confirmed'		=> (($row->time_confirmed == "")?"":convert_to_ymdhis($row->time_confirmed)),
					'time_waiting'			=> (($row->time_waiting == "")?"-":convert_to_ymdhis($row->time_waiting)),
					'time_set_crew'			=> (($row->time_set_crew == "")?"-":convert_to_ymdhis($row->time_set_crew)),
					'time_to_patient'		=> (($row->time_to_patient == "")?"-":convert_to_ymdhis($row->time_to_patient)),
					'time_call_patient'		=> (($row->time_call_patient == "")?"-":convert_to_ymdhis($row->time_call_patient)),
					'time_arrived_patient'	=> (($row->time_arrived_patient == "")?"-":convert_to_ymdhis($row->time_arrived_patient)),
					'time_to_hospital'		=> (($row->time_to_hospital == "")?"-":convert_to_ymdhis($row->time_to_hospital)),
					'time_arrived_hospital'	=> (($row->time_arrived_hospital == "")?"-":convert_to_ymdhis($row->time_arrived_hospital)),
					'time_back_hospital'	=> (($row->time_back_hospital == "")?"-":convert_to_ymdhis($row->time_back_hospital)),
					'time_complete'			=> (($row->time_complete == "")?"-":convert_to_ymdhis($row->time_complete)),
					'time_cancel'			=> (($row->time_cancel == "")?"-":convert_to_ymdhis($row->time_cancel)),
					'reason_cancel'			=> strip_tags($row->reason_cancel),
					'time_reject'			=> (($row->time_reject == "")?"-":convert_to_ymdhis($row->time_reject)),
					'reason_reject'			=> strip_tags($row->reason_reject),
					'case_type'				=> (($row->subcategory_id == "")?"-":$CI->load->model('m_api')->get_name_subcategory_by_id($row->subcategory_id)),
					'hospital'				=> (($row->forward_id == "")?"-":$CI->load->model('m_api')->get_name_hospital_by_id($CI->load->model('m_api')->get_hospital_by_forward($row->forward_id))),
					'ambulance'				=> (($row->ambulance_id == "")?"-":$CI->load->model('m_api')->get_plat_ambulance_by_id($row->ambulance_id)),
					'status'				=> get_transaction($row->emergency_status),
					'member_name'			=> $member_name,
					'member_phone'			=> $member_phone,
					'member_image'			=> base_url() ."assets/uploads/". $member_image
				);
			}	
		}
		
		return $result;
	}
	
	function set_emergency_list($query) {
		$CI =& get_instance();
		
		$result = array();
		if(!empty($query)) {
			foreach($query as $row) {
				$member_fname = $CI->load->model('m_api')->get_member_firstname_by_id($row->member_id);
				$member_lname = $CI->load->model('m_api')->get_member_lastname_by_id($row->member_id);
				$member_name  = $member_fname .' '. $member_lname;
				$member_phone = $CI->load->model('m_api')->get_member_phone_by_id($row->member_id);
				$member_image = $CI->load->model('m_api')->get_member_image_by_id($row->member_id);
				
				if($member_image == "") {
					$member_image = "no_images.png";
				}
				else {
					$member_image = "member/". $member_image;
				}
				
				$result[] = array(
					'id' 					=> $row->emergency_id,
					'callreference' 		=> $row->emergency_callreference,
					'date'					=> convert_to_ymd($row->emergency_date),
					'time'					=> convert_to_his($row->emergency_time),
					'callername'			=> strip_tags($row->emergency_callername),
					'callerphone'			=> $row->emergency_callerphone,
					'latitude'				=> $row->emergency_infolatitude,
					'longitude'				=> $row->emergency_infolongitude,
					'address'				=> $row->emergency_infostreet,
					'patientname'			=> strip_tags($row->emergency_patientname),
					'time_confirmed'		=> (($row->time_confirmed == "")?"":convert_to_ymdhis($row->time_confirmed)),
					'time_waiting'			=> (($row->time_waiting == "")?"-":convert_to_ymdhis($row->time_waiting)),
					'time_set_crew'			=> (($row->time_set_crew == "")?"-":convert_to_ymdhis($row->time_set_crew)),
					'time_to_patient'		=> (($row->time_to_patient == "")?"-":convert_to_ymdhis($row->time_to_patient)),
					'time_call_patient'		=> (($row->time_call_patient == "")?"-":convert_to_ymdhis($row->time_call_patient)),
					'time_arrived_patient'	=> (($row->time_arrived_patient == "")?"-":convert_to_ymdhis($row->time_arrived_patient)),
					'time_to_hospital'		=> (($row->time_to_hospital == "")?"-":convert_to_ymdhis($row->time_to_hospital)),
					'time_arrived_hospital'	=> (($row->time_arrived_hospital == "")?"-":convert_to_ymdhis($row->time_arrived_hospital)),
					'time_back_hospital'	=> (($row->time_back_hospital == "")?"-":convert_to_ymdhis($row->time_back_hospital)),
					'time_complete'			=> (($row->time_complete == "")?"-":convert_to_ymdhis($row->time_complete)),
					'time_cancel'			=> (($row->time_cancel == "")?"-":convert_to_ymdhis($row->time_cancel)),
					'reason_cancel'			=> strip_tags($row->reason_cancel),
					'time_reject'			=> (($row->time_reject == "")?"-":convert_to_ymdhis($row->time_reject)),
					'reason_reject'			=> strip_tags($row->reason_reject),
					'case_type'				=> (($row->subcategory_id == "")?"-":$CI->load->model('m_api')->get_name_subcategory_by_id($row->subcategory_id)),
					'hospital'				=> (($row->forward_id == "")?"-":$CI->load->model('m_api')->get_name_hospital_by_id($CI->load->model('m_api')->get_hospital_by_forward($row->forward_id))),
					'ambulance'				=> (($row->ambulance_id == "")?"-":$CI->load->model('m_api')->get_plat_ambulance_by_id($row->ambulance_id)),
					'status'				=> get_transaction($row->emergency_status),
					'member_name'			=> $member_name,
					'member_phone'			=> $member_phone,
					'member_image'			=> base_url() ."assets/uploads/". $member_image
				);
			}	
		}
		
		return $result;
	}
	
	function set_emergency_driver($id) {
		$CI =& get_instance();
		
		$result = array();
		$query = $CI->load->model('m_global')->get_by_id('td_emergencydriver', 'emergency_id', $id);
		if(!empty($query)) {
			foreach($query as $row) {
				$detail = $CI->load->model('m_global')->get_by_id('tm_driver', 'driver_id', $row->driver_id);
				foreach($detail as $rows) {
					$result[] = array(
						'driver_id' 	=> $row->driver_id,
						'driver_name'	=> strip_tags($rows->driver_name),
						'driver_phone'	=> $rows->driver_phone
					);
				}
			}	
		}
		
		return $result;
	}
	
	function set_emergency_doctor($id) {
		$CI =& get_instance();
		
		$result = array();
		$query = $CI->load->model('m_global')->get_by_id('td_emergencydoctor', 'emergency_id', $id);
		if(!empty($query)) {
			foreach($query as $row) {
				$detail = $CI->load->model('m_global')->get_by_id('tm_doctor', 'doctor_id', $row->doctor_id);
				foreach($detail as $rows) {
					$result[] = array(
						'doctor_id' 	=> $row->doctor_id,
						'doctor_name'	=> strip_tags($rows->doctor_name),
						'doctor_phone'	=> $rows->doctor_phone
					);
				}
			}	
		}
		
		return $result;
	}
	
	function set_emergency_nurse($id) {
		$CI =& get_instance();
		
		$result = array();
		$query = $CI->load->model('m_global')->get_by_id('td_emergencynurse', 'emergency_id', $id);
		if(!empty($query)) {
			foreach($query as $row) {
				$detail = $CI->load->model('m_global')->get_by_id('tm_nurse', 'nurse_id', $row->nurse_id);
				foreach($detail as $rows) {
					$result[] = array(
						'nurse_id' 		=> $row->nurse_id,
						'nurse_name'	=> strip_tags($rows->nurse_name),
						'nurse_phone'	=> $rows->nurse_phone
					);
				}
			}	
		}
		
		return $result;
	}
	
	function get_nonemergency_track_detail($query) {
		$CI =& get_instance();
		
		$result = array();
		if(!empty($query)) {
			foreach($query as $row) {
				$member_fname = $CI->load->model('m_api')->get_member_firstname_by_id($row->member_id);
				$member_lname = $CI->load->model('m_api')->get_member_lastname_by_id($row->member_id);
				$member_name  = $member_fname .' '. $member_lname;
				$member_phone = $CI->load->model('m_api')->get_member_phone_by_id($row->member_id);
				$member_image = $CI->load->model('m_api')->get_member_image_by_id($row->member_id);
				
				if($member_image == "") {
					$member_image = "no_images.png";
				}
				else {
					$member_image = "member/". $member_image;
				}
				
				$latitude_ambulance 	= "";
				$longitude_ambulance 	= "";
				$rotation_ambulance 	= "";
				$plat_ambulance 		= "";
				$distance_ambulance 	= "";
				$eta_ambulance 	= "";
				
				$detail_ambulance = $CI->load->model('m_global')->get_by_id('tm_ambulance', 'ambulance_id', $row->ambulance_id);
				foreach($detail_ambulance as $rows) {
					$latitude_ambulance 	= $rows->ambulance_tracklatitude;
					$longitude_ambulance 	= $rows->ambulance_tracklongitude;
					$rotation_ambulance 	= $rows->ambulance_trackrotation;
					$plat_ambulance			= $rows->ambulance_police;
					$distance_ambulance		= $rows->ambulance_distance;
					$eta_ambulance			= $rows->ambulance_eta;
				}
				
				$from_latitude_hospital 	= "";
				$from_longitude_hospital 	= "";
				$from_hospital 				= "";
				
				$detail_from_hospital = $CI->load->model('m_global')->get_by_id('tm_hospital', 'hospital_id', $row->nonemergency_fromhospital);
				foreach($detail_from_hospital as $rows) {
					$from_latitude_hospital 	= $rows->hospital_latitude;
					$from_longitude_hospital 	= $rows->hospital_longitude;
					$from_hospital				= strip_tags($rows->hospital_name);
				}
				
				$to_latitude_hospital 	= "";
				$to_longitude_hospital 	= "";
				$to_hospital 			= "";
				
				$detail_to_hospital = $CI->load->model('m_global')->get_by_id('tm_hospital', 'hospital_id', $row->nonemergency_tohospital);
				foreach($detail_to_hospital as $rows) {
					$to_latitude_hospital 	= $rows->hospital_latitude;
					$to_longitude_hospital 	= $rows->hospital_longitude;
					$to_hospital			= strip_tags($rows->hospital_name);
				}
				
				$result = array(
					'id' 						=> $row->nonemergency_id,
					'callreference' 			=> $row->nonemergency_callreference,
					'date'						=> convert_to_ymd($row->nonemergency_date),
					'time'						=> convert_to_his($row->nonemergency_time),
					'infoname'					=> strip_tags($row->nonemergency_infoname),
					'infophone'					=> $row->nonemergency_infophone,
					'infodate'					=> convert_to_dmy($row->nonemergency_infodate),
					'infotime'					=> convert_to_his($row->nonemergency_infotime),
					'infodiagnosis'				=> $row->nonemergency_infodiagnosis,
					'infoconsultant'			=> $row->nonemergency_infoconsultant,
					'inforeason'				=> $row->nonemergency_inforeason,	
					'requestname'				=> $row->nonemergency_requestname,
					'requestdepartment'			=> $row->nonemergency_requestdepartment,
					'requesttittle'				=> $row->nonemergency_requesttittle,
					'from'						=> (($row->nonemergency_from == 0)?"INTERNAL LOCATION":"EXTERNAL LOCATION"),
					'from_latitude_hospital'	=> $from_latitude_hospital,
					'from_longitude_hospital'	=> $from_longitude_hospital,
					'from_hospital'				=> $from_hospital,
					'from_unit'					=> (($row->nonemergency_fromunit == "")?"-":$CI->load->model('m_api')->get_name_unit_by_id($row->nonemergency_fromunit)),
					'from_bed'					=> $row->nonemergency_frombed,
					'from_latitude'				=> $row->nonemergency_fromlatitude,
					'from_longitude'			=> $row->nonemergency_fromlongitude,
					'from_address'				=> $row->nonemergency_fromstreet,
					'from_area'					=> (($row->nonemergency_fromarea == "")?"-":$CI->load->model('m_api')->get_name_area_by_id($row->nonemergency_fromarea)),
					'from_area_detail'			=> (($row->nonemergency_fromlocation == "")?"-":$CI->load->model('m_api')->get_name_location_by_id($row->nonemergency_fromlocation)),
					'to'						=> (($row->nonemergency_to == 0)?"INTERNAL LOCATION":"EXTERNAL LOCATION"),
					'to_latitude_hospital'		=> $to_latitude_hospital,
					'to_longitude_hospital'		=> $to_longitude_hospital,
					'to_hospital'				=> $to_hospital,
					'to_unit'					=> (($row->nonemergency_tounit == "")?"-":$CI->load->model('m_api')->get_name_unit_by_id($row->nonemergency_tounit)),
					'to_bed'					=> $row->nonemergency_tobed,
					'to_latitude'				=> $row->nonemergency_tolatitude,
					'to_longitude'				=> $row->nonemergency_tolongitude,
					'to_address'				=> $row->nonemergency_tostreet,
					'to_area'					=> (($row->nonemergency_toarea == "")?"-":$CI->load->model('m_api')->get_name_area_by_id($row->nonemergency_toarea)),
					'to_area_detail'			=> (($row->nonemergency_tolocation == "")?"-":$CI->load->model('m_api')->get_name_location_by_id($row->nonemergency_tolocation)),
					'distance'					=> $row->nonemergency_distance,
					'time_confirmed'			=> (($row->time_confirmed == "")?"":convert_to_ymdhis($row->time_confirmed)),
					'time_waiting'				=> (($row->time_waiting == "")?"-":convert_to_ymdhis($row->time_waiting)),
					'time_set_crew'				=> (($row->time_set_crew == "")?"-":convert_to_ymdhis($row->time_set_crew)),
					'time_to_patient'			=> (($row->time_to_patient == "")?"-":convert_to_ymdhis($row->time_to_patient)),
					'time_call_patient'			=> (($row->time_call_patient == "")?"-":convert_to_ymdhis($row->time_call_patient)),
					'time_arrived_patient'		=> (($row->time_arrived_patient == "")?"-":convert_to_ymdhis($row->time_arrived_patient)),
					'time_to_hospital'			=> (($row->time_to_hospital == "")?"-":convert_to_ymdhis($row->time_to_hospital)),
					'time_arrived_hospital'		=> (($row->time_arrived_hospital == "")?"-":convert_to_ymdhis($row->time_arrived_hospital)),
					'time_back_hospital'		=> (($row->time_back_hospital == "")?"-":convert_to_ymdhis($row->time_back_hospital)),
					'time_complete'				=> (($row->time_complete == "")?"-":convert_to_ymdhis($row->time_complete)),
					'time_cancel'				=> (($row->time_cancel == "")?"-":convert_to_ymdhis($row->time_cancel)),
					'reason_cancel'				=> strip_tags($row->reason_cancel),
					'time_reject'				=> (($row->time_reject == "")?"-":convert_to_ymdhis($row->time_reject)),
					'reason_reject'				=> strip_tags($row->reason_reject),
					'case_noncategory'			=> (($row->subcategory_case == "")?"-":$CI->load->model('m_api')->get_name_subcategory_by_id($row->subcategory_case)),
					'case_type'					=> (($row->subcategory_id == "")?"-":$CI->load->model('m_api')->get_name_subcategory_by_id($row->subcategory_id)),
					'transfer'					=> (($row->transfer_id == "")?"-":$CI->load->model('m_api')->get_name_transfer_by_id($row->transfer)),
					'latitude_ambulance'		=> $latitude_ambulance,
					'longitude_ambulance'		=> $longitude_ambulance,
					'rotation_ambulance'		=> $rotation_ambulance,
					'ambulance'					=> $plat_ambulance,
					'distance_ambulance'		=> $distance_ambulance,
					'eta_ambulance'				=> $eta_ambulance,
					'status'					=> get_transaction($row->nonemergency_status),
					'member_name'				=> $member_name,
					'member_phone'				=> $member_phone,
					'member_image'				=> base_url() ."assets/uploads/". $member_image
				);
			}	
		}
		
		return $result;
	}
	
	function set_nonemergency($query) {
		$CI =& get_instance();
		
		$result = array();
		if(!empty($query)) {
			foreach($query as $row) {
				$member_fname = $CI->load->model('m_api')->get_member_firstname_by_id($row->member_id);
				$member_lname = $CI->load->model('m_api')->get_member_lastname_by_id($row->member_id);
				$member_name  = $member_fname .' '. $member_lname;
				$member_phone = $CI->load->model('m_api')->get_member_phone_by_id($row->member_id);
				$member_image = $CI->load->model('m_api')->get_member_image_by_id($row->member_id);
				
				if($member_image == "") {
					$member_image = "no_images.png";
				}
				else {
					$member_image = "member/". $member_image;
				}
				
				$result = array(
					'id' 					=> $row->nonemergency_id,
					'callreference' 		=> $row->nonemergency_callreference,
					'date'					=> convert_to_ymd($row->nonemergency_date),
					'time'					=> convert_to_his($row->nonemergency_time),
					'infoname'				=> strip_tags($row->nonemergency_infoname),
					'infophone'				=> $row->nonemergency_infophone,
					'infodate'				=> convert_to_dmy($row->nonemergency_infodate),
					'infotime'				=> convert_to_his($row->nonemergency_infotime),
					'infodiagnosis'			=> $row->nonemergency_infodiagnosis,
					'infoconsultant'		=> $row->nonemergency_infoconsultant,
					'inforeason'			=> $row->nonemergency_inforeason,	
					'requestname'			=> $row->nonemergency_requestname,
					'requestdepartment'		=> $row->nonemergency_requestdepartment,
					'requesttittle'			=> $row->nonemergency_requesttittle,
					'from'					=> (($row->nonemergency_from == 0)?"INTERNAL LOCATION":"EXTERNAL LOCATION"),
					'from_hospital'			=> (($row->nonemergency_fromhospital == "")?"-":$CI->load->model('m_api')->get_name_hospital_by_id($row->nonemergency_fromhospital)),
					'from_unit'				=> (($row->nonemergency_fromunit == "")?"-":$CI->load->model('m_api')->get_name_unit_by_id($row->nonemergency_fromunit)),
					'from_bed'				=> $row->nonemergency_frombed,
					'from_latitude'			=> $row->nonemergency_fromlatitude,
					'from_longitude'		=> $row->nonemergency_fromlongitude,
					'from_address'			=> $row->nonemergency_fromstreet,
					'from_area'				=> (($row->nonemergency_fromarea == "")?"-":$CI->load->model('m_api')->get_name_area_by_id($row->nonemergency_fromarea)),
					'from_area_detail'		=> (($row->nonemergency_fromlocation == "")?"-":$CI->load->model('m_api')->get_name_location_by_id($row->nonemergency_fromlocation)),
					'to'					=> (($row->nonemergency_to == 0)?"INTERNAL LOCATION":"EXTERNAL LOCATION"),
					'to_hospital'			=> (($row->nonemergency_tohospital == "")?"-":$CI->load->model('m_api')->get_name_hospital_by_id($row->nonemergency_tohospital)),
					'to_unit'				=> (($row->nonemergency_tounit == "")?"-":$CI->load->model('m_api')->get_name_unit_by_id($row->nonemergency_tounit)),
					'to_bed'				=> $row->nonemergency_tobed,
					'to_latitude'			=> $row->nonemergency_tolatitude,
					'to_longitude'			=> $row->nonemergency_tolongitude,
					'to_address'			=> $row->nonemergency_tostreet,
					'to_area'				=> (($row->nonemergency_toarea == "")?"-":$CI->load->model('m_api')->get_name_area_by_id($row->nonemergency_toarea)),
					'to_area_detail'		=> (($row->nonemergency_tolocation == "")?"-":$CI->load->model('m_api')->get_name_location_by_id($row->nonemergency_tolocation)),
					'distance'				=> $row->nonemergency_distance,
					'time_confirmed'		=> (($row->time_confirmed == "")?"":convert_to_ymdhis($row->time_confirmed)),
					'time_waiting'			=> (($row->time_waiting == "")?"-":convert_to_ymdhis($row->time_waiting)),
					'time_set_crew'			=> (($row->time_set_crew == "")?"-":convert_to_ymdhis($row->time_set_crew)),
					'time_to_patient'		=> (($row->time_to_patient == "")?"-":convert_to_ymdhis($row->time_to_patient)),
					'time_call_patient'		=> (($row->time_call_patient == "")?"-":convert_to_ymdhis($row->time_call_patient)),
					'time_arrived_patient'	=> (($row->time_arrived_patient == "")?"-":convert_to_ymdhis($row->time_arrived_patient)),
					'time_to_hospital'		=> (($row->time_to_hospital == "")?"-":convert_to_ymdhis($row->time_to_hospital)),
					'time_arrived_hospital'	=> (($row->time_arrived_hospital == "")?"-":convert_to_ymdhis($row->time_arrived_hospital)),
					'time_back_hospital'	=> (($row->time_back_hospital == "")?"-":convert_to_ymdhis($row->time_back_hospital)),
					'time_complete'			=> (($row->time_complete == "")?"-":convert_to_ymdhis($row->time_complete)),
					'time_cancel'			=> (($row->time_cancel == "")?"-":convert_to_ymdhis($row->time_cancel)),
					'reason_cancel'			=> strip_tags($row->reason_cancel),
					'time_reject'			=> (($row->time_reject == "")?"-":convert_to_ymdhis($row->time_reject)),
					'reason_reject'			=> strip_tags($row->reason_reject),
					'case_noncategory'		=> (($row->subcategory_case == "")?"-":$CI->load->model('m_api')->get_name_subcategory_by_id($row->subcategory_case)),
					'case_type'				=> (($row->subcategory_id == "")?"-":$CI->load->model('m_api')->get_name_subcategory_by_id($row->subcategory_id)),
					'transfer'				=> (($row->transfer_id == "")?"-":$CI->load->model('m_api')->get_name_transfer_by_id($row->transfer)),
					'ambulance'				=> (($row->ambulance_id == "")?"-":$CI->load->model('m_api')->get_plat_ambulance_by_id($row->ambulance_id)),
					'status'				=> get_transaction($row->nonemergency_status),
					'member_name'			=> $member_name,
					'member_phone'			=> $member_phone,
					'member_image'			=> base_url() ."assets/uploads/". $member_image
				);
			}	
		}
		
		return $result;
	}
	
	function set_nonemergency_track($query) {
		$CI =& get_instance();
		
		$result = array();
		if(!empty($query)) {
			foreach($query as $row) {
				$member_fname = $CI->load->model('m_api')->get_member_firstname_by_id($row->member_id);
				$member_lname = $CI->load->model('m_api')->get_member_lastname_by_id($row->member_id);
				$member_name  = $member_fname .' '. $member_lname;
				$member_phone = $CI->load->model('m_api')->get_member_phone_by_id($row->member_id);
				$member_image = $CI->load->model('m_api')->get_member_image_by_id($row->member_id);
				
				if($member_image == "") {
					$member_image = "no_images.png";
				}
				else {
					$member_image = "member/". $member_image;
				}
				
				$latitude_ambulance 	= "";
				$longitude_ambulance 	= "";
				$rotation_ambulance 	= "";
				$plat_ambulance 		= "";
				$distance_ambulance 	= "";
				$eta_ambulance 			= "";
				
				$detail_ambulance = $CI->load->model('m_global')->get_by_id('tm_ambulance', 'ambulance_id', $row->ambulance_id);
				foreach($detail_ambulance as $rows) {
					$latitude_ambulance 	= $rows->ambulance_tracklatitude;
					$longitude_ambulance 	= $rows->ambulance_tracklongitude;
					$rotation_ambulance 	= $rows->ambulance_trackrotation;
					$plat_ambulance			= $rows->ambulance_police;
					$distance_ambulance		= $rows->ambulance_distance;
					$eta_ambulance			= $rows->ambulance_eta;
				}
				
				$result = array(
					'id' 					=> $row->nonemergency_id,
					'callreference' 		=> $row->nonemergency_callreference,
					'date'					=> convert_to_ymd($row->nonemergency_date),
					'time'					=> convert_to_his($row->nonemergency_time),
					'infoname'				=> strip_tags($row->nonemergency_infoname),
					'infophone'				=> $row->nonemergency_infophone,
					'infodate'				=> convert_to_dmy($row->nonemergency_infodate),
					'infotime'				=> convert_to_his($row->nonemergency_infotime),
					'from'					=> (($row->nonemergency_from == 0)?"INTERNAL LOCATION":"EXTERNAL LOCATION"),
					'from_hospital'			=> (($row->nonemergency_fromhospital == "")?"-":$CI->load->model('m_api')->get_name_hospital_by_id($row->nonemergency_fromhospital)),
					'from_unit'				=> (($row->nonemergency_fromunit == "")?"-":$CI->load->model('m_api')->get_name_unit_by_id($row->nonemergency_fromunit)),
					'from_bed'				=> $row->nonemergency_frombed,
					'from_latitude'			=> $row->nonemergency_fromlatitude,
					'from_longitude'		=> $row->nonemergency_fromlongitude,
					'from_address'			=> $row->nonemergency_fromstreet,
					'to'					=> (($row->nonemergency_to == 0)?"INTERNAL LOCATION":"EXTERNAL LOCATION"),
					'to_hospital'			=> (($row->nonemergency_tohospital == "")?"-":$CI->load->model('m_api')->get_name_hospital_by_id($row->nonemergency_tohospital)),
					'to_unit'				=> (($row->nonemergency_tounit == "")?"-":$CI->load->model('m_api')->get_name_unit_by_id($row->nonemergency_tounit)),
					'to_bed'				=> $row->nonemergency_tobed,
					'to_latitude'			=> $row->nonemergency_tolatitude,
					'to_longitude'			=> $row->nonemergency_tolongitude,
					'to_address'			=> $row->nonemergency_tostreet,
					'distance'				=> $row->nonemergency_distance,
					'eta'					=> $row->nonemergency_eta,
					'latitude_ambulance'	=> $latitude_ambulance,
					'longitude_ambulance'	=> $longitude_ambulance,
					'rotation_ambulance'	=> $rotation_ambulance,
					'ambulance'				=> $plat_ambulance,
					'distance_ambulance'	=> $distance_ambulance,
					'eta_ambulance'			=> $eta_ambulance,
					'status'				=> get_transaction($row->nonemergency_status),
					'member_name'			=> $member_name,
					'member_phone'			=> $member_phone,
					'member_image'			=> base_url() ."assets/uploads/". $member_image
				);
			}	
		}
		
		return $result;
	}
	
	function set_nonemergency_tracking($query) {
		$CI =& get_instance();
		
		$result = array();
		if(!empty($query)) {
			foreach($query as $row) {
				$member_fname = $CI->load->model('m_api')->get_member_firstname_by_id($row->member_id);
				$member_lname = $CI->load->model('m_api')->get_member_lastname_by_id($row->member_id);
				$member_name  = $member_fname .' '. $member_lname;
				$member_phone = $CI->load->model('m_api')->get_member_phone_by_id($row->member_id);
				$member_image = $CI->load->model('m_api')->get_member_image_by_id($row->member_id);
				
				if($member_image == "") {
					$member_image = "no_images.png";
				}
				else {
					$member_image = "member/". $member_image;
				}
				
				$result = array(
					'id' 				=> $row->nonemergency_id,
					'callreference' 	=> $row->nonemergency_callreference,
					'date'				=> convert_to_ymd($row->nonemergency_date),
					'time'				=> convert_to_his($row->nonemergency_time),
					'infoname'			=> strip_tags($row->nonemergency_infoname),
					'infophone'			=> $row->nonemergency_infophone,
					'infodate'			=> convert_to_dmy($row->nonemergency_infodate),
					'infotime'			=> convert_to_his($row->nonemergency_infotime),
					'from'				=> (($row->nonemergency_from == 0)?"INTERNAL LOCATION":"EXTERNAL LOCATION"),
					'from_hospital'		=> (($row->nonemergency_fromhospital == "")?"-":$CI->load->model('m_api')->get_name_hospital_by_id($row->nonemergency_fromhospital)),
					'from_unit'			=> (($row->nonemergency_fromunit == "")?"-":$CI->load->model('m_api')->get_name_unit_by_id($row->nonemergency_fromunit)),
					'from_bed'			=> $row->nonemergency_frombed,
					'from_latitude'		=> $row->nonemergency_fromlatitude,
					'from_longitude'	=> $row->nonemergency_fromlongitude,
					'from_address'		=> $row->nonemergency_fromstreet,
					'to'				=> (($row->nonemergency_to == 0)?"INTERNAL LOCATION":"EXTERNAL LOCATION"),
					'to_hospital'		=> (($row->nonemergency_tohospital == "")?"-":$CI->load->model('m_api')->get_name_hospital_by_id($row->nonemergency_tohospital)),
					'to_unit'			=> (($row->nonemergency_tounit == "")?"-":$CI->load->model('m_api')->get_name_unit_by_id($row->nonemergency_tounit)),
					'to_bed'			=> $row->nonemergency_tobed,
					'to_latitude'		=> $row->nonemergency_tolatitude,
					'to_longitude'		=> $row->nonemergency_tolongitude,
					'to_address'		=> $row->nonemergency_tostreet,
					'distance'			=> $row->nonemergency_distance,
					'eta'				=> $row->nonemergency_eta,
					'ambulance'			=> (($row->ambulance_id == "")?"-":$CI->load->model('m_api')->get_plat_ambulance_by_id($row->ambulance_id)),
					'distance_ambulance'=> (($row->ambulance_id == "")?"-":$CI->load->model('m_api')->get_distance_ambulance_by_id($row->ambulance_id)),
					'eta_ambulance'		=> (($row->ambulance_id == "")?"-":$CI->load->model('m_api')->get_eta_ambulance_by_id($row->ambulance_id)),
					'status'			=> get_transaction($row->nonemergency_status),
					'member_name'		=> $member_name,
					'member_phone'		=> $member_phone,
					'member_image'			=> base_url() ."assets/uploads/". $member_image
				);
			}	
		}
		
		return $result;
	}
	
	function set_nonemergency_history($query) {
		$CI =& get_instance();
		
		$result = array();
		if(!empty($query)) {
			foreach($query as $row) {
				$member_fname = $CI->load->model('m_api')->get_member_firstname_by_id($row->member_id);
				$member_lname = $CI->load->model('m_api')->get_member_lastname_by_id($row->member_id);
				$member_name  = $member_fname .' '. $member_lname;
				$member_phone = $CI->load->model('m_api')->get_member_phone_by_id($row->member_id);
				$member_image = $CI->load->model('m_api')->get_member_image_by_id($row->member_id);
				
				if($member_image == "") {
					$member_image = "no_images.png";
				}
				else {
					$member_image = "member/". $member_image;
				}
				
				$result[] = array(
					'id' 					=> $row->nonemergency_id,
					'callreference' 		=> $row->nonemergency_callreference,
					'date'					=> convert_to_ymd($row->nonemergency_date),
					'time'					=> convert_to_his($row->nonemergency_time),
					'infoname'				=> strip_tags($row->nonemergency_infoname),
					'infophone'				=> $row->nonemergency_infophone,
					'infodate'				=> convert_to_dmy($row->nonemergency_infodate),
					'infotime'				=> convert_to_his($row->nonemergency_infotime),
					'infodiagnosis'			=> $row->nonemergency_infodiagnosis,
					'infoconsultant'		=> $row->nonemergency_infoconsultant,
					'inforeason'			=> $row->nonemergency_inforeason,	
					'requestname'			=> $row->nonemergency_requestname,
					'requestdepartment'		=> $row->nonemergency_requestdepartment,
					'requesttittle'			=> $row->nonemergency_requesttittle,
					'from_latitude'			=> $row->nonemergency_fromlatitude,
					'from_longitude'		=> $row->nonemergency_fromlongitude,
					'from_address'			=> $row->nonemergency_fromstreet,
					'to_latitude'			=> $row->nonemergency_tolatitude,
					'to_longitude'			=> $row->nonemergency_tolongitude,
					'to_address'			=> $row->nonemergency_tostreet,
					'time_confirmed'		=> (($row->time_confirmed == "")?"":convert_to_ymdhis($row->time_confirmed)),
					'time_waiting'			=> (($row->time_waiting == "")?"-":convert_to_ymdhis($row->time_waiting)),
					'time_set_crew'			=> (($row->time_set_crew == "")?"-":convert_to_ymdhis($row->time_set_crew)),
					'time_to_patient'		=> (($row->time_to_patient == "")?"-":convert_to_ymdhis($row->time_to_patient)),
					'time_call_patient'		=> (($row->time_call_patient == "")?"-":convert_to_ymdhis($row->time_call_patient)),
					'time_arrived_patient'	=> (($row->time_arrived_patient == "")?"-":convert_to_ymdhis($row->time_arrived_patient)),
					'time_to_hospital'		=> (($row->time_to_hospital == "")?"-":convert_to_ymdhis($row->time_to_hospital)),
					'time_arrived_hospital'	=> (($row->time_arrived_hospital == "")?"-":convert_to_ymdhis($row->time_arrived_hospital)),
					'time_back_hospital'	=> (($row->time_back_hospital == "")?"-":convert_to_ymdhis($row->time_back_hospital)),
					'time_complete'			=> (($row->time_complete == "")?"-":convert_to_ymdhis($row->time_complete)),
					'time_cancel'			=> (($row->time_cancel == "")?"-":convert_to_ymdhis($row->time_cancel)),
					'reason_cancel'			=> strip_tags($row->reason_cancel),
					'time_reject'			=> (($row->time_reject == "")?"-":convert_to_ymdhis($row->time_reject)),
					'reason_reject'			=> strip_tags($row->reason_reject),
					'case_noncategory'		=> (($row->subcategory_case == "")?"-":$CI->load->model('m_api')->get_name_subcategory_by_id($row->subcategory_case)),
					'case_type'				=> (($row->subcategory_id == "")?"-":$CI->load->model('m_api')->get_name_subcategory_by_id($row->subcategory_id)),
					'ambulance'				=> (($row->ambulance_id == "")?"-":$CI->load->model('m_api')->get_plat_ambulance_by_id($row->ambulance_id)),
					'status'				=> get_transaction($row->nonemergency_status),
					'member_name'			=> $member_name,
					'member_phone'			=> $member_phone,
					'member_image'			=> base_url() ."assets/uploads/". $member_image
				);
			}	
		}
		
		return $result;
	}
	
	function set_nonemergency_call($query) {
		$CI =& get_instance();
		
		$result = array();
		if(!empty($query)) {
			foreach($query as $row) {
				$member_fname = $CI->load->model('m_api')->get_member_firstname_by_id($row->member_id);
				$member_lname = $CI->load->model('m_api')->get_member_lastname_by_id($row->member_id);
				$member_name  = $member_fname .' '. $member_lname;
				$member_phone = $CI->load->model('m_api')->get_member_phone_by_id($row->member_id);
				$member_image = $CI->load->model('m_api')->get_member_image_by_id($row->member_id);
				
				if($member_image == "") {
					$member_image = "no_images.png";
				}
				else {
					$member_image = "member/". $member_image;
				}
				
				$result = array(
					'id' 					=> $row->nonemergency_id,
					'callreference' 		=> $row->nonemergency_callreference,
					'date'					=> convert_to_ymd($row->nonemergency_date),
					'time'					=> convert_to_his($row->nonemergency_time),
					'infoname'				=> strip_tags($row->nonemergency_infoname),
					'infophone'				=> $row->nonemergency_infophone,
					'infodate'				=> convert_to_dmy($row->nonemergency_infodate),
					'infotime'				=> convert_to_his($row->nonemergency_infotime),
					'infodiagnosis'			=> $row->nonemergency_infodiagnosis,
					'infoconsultant'		=> $row->nonemergency_infoconsultant,
					'inforeason'			=> $row->nonemergency_inforeason,	
					'requestname'			=> $row->nonemergency_requestname,
					'requestdepartment'		=> $row->nonemergency_requestdepartment,
					'requesttittle'			=> $row->nonemergency_requesttittle,
					'from_latitude'			=> $row->nonemergency_fromlatitude,
					'from_longitude'		=> $row->nonemergency_fromlongitude,
					'from_address'			=> $row->nonemergency_fromstreet,
					'to_latitude'			=> $row->nonemergency_tolatitude,
					'to_longitude'			=> $row->nonemergency_tolongitude,
					'to_address'			=> $row->nonemergency_tostreet,
					'time_confirmed'		=> (($row->time_confirmed == "")?"":convert_to_ymdhis($row->time_confirmed)),
					'time_waiting'			=> (($row->time_waiting == "")?"-":convert_to_ymdhis($row->time_waiting)),
					'time_set_crew'			=> (($row->time_set_crew == "")?"-":convert_to_ymdhis($row->time_set_crew)),
					'time_to_patient'		=> (($row->time_to_patient == "")?"-":convert_to_ymdhis($row->time_to_patient)),
					'time_call_patient'		=> (($row->time_call_patient == "")?"-":convert_to_ymdhis($row->time_call_patient)),
					'time_arrived_patient'	=> (($row->time_arrived_patient == "")?"-":convert_to_ymdhis($row->time_arrived_patient)),
					'time_to_hospital'		=> (($row->time_to_hospital == "")?"-":convert_to_ymdhis($row->time_to_hospital)),
					'time_arrived_hospital'	=> (($row->time_arrived_hospital == "")?"-":convert_to_ymdhis($row->time_arrived_hospital)),
					'time_back_hospital'	=> (($row->time_back_hospital == "")?"-":convert_to_ymdhis($row->time_back_hospital)),
					'time_complete'			=> (($row->time_complete == "")?"-":convert_to_ymdhis($row->time_complete)),
					'time_cancel'			=> (($row->time_cancel == "")?"-":convert_to_ymdhis($row->time_cancel)),
					'reason_cancel'			=> strip_tags($row->reason_cancel),
					'time_reject'			=> (($row->time_reject == "")?"-":convert_to_ymdhis($row->time_reject)),
					'reason_reject'			=> strip_tags($row->reason_reject),
					'case_noncategory'		=> (($row->subcategory_case == "")?"-":$CI->load->model('m_api')->get_name_subcategory_by_id($row->subcategory_case)),
					'case_type'				=> (($row->subcategory_id == "")?"-":$CI->load->model('m_api')->get_name_subcategory_by_id($row->subcategory_id)),
					'ambulance'				=> (($row->ambulance_id == "")?"-":$CI->load->model('m_api')->get_plat_ambulance_by_id($row->ambulance_id)),
					'status'				=> get_transaction($row->nonemergency_status),
					'member_name'			=> $member_name,
					'member_phone'			=> $member_phone,
					'member_image'			=> base_url() ."assets/uploads/". $member_image
				);
			}	
		}
		
		return $result;
	}
	
	function set_nonemergency_list($query) {
		$CI =& get_instance();
		
		$result = array();
		if(!empty($query)) {
			foreach($query as $row) {
				$member_fname = $CI->load->model('m_api')->get_member_firstname_by_id($row->member_id);
				$member_lname = $CI->load->model('m_api')->get_member_lastname_by_id($row->member_id);
				$member_name  = $member_fname .' '. $member_lname;
				$member_phone = $CI->load->model('m_api')->get_member_phone_by_id($row->member_id);
				$member_image = $CI->load->model('m_api')->get_member_image_by_id($row->member_id);
				
				if($member_image == "") {
					$member_image = "no_images.png";
				}
				else {
					$member_image = "member/". $member_image;
				}
				
				$result[] = array(
					'id' 					=> $row->nonemergency_id,
					'callreference' 		=> $row->nonemergency_callreference,
					'date'					=> convert_to_ymd($row->nonemergency_date),
					'time'					=> convert_to_his($row->nonemergency_time),
					'infoname'				=> strip_tags($row->nonemergency_infoname),
					'infophone'				=> $row->nonemergency_infophone,
					'infodate'				=> convert_to_dmy($row->nonemergency_infodate),
					'infotime'				=> convert_to_his($row->nonemergency_infotime),
					'infodiagnosis'			=> $row->nonemergency_infodiagnosis,
					'infoconsultant'		=> $row->nonemergency_infoconsultant,
					'inforeason'			=> $row->nonemergency_inforeason,	
					'requestname'			=> $row->nonemergency_requestname,
					'requestdepartment'		=> $row->nonemergency_requestdepartment,
					'requesttittle'			=> $row->nonemergency_requesttittle,
					'from_latitude'			=> $row->nonemergency_fromlatitude,
					'from_longitude'		=> $row->nonemergency_fromlongitude,
					'from_address'			=> $row->nonemergency_fromstreet,
					'to_latitude'			=> $row->nonemergency_tolatitude,
					'to_longitude'			=> $row->nonemergency_tolongitude,
					'to_address'			=> $row->nonemergency_tostreet,
					'time_confirmed'		=> (($row->time_confirmed == "")?"":convert_to_ymdhis($row->time_confirmed)),
					'time_waiting'			=> (($row->time_waiting == "")?"-":convert_to_ymdhis($row->time_waiting)),
					'time_set_crew'			=> (($row->time_set_crew == "")?"-":convert_to_ymdhis($row->time_set_crew)),
					'time_to_patient'		=> (($row->time_to_patient == "")?"-":convert_to_ymdhis($row->time_to_patient)),
					'time_call_patient'		=> (($row->time_call_patient == "")?"-":convert_to_ymdhis($row->time_call_patient)),
					'time_arrived_patient'	=> (($row->time_arrived_patient == "")?"-":convert_to_ymdhis($row->time_arrived_patient)),
					'time_to_hospital'		=> (($row->time_to_hospital == "")?"-":convert_to_ymdhis($row->time_to_hospital)),
					'time_arrived_hospital'	=> (($row->time_arrived_hospital == "")?"-":convert_to_ymdhis($row->time_arrived_hospital)),
					'time_back_hospital'	=> (($row->time_back_hospital == "")?"-":convert_to_ymdhis($row->time_back_hospital)),
					'time_complete'			=> (($row->time_complete == "")?"-":convert_to_ymdhis($row->time_complete)),
					'time_cancel'			=> (($row->time_cancel == "")?"-":convert_to_ymdhis($row->time_cancel)),
					'reason_cancel'			=> strip_tags($row->reason_cancel),
					'time_reject'			=> (($row->time_reject == "")?"-":convert_to_ymdhis($row->time_reject)),
					'reason_reject'			=> strip_tags($row->reason_reject),
					'case_noncategory'		=> (($row->subcategory_case == "")?"-":$CI->load->model('m_api')->get_name_subcategory_by_id($row->subcategory_case)),
					'case_type'				=> (($row->subcategory_id == "")?"-":$CI->load->model('m_api')->get_name_subcategory_by_id($row->subcategory_id)),
					'ambulance'				=> (($row->ambulance_id == "")?"-":$CI->load->model('m_api')->get_plat_ambulance_by_id($row->ambulance_id)),
					'status'				=> get_transaction($row->nonemergency_status),
					'member_name'			=> $member_name,
					'member_phone'			=> $member_phone,
					'member_image'			=> base_url() ."assets/uploads/". $member_image
				);
			}	
		}
		
		return $result;
	}
	
	function set_nonemergency_driver($id) {
		$CI =& get_instance();
		
		$result = array();
		$query = $CI->load->model('m_global')->get_by_id('td_nonemergencydriver', 'nonemergency_id', $id);
		if(!empty($query)) {
			foreach($query as $row) {
				$detail = $CI->load->model('m_global')->get_by_id('tm_driver', 'driver_id', $row->driver_id);
				foreach($detail as $rows) {
					$result[] = array(
						'driver_id' 	=> $row->driver_id,
						'driver_name'	=> strip_tags($rows->driver_name),
						'driver_phone'	=> $rows->driver_phone
					);
				}
			}	
		}
		
		return $result;
	}
	
	function set_nonemergency_doctor($id) {
		$CI =& get_instance();
		
		$result = array();
		$query = $CI->load->model('m_global')->get_by_id('td_nonemergencydoctor', 'nonemergency_id', $id);
		if(!empty($query)) {
			foreach($query as $row) {
				$detail = $CI->load->model('m_global')->get_by_id('tm_doctor', 'doctor_id', $row->doctor_id);
				foreach($detail as $rows) {
					$result[] = array(
						'doctor_id' 	=> $row->doctor_id,
						'doctor_name'	=> strip_tags($rows->doctor_name),
						'doctor_phone'	=> $rows->doctor_phone
					);
				}
			}	
		}
		
		return $result;
	}
	
	function set_nonemergency_nurse($id) {
		$CI =& get_instance();
		
		$result = array();
		$query = $CI->load->model('m_global')->get_by_id('td_nonemergencynurse', 'nonemergency_id', $id);
		if(!empty($query)) {
			foreach($query as $row) {
				$detail = $CI->load->model('m_global')->get_by_id('tm_nurse', 'nurse_id', $row->nurse_id);
				foreach($detail as $rows) {
					$result[] = array(
						'nurse_id' 		=> $row->nurse_id,
						'nurse_name'	=> strip_tags($rows->nurse_name),
						'nurse_phone'	=> $rows->nurse_phone
					);
				}
			}	
		}
		
		return $result;
	}
	
	function set_hospital_detail($query) {
		$CI =& get_instance();
		
		$result = array();
		if(!empty($query)) {
			foreach($query as $row) {
				if($row->hospital_image == "") {
					$img = "no_images.png";
				}
				else {
					$img = "hospital/". $row->hospital_image;
				}
				
				$result = array(
					'id' 				=> $row->hospital_id,
					'no' 				=> $row->hospital_no,
					'name'				=> strip_tags($row->hospital_name),
					'identity'			=> $row->hospital_identity,
					'email'				=> $row->hospital_email,
					'phone' 			=> $row->hospital_phone,
					'latitude'			=> $row->hospital_latitude,
					'longitude'			=> $row->hospital_longitude,
					'address'			=> $row->hospital_address,
					'area'				=> (($row->area_id == "")?"-":$CI->load->model('m_api')->get_name_area_by_id($row->area_id)),
					'status'			=> get_status($row->hospital_status),
					'photo'				=> base_url() ."assets/uploads/". $img
				);
			}	
		}
		
		return $result;
	}
	
	
	function set_hospital_specialist($id) {
		$CI =& get_instance();
		
		$result = array();
		$query = $CI->load->model('m_global')->get_by_id('td_specialist', 'hospital_id', $id);
		if(!empty($query)) {
			foreach($query as $row) {
				$detail = $CI->load->model('m_global')->get_by_id('tm_specialist', 'specialist_id', $row->specialist_id);
				foreach($detail as $rows) {
					$result[] = array(
						'specialist_id' 	=> $row->specialist_id,
						'specialist_name'	=> strip_tags($rows->specialist_name)
					);
				}
			}	
		}
		
		return $result;
	}
	
	function set_hospital_facility($id) {
		$CI =& get_instance();
		
		$result = array();
		$query = $CI->load->model('m_global')->get_by_id('td_facility', 'hospital_id', $id);
		if(!empty($query)) {
			foreach($query as $row) {
				$detail = $CI->load->model('m_global')->get_by_id('tm_facility', 'facility_id', $row->facility_id);
				foreach($detail as $rows) {
					$result[] = array(
						'facility_id' 	=> $row->facility_id,
						'facility_name'	=> strip_tags($rows->facility_name)
					);
				}
			}	
		}
		
		return $result;
	}
?>