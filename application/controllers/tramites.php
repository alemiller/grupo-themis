<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tramites extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('tramites_model');
        $this->load->model('clientes_model');
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->library('session');
        $email = $this->config->item('email_app');
        switch ($email) {
            case 'heroku_email':
                $this->load->model('heroku_email_model', 'final_email_model');
                break;
            case 'php_email':
                $this->load->model('email_model', 'final_email_model');
                break;
        }
    }

    public function index() {

        $data = array();
        $data["tramites"] = $this->tramites_model->list_tramites();

        $this->load->view('pages/tramites', $data);
    }

    public function get_by_id() {

        $id = $_POST['id'];
        $cliente = $this->tramites_model->get_by_id($id);

        echo json_encode($cliente);
    }

    public function create() {

        if (isset($_POST['data'])) {

            $create = $this->tramites_model->create($_POST['data']);

            if ($create) {
                $return = array('status' => 1, 'msg' => 'El tramite fue creado con éxito', 'data' => $create[0]);
            } else {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en la creación del tramite');
            }


            echo json_encode($return);
        }
    }

    public function update() {

        if (isset($_POST['data']) && isset($_POST['id'])) {

            $data = json_decode($_POST['data']);
            $flag = true;
            $url = null;

            if ($data->estado === 'listo') {

                $tramite = $this->tramites_model->get_by_id($_POST['id']);

                if (!$tramite->fecha_aviso) {

                    $cliente = $this->clientes_model->get_by_id($_POST['id_cliente']);

                    if ($cliente->email === '') {
                        $return = array('status' => 0, 'msg' => 'Complete el campo "Email" en la solapa Datos Personales');
                        $flag = false;
                    } else {

                        $data->fecha_aviso = date('Y-m-d', time());

                        $info = new stdClass();
                        $info->cliente = $cliente;
                        $info->tramite = $data;
                        $info->tramite->id = $_POST['id'];

                        $this->email_model->final_email_model('Aviso de trámite finalizado', $info, 'tramite_listo');
                    }
                }
            } else if ($data->estado === 'retirado') {

                $tramite = $this->tramites_model->get_by_id($_POST['id']);

                if (!$tramite->fecha_retiro) {
                    $data->fecha_retiro = date('Y-m-d', time());
                    $info = new stdClass();
                    $info->cliente = $cliente;
                    $info->tramite = $data;
                    $info->tramite->id = $_POST['id'];

                    $this->email_model->final_email_model('Aviso de trámite retirado', $info, 'tramite_retirado');
                }
            }

            if ($flag) {
                $data->fecha_actualizacion = date('Y-m-d', time());
                $update = $this->tramites_model->update($_POST['id'], json_encode($data));

                if ($update) {

                    $return = array('status' => 1, 'msg' => 'El tramite fue actualizado con éxito', 'data' => $data);
                } else {
                    $return = array('status' => 0, 'msg' => 'Hubo un problema en la actualización del tramite');
                }
            }

            echo json_encode($return);
        }
    }

    public function delete() {

        if (isset($_POST['ids'])) {

            $ids = explode(',', $_POST['ids']);
            $delete = $this->tramites_model->delete($ids);

            if ($delete === sizeof($ids)) {
                if ($delete > 1) {
                    $msg = 'Los tramites fueron eliminados con éxito';
                } else {
                    $msg = 'el tramite fue eliminado con éxito';
                }
                $return = array('status' => 1, 'msg' => $msg);
            } else {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en el borrado del/los tramite(es)');
            }

            echo json_encode($return);
        }
    }

    public function generar_impresion($id_cliente, $tramite) {

        $data = array();
        $data['cliente'] = $this->clientes_model->get_by_id($id_cliente);


        $data['tramites'] = $this->tramites_model->get_by_custom($custom);

        $data['saldo'] = $this->cta_cte_model->get_saldo($data['cliente']->id);

        $ajax_response = $this->load->view('templates/constancias/retiro', $data, TRUE);

        $name = 'tramite_' . time() . '.html';
        $root = $this->config->item('save_file_folder') . $name;
        $url = base_url() . $this->config->item('save_file_root') . $name;
        $create_file = file_put_contents($root, $ajax_response);

        if ($create_file) {
            return $url;
        } else {
            return false;
        }
    }

    public function batch_insert() {
        $delete = $this->tramites_model->batch_insert();
    }

}
