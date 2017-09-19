<?php

class Tareas_programadas_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_tramites_by_custom($custom) {
        error_log('date: '.$custom);
        $this->db->select(
                't.id,'
                . 't.id_cliente,'
                . 't.id_clase,'
                . 't.id_subzona,'
                . 't.caratula,'
                . 't.observacion_id,'
                . 't.estado,'
                . 't.correo,'
                . 't.nro_envio,'
                . 't.fecha_creacion,'
                . 't.fecha_actualizacion,'
                . 't.fecha_vencimiento,'
                . 't.fecha_audiencia,'
                . 't.fecha_retiro,'
                . 't.fecha_aviso,'
                . 't.fecha_envio,'
                . 't.observaciones_cliente,'
                . 't.id_orden_trabajo,'
                . 't.honorarios + t.sellado + t.honorario_corresponsal as total,'
                . 'c.nombre as cliente,'
                . 'c.email');
        $this->db->from('tramites t');
        $this->db->join('clientes c', 't.id_cliente = c.id','left');
        $this->db->where($custom);
        
        $query = $this->db->get();
        
        $tramites = $query->result();
        error_log('model tramites: '.json_encode($tramites));     
        $tramites_final = array();
        for($i=0;$i<sizeof($tramites);$i++){
            if(array_key_exists($tramites[$i]->id_cliente, $tramites_final)){
                array_push($tramites_final[$tramites[$i]->id_cliente], $tramites[$i]); 
            }else{
                $tramites_final[$tramites[$i]->id_cliente] = array();
                array_push($tramites_final[$tramites[$i]->id_cliente], $tramites[$i]);
            }
        }

        return $tramites_final;
    }

}
