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
class Play_Browsers_Utils {

    //put your code here
    
    var $CI;
    var $start_date;
    var $end_date;

    var $count;
    var $view_time;
    var $avg_view_time;
    var $impressions;
    var $dates_data;
    var $browsers_data;
    var $account;
    
    function Play_Browsers_Utils() {

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
        $this->sum_browsers_data();
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

    public function sum_browsers_data() {

        $report = $this->report;
        $result = array();
        $detail = array('total' => '0', 'session_duration' => '', 'avg_session_duration' => '');

        foreach( $report as $account ){

            $browsers = $account['browsers'];

            foreach( $browsers as $browser => $browser_data ){

                if ( !array_key_exists( $browser , $result )) {
                    $result[$browser] = array( 'Play' => $detail, 'Player Impressions' => $detail );
                }

                foreach( $browser_data as $event => $value){

                    $result[$browser][$event]['total'] += intval($value['total']);
                    $result[$browser][$event]['session_duration'] += intval($value['session_duration']);
                    $result[$browser][$event]['avg_session_duration'] += intval($value['avg_session_duration']);
                }

            }
            
        } 

        $this->browsers_data = $result;
        
    }
    
    private function get_report() {
        
        $report = array();
        
        $report['plays'] = $this->count;
        $report['view_time'] = $this->view_time;
        $report['avg_view_time'] = $this->avg_view_time;
        $report['impressions'] = $this->impressions;
        $report['browsers'] = $this->browsers_data;
        
        return $report;
    }

}
