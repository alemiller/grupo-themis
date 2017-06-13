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
class Play_Geo_Distribution_Utils {

    //put your code here
    
    var $CI;
    var $start_date;
    var $end_date;

    var $drop_data;
    var $medias;
    var $geo_data;
    var $account;

    function Play_Geo_Distribution_Utils() {

        $this->CI = & get_instance();
        $this->CI->load->model('analytics_model', '', TRUE);
        $this->CI->load->model('media_model', '', TRUE);
        $this->CI->load->helper('util_helper');
    }

    public function initialize( $report ) {

        $this->report = $report;
    }
    
    public function get_unified_report() {

        $this->sum_drops_data();
        $this->sum_medias();
        $this->order_sources();
        $report = $this->get_report();
        return $report;
    }

    public function sum_drops_data() {

        $result = array('Play' => 0, 'Played 25%' => 0, 'Played 50%' => 0, 'Played 75%' => 0, 'Complete' => 0);

        foreach( $this->report as $accounts => $account_data ){

            $drop_data = $account_data['drops'];

            foreach( $drop_data as $event => $value){

                $result[$event] += intval($value);
            }

        }

        $this->drop_data = $result;
    }

    public function sum_medias() {

        $medias = 0;
        foreach( $this->report as $accounts => $account_data ){

            $medias += intval( $account_data['medias'] );

        }

        $this->medias = $medias;
    }

    public function order_sources(){

        $report = $this->report;
        $result = array();
        $plays = array();
        error_log('report es ' . json_encode( $report ) );
        foreach( $report as $account => $account_data ){
            
            $sources = $account_data['geo_distribution'];

            $result = array_merge( $result , $account_data['geo_distribution'] );

            foreach( $sources as $source => $events ){

                $plays[] = $events['Play'];
            }

        }
        error_log( 'plays es ' . json_encode( $plays) );
        error_log( 'result es ' . json_encode( $result ) );
        // array multisort can have issues in order sources because maybe there are
        // two or more equals key in $account_data['sources']
        array_multisort( $plays , SORT_DESC , $result );
        $this->geo_data = $result;
    }

    
    private function get_report() {
        
        $report = array();
        
        $report['drops'] = $this->drop_data;
        $report['medias'] = $this->medias;
        $report['geo_distribution'] = $this->geo_data;

        return $report;
    }

}
