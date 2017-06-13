<?php

function get_upload_usernames($media, $users) {
    
    if (isset($media->content->entries) && sizeof($media->content->entries) > 0 && sizeof($users) > 0) {
        for ($i = 0; $i < sizeof($media->content->entries); $i++) {

            $flag = 0;
            for ($h = 0; $h < sizeof($users); $h++) {
                
                if (isset($users[$h]['id']) && $users[$h]['id'] == $media->content->entries[$i]->addedByUserId) {
                    $flag = 1;
                    $mail = $users[$h]['username'];
                    break;
                }
            }

            if ($flag) {
                $media->content->entries[$i]->addedUserName = $mail;
            } else {
                $media->content->entries[$i]->addedUserName = 'Unknown';
            }
        }
    }

    return $media;
}

?>