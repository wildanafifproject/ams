<?php
class Fcm {

    protected $CI;
    private $firebaseKey="AIzaSyBwpyAcjiZw002R9wPlnTAwcW0TqgjBUEk";
    public function __construct()
    {
        $this->CI =& get_instance();
    }

    function sendNotif($ambulanceId,$data)
    {    	
	    $ids = $this->getIds($ambulanceId);
	     $this->send_notification_firebase($ids,$data);
    }

    function getIds($ambulanceId='')
    {
    	$tokens = array();
	  	$this->CI->db->where('ambulance_id',$ambulanceId);
	  	$data_get=$this->CI->db->get('tm_historytoken')->result_array();
	  	foreach($data_get as $key => $value){
	      $tokens[] = $value["token_id"];
	  	}
	  	//print_r($tokens);
	  	return $tokens;
    }

    function send_notification_firebase ($tokens, $message)
	{
		$url = 'https://fcm.googleapis.com/fcm/send';
		$fields = array(
			 'registration_ids' => $tokens,
			 'data' => $message
			);

		$headers = array(
			'Authorization:key = '.$this->firebaseKey,
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