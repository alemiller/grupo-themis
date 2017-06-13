<?php

class Email_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('email');
    }

    public function send_email($title, $data, $view) {
        error_log('llego a send email');
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from('info@grupo-themis.com.ar', 'Grupo-Themis');
        $this->email->to($data->cliente->email);
        $this->email->subject($title);

        $message = $this->load->view('templates/emails/' . $view, $data, TRUE);
        $this->email->message($message);

        $send =$this->email->send();
        error_log('result send email: '.json_encode($send));
    }

}
