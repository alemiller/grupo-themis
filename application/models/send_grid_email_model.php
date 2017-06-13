<?php

require 'vendor/autoload.php';

class Send_grid_email_model extends CI_Model {

    function __construct() {
        
    }

    public function send_email($title, $data, $view) {

        $sendgrid = new SendGrid('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');
        $email = new SendGrid\Email();

        $message = $this->load->view('templates/emails/' . $view, $data, TRUE);

        $email->addTo($data->cliente->email)
                ->setFrom('info@grupo-themis.com.ar')
                ->setSubject($title)
                ->setHtml($message);

        $sendgrid->send($email);
    }

}
