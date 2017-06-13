<?php

/**
 * Description of PortalException
 *
 * @author luisriquelme
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class PortalException extends Exception
{
    // Redefine the exception so message isn't optional
    //public function __construct($message, $code = 0, Exception $previous = null) {
    public function __construct($params) {
        // some code
        // 
        // make sure everything is assigned properly
        parent::__construct($params['message'], $params['code'], null);
    }

    // custom string representation of object
    public function __toString() {
        $array = array('status' => "error", 'message' => "$this->message");
        return json_encode($array);
    }

}

