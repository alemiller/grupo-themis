<?php

define('ENVIRONMENT', read_config_var('ENVIRONMENT'));

function read_config_var($variable) {

	$ret = '';

	if (file_exists('env.ini')) {
		$env_array = parse_ini_file("env.ini");
		if (isset($env_array[$variable])) $ret = $env_array[$variable];
	} 

	if (!$ret) {
		if (getenv($variable) === false) {
			die('Invalid configuration. ' . $variable . ' not set.');
		} else {
			$ret = getenv($variable);
		}
	}

	return $ret;
}

