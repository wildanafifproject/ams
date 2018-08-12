<?php 

class Push {
    //notification title
    private $title;
	private $message;
	private $id;
	
    //notification image url 
    private $image;

    //initializing values in this constructor
    function construct($title, $message, $id, $image) {
         $this->title = $title;
         $this->message = $message; 
		 $this->id= $id;
         $this->image = $image; 
    }
    
    //getting the push notification
    public function getPush() {
        $res = array();
        $res['data']['title'] = $this->title;
        $res['data']['message'] = $this->message;
		$res['data']['id'] = $this->id;
        $res['data']['image'] = $this->image;
        return $res;
    }
}