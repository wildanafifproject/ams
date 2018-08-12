<?php
if (!function_exists('image')) {
    function image($image_path, $preset) {
        $CI = &get_instance();
        $CI->load->config("images");
        
        $sizes = $CI->config->item("image_sizes");

        $pathinfo = pathinfo($image_path);
        $new_path = $image_path;
       
        if (isset($sizes[$preset])) {
            $new_path = $pathinfo["dirname"] .  "/thumb"."/" . $pathinfo["filename"].".". $pathinfo["extension"];
            //$new_path = $pathinfo["dirname"] . "/" . $pathinfo["filename"] . "-" . implode("x", $sizes[$preset]) . "." . $pathinfo["extension"];
        }
        
        return $new_path;
    }
}

if (!function_exists('thumbnail')) {
    function thumbnail($data, $preset) {
        $CI = &get_instance();
        $CI->load->config("images");
        $sizes = $CI->config->item("image_sizes");

        $pathinfo = pathinfo($data);
        $new_path = $data;
       
        $new_path = $pathinfo["dirname"] .  "/thumb"."/" . $pathinfo["filename"].".". $pathinfo["extension"];
       
        $config["source_image"] = $data;
        $config['new_image']    = $new_path;
        $config["width"]        = $sizes[$preset][0];
        $config["height"]       = $sizes[$preset][1];
        // $config["dynamic_output"] = FALSE;
        
        $CI->load->library('image_lib');
        $CI->image_lib->initialize($config);
        if(!$CI->image_lib->fit()){
            $CI->image_lib->clear();
            return "Fail";
        }
        else{
            $CI->image_lib->clear();
            return $new_path;
        }
    }
}