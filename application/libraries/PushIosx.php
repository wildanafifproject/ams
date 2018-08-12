<?php
class PushIosx {
    //notification title
    private $message;
    private $priority;
    private $icon;
    private $id;
    private $type;

    //initializing values in this constructor
    function construct($title, $message, $id, $image, $type, $priority, $icon, $tag, $action) {
         $this->title = $title;
         $this->message = $message; 
         $this->priority= $priority;
        // $this->icon= $icon;
         $this->id= $id;
         $this->type= $type;
		 $this->vibrate= 1;
		 $this->badge= 0;
		 $this->sound= "alarm_sound.wav";
		 $this->image = "ic_apps" ; //$image;
         $this->tag = $tag;
         $this->click_action = $action;
         $this->icon = 'cast_ic_notification_small_icon';
    }
    
    //getting the push notification
    public function getPush() {
        $res = array();
        $res['title'] = $this->title;
        $res['body'] = $this->message;
        $res['priority'] = $this->priority;
        //$res['icon'] = $this->icon;
        $res['id'] = $this->id;
        $res['type'] = $this->type;
		$res['vibrate'] = $this->vibrate;
		$res['badge'] = $this->badge;
		$res['sound'] = $this->sound;
		$res['image'] = $this->image;
        $res['tag'] = $this->tag;
        $res['click_action'] = $this->click_action;
        $res['icon'] = $this->icon;

        return $res;
    }
}
?>