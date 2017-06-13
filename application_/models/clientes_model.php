<?php

class Clientes_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function list_clientes() {
        $this->db->select('id,nombre,fecha_ingreso');
        $this->db->order_by("nombre", "asc");
        $query = $this->db->get('clientes');
        
        return $query->result();
    }

    public function get_by_id($id) {

        $this->db->select('*');
        $this->db->from('clientes');
        $this->db->where('clientes.id', $id);
        $query = $this->db->get();

        return $query->result()[0];
    }

    public function create($data) {
        error_log('data insert: ' . $data);

        $data_obj = json_decode($data);

        $this->db->set('nombre', $data_obj->nombre);
        $this->db->set('domicilio', $data_obj->domicilio);
        $this->db->set('telefono', $data_obj->telefono);
        $this->db->set('como_nos_conocio', $data_obj->conocio);
        $this->db->set('email', $data_obj->email);
        $this->db->set('password', $data_obj->password);

        $this->db->insert('clientes');
        $result = $this->db->affected_rows();

        if ($result) {

            $id = $this->db->insert_id();

            $query = $this->db->get_where('clientes', array('id' => $id));

            $result = $query->result();
        }


        return $result;
    }

    public function update($id, $data) {
        error_log('data update: ' . $data);

        $data_obj = json_decode($data);

        $this->db->set('nombre', $data_obj->nombre);
        $this->db->set('domicilio', $data_obj->domicilio);
        $this->db->set('telefono', $data_obj->telefono);
        $this->db->set('como_nos_conocio', $data_obj->conocio);
        $this->db->set('email', $data_obj->email);
        $this->db->set('password', $data_obj->password);

        $this->db->where('id', $id);
        $this->db->update('clientes');
        $result = $this->db->affected_rows();

        return $result;
    }

    public function insert_users() {
        ini_set("auto_detect_line_endings", true);

        try {
            $file = fopen(APPPATH . '/models/users_new.csv', 'r');
            $result = array();
            $i = 0;


            $delimiter = $this->findDelimiter($file);
            setlocale(LC_CTYPE, "UTF-8");
            while (($result[$i] = fgetcsv($file, 0, $delimiter)) !== false) {
                $i++;
            }

            fclose($file);
        } catch (Exception $e) {
            throw new Exception('Cannot open the file');
        }
        array_pop($result);

        for ($i = 0; $i < sizeof($result); $i++) {

            $name = strtolower($result[$i][1]) . ' ' . strtolower($result[$i][2]);
            error_log(ucwords($name));

            $data = array(
                'id' => $result[$i][0],
                'nombre' => ucwords($name)
            );

            $this->db->insert('clientes', $data);
        }
    }

    function findDelimiter($file) {

        $delimiter = '';
        $line = fgets($file);

        $comma_array = explode(',', $line);
        $semmicolon_array = explode(';', $line);

        if (sizeof($comma_array) > sizeof($semmicolon_array)) {
            $delimiter = ',';
        } else {
            $delimiter = ';';
        }

        return $delimiter;
    }

}
