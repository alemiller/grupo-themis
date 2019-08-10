<?php

class Tramites_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        session_start();
    }

    public function list_tramites() {

        $this->db->select("*");
        $this->db->order_by("fecha_creacion","desc");
        $query = $this->db->get("tramites");

        return $query->result();
    }

    public function get_by_id($id) {

        $this->db->select("t.id,"
                . "t.id_cliente,"
                . "t.id_clase,"
                . "t.id_subzona,"
                . "t.caratula,"
                . "t.observacion_id,"
                . "t.honorarios,"
                . "t.sellado,"
                . "t.estado,"
                . "t.correo,"
                . "t.nro_envio,"
                . "t.fecha_creacion,"
                . "t.fecha_actualizacion,"
                . "t.fecha_vencimiento,"
                . "t.fecha_audiencia,"
                . "t.fecha_retiro,"
                . "t.fecha_aviso,"
                . "t.fecha_envio,"
                . "t.observaciones_cliente,"
                . "t.id_corresponsal,"
                . "t.honorario_corresponsal,"
                . "t.id_orden_trabajo,"
                . "SUM(t.honorarios + t.sellado + t.honorario_corresponsal) as total,"
                . "u.username as creado_por,"
                . "ua.username as actualizado_por,"
                . "o.texto as observacion_texto");
        $this->db->from("tramites t");
        $this->db->join("usuarios u","t.creado_por = u.id");
        $this->db->join("usuarios ua","t.actualizado_por = ua.id","left");
        $this->db->join("observaciones o","t.observacion_id = o.id","left");
        $this->db->where("t.id", $id);
        $query = $this->db->get();

        if (isset($query->result()[0])) {
            $result = $query->result()[0];
        } else {
            $result = new stdClass();
        }

        return $result;
    }

    public function get_by_cliente_id($id) {

        $this->db->select("t.id,"
                . "t.caratula,"
                . "t.estado,"
                . "t.fecha_creacion,"
                . "t.honorarios,"
                . "t.sellado,"
                . "SUM(t.honorarios + t.sellado + t.honorario_corresponsal) AS total,"
                . "u.username as creado_por,"
                . "ua.username as actualizado_por");
        $this->db->from("tramites t");
        $this->db->join("usuarios u","t.creado_por = u.id");
        $this->db->join("usuarios ua","t.actualizado_por = ua.id","left");
        $this->db->where("id_cliente", $id);
        $this->db->order_by("fecha_creacion","desc");
        $this->db->group_by("id");
        $query = $this->db->get();

        return $query->result();
    }

    public function get_by_custom($custom) {

        $this->db->select("t.id,"
                . "t.caratula,"
                . "t.honorarios,"
                . "t.sellado,"
                . "t.honorario_corresponsal,"
                . "clases_tramite.nombre");
        $this->db->from("tramites t");
        $this->db->join("clases_tramite","t.id_clase = clases_tramite.id");
       
        $this->db->where($custom);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_by_multiple_ids($ids) {

        $this->db->select("*");
        $this->db->from("tramites");

        for ($i = 0; $i < sizeof($ids); $i++) {
            if ($i === 0) {
                $this->db->where("id", $ids[$i]);
            } else {
                $this->db->or_where("id ", $ids[$i]);
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

        if (isset($_SESSION["user"]->id)) {
            $this->db->set("creado_por", $_SESSION["user"]->id);
        }

        $this->db->insert("tramites");
        $result = $this->db->affected_rows();

        if ($result) {

            $id = $this->db->insert_id();

            $result = $this->get_by_id($id);
        }


        return $result;
    }

    public function update($id, $data) {

        $result = new stdClass();
        $data_obj = json_decode($data);

        foreach ($data_obj as $key => $value) {
            $this->db->set($key, $value);
        }

        $this->db->set("fecha_actualizacion", date("Y-m-d H:i:s", time()));

        if (isset($_SESSION["user"]->id)) {
            $this->db->set("actualizado_por", $_SESSION["user"]->id);
        }

        $this->db->where("id", $id);
        $this->db->update("tramites");

        if ($this->db->_error_number() !== 0) {
            $result->error = true;
            $result->msg = $this->db->_error_message();
        } else {
            $result->tramite = $this->get_by_id($id);
            $result->error = false;
        }
       
        return $result;
    }

    public function update_batch($data, $field) {

        $result = new stdClass();
        $this->db->update_batch("tramites", $data, $field);

        if ($this->db->_error_number() !== 0) {
            $result->error = true;
            $result->msg = $this->db->_error_message();
        } else {
            $result->error = false;
            $result->affected_rows = $this->db->affected_rows();
        }

        return $result;
    }

    public function delete($ids) {

        $this->db->or_where_in("id", $ids);
        $this->db->delete("tramites");

        return $this->db->affected_rows();
    }

    public function search($clausulas, $adicionales) {

        error_log("clausulas: " . json_encode($clausulas));
        $this->db->select("tramites.id,"
                . "tramites.fecha_creacion,"
                . "caratula,"
                . "estado,"
                . "SUM(tramites.honorarios + tramites.sellado + tramites.honorario_corresponsal) as total,"
                . "clientes.nombre,"
                . "clases_tramite.nombre as clase_tramite,"
                . "clientes.id as id_cliente");
        $this->db->from("tramites");
        $this->db->join("clientes","tramites.id_cliente = clientes.id");
        $this->db->join("clases_tramite","tramites.id_clase = clases_tramite.id");
        $this->db->where($clausulas);
        if ($adicionales) {
            $this->db->where($adicionales);
        }
        $this->db->order_by("tramites.fecha_creacion","desc");
        $this->db->group_by("tramites.id");
        $query = $this->db->get();

        return $query->result();
    }

}
