<?php

class Tramites_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function list_tramites() {

        $this->db->select('*');
        $this->db->order_by("fecha_creacion", "desc");
        $query = $this->db->get('tramites');

        return $query->result();
    }

    public function get_by_id($id) {

        $this->db->select('*');
        $this->db->from('tramites');
        $this->db->where('id', $id);
        $query = $this->db->get();

        if (isset($query->result()[0])) {
            $result = $query->result()[0];
        } else {
            $result = new stdClass();
        }

        return $result;
    }

    public function get_by_cliente_id($id) {

        $this->db->select('id,caratula,estado,fecha_creacion,(SUM(honorarios)+SUM(sellado)+SUM(honorario_corresponsal)) AS total');
        $this->db->from('tramites');
        $this->db->where('id_cliente', $id);
        $this->db->order_by("fecha_creacion", "desc");
        $this->db->group_by("id");
        $query = $this->db->get();

        return $query->result();
    }

    public function get_by_custom($custom) {

        $this->db->select('tramites.id,tramites.caratula,tramites.honorarios,tramites.sellado,'
                . 'tramites.honorario_corresponsal,clases_tramite.nombre');
        $this->db->from('tramites');
        $this->db->join('clases_tramite', 'tramites.id_clase = clases_tramite.id');
        $this->db->where($custom);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_by_multiple_ids($ids) {

        $this->db->select('*');
        $this->db->from('tramites');

        for ($i = 0; $i < sizeof($ids); $i++) {
            if ($i === 0) {
                $this->db->where('id', $ids[$i]);
            } else {
                $this->db->or_where('id ', $ids[$i]);
            }
        }

        $query = $this->db->get();

        return $query->result();
    }

    public function create($data) {

        $data_obj = json_decode($data);

        foreach ($data_obj as $key => $value) {
            $this->db->set($key, $value);
        }

        $this->db->insert('tramites');
        $result = $this->db->affected_rows();

        if ($result) {

            $id = $this->db->insert_id();


            $query = $this->db->query('SELECT * , (SELECT (SUM(honorarios)+SUM(sellado)+SUM(honorario_corresponsal))    
                            FROM tramites 
                            WHERE id=' . $id . ') as total
                            FROM tramites 
                            WHERE id=' . $id);

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
        $this->db->update('tramites');
        $result = $this->db->affected_rows();

        return $result;
    }

    public function update_batch($data, $field) {

        $this->db->update_batch('tramites', $data, $field);
        $result = $this->db->affected_rows();

        return $result;
    }

    public function delete($ids) {

        $this->db->or_where_in('id', $ids);
        $this->db->delete('tramites');

        return $this->db->affected_rows();
    }

    public function search($clausulas, $adicionales) {
        
        error_log('clausulas: '.json_encode($clausulas));
        $this->db->select('tramites.id,tramites.fecha_creacion,caratula,estado,'
                . '(SUM(honorarios)+SUM(sellado)+SUM(honorario_corresponsal)) AS total,'
                . 'clientes.nombre, clases_tramite.nombre as clase_tramite, clientes.id as id_cliente');
        $this->db->from('tramites');
        $this->db->join('clientes', 'tramites.id_cliente = clientes.id');
        $this->db->join('clases_tramite', 'tramites.id_clase = clases_tramite.id');
        $this->db->where($clausulas);
        if($adicionales){
           $this->db->where($adicionales);  
        }
        $this->db->order_by("tramites.fecha_creacion", "desc");
        $this->db->group_by("tramites.id");
        $query = $this->db->get();

        return $query->result();
    }

}
