<?php

class Estadisticas_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function count_tramites() {

        $query = $this->db->query("SELECT estado, count(*) as total FROM tramites GROUP BY estado");

        return $query->result();
    }

    public function ingresos_report($start_date, $end_date) {
       
        $query = $this->db->query('SELECT SUM(valor) as valor, '
                . 'DATE(fecha_creacion) as fecha '
                . 'FROM pagos '
                . 'WHERE DATE(fecha_creacion) >= DATE("'.$start_date.'") AND  '
                . 'DATE(fecha_creacion) <= DATE("'.$end_date.'") GROUP BY DATE(fecha_creacion)');
         
        
        return $query->result();
    }

}