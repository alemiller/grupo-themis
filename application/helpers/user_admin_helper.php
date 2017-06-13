<?php

function get_admin_users () {
    
    $users = '';
    if (isset($_SESSION['admin_users']->content)) {
        
        for ($i = 0; $i < sizeof($_SESSION['admin_users']->content); $i++) {
            
        	$user = $users[$i];
            $user['id'] = $_SESSION['admin_users']->content[$i]->_id;
            $user['username'] = $_SESSION['admin_users']->content[$i]->{'userName'};
        }
    }
    
    return $users;   
}

?>