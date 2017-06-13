<?php

/**
 * Description of Play Content
 *
 * @author luisriquelme
 */

class Play_Content extends Play_Analytics{

    // analytics specific data for play content
    var $sources_data = array();
    var $dates_data = array();
    var $medias;

    function Play_Content() {

        parent::__construct();
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

        $sources = $this->get_videos_titles( $data );

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
