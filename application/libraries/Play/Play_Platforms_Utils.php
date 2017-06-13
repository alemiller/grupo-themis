<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Play_Platforms
 *
 * @author luisriquelme
 */
class Play_Platforms_Utils {
    //put your code here
    
    var $CI;
    var $start_date;
    var $end_date;

    var $count;
    var $view_time;
    var $avg_view_time;
    var $impressions;
    var $dates_data;
    var $devices_data;
    var $devices_count;
    var $account;
    
    function Play_Platforms_Utils() {

        $this->CI = & get_instance();
        $this->CI->load->model('analytics_model', '', TRUE);
        $this->CI->load->model('media_model', '', TRUE);
        $this->CI->load->helper('util_helper');
    }
    
    public function initialize( $report ) {

        $this->report = $report;
    }

    public function get_unified_report() {

        $this->sum_plays();
        $this->sum_view_time();
        $this->sum_avg_view_time();
        $this->sum_impressions();
        $this->sum_devices_data();
        $this->sum_dates();
        $report = $this->get_report();
        return $report;
    }

    public function sum_plays() {

        $plays = 0;
        foreach( $this->report as $account ){   

            $plays += intval( $account['plays'] );
        } 

        $this->count = $plays;
    }

    public function sum_view_time() {

        $view_time = 0;
        foreach( $this->report as $account ){

            $view_time += intval( $account['view_time'] );
        } 
        
        $this->view_time = $view_time;
    }

    public function sum_avg_view_time() {

        $avg_view_time = 0;
        foreach( $this->report as $account ){

            $avg_view_time += intval( $account['avg_view_time'] );
        } 
        
        $this->avg_view_time = $avg_view_time;
    }

    public function sum_impressions() {

        $impressions = 0;
        foreach( $this->report as $account ){

            $impressions += intval( $account['impressions'] );
        } 
        
        $this->impressions = $impressions;
    }

    public function sum_dates(){

        $sum_result = array();
        $result = array();

        foreach( $this->report as $account ){

            $play_dates_data = $account['dates'];

            foreach( $play_dates_data as $device => $device_data ) {

                if ( !array_key_exists( $device , $sum_result )) {
                    $sum_result[$device] = array();
                }

                foreach ( $device_data as $value) {

                    $date = $value['date'];
                    $plays = $value['sessions'];

                    if ( array_key_exists( $date , $sum_result[$device] ) ) {

                        $sum_result[$device][$date] += intval( $plays );
                    }
                    else {

                        $sum_result[$device][$date] = intval( $plays );
                    }  
                }
            }
        } 

        foreach( $sum_result as $device => $device_data) {

            foreach ( $device_data as $date => $value ) {

                $date_data['date'] = $date;
                $date_data['sessions'] = $value;
                $result[$device][] = $date_data;

            }
        }    

        $this->dates_data = $result;  
        
    }

    public function sum_devices_data() {

        $report = $this->report;
        $result = array();
        $detail = array('total' => '0', 'session_duration' => '', 'avg_session_duration' => '');

        foreach( $report as $account ){

            $devices = $account['devices'];

            foreach( $devices as $device => $device_data ){

                if ( !array_key_exists( $device , $result )) {
                    $result[$device] = array( 'Play' => $detail, 'Player Impressions' => $detail );
                }

                foreach( $device_data as $event => $value){

                    $result[$device][$event]['total'] += intval($value['total']);
                    $result[$device][$event]['session_duration'] += intval($value['session_duration']);
                    $result[$device][$event]['avg_session_duration'] += intval($value['avg_session_duration']);
                }

            }
            
        } 

        $this->devices_data = $result;
        
    }
   
    private function get_report() {
        
        $report = array();
        
        $report['plays'] = $this->count;
        $report['view_time'] = $this->view_time;
        $report['avg_view_time'] = $this->avg_view_time;
        $report['impressions'] = $this->impressions;
        $report['dates'] = $this->dates_data;
        $report['devices'] = $this->devices_data;
        $report['devices_count'] = $this->count;
        
        return $report;
    }   
    
}
