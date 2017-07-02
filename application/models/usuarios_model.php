<?php

class Usuarios_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function list_usuarios() {

        $this->db->select('*');
        $this->db->order_by("username", "asc");
        $query = $this->db->get('usuarios');

        return $query->result();
    }

    public function get_by_id($id) {

        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->result()[0];
    }

    public function create($data) {

        $data_obj = json_decode($data);

        foreach ($data_obj as $key => $value) {
            $this->db->set($key, $value);
        }

        $this->db->insert('usuarios');
        $result = $this->db->affected_rows();

        if ($result) {

            $id = $this->db->insert_id();

            $query = $this->db->get_where('usuarios', array('id' => $id));

            $result = $query->result();
        }


        return $result;
    }

    public function update($id, $data) {
        
        $result = new stdClass();
        $data_obj = json_decode($data);

        foreach ($data_obj as $key => $value) {
            $this->db->set($key, $value);
        }

        $this->db->where('id', $id);
        $this->db->update('usuarios');

        if($this->db->_error_number() !== 0){
            $result->error = true;
            $result->msg = $this->db->_error_message();
        }else{
            $result->error = false;
        }

        return $result;
    }

    public function delete($ids) {

        $this->db->or_where_in('id', $ids);
        $this->db->delete('usuarios');

        return $this->db->affected_rows();
    }

}
