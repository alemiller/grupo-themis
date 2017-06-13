<?php

/**
 * 
 * Manage media objects
 * @author luisriquelme
 */

class Media_Manager {
    
    var $CI;
    var $token;
    var $media;

    function Media_Manager() {

        $this->CI = & get_instance();
        $this->CI->load->model('media_model', '', TRUE);
        $this->CI->load->model('vod_model', '', TRUE);  
        $this->CI->load->helper('pdk');   
    }

    public function initialize( $media , $token ) {
        
        $this->media = json_decode($media);
        $this->token = $token;
    }
    
    public function delete() {
    
        return $this->delete_media();
    }
    
    private function delete_media() {
        $result = $this->CI->media_model->delete_media_object( array($this->media->_id) , $this->token );
        return $result;
    }

}
