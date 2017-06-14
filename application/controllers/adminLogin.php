<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class AdminLogin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model("admin_user");
        $this->load->library('session');
        $this->load->helper('file');
    }

    public function index() {
        $this->load->view('pages/login');
        return;
    }

    public function login() {

        $result = $this->admin_user->login($_POST['user'], $_POST['password']);

        if ($result === 'true') {
            delete_files('./uploads/');
            $this->session->set_userdata('user', $_POST['user']);
            $this->session->set_userdata('password', $_POST['password']);
        }

        echo $result;
    }

    public function logout() {

        $this->session->unset_userdata('user');
        $this->session->unset_userdata('password');
        redirect(base_url() . 'index.php/');
    }

}
