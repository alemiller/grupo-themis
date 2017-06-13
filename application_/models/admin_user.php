<?php

class Admin_user extends CI_Model {

  function __construct() {
    parent::__construct();
    	$this->load->database();
  }


  public function login($user, $password) {
   
    $query = $this->db->get_where('usuarios',array('username' => $user, 'password' => $password));

    if ($query->num_rows() > 0) {

      return 'true';
    } else {

      return 'false';
    }
  }

}

?>