<?php

/**
 * Description of Play Operating Systems
 *
 * @author luisriquelme
 */

class Play_Operating_Systems extends Play_Analytics{

    // analytics specific data for play operating systems
    var $systems_data = array();

    function Play_Operating_Systems() {

        parent::__construct();
    }
    
    private function process_systems_data ( $systems_data ) {
        
        if( $systems_data->content->rows != null ){    

            $this->systems_data = $this->set_systems( $systems_data );
        }    
    }

    private function set_systems($systems_data) {

        $data = array();
        
        $detail = array('total' => '0', 'session_duration' => '', 'avg_session_duration' => '');
        $play_data = array('Play' => $detail, 'Player Impressions' => $detail);
        
        $ga_data = $systems_data->content->rows;
        
        for ($i = 0; $i < sizeof($ga_data); $i++) {
            
            $system = $ga_data[$i][1];
            $event = $ga_data[$i][0];
            
            if (!key_exists($system, $data)) {
 
                $data[$system] = $play_data;
            }
            
            $data[$system][$event]['session_duration'] = $ga_data[$i][4];
            $data[$system][$event]['avg_session_duration'] = $ga_data[$i][3];
            $data[$system][$event]['total'] = $ga_data[$i][2];     

        }
        
        $sorted_data = array_reverse($data, true);
        return $sorted_data;
    }

    public function get_analytics() {

        $basic_data = $this->get_basic_data();
        $impressions = $this->get_impressions();
        $systems = $this->get_systems();

        $this->process_basic_data($basic_data);
        $this->process_impressions_data($impressions);
        $this->process_systems_data($systems);
        
        $report = $this->get_report();
        return $report;
    }
    
    private function get_report() {
        
        $report = array();
  
        $report['plays'] = $this->count;
        $report['view_time'] = $this->view_time;
        $report['avg_view_time'] = $this->avg_view_time;
        $report['impressions'] = $this->impressions;
        $report['systems'] = $this->systems_data;
        
        return $report;
    }

}
