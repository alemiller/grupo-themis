<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Play_VOD extends Play_Analytics{
  
      function Play_VOD() {

        parent::__construct();
    }
    
        public function get_analytics() {

        $report = $this->get_videos_time_range();
        return $report;
    }
}