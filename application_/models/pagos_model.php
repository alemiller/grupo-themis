<?php

class Pagos_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function list_pagos() {

        $this->db->select('*');
        $this->db->from('pagos');
        $this->db->join('clases_pago', 'pagos.tipo = clases_pago.id');
        $this->db->order_by("fecha_creacion", "desc");
        $query = $this->db->get();

        return $query->result();
    }

    public function get_by_id($id) {

        $this->db->select('pagos.id,pagos.tipo,pagos.valor,pagos.fecha_creacion,cp.title,cp.label');
        $this->db->from('pagos');
        $this->db->join('clases_pago as cp', 'pagos.tipo = cp.id');
        $this->db->where('pagos.id', $id);
        $query = $this->db->get();

        return $query->result()[0];
    }

    public function get_by_cliente_id($id) {

        $this->db->select('pagos.id,pagos.tipo,pagos.valor,pagos.fecha_creacion,cp.title,cp.label');
        $this->db->from('pagos');
        $this->db->join('clases_pago as cp', 'pagos.tipo = cp.id');
        $this->db->where('pagos.id_cliente', $id);
        $this->db->order_by("fecha_creacion", "desc");
        $query = $this->db->get();

        return $query->result();
    }

    public function create($data) {

        $data_obj = json_decode($data);

        foreach ($data_obj as $key => $value) {
            $this->db->set($key, $value);
        }

        $this->db->insert('pagos');
        $result = $this->db->affected_rows();

        if ($result) {

            $id = $this->db->insert_id();

            $this->db->select('pagos.id,pagos.id_cliente,pagos.tipo,pagos.valor,pagos.fecha_creacion,cp.title,cp.label');
            $this->db->from('pagos');
            $this->db->join('clases_pago as cp', 'pagos.tipo = cp.id');
            $this->db->where('pagos.id', $id);
            $query = $this->db->get();

            $result = $query->result()[0];
        }


        return $result;
    }

    public function update($id, $data) {

        $data_obj = json_decode($data);

        foreach ($data_obj as $key => $value) {
            $this->db->set($key, $value);
        }

        $this->db->where('id', $id);
        $this->db->update('pagos');
        $result = $this->db->affected_rows();

        return $result;
    }

    public function delete($ids) {

        $this->db->or_where_in('id', $ids);
        $this->db->delete('pagos');

        return $this->db->affected_rows();
    }

}
