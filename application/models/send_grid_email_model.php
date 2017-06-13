<?php

require 'vendor/autoload.php';

class Send_grid_email_model extends CI_Model {

    function __construct() {
        
    }

    public function send_email($title, $data, $view) {

//        $sendgrid = new SendGrid('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');
//        $email = new SendGrid\Email();
//
//        $message = $this->load->view('templates/emails/' . $view, $data, TRUE);
//
//        $email->addTo($data->cliente->email)
//                ->setFrom('info@grupo-themis.com.ar')
//                ->setSubject($title)
//                ->setHtml($message);
//
//        $sendgrid->send($email);

        $message = $this->load->view('templates/emails/' . $view, $data, TRUE);
        $from = new SendGrid\Email(null, 'info@grupo-themis.com.ar');
        ;
        $to = new SendGrid\Email(null, $data->cliente->email);
        $content = new SendGrid\Content("text/html", $message);
        $mail = new SendGrid\Mail($from, $title, $to, $content);

        $apiKey = getenv('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');
        $sg = new \SendGrid($apiKey);

        $response = $sg->client->mail()->send()->post($mail);
        echo $response->statusCode();
    }

}
