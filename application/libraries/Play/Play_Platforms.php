<?php

/**
 * Description of Play_Platforms
 *
 * @author luisriquelme
 */

class Play_Platforms extends Play_Analytics{

    var $dates_data = array();
    var $devices_data = array();
    var $devices_count;
    
    function Play_Platforms() {

        parent::__construct();
    }

    public function get_dates() {

        return check_json_error($this->CI->analytics_model->get_play_devices_dates( $this->start_date , $this->end_date , $this->account ) );
    }
    
    private function process_dates_data ( $dates_data ) {
        
        if( $dates_data->content->rows != null ){

            $this->dates_data = $this->set_dates( $dates_data );
         }   
    }
    
    private function process_devices_data ( $devices_data ) {

        if( $devices_data->content->rows != null ){

            $this->devices_data = $this->set_devices( $devices_data );
        }    
    }
    
    private function set_dates($date_data) {
        
        
        $dates = array();
        foreach ($date_data->content->rows as $array) {
            
            $device = $array[1];
            $dates[$device][] = array('date' => $array[2],'sessions' => $array[3]);
        }
        
        return $dates;
    }
    
    private function set_devices($devices_data) {

        $data = array();
        
        $detail = array('total' => '0', 'session_duration' => '', 'avg_session_duration' => '');
        $play_data = array('Play' => $detail, 'Player Impressions' => $detail);
        
        $ga_data = $devices_data->content->rows;
        $this->devices_count = 0;
        
        for ($i = 0; $i < sizeof($ga_data); $i++) {
            
            $device = $ga_data[$i][1];
            $event = $ga_data[$i][0];
            
            if (!key_exists($device, $data)) {
                
                $this->devices_count++;
                $data[$device] = $play_data;
            }
            
            $data[$device][$event]['session_duration'] = $ga_data[$i][4];
            $data[$device][$event]['avg_session_duration'] = $ga_data[$i][3];
            $data[$device][$event]['total'] = $ga_data[$i][2];     

        }
        
        $sorted_data = array_reverse($data, true);
        return $sorted_data;
    }

    public function get_analytics() {
        
        $basic_data = $this->get_basic_data();
        $impressions = $this->get_impressions();
        $dates = $this->get_dates();
        $devices = $this->get_devices();
        
        $this->process_basic_data($basic_data);
        $this->process_impressions_data($impressions);
        $this->process_dates_data($dates);
        $this->process_devices_data($devices); 
        
        $report = $this->get_report();
        return $report;
        
    }

    private function get_report() {
        
        $report = array();
        
        $report['plays'] = $this->count;
        $report['view_time'] = $this->view_time;
        $report['avg_view_time'] = $this->avg_view_time;
        $report['impressions'] = $this->impressions;
        $report['dates'] = $this->dates_data;
        $report['devices'] = $this->devices_data;
        $report['devices_count'] = $this->devices_count;
        
        return $report;
    }   
    
}
