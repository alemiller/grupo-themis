<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Category
 *
 * @author luisriquelme
 */
class Category {

    
    var $CI;
    var $token;
    var $custom;
    var $count;
    
    function Category() {

        $this->CI = & get_instance();
        $this->CI->load->model('categories_model', '', TRUE);
    }
    
    function initialize($token) {

        $this->token = $token;
    }
    
    function count() {

        $this->custom = 'byScheme=vod&sort=title:1';
        $response = $this->CI->categories_model->get_total_categories($this->token, $this->custom);
        $this->count = $response->content->count;
        return $response;
    }
    
    function get_all () {
        
        $this->count();
        $this->custom = 'byScheme=vod&sort=title:1&size='. $this->count .'&page=0';
        return $this->CI->categories_model->get_categories($this->token, $this->custom);     
    }
    
}
