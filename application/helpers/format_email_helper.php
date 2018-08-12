<?php
	function format_subscription($id, $user_id) {	
		// Get a reference to the controller object
		$CI =& get_instance();
		$message = $CI->m_global->get_by_id('tm_magazine', 'magazine_id', $id);
		$detail = $CI->load->model('m_global')->get_by_id('tm_member', 'member_id', $user_id);
		
		// set variabel
		$format = "";
		$password = "";	$member_name = "";
		
		$logo = $CI->load->model('setting/m_company')->get_file_by_id(1);
		$logo = base_url() ."assets/uploads/".(($logo != "")?"company/". $logo:"no_image.png");
		
		foreach($detail as $row) {
			$member_name = strip_tags($row->member_name) .' '. strip_tags($row->member_lname);	
		}
		foreach($message as $row) {
			if($row->magazine_image == "") {
				$img = "no_images.png";
			}
			else {
				$img = "cover/thumb/". $row->magazine_image;
			}
			
			if($row->magazine_path == "") {
				$paths 		  = "";
				$url_pdf 	  = "";
				$url_flipbook = "";
			}
			else {
				$url_pdf 		= base_url() ."assets/uploads/magazine/". str_replace('index.html', 'files', $row->magazine_path). "/assets/common/downloads/kiprah ". str_replace('/index.html', '', $row->magazine_path).".pdf";
				$url_flipbook   = base_url() ."assets/uploads/magazine/". $row->magazine_path;
				$paths 		    = $row->magazine_path;
			}
				
			$magazine_id			= $row->magazine_id;
			$magazine_date			= convert_to_dmy($row->magazine_date);
			$magazine_year			= $row->magazine_year;
			$magazine_title			= strip_tags($row->magazine_title);
			$magazine_volume		= strip_tags($row->magazine_volume);
			$magazine_status		= strip_tags($row->magazine_status);
			$magazine_description	= strip_tags($row->magazine_description);
			$magazine_image			= base_url() .'assets/uploads/'. $img;
			$magazine_path			= $paths;
			$magazine_flipbook		= $url_flipbook;
			$magazine_pdf			= $url_pdf;
		
		}
		$format = 
			"
			<html>
				<head>
					<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
					<title>KIPRAH Notification</title>
				</head>
				<body>
					<table border=0 width=900>
						
						<tr>
							<td valign=top colspan=3 align=left height=5>&nbsp;</td>
						</tr>
						<tr>
							<td valign=top colspan=3 align=left height=15>Hai <b>".strtoupper($member_name)."</b>,</td>
						</tr>
						<tr>
							<td valign=top colspan=3 align=left height=5>&nbsp;</td>
						</tr>
						<tr>
							<td valign=top colspan=3 align=left height=15>Kami menerbitkan majalah KIPRAH Baru :</td>
						</tr>
						
						<tr>
							<td valign=top colspan=3 align=left height=10><b>".$magazine_title."</b></td>
						</tr>
							<tr>
							<td valign=top colspan=3 align=left height=10>".$magazine_volume."</td>
						</tr>
						<tr>
							<td valign=top colspan=3 align=left height=15><img src=".$magazine_image." width=200 /></td>
						</tr>
						<tr>
							<td valign=top colspan=3 align=left height=10><a href='".$url_flipbook."'>Klik Disini untuk Melihat</a></td>
						</tr>
						<tr>
							<td valign=top colspan=3 align=left height=10><a href='".$url_pdf."'>Download PDF</a></td>
						</tr>
						<tr>
							<td valign=top colspan=2 align=left height=10>Terima kasih.</td>
						</tr>
					</table>
				</body>
			</html>
			";	
		
		return $format;
    }

    function format_forgot_password($id) {	
		// Get a reference to the controller object
		$CI =& get_instance();
		
		$detail = $CI->load->model('m_global')->get_by_id('tm_member', 'member_id', $id);
		
		// set variabel
		$format = "";
		$password = "";	$member_name = "";
		
		$logo = $CI->load->model('setting/m_company')->get_file_by_id(1);
		$logo = base_url() ."assets/uploads/".(($logo != "")?"company/". $logo:"no_image.png");
		
		foreach($detail as $row) {
			$member_name = strip_tags($row->member_name) .' '. strip_tags($row->member_lname);	
			$password	 = $row->member_password;
		}
		
		$format = 
			"
			<html>
				<head>
					<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
					<title>KIPRAH Notification</title>
				</head>
				<body>
					<table border=0 width=900>
						<tr>
							<td valign=top colspan=3 align=center height=15><img src=".$logo." width=160 /></td>
						</tr>
						<tr>
							<td valign=top colspan=3 align=left height=5>&nbsp;</td>
						</tr>
						<tr>
							<td valign=top colspan=3 align=left height=15>Dear <b>".$member_name."</b>,</td>
						</tr>
						<tr>
							<td valign=top colspan=3 align=left height=5>&nbsp;</td>
						</tr>
						<tr>
							<td valign=top colspan=3 align=left height=15>Password Anda saat ini <b>".$password."</b>.</td>
						</tr>
						
						<tr>
							<td valign=top colspan=2 align=left height=5>&nbsp;</td>
						</tr>
						<tr>
							<td valign=top colspan=2 align=left height=10>Ini adalah email otomatis, mohon tidak mereply email ini.</td>
						</tr>
						<tr>
							<td valign=top colspan=2 align=left height=10>Terima kasih.</td>
						</tr>
					</table>
				</body>
			</html>
			";	
		
		return $format;
    }
?>