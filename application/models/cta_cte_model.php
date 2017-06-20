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

        $transacciones = $query->result();
        
        $this->db->select('id,fecha_ingreso,saldo_inicial');
        $this->db->from('clientes');
        $this->db->where('clientes.id', $id);
        $query_saldo = $this->db->get();

        $cliente = $query_saldo->result()[0];

        $item = new stdClass();
        $item->id = $cliente->id;
        $item->fecha_creacion = $cliente->fecha_ingreso;
        $item->titulo = 'Saldo Inicial';
        $item->tipo = 'Cliente';
        $item->total = $cliente->saldo_inicial;
        
        array_push($transacciones, $item);
        
        return $transacciones;
    }

    public function get_saldo($id) {

        $query = $this->db->query("select * from (select sum(honorarios)+sum(sellado)+sum(honorario_corresponsal) total_tramites "
                . "FROM tramites "
                . "WHERE id_cliente = " . $id . ") t  "
                . "JOIN (select sum(valor) total_pagos "
                . "FROM pagos "
                . "WHERE id_cliente = " . $id . ") e");

        $result = $query->result();

        $this->db->select('saldo_inicial');
        $this->db->from('clientes');
        $this->db->where('clientes.id', $id);
        $query_saldo = $this->db->get();

        $saldo_in = $query_saldo->result()[0]->saldo_inicial;

        if ($saldo_in) {
            $saldo_inicial = $saldo_in;
        } else {
            $saldo_inicial = 0;
        }

        $saldo = $result[0]->total_tramites + $result[0]->total_pagos + $saldo_inicial;

        return $saldo;
    }

}
