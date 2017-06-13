<?php

class Ordenes_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function list_ordenes() {

        $this->db->select('*');
        $this->db->order_by("nombre", "asc");
        $query = $this->db->get('ordenes_trabajo');

        return $query->result();
    }

    public function get_by_id($id) {

        $this->db->select('*');
        $this->db->from('ordenes_trabajo');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->result()[0];
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
