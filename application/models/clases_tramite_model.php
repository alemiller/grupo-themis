<?php

class Clases_tramite_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function list_clases() {

        $this->db->select('*');
        $this->db->order_by("id", "asc");
        $query = $this->db->get('clases_tramite');

        return $query->result();
    }

    public function get_by_id($id) {

        $this->db->select('*');
        $this->db->from('clases_tramite');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->result()[0];
    }

    public function create($data) {

        $data_obj = json_decode($data);

        $this->db->set('nombre', $data_obj->nombre);
        $this->db->set('duracion', $data_obj->duracion);

        $this->db->insert('clases_tramite');
        $result = $this->db->affected_rows();

        if ($result) {

            $id = $this->db->insert_id();

            $query = $this->db->get_where('clases_tramite', array('id' => $id));

            $result = $query->result();
        }


        return $result;
    }

    public function update($id, $data) {

        $result = new stdClass();
        $data_obj = json_decode($data);

        $this->db->set('nombre', $data_obj->nombre);
        $this->db->set('duracion', $data_obj->duracion);


        $this->db->where('id', $id);
        $this->db->update('clases_tramite');
        
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
        $this->db->delete('clases_tramite');
        
        return $this->db->affected_rows();
    }

    public function batch_insert() {

        $txt = "000139;ADOPCION,
				000079;AGRIMENSOR ESTADO PARCELARIO,
				000145;APOSTILLADO,
				000090;AVERIGUACIONES VARIAS,
				000117;CABA CEDULA,
				000087;CASILLERO CABA,
				000088;CASILLERO GRAN BS AS,
				000076;CATASTRO - CEDULA O PLANCHETA,
				000078;CATASTRO CERTIFICADO,
				000004;Cedula,
				000104;CEDULA CATASTRAL CABA,
				000159;CONFECCION TESTIMONIO U OFICIO,
				000143;CONFRONTE,
				000121;CONSTATACION DOMICILIO,
				000105;CONSULTA INMUEBLE,
				000146;CROQUIS,
				000151;DECLARACION JURADA,
				000147;DECLARATORIA DE HEREDEROS,
				000132;DESARCHIVO,
				000113;DEUDA INFRACCIONES CABA,
				000124;DIVORCIO PCIA,
				000122;DOMINIO,
				000083;EDICTO B.O LA PLATA,
				000084;EDICTO BO CABA,
				000086;EDICTO DIARIO ZONAL BS AS,
				000085;EDICTO DIARIO ZONAL CABA,
				000010;ESCRITO JUDICIAL,
				000118;ESTADO DE DEUDA,
				000097;ESTADO DE DEUDA PATENTES,
				000127;EXHORTO,
				000075;EXPEDIENTES VISTA COMPLETA BS AS,
				000073;EXPEDIENTES VISTA COMPLETA CABA,
				000074;EXPEDIENTES VISTA SIMPLE BS AS,
				000072;EXPEDIENTES VISTA SIMPLE CABA,
				000013;FIJAR FECHA,
				000157;FOTOCOPIA DE EXPEDIENTE,
				000125;INHIBICION INTERIOR,
				000133;INICIO DE EXPEDIENTE,
				000120;JUICIOS UNIVERSALES,
				000089;LEGALIZACION,
				000123;LIBRE DEUDA RENTAS,
				000005;Mandamiento,
				000014;MANDAMIENTO EMBARGO CON MEDIDA,
				000082;OFICIO PENSIONES SOCIALES BS AS,
				000009;OFICIO SIMPLE CABA,
				000098;OFICIO SIMPLE LA PLATA,
				000094;OFICIO SIMPLE PCIA BS AS,
				000080;OFICIO TESTAMENTOS BS AS,
				000081;OFICIO TESTAMENTOS CABA,
				000142;OFICIO URGENTE,
				000106;OFICIOS,
				000137;PARTIDA,
				000011;PERSONAS JURIDICAS  AVERIGUACION,
				000156;PROCURACION QUINCENAL,
				000134;RELEVAMIENTO DE DOMICILIO,
				000138;RETIRO DE CEDULA,
				000158;RETIRO RESPUESTA OFICIO,
				000149;RNP ADOPCION,
				000035;RNP DIVORCIO BS AS COMUN,
				000036;RNP DIVORCIO BS AS URGENTE,
				000031;RNP DIVORCIO CABA,
				000155;RNP INSCRIPCION DE NACIMIENTO,
				000033;RNP PARTIDA DEFUNCION BS AS,
				000029;RNP PARTIDA DEFUNCION CABA,
				000034;RNP PARTIDA MATRIMONIO BS AS,
				000030;RNP PARTIDA MATRIMONIO CABA,
				000032;RNP PARTIDA NACIMIENTO BS AS,
				000028;RNP PARTIDA NACIMIENTO CABA,
				000038;RNP RECTIFICACION BS AS,
				000037;RNP RECTIFICACION CABA,
				000148;RPA CAUTELAR,
				000019;RPA CONSULTA,
				000022;RPA DECLARATORIA CABA,
				000023;RPA DECLARATORIA PCIA BS AS,
				000026;RPA DIVORCIO CABA,
				000027;RPA DIVORCIO PCIA BS AS,
				000015;RPA DOMINIO COMUN,
				000017;RPA DOMINIO URGENTE BS AS,
				000016;RPA DOMINIO URGENTE CABA,
				000129;RPA INFRACCIONES,
				000018;RPA INHIBICION,
				000109;RPA OFICIO CABA,
				000150;RPA REINSCRIPCION PRENDA,
				000020;RPA TRABA DE EMBARGO CABA,
				000021;RPA TRABA DE EMBARGO PCIA BS AS,
				000024;RPA TRANSFERENCIA CABA,
				000025;RPA TRANSFERENCIA PCIA BS AS,
				000131;RPI ADJUDICACION EN DIVORCIO,
				000099;RPI ANOTACION DE LITIS,
				000067;RPI CAUTELAR BS AS COMUN,
				000068;RPI CAUTELAR BS AS URGENTE,
				000048;RPI CAUTELAR CABA COMUN,
				000049;RPI CAUTELAR CABA URGENTE,
				000059;RPI CONSULTA BS AS COMUN,
				000060;RPI CONSULTA BS AS URGENTE,
				000042;RPI CONSULTA CABA,
				000070;RPI CONVENIO DIVORCIO BS AS,
				000052;RPI CONVENIO DIVORCIO CABA COMUN,
				000053;RPI CONVENIO DIVORCIO CABA URGENTE,
				000061;RPI COPIA ASIENTO BS AS COMUN,
				000062;RPI COPIA ASIENTO BS AS URGENTE,
				000012;RPI DECLARATORIA DE HEREDEROS,
				000065;RPI DH BS AS COMUN,
				000066;RPI DH BS AS URGENTE,
				000046;RPI DH CABA COMUN,
				000047;RPI DH CABA URGENTE,
				000056;RPI DOMINIO BS AS URGENTE,
				000039;RPI DOMINIO CABA URGENTE,
				000007;RPI DOMINIO COMUN CABA,
				000008;RPI DOMINIO COMUN PCIA BS AS,
				000063;RPI FRECUENCIA BS AS COMUN,
				000064;RPI FRECUENCIA BS AS URGENTE,
				000044;RPI FRECUENCIA CABA COMUN,
				000045;RPI FRECUENCIA CABA URGENTE,
				000096;RPI INFORME CESION COMUN BS AS,
				000130;RPI INFORME CESION URGENTE BS AS,
				000057;RPI INHIBICION BS AS COMUN,
				000058;RPI INHIBICION BS AS URGENTE,
				000040;RPI INHIBICION CABA COMUN,
				000041;RPI INHIBICION CABA URGENTE,
				000069;RPI INSCRIP TESTIMONIO BS AS COMUN,
				000054;RPI INSCRIP. TESTIMONIO CABA COMUN,
				000055;RPI INSCRIP. TESTIMONIO CABA URGENTE,
				000154;RPI INSCRIPCION ,
				000112;RPI LA PLATA OFICIOS,
				000050;RPI LEVANTAMIENTO CABA COMUN,
				000051;RPI LEVANTAMIENTO CABA URGENTE,
				000135;RPI LEVANTAMIENTO PCIA BS AS,
				000110;RPI OFICIO CABA,
				000128;RPI OFICIO LA PLATA,
				000071;RPI SUBASTA BS AS,
				000140;RPI SUBASTA CABA,
				000043;RPI TITULAR POR DOMICILIO,
				000141;RPI USUCAPION,
				000101;segundo testimonio,
				000136;SOLICITUD SEGUNDO TESTIMONIO,
				000144;TRADUCCION,
				000001;Tramite 01,
				000002;Tramite 02,
				000003;Tramite special de Ballester,
				000126;VALUACION,
				000111;VALUACION CABA,
				000114;VALUACION LA PLATA,
				000095;VARIOS,
				000119;VISTA EXPEDIENTE";

        $arr = explode(',', $txt);

        for ($i = 0; $i < sizeof($arr); $i++) {
            $pos = strpos($arr[$i], ';');
            $substring = strtolower(substr($arr[$i], $pos + 1));
       

            $this->db->set('nombre', ucwords($substring));

            $this->db->insert('clases_tramite');
        }
    }
    
}
