<?php

require 'vendor/autoload.php';
require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

class Heroku_email_model extends CI_Model {

    public function send_email($title, $data, $view) {


        $mail = new PHPMailer;

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.mailgun.org';                     // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'postmaster@app69beac19ee3b410d8526c056fda745bd.mailgun.org';   // SMTP username
        $mail->Password = '765622ae1716c1b96de026165f1116ac';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable encryption, only 'tls' is accepted

        $mail->From = 'info@grupo-themis.com.ar';
        $mail->FromName = 'Grupo-Themis';
        $mail->addAddress($data->cliente->email);                 // Add a recipient

        $mail->WordWrap = 50;                                 // Set word wrap to 50 characters

        $mail->Subject = $title;
        $message = $this->load->view('templates/emails/' . $view, $data, TRUE);
        $mail->Body = $message;
        $mail->IsHTML(true); 

        $result = new stdClass();
        
        if (!$mail->send()) {
            $result->status = 0;
             $result->error = $mail->ErrorInfo;
        } else {
           $result->status = 1;
           $result->error = null;
        }
        error_log('send email result: '.json_encode($result));
        return $result;
    }

}
