<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Clases_tramite extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('clases_tramite_model');
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->library('session');
    }

    public function index() {

        $data = array();
        $data["clases"] = $this->clases_tramite_model->list_clases();

        $this->load->view('pages/clases_tramite', $data);
    }


    public function get_by_id() {

        $id = $_POST['id'];
        $cliente = $this->clases_tramite_model->get_by_id($id);

        echo json_encode($cliente);
    }

    public function create() {

        if (isset($_POST['data'])) {

            $create = $this->clases_tramite_model->create($_POST['data']);

            if ($create) {
                $return = array('status' => 1, 'msg' => 'La clase fue creada con éxito', 'data' => $create[0]);
            } else {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en la creación de la clase');
            }


            echo json_encode($return);
        }
    }

    public function update() {

        if (isset($_POST['data']) && isset($_POST['id'])) {

            $update = $this->clases_tramite_model->update($_POST['id'], $_POST['data']);

            if ($update->error) {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en la actualización de la clase');
            } else {
                $return = array('status' => 1, 'msg' => 'La clase fue actualizada con éxito');
                
            }


            echo json_encode($return);
        }
    }

    public function delete() {

        if (isset($_POST['ids'])) {
            
            $ids = explode(',', $_POST['ids']);
            $delete = $this->clases_tramite_model->delete($ids);
          
            if ($delete === sizeof($ids)) {
                if($delete > 1){
                    $msg = 'Las clases fueron eliminadas con éxito';
                }else{
                    $msg = 'La clase fue eliminada con éxito';
                }
                $return = array('status' => 1, 'msg' => $msg);
            } else {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en el borrado de la(s) clase(s)');
            }

            echo json_encode($return);
        }
    }
    
     public function batch_insert(){
        $delete = $this->clases_tramite_model->batch_insert();
    }

}
