<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//require 'vendor/autoload.php';
//require 'vendor/picqer/phpmailer/php-barcode-generator/src/BarcodeGeneratorPNG.php';

class Tramites extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('tramites_model');
        $this->load->model('clientes_model');
        $this->load->model('cta_cte_model');
        $this->load->model('clases_tramite_model');
        $this->load->model('subzonas_model');
        $this->load->model('corresponsales_model');
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

        $data['subzonas'] = $this->subzonas_model->list_subzonas();
        $data['corresponsales'] = $this->corresponsales_model->list_corresponsales();
        $data['clases_tramite'] = $this->clases_tramite_model->list_clases();

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
            $data->id = $_POST['id'];
            $flag = true;
            $url = null;

            $tramite = $this->tramites_model->get_by_id($_POST['id']);

            if ($data->estado === 'listo') {

                //Si ya tiene fecha de aviso no la actualiza
                if (!isset($tramite->fecha_aviso) || (isset($tramite->fecha_aviso) && !$tramite->fecha_aviso)) {
                    $data->fecha_aviso = date('Y-m-d', time());
                }

                //Actualiza en este momento para enviar datos actualizados en el email
                $data->fecha_actualizacion = date('Y-m-d', time());
                $update = $this->tramites_model->update($_POST['id'], json_encode($data));

                if (!$update->error) {

                    $return = array('status' => 1, 'msg' => 'El tramite fue actualizado con éxito', 'data' => $data);

                    //Si ya tiene fecha de aviso no manda el email
                    if (!isset($tramite->fecha_aviso) || (isset($tramite->fecha_aviso) && !$tramite->fecha_aviso)) {

                        $cliente = $this->clientes_model->get_by_id($_POST['id_cliente']);

                        if ($cliente->email === '') {
                            $return = array('status' => 0, 'msg' => 'Complete el campo "Email" en la solapa Datos Personales');
                            $flag = false;
                        } else {

                            $info = new stdClass();
                            $info->cliente = $cliente;
                            $info->tramites = array($data);

                            $this->final_email_model->send_email('Aviso de trámite finalizado', $info, 'tramite_listo');
         
                        }
                    }
                } else {
                    $return = array('status' => 0, 'msg' => 'Hubo un problema en la actualización del tramite');
                }
            } else if ($data->estado === 'retirado') {

                //Si ya tiene fecha de retiro no la actualiza
                if (!isset($tramite->fecha_retiro) || (isset($tramite->fecha_retiro) && !$tramite->fecha_retiro)) {
                    $data->fecha_retiro = date('Y-m-d', time());
                }

                //Actualiza en este momento para enviar datos actualizados en el email
                $data->fecha_actualizacion = date('Y-m-d', time());
                $update = $this->tramites_model->update($_POST['id'], json_encode($data));

                if (!$update->error) {

                    //Si ya tiene fecha de retiro no manda el email ni imprime el comprobante
                    if (!isset($tramite->fecha_retiro) || (isset($tramite->fecha_retiro) && !$tramite->fecha_retiro)) {

                        $cliente = $this->clientes_model->get_by_id($_POST['id_cliente']);

                        if ($cliente->email === '') {
                            $return = array('status' => 0, 'msg' => 'Complete el campo "Email" en la solapa Datos Personales');
                            $flag = false;
                        } else {

                            $saldo = $this->cta_cte_model->get_saldo($_POST['id_cliente']);

                            $info = new stdClass();
                            $info->cliente = $cliente;
                            $info->tramites = array($data);
                            $info->saldo = $saldo;

                            $url = $this->generar_impresion($info);

                            if ($url) {

                                $this->final_email_model->send_email('Aviso de trámites retirados', $info, 'tramite_retirado');
                                $return = array('status' => 1, 'msg' => 'El trámite se actualizó con éxito', 'url' => $url, 'data'=> $data);
                            } else {

                                $flag = false;
                                $return = array('status' => 0, 'msg' => 'Hay un inconveniente para imprimir la Orden','data'=> $update);
                            }
                        }
                    }
                } else {
                    $return = array('status' => 0, 'msg' => 'Hubo un problema en la actualización del tramite');
                }
            }
        } else {
            $return = array('status' => 0, 'msg' => 'Error interno. Comuníquese con el administrador.');
        }
        echo json_encode($return);
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

    public function cambiar_estado() {

        $cliente = $this->clientes_model->get_by_id($_POST['id_cliente']);
        $tramites_ids = explode(',', $_POST['tramites']);

        switch ($_POST['estado']) {

            case 'listo':

                if ($cliente->email === '') {
                    $return = array('status' => 0, 'msg' => 'Complete el campo "Email" en la solapa Datos Personales');
                } else {

                    $new_tramites = array();

                    for ($i = 0; $i < sizeof($tramites_ids); $i++) {

                        $item = array();
                        $item['id'] = intval($tramites_ids[$i]);
                        $item['estado'] = $_POST['estado'];
                        $item['fecha_aviso'] = date('Y-m-d', time());
                        array_push($new_tramites, $item);
                    }

                    //Actualiza todos los tramites con el nuevo estado
                    $update_tramites = $this->tramites_model->update_batch($new_tramites, 'id');

                    if (!$update_tramites->error && sizeof($tramites_ids) === $update_tramites->affected_rows) {

                        $tramites = $this->tramites_model->get_by_multiple_ids($tramites_ids);

                        $info = new stdClass();
                        $info->cliente = $cliente;
                        $info->tramites = $tramites;

                        $email = $this->final_email_model->send_email('Aviso de trámite finalizado', $info, 'tramite_listo');

                        if ($email) {
                            $return = array('status' => 1, 'msg' => 'Los tramites fueron actualizados con éxito', 'data' => $tramites);
                        } else {
                            $return = array('status' => 0, 'msg' => 'Hubo un problema en la actualización de los trámites');
                        }
                    } else {
                        $return = array('status' => 0, 'msg' => 'Hubo un problema en la actualización de los trámites');
                    }
                }


                break;

            case 'retirado':

                if ($cliente->email === '') {
                    $return = array('status' => 0, 'msg' => 'Complete el campo "Email" en la solapa Datos Personales');
                } else {

                    $saldo = $this->cta_cte_model->get_saldo($_POST['id_cliente']);

                    $new_tramites = array();

                    for ($i = 0; $i < sizeof($tramites_ids); $i++) {

                        $item = array();
                        $item['id'] = intval($tramites_ids[$i]);
                        $item['estado'] = $_POST['estado'];
                        $item['fecha_retiro'] = date('Y-m-d H:i:s', time());
                        array_push($new_tramites, $item);
                    }

                    //Actualiza todos los tramites con el nuevo estado
                    $update_tramites = $this->tramites_model->update_batch($new_tramites, 'id');

                    if (!$update_tramites->error && sizeof($tramites_ids) === $update_tramites->affected_rows) {

                        $tramites = $this->tramites_model->get_by_multiple_ids($tramites_ids);

                        $info = new stdClass();
                        $info->cliente = $cliente;
                        $info->tramites = $tramites;
                        $info->saldo = $saldo;

                        $url = $this->generar_impresion($info);

                        if ($url) {

                            $email = $this->final_email_model->send_email('Aviso de trámites retirados', $info, 'tramite_retirado');

                            if ($email) {
                                $return = array('status' => 1, 'msg' => 'Los tramites fueron actualizados con éxito', 'data' => $tramites, 'url' => $url);
                            } else {
                                $return = array('status' => 0, 'msg' => 'Hay un inconveniente para enviar los emails');
                            }
                        } else {

                            $return = array('status' => 0, 'msg' => 'Hay un inconveniente para imprimir');
                        }
                    } else {
                        $return = array('status' => 0, 'msg' => 'Hay un inconveniente para actualizar los trámites');
                    }
                }
                break;
        }

        echo json_encode($return);
    }

    public function reimprimir() {

        $cliente = $this->clientes_model->get_by_id($_POST['id_cliente']);
        $tramites_ids = explode(',', $_POST['tramites']);

        switch ($_POST['constancia']) {

            case 'retiro':

                $saldo = $this->cta_cte_model->get_saldo($_POST['id_cliente']);
                $tramites = $this->tramites_model->get_by_multiple_ids($tramites_ids);

                $flag = true;
                for ($i = 0; $i < sizeof($tramites); $i++) {
                    if (!isset($tramites[$i]->fecha_retiro) ||
                            (isset($tramites[$i]->fecha_retiro) && !$tramites[$i]->fecha_retiro)) {

                        $flag = false;
                        $id_error = $tramites[$i]->id;
                        break;
                    }
                }

                if ($flag) {

                    $info = new stdClass();
                    $info->cliente = $cliente;
                    $info->tramites = $tramites;
                    $info->saldo = $saldo;

                    $url = $this->generar_impresion($info);

                    if ($url) {

                        $return = array('status' => 1, 'msg' => '', 'url' => $url);
                    } else {

                        $return = array('status' => 0, 'msg' => 'Hay un inconveniente para imprimir');
                    }
                } else {
                    $return = array('status' => 0, 'msg' => 'El trámite Nro. ' . $id_error . ' no ha sido retirado.');
                }

                break;
        }

        echo json_encode($return);
    }

    public function reenviar_email() {

        $cliente = $this->clientes_model->get_by_id($_POST['id_cliente']);

        if ($cliente->email === '') {
            $return = array('status' => 0, 'msg' => 'Complete el campo "Email" en la solapa Datos Personales');
        } else {

            $tramites_ids = explode(',', $_POST['tramites']);
            $tramites = $this->tramites_model->get_by_multiple_ids($tramites_ids);

            $info = new stdClass();
            $info->cliente = $cliente;
            $info->tramites = $tramites;

            if (sizeof($tramites) > 1) {
                $msg = 'Los emails fueron enviados con éxito';
            } else {
                $msg = 'El trámite fue enviado con éxito';
            }

            switch ($_POST['email']) {

                case 'listo':

                    $flag = true;
                    for ($i = 0; $i < sizeof($tramites); $i++) {
                        if (!isset($tramites[$i]->fecha_aviso) ||
                                (isset($tramites[$i]->fecha_aviso) && !$tramites[$i]->fecha_aviso)) {

                            $flag = false;
                            $id_error = $tramites[$i]->id;
                            break;
                        }
                    }

                    if ($flag) {

                        $email = $this->final_email_model->send_email('Aviso de trámite finalizado', $info, 'tramite_listo');

                        if ($email) {
                            $return = array('status' => 1, 'msg' => $msg, 'data' => $tramites);
                        } else {
                            $return = array('status' => 0, 'msg' => 'Hubo un problema en el envío de email(s)');
                        }
                    } else {
                        $return = array('status' => 0, 'msg' => 'El trámite Nro. ' . $id_error . ' no ha finalizado.');
                    }

                    break;

                case 'retirado':

                    $flag = true;
                    for ($i = 0; $i < sizeof($tramites); $i++) {
                        if (!isset($tramites[$i]->fecha_retiro) ||
                                (isset($tramites[$i]->fecha_retiro) && !$tramites[$i]->fecha_retiro)) {

                            $flag = false;
                            $id_error = $tramites[$i]->id;
                            break;
                        }
                    }

                    if ($flag) {

                        $saldo = $this->cta_cte_model->get_saldo($_POST['id_cliente']);

                        $info->saldo = $saldo;

                        $email = $this->final_email_model->send_email('Aviso de trámites retirados', $info, 'tramite_retirado');

                        if ($email) {
                            $return = array('status' => 1, 'msg' => $msg);
                        } else {
                            $return = array('status' => 0, 'msg' => 'Hubo un problema en el envío de email(s)');
                        }
                    } else {
                        $return = array('status' => 0, 'msg' => 'El trámite Nro. ' . $id_error . ' no ha sido retirado.');
                    }
                    break;
            }
        }

        echo json_encode($return);
    }

    public function generar_impresion($info) {

        $data = array();
        $data['cliente'] = $info->cliente;
        $data['tramites'] = $info->tramites;
        $data['saldo'] = $info->saldo;

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

    public function imprimir_codebar() {

        $data = array();

        $tramites_ids = explode(',', $_POST['tramites']);
        $data['tramites'] = $this->tramites_model->get_by_multiple_ids($tramites_ids);
        $data['generator'] = new \Picqer\Barcode\BarcodeGeneratorPNG();

        $ajax_response = $this->load->view('templates/tramites/codebar_page', $data, TRUE);
        $this->output->set_output($ajax_response);
    }

    public function search() {

        $data = array();

        if (isset($_POST['criteria'])) {

            $criterios = json_decode($_POST['criteria']);
            $clausulas = array();
            $clausulas_adicionales = null;

            foreach ($criterios as $key => $value) {

                switch ($key) {
                    case 'id':

                        $clausulas["tramites.id"] = $value;

                        break;

                    case 'fecha_creacion':

                        $clausulas["fecha_creacion >"] = $value[0];
                        $clausulas_adicionales["fecha_creacion <"] = $value[1];

                        break;

                    case 'fecha_vencimiento':

                        $clausulas["fecha_vencimiento >"] = $value[0];
                        $clausulas_adicionales["fecha_vencimiento <"] = $value[1];

                        break;

                    case 'fecha_audiencia':

                        $clausulas["fecha_audiencia >"] = $value[0];
                        $clausulas_adicionales["fecha_audiencia <"] = $value[1];

                        break;
                    case 'fecha_aviso':

                        $clausulas["fecha_aviso >"] = $value[0];
                        $clausulas_adicionales["fecha_aviso <"] = $value[1];

                        break;
                    case 'fecha_retiro':

                        $clausulas["fecha_retiro >"] = $value[0];
                        $clausulas_adicionales["fecha_retiro <"] = $value[1];

                        break;

                    default:
                        $clausulas[$key] = $value;
                        break;
                }
            }

            $data['tramites'] = $this->tramites_model->search($clausulas, $clausulas_adicionales);
        }

        $ajax_response = $this->load->view('templates/tramites/search_results', $data, TRUE);
        $this->output->set_output($ajax_response);
    }

    public function batch_insert() {
        $delete = $this->tramites_model->batch_insert();
    }

}
