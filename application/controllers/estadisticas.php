<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Estadisticas extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('estadisticas_model');
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->library('session');
    }

    public function index() {

        $data = array();
        $data["count_tramites"] = $this->estadisticas_model->count_tramites();

        $this->load->view('pages/estadisticas', $data);
    }

    public function ingresos_report() {

        $data = array();
        $data['ingresos'] = $this->estadisticas_model->ingresos_report($_POST['start_date'], $_POST['end_date']);

        $ajax_response = $this->load->view('templates/reportes/ingresos', $data, TRUE);
        $this->output->set_output($ajax_response);
    }

}
