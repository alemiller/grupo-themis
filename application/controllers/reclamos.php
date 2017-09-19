<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reclamos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('reclamos_model');
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->library('session');
    }

    public function get_by_id() {

        $id = $_POST['id'];
        $reclamo = $this->reclamos_model->get_by_id($id);

        echo json_encode($reclamo);
    }

    public function create() {

        if (isset($_POST['data'])) {

            $create = $this->reclamos_model->create($_POST['data']);

            $url = $this->generar_impresion($create[0]);

            if ($create) {
                $return = array('status' => 1, 'msg' => 'El reclamo fue creado con éxito', 'reclamo' => $create[0], 'url' => $url);
            } else {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en la creación del reclamo');
            }


            echo json_encode($return);
        }
    }

    public function update() {

        if (isset($_POST['data']) && isset($_POST['id'])) {

            $update = $this->reclamos_model->update($_POST['id'], $_POST['data']);

            if ($update->error) {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en la actualización del reclamo');
            } else {
                $return = array('status' => 1, 'msg' => 'El reclamo fue actualizado con éxito');
            }


            echo json_encode($return);
        }
    }

    public function delete() {

        if (isset($_POST['id'])) {

            $delete = $this->reclamos_model->delete($_POST['id']);

            if ($delete > 0) {
                $return = array('status' => 1, 'msg' => 'El reclamo fue eliminado con éxito');
            } else {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en el borrado del/los reclamo(es)');
            }

            echo json_encode($return);
        }
    }

    public function generar_impresion($reclamo) {

        $data = array('reclamo' => $reclamo);
        $ajax_response = $this->load->view('templates/constancias/reclamo', $data, TRUE);

        $name = 'relamo_' . time() . '.html';
        $root = $this->config->item('save_file_folder') . $name;
        $url = base_url() . $this->config->item('save_file_root') . $name;
        $create_file = file_put_contents($root, $ajax_response);

        if ($create_file) {
            return $url;
        } else {
            return false;
        }
    }

    public function imprimir() {

        $id = $_POST['id'];
        $reclamo = $this->reclamos_model->get_by_id($id);

        $url = $this->generar_impresion($reclamo);

        if ($url) {
            $return = array('status' => 1, 'url' => $url);
        } else {
            $return = array('status' => 0, 'msg' => 'Hay un problema para imprimir el reclamo');
        }
        
        echo json_encode($return);
    }

}
