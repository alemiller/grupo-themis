<?php

class Cta_cte_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_transacciones($id) {

        $query = $this->db->query("SELECT * FROM ( (SELECT t.id,fecha_creacion,caratula as titulo,NULL as tipo,(SUM(honorarios)+SUM(sellado)+SUM(honorario_corresponsal)) AS total "
                . "FROM tramites as t "
                . "WHERE id_cliente = " . $id . " "
                . "GROUP BY t.id) "
                . "UNION ALL "
                . "(SELECT p.id,p.fecha_creacion,cp.title as titulo,cp.label as tipo,p.valor as total "
                . "FROM pagos as p "
                . "LEFT JOIN clases_pago as cp ON cp.id = p.tipo "
                . "WHERE id_cliente = " . $id . " ) ) results ORDER BY fecha_creacion DESC");

        return $query->result();
    }

    public function get_saldo($id) {
        
        $query = $this->db->query("select * from (select sum(honorarios)+sum(sellado)+sum(honorario_corresponsal) total_tramites "
                . "FROM tramites "
                . "WHERE id_cliente = ".$id.") t  "
                . "JOIN (select sum(valor) total_pagos "
                . "FROM pagos "
                . "WHERE id_cliente = ".$id.") e");

        $result =  $query->result();
        
        $saldo = $result[0]->total_tramites + $result[0]->total_pagos;
        
        return $saldo;
        
    }

   

}
