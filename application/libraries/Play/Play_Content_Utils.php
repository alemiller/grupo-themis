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
class Play_Content_Utils {

    //put your code here
    
    var $CI;
    var $report;
    var $plays;
    var $view_time;
    var $avg_view_time;
    var $impressions;
    var $plays_medias;
    var $dates_data;
    var $sources_data;   

    function Play_Content_Utils() {

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
        $this->sum_plays_medias();
        $this->sum_dates();
        $this->order_sources();
        $report = $this->get_report();
        return $report;
    }

    public function sum_plays() {

        $plays = 0;
        foreach( $this->report as $account ){   

            $plays += intval( $account['plays'] );
        } 

        $this->plays = $plays;
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

    public function sum_plays_medias() {

        $plays_medias = 0;
        foreach( $this->report as $account ){

            $plays_medias += intval( $account['plays_medias'] );
        } 
        
        $this->plays_medias = $plays_medias;
    }

    public function sum_dates() {

        $sum_result = array();
        $result = array();

        foreach( $this->report as $account ){

            $play_dates_data = $account['dates'];

            foreach( $play_dates_data as $data ) {

                $date = $data['date'];
                $plays = $data['sessions'];

                if ( array_key_exists( $date , $sum_result ) ) {

                    $sum_result[$date] += intval( $plays );
                }
                else {

                    $sum_result[$date] = intval( $plays );
                }    

            }
        } 

        foreach( $sum_result as $date => $plays ) {

            $date_data['date'] = $date;
            $date_data['sessions'] = $plays;
            $result[] = $date_data;

        } 

        $this->dates_data = $result;  
    }

    public function order_sources() {

        $report = $this->report;
        $result = array();

        foreach( $report as $account ) {

            $sources = $account['sources'];
            $result = array_merge( $result , $sources);

            foreach( $sources as $source => $events) {

                foreach ( $events as $event => $metrics ) {

                    $total[$source][$event] = $metrics['total'];
                }    
            } 

        }

        foreach ( $total as $source => $events ) {

            $plays[] = $events['Play'];
            $impressions[] = $events['Player Impressions'];
        }


        array_multisort( $plays , SORT_DESC , $impressions , SORT_DESC , $result );
        $this->sources_data = $result;

    }

    private function get_report() {
        
        $report = array();
        
        $report['plays'] = $this->plays;
        $report['view_time'] = $this->view_time;
        $report['avg_view_time'] = $this->avg_view_time;
        $report['impressions'] = $this->impressions;
        $report['plays_medias'] = $this->plays_medias;
        $report['dates'] = $this->dates_data;
        $report['sources'] = $this->sources_data;
        
        return $report;
    }    

}
