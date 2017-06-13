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
class Play_Content {

    //put your code here
    
    var $CI;
    var $start_date;
    var $end_date;

    var $count;
    var $view_time;
    var $avg_view_time;
    var $impressions;
    var $dates_data = array();
    var $medias;
    var $sources_data = array();
    var $account;
    var $account_id;
    var $account_name;    

    function Play_Content() {

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
        $impressions = $this->get_impressions();
        $dates = $this->get_dates();
        $sources = $this->get_sources();

        $this->process_basic_data($basic_data);
        $this->process_impressions_data($impressions);
        $this->process_dates_data($dates);
        $this->process_sources_data($sources);
        
        $report = $this->get_report();
        return $report;
    }
    
    private function process_basic_data($data) {      
        
        $this->count = $data->content->totalsForAllResults->{'ga:totalEvents'};
        $this->view_time = $data->content->totalsForAllResults->{'ga:SessionDuration'};
        $this->avg_view_time = $data->content->totalsForAllResults->{'ga:avgSessionDuration'};
    }
    
    private function process_impressions_data($data) {
        
        $this->impressions = $data->content->totalsForAllResults->{'ga:totalEvents'};
    }
    
    private function process_dates_data ( $dates_data ) {
        
        if( $dates_data->content->rows != null ){

            $this->dates_data = $this->set_dates( $dates_data );
        }    
    }
    
    private function process_sources_data ( $sources_data ) {
        
        if( $sources_data->content->rows != null ){

            $this->sources_data = $this->set_sources( $sources_data );
        }
    }
    
    private function set_dates($dates_data) {
        
        $dates = array();
        foreach ($dates_data->content->rows as $array) {
            
            $dates[] = array('date' => $array[1],'sessions' => $array[2]);
        }
        
        return $dates;
    }

    public function set_sources($sources_data) {

        $data = array();
        
        $detail = array('total' => '0', 'session_duration' => '', 'avg_session_duration' => '');
        $play_data = array('Play' => $detail, 'Player Impressions' => $detail );
        
        $ga_data = $sources_data->content->rows;

        $this->medias = sizeof($ga_data);
        $element = reset( $ga_data );
        $compound_id = false;

        if( !empty( explode( '-' , $element[1] ) ) ) {

            $compound_id = true;   
        }
        
        for ($i = 0; $i < sizeof($ga_data); $i++) {
            
            $id = $ga_data[$i][1];
            $event = $ga_data[$i][0];
            
            if (!key_exists($id, $data)) {
 
                $data[$id] = $play_data;
            }
            
            $data[$id][$event]['session_duration'] = $ga_data[$i][4];
            $data[$id][$event]['avg_session_duration'] = $ga_data[$i][3];
            $data[$id][$event]['total'] = $ga_data[$i][2];     

        }

        // RJR Google Analytics id comes as 338740291837-Profile interview with Ava Brown   
        // FBS comes as 338740291837
        
        if( !$compound_id ){

            $sources = $this->get_videos_titles( $data );
        }    
        else{

            $sources = $this->get_titles( $data );
        }

        // begin order by play total
        foreach ( $sources as $source => $events ) {

            foreach ($events as $event => $metrics) {

                $total[$source][$event] = $metrics['total'];
            } 

        }

        foreach ( $total as $source => $events ) {

            $plays[] = $events['Play'];
            $impressions[] = $events['Player Impressions'];
        }

        array_multisort( $plays , SORT_DESC , $impressions , SORT_DESC , $sources );
        // end order by play total

        return $sources;
    }   
    
    private function get_videos_titles ($videos) {
        
        $ids = array_keys($videos);
        $titles = $this->get_videos_id_title($ids);
        
        $valid_titles = array();
        
        for ($i = 0; $i < sizeof($videos); $i++) {
            

            for ($j = 0; $j < sizeof( $titles ); $j++) {
                
                $video_id = $ids[$i];
                $media = $titles[$j]->_id;
                if (strpos($media, strval($video_id)) !== false) {

                    $app_name = $this->account_name;
                    $title = $titles[$j]->title . ' (' . $app_name . ') ';
                    $valid_titles[$title] = $videos[$ids[$i]];            
                    break;
                }
            }
            
        }
        return $valid_titles;
    }
    
    private function get_videos_id_title ($ids) {
        

        $chunks = array_chunk( $ids, 100 );
        $total_data = array();

        $media_type = null;
        $fields = '_id,title';
        $account_id = $this->account_id;

        for ($i = 0 ; $i < sizeof( $chunks ) ; $i++) {

            $custom_value = 'byId=' . implode( '|' , $chunks[$i] ) . '&page=0' . '&size=100';
            $partial_data = $this->CI->media_model->get_media_object(@$_SESSION['user_data']->token, $custom_value, $media_type, $fields , $account_id );
            $total_data[] = $partial_data->content->entries;

        }

        foreach ( $total_data as $array ) {

            foreach ($array as $object) {

                $result[] = $object;
            }
        }
        error_log( 'el result es ' . json_encode($result));
        return $result;
    }

    public function get_titles( $data ){

        foreach( $data as $key => $value ){

            unset( $data[$key] );
            $title = explode( '-' ,  $key );
            if( count( $title ) == 1 ){

                $new_key = explode( '-' ,  $key )[0];                
            }
            else{

                $new_key = explode( '-' ,  $key )[1];
            }

            $data[ $new_key] = $value;
        }

        return $data;
    } 

    public function get_basic_data() {

        return check_json_error($this->CI->analytics_model->get_play_times( $this->start_date , $this->end_date , $this->account ) );
    }
    
    public function get_impressions() {

        return check_json_error($this->CI->analytics_model->get_player_impressions( $this->start_date , $this->end_date , $this->account ) );
    }

    public function get_dates() {

        return check_json_error($this->CI->analytics_model->get_play_dates( $this->start_date , $this->end_date , $this->account ) );
    }

    public function get_sources() {

        return check_json_error($this->CI->analytics_model->get_play_labels( $this->start_date , $this->end_date , $this->account ) );
    }
    
    private function get_report() {
        
        $report = array();
        
        $report['plays'] = $this->count;
        $report['view_time'] = $this->view_time;
        $report['avg_view_time'] = $this->avg_view_time;
        $report['impressions'] = $this->impressions;
        $report['plays_medias'] = $this->medias;
        $report['dates'] = $this->dates_data;
        $report['sources'] = $this->sources_data;
        
        return $report;
    }

}
