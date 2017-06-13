<?php

/**
 * Description of Play Analytics
 *
 * @author luisriquelme
 */

class Play_Analytics {

    var $CI;

    // date data
    var $start_date;
    var $end_date;

    // total results analytics data
    var $count;
    var $view_time;
    var $avg_view_time;
    var $impressions;

    // account data
    var $account;
    var $account_id;
    var $account_name;    

    function Play_Analytics() {

        $this->CI = & get_instance();
        $this->CI->load->model('analytics_model', '', TRUE);
        $this->CI->load->model('media_model', '', TRUE);
        $this->CI->load->model('user_model', '', TRUE);
        $this->CI->load->helper('util_helper');
    }

    public function initialize( $start_date , $end_date , $account , $account_id , $account_name ) {

        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->account = $account;
        $this->account_id = $account_id;
        $this->account_name = $account_name;
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

    public function get_shares() {

        return check_json_error($this->CI->analytics_model->get_play_shares( $this->start_date , $this->end_date , $this->account ) );
    }

    public function get_browsers() {

        return check_json_error($this->CI->analytics_model->get_play_browsers( $this->start_date , $this->end_date , $this->account ) );
    }
    
    public function get_systems() {

        return check_json_error($this->CI->analytics_model->get_play_systems( $this->start_date , $this->end_date , $this->account ) );
    }

    public function get_devices() {

        return check_json_error($this->CI->analytics_model->get_play_devices( $this->start_date , $this->end_date , $this->account ) );
    }

    public function process_basic_data($data) {      
        
        $this->count = $data->content->totalsForAllResults->{'ga:totalEvents'};
        $this->view_time = $data->content->totalsForAllResults->{'ga:SessionDuration'};
        $this->avg_view_time = $data->content->totalsForAllResults->{'ga:avgSessionDuration'};
    }

    public function process_impressions_data($data) {
        
        $this->impressions = $data->content->totalsForAllResults->{'ga:totalEvents'};
    }
     
    public function get_videos_titles ($videos) {
        
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
    
    public function get_videos_id_title ($ids) {
        

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
        //error_log( 'el result es ' . json_encode($result));
        return $result;
    }
    
        public function get_videos_time_range () {
        $start_time = strtotime($this->start_date).'000';
        $end_time = strtotime($this->end_date).'000';
        $get_media = "byAdded=".$start_time.'~'.$end_time;
        $count = $this->CI->media_model->get_media_total(@$_SESSION['user_data']->token, $get_media);
        
        
        return $count;
    }
    
    public function get_ppv_statistics(){
        
    }

}
