<?php

class Ordenes_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function list_ordenes($cliente_id) {

        $this->db->select('*');
        $this->db->from('ordenes_trabajo');
        $this->db->where('id_cliente', $cliente_id);
        $this->db->order_by("fecha_creacion", "desc");
        $query = $this->db->get();

        return $query->result();
    }

    public function get_by_id($id) {

        $result =  new stdClass();
        
        $this->db->select('*');
        $this->db->from('ordenes_trabajo');
        $this->db->where('id', $id);

        $orden = $this->db->get();
        $result->orden = $orden->result()[0];
        
        $this->db->select('tramites.id,tramites.fecha_creacion,tramites.caratula,tramites.honorarios,tramites.sellado,'
                . 'tramites.honorario_corresponsal,tramites.estado,clases_tramite.nombre');
        $this->db->from('tramites');
        $this->db->join('clases_tramite', 'tramites.id_clase = clases_tramite.id');
        $this->db->where('id_orden_trabajo', $id);

        $tramites = $this->db->get();
        $result->tramites = $tramites->result();

        return $result;
    }

    public function create($data) {

        foreach ($data as $key => $value) {
            $this->db->set($key, $value);
        }

        $this->db->insert('ordenes_trabajo');
        $result = $this->db->affected_rows();

        if ($result) {

            $id = $this->db->insert_id();

            $query = $this->db->get_where('ordenes_trabajo', array('id' => $id));

            $result = $query->result();
        }


        return $result;
    }

    public function update($id, $data) {

        $data_obj = json_decode($data);

        foreach ($data_obj as $key => $value) {
            $this->db->set($key, $value);
        }

        $this->db->where('id', $id);
        $this->db->update('ordenes_trabajo');
        $result = $this->db->affected_rows();

        return $result;
    }

    public function delete($ids) {

        $this->db->or_where_in('id', $ids);
        $this->db->delete('ordenes_trabajo');

        return $this->db->affected_rows();
    }

}
