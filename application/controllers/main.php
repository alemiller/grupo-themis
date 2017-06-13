<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('file');
    }

    public function index() {
        error_log('llego al main');
        // check user login
        if (!$this->session->userdata('user') || !$this->session->userdata('password')) {
            error_log('base url: '.base_url());
            redirect(base_url() . 'index.php/adminLogin');
            return;
        }
        
        $this->load->view('pages/main');
    }

}
