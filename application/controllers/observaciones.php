<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Observaciones extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('observaciones_model');
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->library('session');
    }

    public function index() {

        $data = array();
        $data["observaciones"] = $this->observaciones_model->list_observaciones();
        

        $this->load->view('pages/observaciones', $data);
    }

    public function get_by_id() {

        $id = $_POST['id'];
        $cliente = $this->observaciones_model->get_by_id($id);

        echo json_encode($cliente);
    }

    public function create() {

        if (isset($_POST['data'])) {

            $create = $this->observaciones_model->create($_POST['data']);

            if ($create) {
                $return = array('status' => 1, 'msg' => 'La observación fue creada con éxito', 'data' => $create[0]);
            } else {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en la creación de la observación');
            }


            echo json_encode($return);
        }
    }

    public function update() {

        if (isset($_POST['data']) && isset($_POST['id'])) {

            $update = $this->observaciones_model->update($_POST['id'], $_POST['data']);

            if ($update->error) {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en la actualización de la observación');
            } else {
                $return = array('status' => 1, 'msg' => 'La observación fue actualizada con éxito');
            }


            echo json_encode($return);
        }
    }

    public function delete() {

        if (isset($_POST['ids'])) {

            $ids = explode(',', $_POST['ids']);
            $delete = $this->observaciones_model->delete($ids);

            if ($delete === sizeof($ids)) {
                if ($delete > 1) {
                    $msg = 'Los observaciones fueron eliminadas con éxito';
                } else {
                    $msg = 'La observación fue eliminada con éxito';
                }
                $return = array('status' => 1, 'msg' => $msg);
            } else {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en el borrado de la/las observación(es)');
            }

            echo json_encode($return);
        }
    }

 

}
