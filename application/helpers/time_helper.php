<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function date_to_timestamp ($date) {
    
    $timestamp = strtotime($date);
    return $timestamp;
}

function second_to_minutes($time) {
    
    $hours = floor($time / 3600);
    $minutes = floor($time % 3600 / 60);
    $seconds = $time % 60;
    
    return array($hours, leading_zero($minutes), leading_zero($seconds));
}

function leading_zero ($num) {
    
    return (strlen((string)$num) < 2) ? "0{$num}" : "$num";
}

function parse_user_added( $date ){

	if ( is_timestamp( $date) ){

		$result = date('m-d-Y H:i', $date/1000 ); 
	}
	else{

		$result = date('m-d-Y H:i', strtotime( $date) ); 
	}
	return $result;

}

function is_timestamp( $date ){

	$check = (is_int($date) OR is_float($date))
		? $date
		: (string) (int) $date;
	return  ($check === $date)
        	AND ( (int) $date <=  PHP_INT_MAX)
        	AND ( (int) $date >= ~PHP_INT_MAX);
}