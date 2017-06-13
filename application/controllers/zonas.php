<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Zonas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('zonas_model');
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->library('session');
    }

    public function index() {

        $data = array();
        $data["zonas"] = $this->zonas_model->list_zonas();

        $this->load->view('pages/zonas', $data);
    }


    public function get_by_id() {

        $id = $_POST['id'];
        $cliente = $this->zonas_model->get_by_id($id);

        echo json_encode($cliente);
    }

    public function create() {

        if (isset($_POST['data'])) {

            $create = $this->zonas_model->create($_POST['data']);

            if ($create) {
                $return = array('status' => 1, 'msg' => 'La zona fue creada con éxito', 'data' => $create[0]);
            } else {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en la creación de la zona');
            }


            echo json_encode($return);
        }
    }

    public function update() {

        if (isset($_POST['data']) && isset($_POST['id'])) {

            $update = $this->zonas_model->update($_POST['id'], $_POST['data']);

            if ($update) {
                $return = array('status' => 1, 'msg' => 'La zona fue actualizada con éxito');
            } else {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en la actualización de la zona');
            }


            echo json_encode($return);
        }
    }

    public function delete() {

        if (isset($_POST['ids'])) {
            
            $ids = explode(',', $_POST['ids']);
            $delete = $this->zonas_model->delete($ids);
           
            if ($delete === sizeof($ids)) {
                if($delete > 1){
                    $msg = 'Las zonas fueron eliminadas con éxito';
                }else{
                    $msg = 'La zona fue eliminada con éxito';
                }
                $return = array('status' => 1, 'msg' => $msg);
            } else {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en el borrado de la(s) zona(s)');
            }

            echo json_encode($return);
        }
    }
    
    public function batch_insert(){
        $delete = $this->zonas_model->batch_insert();
    }

}
