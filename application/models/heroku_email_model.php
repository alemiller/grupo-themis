<?php

require 'vendor/autoload.php';

use Mailgun\Mailgun;

class Heroku_email_model extends CI_Model {

    public function send_email($title, $data, $view) {


# Instantiate the client.
        $mgClient = new Mailgun('key-729e24b4c8cc8bb3eba2af46bccb57e6');
        $domain = "app69beac19ee3b410d8526c056fda745bd.mailgun.org";
        $message = $this->load->view('templates/emails/' . $view, $data, TRUE);
# Make the call to the client.
        $result = $mgClient->sendMessage($domain, array(
            'from' => 'Grupo-Themis <info@grupo-themis.com.ar>',
            'to' => '<' . $data->cliente->email . '>',
            'subject' => $title,
            'html' => $message
        ));
        
        error_log('send email: '.json_encode($result));
        
        return $result;
    }
}
