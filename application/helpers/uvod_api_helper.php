<?php

function apiCall($method, $parameters = null) {

    $url_params = "";

    if ($parameters) {
        $url_params = str_replace("=", "/", http_build_query($parameters, "", "="));
    }

    $url = UVOD_ADMIN_API_ENDPOINT . $method . "/" . $url_params;

    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, $url);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_handle, CURLOPT_USERPWD, UVOD_ADMIN_API_USER . ':' . UVOD_ADMIN_API_PASSWORD);

    $buffer = curl_exec($curl_handle);
//    error_log($method." BUFFER: ".$buffer);
    curl_close($curl_handle);

    return json_decode($buffer);
}

function apiPost($method, $parameters = null) {

    $ci = & get_instance();

    $url = UVOD_ADMIN_API_ENDPOINT . $method;

    $parameters_str = json_encode($parameters);

    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, $url);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_handle, CURLOPT_USERPWD, UVOD_ADMIN_API_USER . ':' . UVOD_ADMIN_API_PASSWORD);
    curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($parameters_str)));
    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $parameters_str);

    $buffer = curl_exec($curl_handle);
    curl_close($curl_handle);
//    error_log($method. " BUFFER: ".$buffer);
    $response = json_decode($buffer);

    return $response;
}

?>