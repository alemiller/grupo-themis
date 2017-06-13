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
class Play_Drop_Off {

    //put your code here
    
    var $CI;
    var $start_date;
    var $end_date;

    var $drop_data = array();
    var $medias;
    var $sources_data = array();
    var $account;
    var $account_id;
    var $account_name;   

    function Play_Drop_Off() {

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
        $this->process_basic_data($basic_data);
        $sources_data = $this->get_sources();
        $this->process_sources_data($sources_data);
        $report = $this->get_report();
        return $report;
    }
    
    private function process_basic_data ($basic_data) {
        
        $data = array('Play' => '0', 'Played 25%' => '0', 'Played 50%' => '0', 'Played 75%' => '0', 'Complete' => '0');

        if( $basic_data->content->rows != null ){

            foreach ($basic_data->content->rows as $event_data) {
            
                $data[$event_data[0]] = $event_data[1]; 
            }
        }
        
        $this->drop_data = $data;
    }
    
    private function process_sources_data ( $sources_data ) {
        
        if( $sources_data->content->rows != null ){

            $this->sources_data = $this->set_sources( $sources_data );
        }   
    }

    private function set_sources($sources_data) {
        
        $data = array();
        
        $drop_data = array('Play' => '0', 'Played 25%' => '0', 'Played 50%' => '0', 'Played 75%' => '0', 'Complete' => '0');
        
        $ga_data = $sources_data->content->rows;
        $this->medias = sizeof($ga_data);
        $element = reset( $ga_data );
        $compound_id = false;

        if( !empty( explode( '-' , $element[1] ) ) ) {

            $compound_id = true;   
        }
        for ($i = 0; $i < sizeof($ga_data); $i++) {
            
            $event = $ga_data[$i][0];
            $id = $ga_data[$i][1];
            
            
            if (!key_exists($id, $data)) {
 
                $data[$id] = $drop_data;
            }
            
            $data[$id][$event] = $ga_data[$i][2];   

        }

        // RJR Google Analytics id comes as 338740291837-Profile interview with Ava Brown   
        // FBS comes as 338740291837
        
        if( !$compound_id ){

            $drops = $this->get_videos_titles( $data );
        }    
        else{

            $drops = $this->get_titles( $data );
        }

        foreach ($drops as $drop ) {

            $plays[] = $drop['Play'];
        }

        array_multisort( $plays, SORT_DESC, $drops);

        return $drops;
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

        return check_json_error($this->CI->analytics_model->get_play_drops( $this->start_date , $this->end_date , $this->account ) );
    }
    
    public function get_sources() {

        return check_json_error($this->CI->analytics_model->get_play_drops_sources( $this->start_date , $this->end_date , $this->account ) );
    }
    
    private function get_report() {
        
        $report = array();
        
        $report['drops'] = $this->drop_data;
        $report['medias'] = $this->medias;
        $report['sources'] = $this->sources_data;

        return $report;
    }

}
