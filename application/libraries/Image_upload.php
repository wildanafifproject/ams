<?php
class Image_upload {

    protected $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
    }
	public function upload($post,$url,$name="")
    {
    	$config['upload_path']   = "$url"; 
        $config['allowed_types'] = 'gif|jpg|png|pdf|jpeg|PNG|JPG';  
    	if (empty($name)) {
    		$config['file_name'] = time();
    	}else{
    		$config['file_name'] = $name;
    	}
        
        $this->CI->load->library('upload', $config);
        if ( ! $this->CI->upload->do_upload("$post")) {
            $data['message'] = $this->CI->upload->display_errors(); 
            $data['error']=true;
        }
                
        else { 
            $data =  $this->CI->upload->data(); 
            $data['error']=false;
        } 
		return $data;
    }

}