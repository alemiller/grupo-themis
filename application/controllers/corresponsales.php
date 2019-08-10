<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Corresponsales extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('corresponsales_model');
        $this->load->model('subzonas_model');
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->library('session');
    }

    public function index() {

        $data = array();
        $data["corresponsales"] = $this->corresponsales_model->list_corresponsales();
        $data["subzonas"] = $this->subzonas_model->list_subzonas();

        $this->load->view('pages/corresponsales', $data);
    }

    public function get_by_id() {

        $id = $_POST['id'];
        $cliente = $this->corresponsales_model->get_by_id($id);

        echo json_encode($cliente);
    }

    public function create() {

        if (isset($_POST['data'])) {

            $create = $this->corresponsales_model->create($_POST['data']);

            if ($create) {
                $return = array('status' => 1, 'msg' => 'El corresponsal fue creado con éxito', 'data' => $create[0]);
            } else {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en la creación del corresponsal');
            }


            echo json_encode($return);
        }
    }

    public function update() {

        if (isset($_POST['data']) && isset($_POST['id'])) {

            $update = $this->corresponsales_model->update($_POST['id'], $_POST['data']);

            if ($update->error) {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en la actualización del corresponsal');
            } else {
                $return = array('status' => 1, 'msg' => 'El corresponsal fue actualizado con éxito');
            }


            echo json_encode($return);
        }
    }

    public function delete() {

        if (isset($_POST['ids'])) {

            $ids = explode(',', $_POST['ids']);
            $delete = $this->corresponsales_model->delete($ids);

            if ($delete === sizeof($ids)) {
                if ($delete > 1) {
                    $msg = 'Los corresponsales fueron eliminados con éxito';
                } else {
                    $msg = 'el corresponsal fue eliminado con éxito';
                }
                $return = array('status' => 1, 'msg' => $msg);
            } else {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en el borrado del/los corresponsal(es)');
            }

            echo json_encode($return);
        }
    }

    public function batch_insert() {
        $delete = $this->corresponsales_model->batch_insert();
    }

}
