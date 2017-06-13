<?php

/**
 * Description of Play Browsers
 *
 * @author luisriquelme
 */

class Play_Browsers extends Play_Analytics{

    // analytics specific data for play browsers
    var $dates_data = array();
    var $browsers_data = array();
    
    function Play_Browsers() {

        parent::__construct();
    }
    
    private function process_dates_data ( $dates_data ) {
        
        if ( $dates_data->content->rows != null ){
            $this->dates_data = $this->set_dates( $dates_data );
        }   
    }
    
    private function process_browsers_data ( $browsers_data ) {
        
        if ( $browsers_data->content->rows != null ){
            $this->browsers_data = $this->set_browsers( $browsers_data );
        }   
    }
    
    private function set_dates($dates_data) {
        
        $dates = array();

        foreach ($dates_data->content->rows as $array) {
            $system = $array[1];
            $dates[$system][] = array('date' => $array[2],'sessions' => $array[3]);
        }
        
        return $dates;
    }

    private function set_browsers($browsers_data) {

        $data = array();
        
        $detail = array('total' => '0', 'session_duration' => '', 'avg_session_duration' => '');
        $play_data = array('Play' => $detail, 'Player Impressions' => $detail);
        
        $ga_data = $browsers_data->content->rows;
        
        for ($i = 0; $i < sizeof($ga_data); $i++) {
            
            $browser = $ga_data[$i][1];
            $event = $ga_data[$i][0];
            
            if (!key_exists($browser, $data)) {
 
                $data[$browser] = $play_data;
            }
            
            $data[$browser][$event]['session_duration'] = $ga_data[$i][4];
            $data[$browser][$event]['avg_session_duration'] = $ga_data[$i][3];
            $data[$browser][$event]['total'] = $ga_data[$i][2];     

        }

        $browsers = $data;   
        // begin order by play total
        foreach ( $browsers as $browser => $events ) {

            foreach ($events as $event => $metrics) {

                $total[$browser][$event] = $metrics['total'];
            } 

        }

        foreach ( $total as $browser => $events ) {

            $plays[] = $events['Play'];
            $impressions[] = $events['Player Impressions'];
        }

        array_multisort( $plays , SORT_DESC, $impressions, SORT_DESC, $browsers);
        // end order by play total
        
        return $browsers;
    }

    public function get_analytics() {

        $basic_data = $this->get_basic_data();
        $impressions = $this->get_impressions();
        $systems = $this->get_browsers();

        $this->process_basic_data($basic_data);
        $this->process_impressions_data($impressions);
        $this->process_browsers_data($systems);
        
        $report = $this->get_report();
        return $report;
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
