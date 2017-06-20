<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Clientes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('clientes_model');
        $this->load->model('tramites_model');
        $this->load->model('clases_tramite_model');
        $this->load->model('subzonas_model');
        $this->load->model('corresponsales_model');
        $this->load->model('pagos_model');
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->library('session');
    }

    public function index() {

        $data = array();
        $data["clientes"] = $this->clientes_model->list_clientes();

        $this->load->view('pages/clientes', $data);
    }

    public function get_by_id() {

        $id = $_GET['id'];
        $data = array();
        $data['cliente'] = $this->clientes_model->get_by_id($id);
        $data['tramites'] = $this->tramites_model->get_by_cliente_id($id);
        $data['pagos'] = $this->pagos_model->get_by_cliente_id($id);

        $data['subzonas'] = $this->subzonas_model->list_subzonas();
        $data['corresponsales'] = $this->corresponsales_model->list_corresponsales();
        $data['clases_tramite'] = $this->clases_tramite_model->list_clases();

        if (isset($_GET['tramite_id'])) {
            $data['tramite_selected'] = $this->tramites_model->get_by_id($_GET['tramite_id']);
        }

        $ajax_response = $this->load->view('pages/detalle_cliente', $data, TRUE);
        $this->output->set_output($ajax_response);
    }

    public function new_client() {

        $data = array();

        $data['subzonas'] = $this->subzonas_model->list_subzonas();
        $data['corresponsales'] = $this->corresponsales_model->list_corresponsales();
        $data['clases_tramite'] = $this->clases_tramite_model->list_clases();

        $ajax_response = $this->load->view('pages/detalle_cliente', $data, TRUE);
        $this->output->set_output($ajax_response);
    }

    public function create() {

        if (isset($_POST['data'])) {

            $create = $this->clientes_model->create($_POST['data']);

            if ($create) {
                $return = array('status' => 1, 'msg' => 'El usuario fue creado con éxito', 'data' => $create[0]);
            } else {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en la creación del usuario');
            }

            echo json_encode($return);
        }
    }

    public function update() {

        if (isset($_POST['data']) && isset($_POST['id'])) {

            $create = $this->clientes_model->update($_POST['id'], $_POST['data']);

            if ($create) {
                $return = array('status' => 1, 'msg' => 'El usuario fue actualizado con éxito');
            } else {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en la actualización del usuario');
            }

            echo json_encode($return);
        }
    }

    public function insert_users() {

        $this->clientes_model->insert_users();
    }

}
