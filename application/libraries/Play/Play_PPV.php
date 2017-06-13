<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Play_PPV extends Play_Analytics{
  
      function Play_VOD() {

        parent::__construct();
    }
    
        public function get_analytics() {

        $report = $this->get_ppv_statistics();
        return $report;
    }
}