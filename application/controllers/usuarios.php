<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuarios extends CI_Controller {

    var $user = '';

    public function __construct() {
        parent::__construct();
        $this->load->model('usuarios_model');
        $this->load->model('subzonas_model');
        $this->load->helper('url');
        $this->load->helper('file');
        session_start();

        $this->user = $_SESSION['user'];
    }

    public function index() {

        $data = array();
        $data["usuarios"] = $this->usuarios_model->list_usuarios();
        $data["subzonas"] = $this->subzonas_model->list_subzonas();

        $this->load->view('pages/usuarios', $data);
    }

    public function get_by_id() {

        $id = $_POST['id'];
        $usuario = $this->usuarios_model->get_by_id($id);
        
        if($usuario->id === $this->user->id || $usuario->type === 'admin'){
            $usuario->confirm_password = $usuario->password;
        }

        echo json_encode($usuario);
    }

    public function create() {

        if ($this->user->type = 'superadmin') {

            if (isset($_POST['data'])) {

                $create = $this->usuarios_model->create($_POST['data']);

                if ($create) {
                    $return = array('status' => 1, 'msg' => 'El usuario fue creado con éxito', 'data' => $create[0]);
                } else {
                    $return = array('status' => 0, 'msg' => 'Hubo un problema en la creación del usuario');
                }
            } else {
                $return = array('status' => 0, 'msg' => 'Hubo un error interno. Comuníquese con el administrador');
            }
        } else {
            $return = array('status' => 0, 'msg' => 'No tiene permisos para realizar esta operación');
        }
        echo json_encode($return);
    }

    public function update() {

        if (isset($_POST['data']) && isset($_POST['id'])) {

            $update = $this->usuarios_model->update($_POST['id'], $_POST['data']);

            if ($update->error) {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en la actualización del usuario');
            } else {
                $return = array('status' => 1, 'msg' => 'El usuario fue actualizado con éxito');
                
            }


            echo json_encode($return);
        }
    }

    public function delete() {

        if (isset($_POST['ids'])) {

            $ids = explode(',', $_POST['ids']);
            $delete = $this->usuarios_model->delete($ids);

            if ($delete === sizeof($ids)) {
                if ($delete > 1) {
                    $msg = 'Los usuarios fueron eliminados con éxito';
                } else {
                    $msg = 'el usuario fue eliminado con éxito';
                }
                $return = array('status' => 1, 'msg' => $msg);
            } else {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en el borrado del/los usuario(es)');
            }

            echo json_encode($return);
        }
    }

    public function batch_insert() {
        $delete = $this->usuarios_model->batch_insert();
    }

}
