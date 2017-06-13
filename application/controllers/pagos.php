<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pagos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('pagos_model');
        $this->load->model('clientes_model');
        $this->load->model('cta_cte_model');
        $this->load->model('email_model');
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->library('session');
    }

    public function index() {

        $data = array();
        $data["pagos"] = $this->pagos_model->list_pagos();

        $this->load->view('pages/pagos', $data);
    }

    public function get_by_id() {

        $id = $_POST['id'];
        $cliente = $this->pagos_model->get_by_id($id);

        echo json_encode($cliente);
    }

    public function create() {

        if (isset($_POST['data'])) {

            $create = $this->pagos_model->create($_POST['data']);

            if ($create) {

                $cliente = $this->clientes_model->get_by_id($create->id_cliente);

                $return = $this->generar_impresion($create, $cliente);
            } else {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en la creación del pago');
            }


            echo json_encode($return);
        }
    }

    public function update() {

        if (isset($_POST['data']) && isset($_POST['id'])) {

            $update = $this->pagos_model->update($_POST['id'], json_encode($data));

            if ($update) {

                $return = array('status' => 1, 'msg' => 'El pago fue actualizado con éxito', 'data' => $data);
            } else {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en la actualización del pago');
            }
        } else {
            array('status' => 0, 'msg' => 'Hubo un problema en la actualización del pago');
        }

        echo json_encode($return);
    }

    public function delete() {

        if (isset($_POST['ids'])) {

            $ids = explode(',', $_POST['ids']);
            $delete = $this->pagos_model->delete($ids);

            if ($delete === sizeof($ids)) {
                if ($delete > 1) {
                    $msg = 'Los pagos fueron eliminados con éxito';
                } else {
                    $msg = 'el pago fue eliminado con éxito';
                }
                $return = array('status' => 1, 'msg' => $msg);
            } else {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en el borrado del/los pago(es)');
            }

            echo json_encode($return);
        }
    }

    public function generar_impresion($pago, $cliente) {

        $data = array();
        $data['cliente'] = $cliente;
        $data['pago'] = $pago;

        $data['saldo'] = $this->cta_cte_model->get_saldo($data['cliente']->id);

        $ajax_response = $this->load->view('templates/constancias/pago', $data, TRUE);

        $name = 'pago_' . time() . '.html';
        $root = $this->config->item('save_file_folder') . $name;
        $url = base_url() . $this->config->item('save_file_root') . $name;
        $create_file = file_put_contents($root, $ajax_response);
        error_log('create file: '.json_encode($create_file));
        if ($create_file) {
            error_log('entra a crear file'); 
            $info = new stdClass();
            $info->pago = $pago;
            $info->cliente = $cliente;
            $info->saldo = $data['saldo'];

            $this->email_model->send_email('Aviso de pago', $info, 'pago');

            $return = array('status' => 1, 'msg' => 'El pago fue creado con éxito', 'data' => $pago, 'url' => $url);
        } else {
            $return = array('status' => 0, 'msg' => 'Hubo un problema en la creación del pago');
        }

        return $return;
    }

}
