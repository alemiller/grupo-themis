<?php

function count_added_username ($array) {
    
    $usernames = array(); 
    for ($x = 0; $x < sizeof($array); $x++) {

        $user = $array[$x]->addedUserName;
        if (array_key_exists ($user, $usernames)) {

            $usernames[$user]++; 
        }
        else {
            $usernames[$user] = 1;
        }
    }
    
    return $usernames;
}

function sort_by_numerical_values ($array) {
    
    // associative array
    uasort($array, function ($a, $b){
            
        if ($a == $b) {
            
            return 0;
        }
        return ($a > $b) ? -1 : 1;
    });
    
    return $array;    
}

function get_impression_ratio($plays, $impressions) {
    
    if ($impressions == 0) {
        
        $impression_ratio = 0;
    } 
    else {
        
        $impression_ratio = (($plays * 100) / $impressions);
    }
    
    return round($impression_ratio, 2);
}

function get_dates ($dates_data) {
    
    $plays_per_date = array();
    foreach ($dates_data as $entry) {

        $data = array(strtotime($entry['date'])*1000, intval($entry['sessions']));
        $plays_per_date[] = $data;
    }
                        
    return json_encode($plays_per_date);    
}

function get_play_through_ratio ($drop_data) {
    
    $result = 0;
    if( $drop_data['Play'] != 0 ){     
        $result = ($drop_data['Complete'] * 100) / $drop_data['Play'];                  
    }    
    return round($result, 2);   
}

?>