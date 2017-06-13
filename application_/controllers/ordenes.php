<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ordenes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ordenes_model');
        $this->load->model('clientes_model');
        $this->load->model('tramites_model');
        $this->load->model('cta_cte_model');
        $this->load->model('email_model');
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->library('session');
    }

    public function index() {

        $data = array();
        $data["ordenes"] = $this->ordenes_model->list_ordenes();
        $data["subzonas"] = $this->subzonas_model->list_subzonas();

        $this->load->view('pages/ordenes', $data);
    }

    public function get_by_id() {

        $id = $_POST['id'];
        $cliente = $this->ordenes_model->get_by_id($id);

        echo json_encode($cliente);
    }

    public function create() {

        if (isset($_POST['id']) && isset($_POST['order_items'])) {

            $new_order = array("id_cliente" => $_POST['id']);

            //Crea la orden
            $create = $this->ordenes_model->create($new_order);

            if ($create) {

                $items = json_decode($_POST['order_items']);
                $order_items = array();

                for ($i = 0; $i < sizeof($items); $i++) {

                    $item = array();
                    $item['id'] = intval($items[$i]);
                    $item['id_orden_trabajo'] = intval($create[0]->id);
                    array_push($order_items, $item);
                }

                //Actualiza todos los tramites con el ID de la orden creada
                $update_tramites = $this->tramites_model->update_batch($order_items, 'id');

                if ($update_tramites) {
                    $return = $this->generar_impresion($_POST['id'], intval($create[0]->id));
                } else {
                    $return = array('status' => 0, 'msg' => 'Hubo un problema en la creación de la orden');
                }
            } else {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en la creación de la orden');
            }


            echo json_encode($return);
        }
    }

    public function update() {

        if (isset($_POST['data']) && isset($_POST['id'])) {

            $update = $this->ordenes_model->update($_POST['id'], $_POST['data']);

            if ($update) {
                $return = array('status' => 1, 'msg' => 'La orden fue actualizada con éxito');
            } else {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en la actualización de la orden');
            }


            echo json_encode($return);
        }
    }

    public function delete() {

        if (isset($_POST['ids'])) {

            $ids = explode(',', $_POST['ids']);
            $delete = $this->ordenes_model->delete($ids);

            if ($delete === sizeof($ids)) {
                if ($delete > 1) {
                    $msg = 'Los ordenes fueron eliminadas con éxito';
                } else {
                    $msg = 'La orden fue eliminada con éxito';
                }
                $return = array('status' => 1, 'msg' => $msg);
            } else {
                $return = array('status' => 0, 'msg' => 'Hubo un problema en el borrado de la/las orden(es)');
            }

            echo json_encode($return);
        }
    }

    public function generar_impresion($id_cliente, $id_orden) {

        $data = array();
        $data['cliente'] = $this->clientes_model->get_by_id($id_cliente);

        $custom = 'id_orden_trabajo = ' . $id_orden;
        $data['tramites'] = $this->tramites_model->get_by_custom($custom);

        $data['saldo'] = $this->cta_cte_model->get_saldo($data['cliente']->id);

        $ajax_response = $this->load->view('templates/constancias/orden_trabajo', $data, TRUE);

        $name = 'orden_' . time() . '.html';
        $root = './uploads/' . $name;
        $url = base_url() . 'uploads/' . $name;
        $create_file = file_put_contents($root, $ajax_response);

        if ($create_file) {

            $info = new stdClass();
            $info->cliente = $data['cliente'];
            $info->tramites = $data['tramites'];
            $info->saldo = $data['saldo'];
            $info->id_orden = $id_orden;

            $this->email_model->send_email('Aviso de orden de trabajo', $info, 'orden_trabajo');

            $return = array('status' => 1, 'msg' => 'La orden fue actualizada con éxito', 'url' => $url);
        } else {
            $return = array('status' => 0, 'msg' => 'Hubo un problema en la creación de la orden');
        }

        return $return;
    }

}
