<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Subzonas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('zonas_model');
        $this->load->model('subzonas_model');
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->library('session');
    }

    public function index() {

        $data = array();
        $data["zonas"] = $this->zonas_model->list_zonas();
        $data["subzonas"] = $this->subzonas_model->list_subzonas();
        error_log('subzonas: ' . json_encode($data["subzonas"]));
        $this->load->view('pages/subzonas', $data);
    }

    public function get_by_id() {

        $id = $_POST['id'];
        $cliente = $this->subzonas_model->get_by_id($id);

        echo json_encode($cliente);
    }

    public function create() {

        if (isset($_POST['data'])) {

            $create = $this->subzonas_model->create($_POST['data']);

            if ($create) {
                $return = array('status' => 1, 'msg' => 'La subzona fue creada con éxito', 'data' => $create[0]);
            } else {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en la creación de la subzona');
            }


            echo json_encode($return);
        }
    }

    public function update() {

        if (isset($_POST['data']) && isset($_POST['id'])) {

            $update = $this->subzonas_model->update($_POST['id'], $_POST['data']);

            if ($update) {
                $return = array('status' => 1, 'msg' => 'La subzona fue actualizada con éxito');
            } else {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en la actualización de la subzona');
            }


            echo json_encode($return);
        }
    }

    public function delete() {

        if (isset($_POST['ids'])) {

            $ids = explode(',', $_POST['ids']);
            $delete = $this->subzonas_model->delete($ids);

            if ($delete === sizeof($ids)) {
                if ($delete > 1) {
                    $msg = 'Las subzonas fueron eliminadas con éxito';
                } else {
                    $msg = 'La subzona fue eliminada con éxito';
                }
                $return = array('status' => 1, 'msg' => $msg);
            } else {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en el borrado de la(s) subzona(s)');
            }

            echo json_encode($return);
        }
    }

    public function batch_insert() {
        $delete = $this->subzonas_model->batch_insert();
    }

}
