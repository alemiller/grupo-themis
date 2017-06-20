<?php

class Corresponsales_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function list_corresponsales() {

        $this->db->select('*');
        $this->db->order_by("nombre", "asc");
        $query = $this->db->get('corresponsales');

        return $query->result();
    }

    public function get_by_id($id) {

        $this->db->select('*');
        $this->db->from('corresponsales');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->result()[0];
    }

    public function create($data) {

        $data_obj = json_decode($data);

        $this->db->set('nombre', $data_obj->nombre);
        $this->db->set('domicilio', $data_obj->domicilio);
        $this->db->set('telefono', $data_obj->telefono);
        $this->db->set('email', $data_obj->email);
        $this->db->set('tomo_folio_colegio', $data_obj->tomo_folio_colegio);
        $this->db->set('observaciones', $data_obj->observaciones);
        $this->db->set('id_subzona', $data_obj->id_subzona);

        $this->db->insert('corresponsales');
        $result = $this->db->affected_rows();

        if ($result) {

            $id = $this->db->insert_id();

            $query = $this->db->get_where('corresponsales', array('id' => $id));

            $result = $query->result();
        }


        return $result;
    }

    public function update($id, $data) {

        $data_obj = json_decode($data);

        $this->db->set('nombre', $data_obj->nombre);
        $this->db->set('domicilio', $data_obj->domicilio);
        $this->db->set('telefono', $data_obj->telefono);
        $this->db->set('email', $data_obj->email);
        $this->db->set('tomo_folio_colegio', $data_obj->tomo_folio_colegio);
        $this->db->set('observaciones', $data_obj->observaciones);
        $this->db->set('id_subzona', $data_obj->id_subzona);

        $this->db->where('id', $id);
        $this->db->update('corresponsales');
        $result = $this->db->affected_rows();

        return $result;
    }

    public function delete($ids) {

        $this->db->or_where_in('id', $ids);
        $this->db->delete('corresponsales');

        return $this->db->affected_rows();
    }

    public function batch_insert() {

        $txt = "000041- FELICE ABEL roque;FELICE ABEL roque,
								000031-ADRIAN GAITAN;ADRIAN GAITAN,
								000050-AGUILAR AGUSTIN;AGUILAR AGUSTIN,
								000043-ARRO LEANDRO GONZALO;ARRO LEANDRO GONZALO,
								000019-CANCINO HUGO;CANCINO HUGO,
								000025-CAVAGLIATO XIMENA;CAVAGLIATO XIMENA,
								000006-CHAVES Y ASOCIADOS;CHAVES Y ASOCIADOS,
								000020-CLARISA SANCHEZ RONCERO;CLARISA SANCHEZ RONCERO,
								000012-CORNEJO FABIO;CORNEJO FABIO,
								000033-COSTANZO ANIBAL ENRIQUE;COSTANZO ANIBAL ENRIQUE,
								000044-CRISTIAN LAZARTE;CRISTIAN LAZARTE,
								000022-CYNTHIA SAVINO;CYNTHIA SAVINO,
								000024-DE LOS SANTOS MAURO;DE LOS SANTOS MAURO,
								000029-DE ZORZI PABLO;DE ZORZI PABLO,
								000005-DIONISI MIGUEL ANGEL;DIONISI MIGUEL ANGEL,
								000051-Dr. Fabián A. Spilere;Dr. Fabián A. Spilere,
								000035-ELSA MENDILAHARZU;ELSA MENDILAHARZU,
								000015-ESTELA ABALLAY;ESTELA ABALLAY,
								000048-FACUNDO GONZALEZ FIGUEROA. ANA LAGOS;FACUNDO GONZALEZ FIGUEROA. ANA LAGOS,
								000045-FURLONG NATALIA;FURLONG NATALIA,
								000021-GABRIEL ARDILES;GABRIEL ARDILES,
								000014-GESTIONES EXPRESS;GESTIONES EXPRESS,
								000027-JORGE JUAN RAMON;JORGE JUAN RAMON,
								000039-JUZGADO DE PAZ CATRIEL;JUZGADO DE PAZ CATRIEL,
								000028-JUZGADO DE PAZ CHOS MALAL- silvia pucci;JUZGADO DE PAZ CHOS MALAL- silvia pucci,
								000047-JUZGADO DE PAZ LAMARQUE- Jueza Claudia Bazcunian;JUZGADO DE PAZ LAMARQUE- Jueza Claudia Bazcunian,
								000040-JUZGADO DE PAZ PUNTA INDIO.  BS AS- oficial RUFIERO SEBASTIAN;JUZGADO DE PAZ PUNTA INDIO.  BS AS- oficial RUFIERO SEBASTIAN,
								000038-juzgado de paz ZAPALA. Monica Perez;juzgado de paz ZAPALA. Monica Perez,
								000016-LAGOS JUAN;LAGOS JUAN,
								000023-LOPEZ MARCINKO VANESA;LOPEZ MARCINKO VANESA,
								000046-MANSILLA ALEJANDRO;MANSILLA ALEJANDRO,
								000017-MANUEL LOPEZ VACA;MANUEL LOPEZ VACA,
								000010-MEDDE MARIA BELEN;MEDDE MARIA BELEN,
								000004-MENSI JORGELINA;MENSI JORGELINA,
								000034-MOLINA IVAN;MOLINA IVAN,
								000009-NAZAR SANDRA;NAZAR SANDRA,
								000030-NOIR WALTER;NOIR WALTER,
								000001-Pablo;Pablo,
								000042-PASTORE MARIA LAURA;PASTORE MARIA LAURA,
								000037-PEREZ DEL VISO Y COSTANZO;PEREZ DEL VISO Y COSTANZO,
								000032-PEREZ MONICA;PEREZ MONICA,
								000011-PONTONI CLAUDIA;PONTONI CLAUDIA,
								000018-PRATI GUSTAVO;PRATI GUSTAVO,
								000007-REY VAZQUEZ JORGE;REY VAZQUEZ JORGE,
								000013-RIOS WALTER;RIOS WALTER,
								000026-SALVATIERRA LUIS MARIA;SALVATIERRA LUIS MARIA,
								000049-SERRANO GLORIA;SERRANO GLORIA,
								000036-SOLIER MARIO ;SOLIER MARIO ,
								000003-tercero;tercero,
								000002-w;w,
								000008-WENDT PABLO;WENDT PABLO
		";

        $arr = explode(',', $txt);

        for ($i = 0; $i < sizeof($arr); $i++) {
            $pos = strpos($arr[$i], ';');
            $substring = strtolower(substr($arr[$i], $pos + 1));
    

            $this->db->set('nombre', ucwords($substring));

            $this->db->insert('corresponsales');
        }
    }

}
