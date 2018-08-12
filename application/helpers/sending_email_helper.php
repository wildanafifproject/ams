<?php
	function sending_email($subject, $to, $msg) {
		$from 		= "kiprah.app@gmail.com";
        $name		= "KIPRAH | Hunian, Infrastruktur, Kota dan Lingkungan";
		switch($subject) {
			case 1:
				$subject = "KIPRAH |  Forgot Password Notification";
			break;
			case 2:
				$subject = "KIPRAH |  New Magazine Notification";
			break;
		}
		
		// $CI =& get_instance();
		// $config = array(
		// 	'protocol'  	=> 'smtp',
  //           'smtp_host'    	=> 'ssl://smtp.gmail.com',
  //           'smtp_port'   	=> '465',
  //           'smtp_user'   	=> 'kiprah.app@gmail.com',
  //           'smtp_pass'    	=> 'kiprah123',
  //           'mailtype'     	=> 'html',
  //           'MIME-Version' 	=> '1.0',
  //           'Content-Type' 	=> 'text/html',
  //           'charset'      	=> 'iso-8859-1',
  //           'newline'   	=> "\r\n"
  //       );
        
  //       //load library            
  //       $CI->load->library('email', $config);
  //       $CI->email->from($from, $name);
  //       $CI->email->subject($subject);    
  //       $CI->email->message($msg); 
	
		// if(count($to) > 1) {
		// 	foreach ($to as $address){
		// 		$CI->email->to($address);
		// 		if($CI->email->send()){
		// 			$status = 1;
		// 		}
		// 		else {
		// 			$status = 0;
		// 		}	
		// 	}
		// } 
		// else {
		// 	$CI->email->to($to);
		// 	if($CI->email->send()){
		// 		$status = 1;
		// 	}
		// 	else {
		// 		$status = 0;
		// 	}	
		// }
		// return $status;
	
	require_once 'phpmailer/class.phpmailer.php';
	include_once 'phpmailer/class.smtp.php';
 
    $mail = new PHPMailer();
    $mail->CharSet =  "utf-8";
    //$mail->IsSMTP();
    $mail->SMTPAuth   = true;
    $mail->Username   = "kiprah.app@gmail.com";
    $mail->Password   = "kiprah123";
    $mail->SMTPSecure = "ssl";  
    $mail->Host       = "ssl://smtp.gmail.com";
    $mail->Port       = "465";
 
    $mail->setFrom($from, $name);
    $mail->AddAddress($to); 

    $mail->Subject  =  $subject;
    $mail->IsHTML(true);
    $mail->Body    = $msg;
  
     if($mail->Send()){
       $status = 1;
     }
     else {
       $status = 0;
     }		
        //Untuk mendukung coding email, pada php.ini extension=php_openssl.dll harus diaktifkan
		return $status;
    }
?>