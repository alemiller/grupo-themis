<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Search Manager
 *
 * @author luisriquelme
 */
class Search_Manager {

    var $CI;
    var $search;
    var $page;
    var $query;

    function Search_Manager() {

        $this->CI = & get_instance();
        $this->CI->load->model('media_model', '', TRUE);
        $this->CI->load->model('episode_model', '', TRUE);
        $this->CI->load->model('season_model', '', TRUE);
    }

    public function initialize($search_value, $page) {

        $params = array();
        foreach ($search_value as $key => $value) {

            switch ($key) {
                case "ById":
                    $params[] = "byId=" . urlencode($value);
                    break;
                case "ByTitle":
                    $params[] = "search" . $key . "=" . urlencode($value);
                    break;

                case "byAired_date":
                    $params[] = $key . "=" . $value;
                    break;
            }
        }

        // search => searchByTitle=Smile+jamaica
        $this->search = implode("&", $params);
        $this->page = $page;
        $this->set_query();
    }

    public function search() {

        $data = array();
        $data['media_obj'] = $this->get_medias();
        $data['count'] = $this->get_media_count();

        $from = ((intval($this->page)) * $this->CI->config->item('elements_return')) - ($this->CI->config->item('elements_return')) + 1;
        $to = (intval($this->page)) * $this->CI->config->item('elements_return');

        $data['page_number'] = $this->page;
        $data['from'] = $from;
        $data['to'] = $to;
        return $data;
    }

    public function get_media_by_id($id) {

        $media = $this->CI->media_model->get_media_by_id(@$_SESSION['user_data']->token, $id, null);

        if ($media->content->entries[0]->media_type == 'season') {

            $this->get_tvshow($media);
        }

        if ($media->content->entries[0]->media_type == 'episode') {

            $this->get_tvshow($media);
            $this->get_season($media);
        }

        return $media;
    }

    private function get_media_count() {

        $total = 0;
        $count = $this->get_media_total();
        if (isset($count->content->count)) {

            $total = $count->content->count;
        }

        return $total;
    }

    private function get_medias() {


        return $this->CI->media_model->get_media_object(@$_SESSION['user_data']->token, $this->query);
        //return check_json_error($this->CI->analytics_model->get_play_drops($this->start_date, $this->end_date));
    }

    private function get_media_total() {

        return $this->CI->media_model->get_media_total(@$_SESSION['user_data']->token, $this->query);
        //return check_json_error($this->CI->analytics_model->get_play_drops($this->start_date, $this->end_date));
    }

    private function set_query() {

        // params => searchByTitle=Smile+jamaica&size=20&page=0
        $params = array();
        $params[] = $this->search;
        $params[] = 'size=20';
        $params[] = "page=" . ( $this->page - 1 );
        $params[] = "sort=aired_date:-1";
        $this->query = implode('&', $params);
    }

    private function get_tvshow($media) {

        $fields = 'title';
        $query = 'bySeries_id=' . $media->content->entries[0]->series_id . '&byMedia_type=tv_show';
        $media_tvshow = $this->CI->media_model->get_media_object(@$_SESSION['user_data']->token, $query, null, $fields);
        $media->content->entries[0]->serie_name = $media_tvshow->content->entries[0]->title;
    }

    private function get_season($media) {

        $episode = $this->get_episode($media);
        $tvseason_id = $episode->program->entries[0]->tvSeasonId;
        $season = $this->CI->season_model->get_season_by_id(@$_SESSION['user_data']->token, $tvseason_id);
        $media->content->entries[0]->season_name = $season->content->title;
    }

    private function get_episode($media) {

        $episode = $this->CI->episode_model->get_episode_by_guid(@$_SESSION['user_data']->token, $media->content->entries[0]->_id, $media->content->entries[0]->program_id);
        return $episode->content->entries[0];
    }

}
