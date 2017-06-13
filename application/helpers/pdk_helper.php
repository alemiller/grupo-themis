<?php

function getEntryId($entry) {
    $item_id_arr = explode("/", $entry->id);
    return $item_id_arr[sizeof($item_id_arr) - 1];
}

function getExplodeId($uri) {
    $item_id_arr = explode("/", $uri);
    return $item_id_arr[sizeof($item_id_arr) - 1];
}

function getEntryCategories($entry) {
    $ret = "";
    if ($entry && $entry->categories) {
        $retArr = array();
        for ($i = 0; $i < sizeof($entry->categories); $i++) {
            $retArr[] = $entry->categories[i]->name;
        }
        $ret = implode(",", $retArr);
    }
    return $ret;
}

function getEntryProperty($entry, $property) {

    $ret = "-";

    switch ($property) {
        case 'cover':
            if ($entry->content &&
                sizeof($entry->content) &&
                $entry->content[0]->url) {
                $ret = $entry->content[0]->url;
            }
            break;
        case 'title':
            if (isset($entry->title)) {
                $ret = $entry->title;
            }
            break;
        case 'year':
            if (isset($entry->movie_year)) {
                $ret = $entry->movie_year;
            }
            break;
        case 'runtime':
            if (isset($entry->runtime)) {
                $ret = $entry->runtime;
            }
            break;

        case 'director':
            if (isset($entry->directors)) {
                $ret = $entry->directors;
            }
            break;
        case 'actors':
            if (isset($entry->actors)) {
                $ret = $entry->actors;
            }
            break;
        case 'adPolicyId':
            if (isset($entry->pladPolicyId)) {
                $ret = $entry->pladPolicyId;
            }
            break;
        case 'description':
            if (isset($entry->description)) {
                $ret = $entry->description;
            }
            break;
        case 'writer':
        case 'language':
        case 'rating':
        case 'trailer':
        case 'genre':
        case 'tags':
    }

    return $ret;
}

function getEntryReleaseId($entry, $rendition = "Video") {
    $ret = "";
    if ($entry && $entry->content) {
        for ($i = 0; $i < sizeof($entry->content); $i++) {
            if ($entry->content[$i]->assetTypes[0] == $rendition) {
                $ret = $entry->content[$i]->releases[0]->pid;
                break;
            }
        }
    }
    return $ret;
}

function getStorageUrls($entry, $rendition = "Video", $parameters) {
    $ret = array();
    if ($entry && $entry->content) {
        for ($i = 0; $i < sizeof($entry->content); $i++) {
            if (isset($entry->content[$i]->assetTypes[0]) && $entry->content[$i]->assetTypes[0] == $rendition) {
                for ($h = 0; $h < sizeof($parameters); $h++) {
                    if ($parameters[$h]['w'] == $entry->content[$i]->width &&
                        $parameters[$h]['h'] == $entry->content[$i]->height) {
                        $ret[] = $entry->content[$i]->storageUrl;
                    }
                }
            }
        }
    }
    return $ret;
}

function getMediaFilesIds($entry) {

    $ret = array();
    if ($entry && $entry->content) {

        for ($i = 0; $i < sizeof($entry->content); $i++) {

            $ret[] = $entry->content[$i]->_id;
        }
    }

    return $ret;
}

function getMediaFilesIds_to_delete($entry, $asset_type) {
    $ret = array();
    if ($entry && $entry->content) {
        for ($i = 0; $i < sizeof($entry->content); $i++) {
            if ($entry->content[$i]->assetTypes[0] !== $asset_type) {
                $ret[] = $entry->content[$i]->_id;
            }
        }
    }
    return $ret;
}

function getEntryReleaseUrl($entry, $rendition = "Video") {
    $ret = "";
    if ($entry && $entry->content) {
        for ($i = 0; $i < sizeof($entry->content); $i++) {
            if ($entry->content[$i]->assetTypes[0] == $rendition) {
                $ret = $entry->content[$i]->releases[0]->url;
                break;
            }
        }
    }
    return $ret;
}

function getEntryStreamingUrl($entry, $rendition = "Video") {
    $ret = "";

    if ($entry && $entry->content) {
        for ($i = 0; $i < sizeof($entry->content); $i++) {
            if (isset($entry->content[$i]->assetTypes) &&
                sizeof($entry->content[$i]->assetTypes)) {
                for ($j = 0; $j < sizeof($entry->content[$i]->assetTypes); $j++) {
                    if ($entry->content[$i]->assetTypes[$j] == $rendition &&
                        isset($entry->content[$i]->streamingUrl)) {
                        $ret = $entry->content[$i]->streamingUrl;
                        break;
                    }
                }
            }
            if ($ret)
                break;
        }
    }
    return $ret;
}

function getAssetId($entry, $rendition = "Video") {
    $ret = "";

    if ($entry && $entry->content) {
        for ($i = 0; $i < sizeof($entry->content); $i++) {
            if (isset($entry->content[$i]->assetTypes) &&
                sizeof($entry->content[$i]->assetTypes)) {
                for ($j = 0; $j < sizeof($entry->content[$i]->assetTypes); $j++) {
                    if ($entry->content[$i]->assetTypes[$j] == $rendition &&
                        isset($entry->content[$i]->_id)) {
                        $ret = $entry->content[$i]->_id;
                        break;
                    }
                }
            }
            if ($ret)
                break;
        }
    }
    return $ret;
}

function getEntryRenditions($entry, $rendition = "Video") {
    $ret = array();
    if ($entry && $entry->content) {
        for ($i = 0; $i < sizeof($entry->content); $i++) {
            if (isset($entry->content[$i]->assetTypes) && sizeof($entry->content[$i]->assetTypes)) {
                for ($j = 0; $j < sizeof($entry->content[$i]->assetTypes); $j++) {
                    if ($entry->content[$i]->assetTypes[$j] == $rendition &&
                        isset($entry->content[$i]->streamingUrl)) {

                        $rend = new stdClass();

                        $rend->file = $entry->content[$i]->streamingUrl;
                        $rend->label = $entry->content[$i]->width . 'x' . $entry->content[$i]->height . ' ' . formatBytes($entry->content[$i]->bitrate, 0);
                        $rend->bitrate = $entry->content[$i]->bitrate;

                        $ret[] = $rend;
                    }
                }
            }
        }
    }

    usort($ret, function($a, $b) {
        return ($a->bitrate < $b->bitrate);
    });

    return $ret;
}

function getEntryThumbnail($entry, $type) {
    $ret = "";
    if ($entry && isset($entry->content)) {
        for ($i = 0; $i < sizeof($entry->content); $i++) {
            if (isset($entry->content[$i]->assetTypes) &&
                sizeof($entry->content[$i]->assetTypes)) {
                for ($j = 0; $j < sizeof($entry->content[$i]->assetTypes); $j++) {
                    if ($entry->content[$i]->assetTypes[$j] == $type) {
                        if ($entry->content[$i]->downloadUrl) {
                            $ret = $entry->content[$i]->downloadUrl;
                        } else if (isset($entry->content[$i]->url)) {
                            $ret = $entry->content[$i]->url;
                        }
                        break;
                    }
                }
            }
        }
    }
    return $ret;
}

function getFileDuration($entry, $rendition) {

    $ret = '';
    if ($entry && $entry->content) {
        for ($i = 0; $i < sizeof($entry->content); $i++) {
            if ($entry->content[$i]->assetTypes && sizeof($entry->content[$i]->assetTypes)) {
                for ($j = 0; $j < sizeof($entry->content[$i]->assetTypes); $j++) {
                    if ($entry->content[$i]->assetTypes[$j] == $rendition && $entry->content[$i]->duration) {

                        $ret = $entry->content[$i]->duration;
                        break;
                    }
                }
            }
        }
    }

    return $ret;
}

function getFileSize($entry, $rendition) {

    $ret = '';
    if ($entry && $entry->content) {
        for ($i = 0; $i < sizeof($entry->content); $i++) {
            if ($entry->content[$i]->assetTypes && sizeof($entry->content[$i]->assetTypes)) {
                for ($j = 0; $j < sizeof($entry->content[$i]->assetTypes); $j++) {
                    if ($entry->content[$i]->assetTypes[$j] == $rendition && $entry->content[$i]->fileSize) {

                        $ret = $entry->content[$i]->fileSize;
                        break;
                    }
                }
            }
        }
    }

    return $ret;
}

function convert_to_timestamp($date, $time, $delimiter) {

    $date_arr = explode($delimiter, $date);
    $time_arr = explode(":", $time);
    return mktime(intval($time_arr[0]), intval($time_arr[1]), 0, intval($date_arr[0]), intval($date_arr[1]), intval($date_arr[2]));
}

function normalize_string($str = '') {
    $str = strip_tags($str);
    $str = preg_replace('/[\r\n\t ]+/', '_', $str);
    $str = preg_replace('/[\"\*\/\:\<\>\?\#\(\)\'\|]+/', '-', $str);
    $str = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $str);
    $str = str_replace(' ', '_', $str);
    $str = str_replace('%', '-', $str);
    return $str;
}

function sanitize_search_string($string) {

    $new_string = "*" . str_replace(" ", "* AND *", preg_replace('/\s\s+/', ' ', trim($string))) . "*";
    return urlencode($new_string);
}

function get_entry_live_streaming_url($entry) {

    $ret = "";

    if (!$entry)
        return;

    for ($i = 0; $i < sizeof($entry); $i++) {
        if ($entry && $entry[$i]->{'assetTypes'}) {
            for ($j = 0; $j < sizeof($entry[$i]->{'assetTypes'}); $j++) {
                if ($entry[$i]->{'assetTypes'}[$j] == "HLS Stream") {

                    $ret = urldecode($entry[$i]->{'downloadUrl'});
                }
            }
        }
    }

    return $ret;
}

function get_entry_live_streaming_blocked_url($entry) {

    $ret = "";

    if (!$entry)
        return;

    for ($i = 0; $i < sizeof($entry); $i++) {
        if ($entry && $entry[$i]->{'assetTypes'}) {
            for ($j = 0; $j < sizeof($entry[$i]->{'assetTypes'}); $j++) {
                if ($entry[$i]->{'assetTypes'}[$j] == "HLS Blocked Stream") {
                    $ret = urldecode($entry[$i]->{'downloadUrl'});
                }
            }
        }
    }

    return $ret;
}

function get_secure_hls_url($url, $secret = "", $expiration = 60, $ci = 10, $cd = 10) {

    if (!$secret)
        return $url;

    $base_url = substr($url, 0, strrpos($url, "/") + 1);
    $p = strlen($base_url);
    $ci = 60;
    $cd = 60;
    $e = time() + $expiration * 60;
    $cf = time() + 240 * 60 * 60;
    $hash = md5($secret . $base_url . "?p=$p&ci=$ci&cd=$cd&e=$e&cf=$cf");

    return $url . "?p=$p&ci=$ci&cd=$cd&e=$e&cf=$cf&h=$hash";
}

?>
