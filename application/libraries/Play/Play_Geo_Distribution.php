<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Play
 *
 * @author luisriquelme
 */
class Play_Geo_Distribution {

    //put your code here
    
    var $CI;
    var $start_date;
    var $end_date;

    var $drop_data;
    var $medias;
    var $geo_data;
    var $account;
    var $account_id;
    var $account_name;  

    function Play_Geo_Distribution() {

        $this->CI = & get_instance();
        $this->CI->load->model('analytics_model', '', TRUE);
        $this->CI->load->model('media_model', '', TRUE);
        $this->CI->load->helper('util_helper');
    }

    public function initialize( $start_date , $end_date , $account , $account_id , $account_name ) {

        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->account = $account;
        $this->account_id = $account_id;
        $this->account_name = $account_name;
    }
    
    public function get_analytics() {

        $basic_data = $this->get_basic_data();
        $geo_data = $this->get_geo_distribution();

        $this->process_basic_data($basic_data);
        $this->process_geo_data($geo_data);

        $report = $this->get_report();
        return $report;
    }
    
    private function process_basic_data ($basic_data) {
        
        $data = array('Play' => '', 'Played 25%' => '', 'Played 50%' => '', 'Played 75%' => '', 'Complete' => '');

        if( $basic_data->content->rows != null ){

            foreach ($basic_data->content->rows as $event_data) {
            
                $data[$event_data[0]] = $event_data[1]; 
            }
        }    
        
        $this->drop_data = $data;
    }
    
    private function process_geo_data ($geo_data) {
        
        $this->geo_data = $this->set_geo_distribution($geo_data);
    }

    private function set_geo_distribution($geo_data) {
        
        $data = array();
        
        $drop_data = array('Play' => '0', 'Played 25%' => '0', 'Played 50%' => '0', 'Played 75%' => '0', 'Complete' => '0');
        
        $ga_data = $geo_data->content->rows;
        $this->medias = sizeof($ga_data);
        
        for ($i = 0; $i < sizeof($ga_data); $i++) {
            
            $country = $ga_data[$i][0];
            $site_country = $country . ' (' . $this->account_name . ') ';
            $event = $ga_data[$i][1];
            
            
            if (!key_exists( $site_country , $data )) {
 
                $data[$site_country] = $drop_data;
            }
            
            $data[$site_country][$event] = $ga_data[$i][2];   

        }
        
        return $data;
    }

    public function get_basic_data() {

        return check_json_error($this->CI->analytics_model->get_play_drops( $this->start_date , $this->end_date , $this->account ) );
    }
    
    public function get_geo_distribution() {

        return check_json_error($this->CI->analytics_model->get_play_geo_distribution( $this->start_date , $this->end_date , $this->account ) );
    }
    
    private function get_report() {
        
        $report = array();
        
        $report['drops'] = $this->drop_data;
        $report['medias'] = $this->medias;
        $report['geo_distribution'] = $this->geo_data;
        return $report;
    }

}
