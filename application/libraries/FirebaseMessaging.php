<?php
/**
* 
*/
class FirebaseMessaging 
{
	
	protected $CI;	
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    public function custom_emergency($ambulanceId='')
    {
    	$this->CI->db->where('ambulance_id',$ambulanceId);
      	$data_s=$this->CI->db->get('tm_historytoken')->result_array();
	    foreach($data_s as $key=>$value){
	          $tokens[] = $value["token_id"];
	    }
	    $message = array(
		    "message" => "Emergency",
		    "title"=>"Emergency",
		    "nama"=>"Nama Pasien"
		);
      	$message_status = $this->send_notification($tokens, $message);
	   	echo $message_status;
    }
    function send_notification ($tokens, $message)
	{
		$url = 'https://fcm.googleapis.com/fcm/send';
		$fields = array(
			 'registration_ids' => $tokens,
			 'data' => $message
			);

		$headers = array(
			'Authorization:key = AIzaSyBwpyAcjiZw002R9wPlnTAwcW0TqgjBUEk',
			'Content-Type: application/json'
			);

	   $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);  
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
       $result = curl_exec($ch);           
       if ($result === FALSE) {
           die('Curl failed: ' . curl_error($ch));
       }
       curl_close($ch);
       return $result;
	}
}