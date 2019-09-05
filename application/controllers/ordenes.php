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
        $data["ordenes"] = $this->ordenes_model->list_ordenes();
        $data["subzonas"] = $this->subzonas_model->list_subzonas();

        $this->load->view('pages/ordenes', $data);
    }

    public function list_ordenes() {

        if ($_POST['id_cliente']) {

            $data = array();
            $data["ordenes"] = $this->ordenes_model->list_ordenes($_POST['id_cliente']);

            $ajax_response = $this->load->view('templates/cliente/ordenes/lista_ordenes', $data, TRUE);
            $this->output->set_output($ajax_response);
        }
    }

    public function get_by_id() {

        $id = $_POST['id'];
        $data = array();

        $data['orden'] = $this->ordenes_model->get_by_id($id);
        if ($data['orden']->tramites) {
            $ajax_response = $this->load->view('templates/cliente/ordenes/detalle_orden', $data, TRUE);
        } else {
            $ajax_response = null;
        }
        $this->output->set_output($ajax_response);
    }

    public function create() {

        if (isset($_POST['id']) && isset($_POST['order_items'])) {

            $new_order = array("id_cliente" => $_POST['id']);

            $items = json_decode($_POST['order_items']);

            $tramites = $this->tramites_model->get_by_multiple_ids($items);

            //Chequea que ningún trámite ya pertenezca a una orden creada.
            $exists = false;
            $exists_array = array();
            for ($i=0; $i < sizeof($tramites) ; $i++) {
                if($tramites[$i]->id_orden_trabajo){
                    $exists = true;
                    $item = new stdClass();
                    $item->tramite_id = $tramites[$i]->id;
                    $item->orden_id = $tramites[$i]->id_orden_trabajo;
                    array_push($exists_array, $item);
                } 
            }

            //Si ninguno de los tramites está incluido en un orden, crea la orden y actualiza los tramites
            if(!$exists){
                //Crea la orden
                $create = $this->ordenes_model->create($new_order);

                if ($create) {

                    
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

                        $cliente = $this->clientes_model->get_by_id($_POST['id']);

                        $custom = 'id_orden_trabajo = ' . $create[0]->id;
                        $tramites = $this->tramites_model->get_by_custom($custom);

                        $saldo = $this->cta_cte_model->get_saldo($_POST['id']);

                        $info = new stdClass();
                        $info->cliente = $cliente;
                        $info->tramites = $tramites;
                        $info->saldo = $saldo;
                        $info->id_orden = $create[0]->id;

                        $url = $this->generar_impresion($info);

                        if ($url) {

                            $this->final_email_model->send_email('Aviso de orden de trabajo', $info, 'orden_trabajo');

                            $return = array('status' => 1, 'msg' => 'La orden fue creada con éxito', 'url' => $url);
                        } else {
                            $return = array('status' => 0, 'msg' => 'Hay un inconveniente para imprimir la Orden');
                        }
                    } else {
                        $return = array('status' => 0, 'msg' => 'Hubo un problema en la creación de la orden');
                    }
                } else {
                    $return = array('status' => 0, 'msg' => 'Hubo un problema en la creación de la orden');
                }
            }else{
                $return = array('status' => 0, 'msg' => 'Hay ordenes creadas para los algunos trámites', "tramites" => $exists_array);
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

    public function enviar_email() {

        $ids_orden = explode(',', $_POST['order_items']);


        $cliente = $this->clientes_model->get_by_id($_POST['id_cliente']);
        $saldo = $this->cta_cte_model->get_saldo($_POST['id_cliente']);
        $flag = true;

        for ($i = 0; $i < sizeof($ids_orden); $i++) {

            $item = new stdClass();
            
            $item->fecha_creacion = $this->ordenes_model->get_by_id($ids_orden[$i])->orden->fecha_creacion;

            $item->id_orden = $ids_orden[$i];
            $item->cliente = $cliente;
            $item->saldo = $saldo;

            $custom = 'id_orden_trabajo = ' . $ids_orden[$i];
            $item->tramites = $this->tramites_model->get_by_custom($custom);

            $email = $this->final_email_model->send_email('Aviso de orden de trabajo', $item, 'orden_trabajo');

            if (!$email) {
                $flag = false;
                break;
            }
        }

        if (sizeof($ids_orden) > 1) {
            $msg_ok = 'Los emails fueron enviados con éxito';
            $msg_error = 'Hubo un inconveniente al enviar los emails';
        } else {
            $msg_ok = 'El email fue enviado con éxito';
            $msg_error = 'Hubo un inconveniente al enviar el email';
        }

        if ($flag) {

            $return = array('status' => 1, 'msg' => $msg_ok);
        } else {
            $return = array('status' => 0, 'msg' => $msg_error);
        }

        echo json_encode($return);
    }

    public function imprimir() {

        $ids_orden = explode(',', $_POST['order_items']);
        $info = array();

        $cliente = $this->clientes_model->get_by_id($_POST['id_cliente']);
        $saldo = $this->cta_cte_model->get_saldo($_POST['id_cliente']);

        for ($i = 0; $i < sizeof($ids_orden); $i++) {

            $item = new stdClass();

            $item->orden = $this->ordenes_model->get_by_id($ids_orden[$i])->orden;
            $item->cliente = $cliente;
            $item->saldo = $saldo;

            $custom = 'id_orden_trabajo = ' . $ids_orden[$i];
            $item->tramites = $this->tramites_model->get_by_custom($custom);

            array_push($info, $item);
        }
     
        $url = $this->generar_impresiones($info);

        if ($url) {

            $return = array('status' => 1, 'msg' => '', 'url' => $url);
        } else {
            $return = array('status' => 0, 'msg' => 'Hay un inconveniente para imprimir la Orden');
        }

        echo json_encode($return);
    }

    private function generar_impresion($info) {

        $data = array();
        $data['cliente'] = $info->cliente;
        $data['tramites'] = $info->tramites;
        $data['saldo'] = $info->saldo;
        $data['orden_id'] = $info->id_orden;

        $ajax_response = $this->load->view('templates/constancias/orden_trabajo', $data, TRUE);

        $name = 'orden_' . time() . '.html';
        $root = $this->config->item('save_file_folder') . $name;
        $url = base_url() . $this->config->item('save_file_root') . $name;
        $create_file = file_put_contents($root, $ajax_response);

        if ($create_file) {
            return $url;
        } else {
            return false;
        }
    }

    private function generar_impresiones($info) {

        $data = array();
        $data['ordenes'] = $info;

        $ajax_response = $this->load->view('templates/constancias/ordenes_trabajo', $data, TRUE);

        $name = 'orden_' . time() . '.html';
        $root = $this->config->item('save_file_folder') . $name;
        $url = base_url() . $this->config->item('save_file_root') . $name;
        $create_file = file_put_contents($root, $ajax_response);

        if ($create_file) {
            return $url;
        } else {
            return false;
        }
    }

}
