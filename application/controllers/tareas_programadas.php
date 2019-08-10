<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require 'vendor/autoload.php';

//require 'vendor/picqer/phpmailer/php-barcode-generator/src/BarcodeGeneratorPNG.php';

class Tareas_programadas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('tareas_programadas_model');
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

        $data = array('tramites'=>array());

        $fecha_aviso = date('Y-m-d H:i:s', mktime(0, 0, 0, date('m') - 1, date('d'), date('Y')));

        $custom = 'DATE(t.fecha_aviso) = DATE("' . $fecha_aviso . '") AND estado = "listo"';

        $tramites = $this->tareas_programadas_model->get_tramites_by_custom($custom);
        error_log('tramites: '.json_encode($tramites));
        foreach ($tramites as $key => $value) {
//            error_log('value: '.json_encode($value));
            $cliente = new stdClass();
            $cliente->id = $key;
            $cliente->nombre = $value[0]->cliente;
            $cliente->email = $value[0]->email;

            $info = new stdClass();
            $info->cliente = $cliente;
            $info->tramites = $value;

            $this->final_email_model->send_email('Recordatorio de Trámite(s) listo(s)', $info, 'recordatorio_tramite_listo');
        
            array_push($data['tramites'], $info);
        }

//        error_log('tramites: ' . json_encode($data['tramites']));
//        $data['subzonas'] = $this->subzonas_model->list_subzonas();
//        $data['corresponsales'] = $this->corresponsales_model->list_corresponsales();
//        $data['clases_tramite'] = $this->clases_tramite_model->list_clases();

        $this->load->view('pages/tareas_programadas', $data);
    }
    
    public function aviso_tramite_vencido(){
        
        $data = array();
        $fecha_aviso = date('Y-m-d H:i:s', mktime(0, 0, 0, date('m') - 1, date('d'), date('Y')));

        $custom = 'DATE(t.fecha_aviso) = DATE("' . $fecha_aviso . '") AND estado = "listo"';

        $tramites = $this->tareas_programadas_model->get_tramites_by_custom($custom);

        foreach ($tramites as $key => $value) {
            
            $saldo = $this->cta_cte_model->get_saldo($key);
            $cliente = new stdClass();
            $cliente->nombre = $value[0]->cliente;
            $cliente->email = $value[0]->email;

            $info = new stdClass();
            $info->cliente = $cliente;
            $info->tramites = $value;
            $info->saldo = $saldo;

            $info->send_email = $this->final_email_model->send_email('Recordatorio de Trámite(s) listo(s)', $info, 'recordatorio_tramite_listo');
        
            array_push($data, $info);
        }
        
        return $data;
    }

}
