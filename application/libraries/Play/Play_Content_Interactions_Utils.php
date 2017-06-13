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
class Play_Content_Interactions_Utils {

    //put your code here
    
    var $CI;
    var $start_date;
    var $end_date;
    
    var $plays = 0;
    var $shares = 0;
    var $medias;
    var $dates_data;
    var $sources_data;
    var $account;
    
    function Play_Content_Interactions_Utils() {

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
        $this->sum_shares();
        $this->sum_medias();
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

    public function sum_shares() {

        $shares = 0;
        foreach( $this->report as $account ){

            $shares += intval( $account['shares'] );
        } 
        
        $this->shares = $shares;
    }

    public function sum_medias() {

        $medias = 0;
        foreach( $this->report as $account ){

            $medias += intval( $account['medias'] );
        } 
        
        $this->medias = $medias;
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
        }

        array_multisort( $plays , SORT_DESC , $result );
        $this->sources_data = $result;

    }  
    
    private function get_report() {
        
        $report = array();
        $report['plays'] = $this->plays;
        $report['shares'] = $this->shares;
        $report['medias'] = $this->medias;
        $report['dates'] = $this->dates_data;
        $report['sources'] = $this->sources_data;
        
        return $report;
    }

}
