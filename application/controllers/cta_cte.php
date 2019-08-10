<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cta_cte extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('cta_cte_model');
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->library('session');
    }

    public function get_transacciones() {

        $id = $_POST['id'];
        $data = array();
        $data['transacciones'] = $this->cta_cte_model->get_transacciones($id);
        $data['saldo'] = $this->cta_cte_model->get_saldo($id);
     
        $ajax_response = $this->load->view('templates/cliente/cta_cte/lista_transacciones', $data, TRUE);
        $this->output->set_output($ajax_response);
    }

    public function get_saldo() {

        $id = $_POST['id'];
        $cliente = $this->cta_cte_model->get_saldo($id);

        echo json_encode($cliente);
    }

    

}
