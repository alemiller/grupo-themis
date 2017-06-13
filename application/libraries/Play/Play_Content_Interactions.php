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
class Play_Content_Interactions {

    //put your code here
    
    var $CI;
    var $start_date;
    var $end_date;
    
    var $plays = 0;
    var $shares = 0;
    var $medias;
    var $dates_data = array();
    var $sources_data = array();
    var $account;  
    var $account_name;  

    function Play_Content_Interactions() {

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
        
        $sources = $this->get_sources();
        $dates = $this->get_dates();
        
        $this->process_sources_data($sources);
        $this->process_dates_data($dates);
        
        
        $report = $this->get_report();
        return $report;
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

    private function set_sources($sources_data) {

        $data = array();
        
        $detail = array('total' => 0);
        $play_data = array('Play' => $detail, 'Edits' => $detail, 'Share' => $detail, 'Downloads' => $detail, 'Reports of Abuse' => $detail);
        
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

            // Improve fetch sources service to fetch only plays 
            if( $event != 'Player Impressions') {
                $data[$id][$event]['total'] = $ga_data[$i][2];     
                $this->plays += $ga_data[$i][2];
            }    
        }
        
        $result_data = $this->set_shares_data($data);
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
        }

        array_multisort( $plays , SORT_DESC , $sources );
        // end order by play total
        
        return $sources;
    }
    
    private function set_shares_data($data) {      
                  
        $shares = $this->get_shares()->content->rows;

        for ($j = 0 ; $j < sizeof($shares); $j++ ) {
                
            $id = $shares[$j][1];
            // maybe video exists in ga but no in db
            if (array_key_exists( $id ,$data)) {
                
                $data[$id]['Share']['total'] +=  strval($shares[$j][2]);
                $this->shares += strval($shares[$j][2]);
            }
            
        }
        
        return $data;
        
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
        
        return $result;
    }
    
    public function get_dates() {

        return check_json_error($this->CI->analytics_model->get_play_dates( $this->start_date , $this->end_date , $this->account ) );
    }
    
    public function get_sources() {

        return check_json_error($this->CI->analytics_model->get_play_labels( $this->start_date , $this->end_date , $this->account ) );
    }
    
    public function get_shares() {

        return check_json_error($this->CI->analytics_model->get_play_shares( $this->start_date , $this->end_date , $this->account ) );
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
