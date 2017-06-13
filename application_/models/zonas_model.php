<?php

class Zonas_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function list_zonas() {

        $this->db->select('*');
        $this->db->order_by("nombre", "asc");
        $query = $this->db->get('zonas');

        return $query->result();
    }

    public function get_by_id($id) {

        $this->db->select('*');
        $this->db->from('zonas');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->result()[0];
    }

    public function create($data) {

        $data_obj = json_decode($data);

        $this->db->set('nombre', $data_obj->nombre);

        $this->db->insert('zonas');
        $result = $this->db->affected_rows();

        if ($result) {

            $id = $this->db->insert_id();

            $query = $this->db->get_where('zonas', array('id' => $id));

            $result = $query->result();
        }


        return $result;
    }

    public function update($id, $data) {

        $data_obj = json_decode($data);

        $this->db->set('nombre', $data_obj->nombre);

        $this->db->where('id', $id);
        $this->db->update('zonas');
        $result = $this->db->affected_rows();

        return $result;
    }

    public function delete($ids) {

        $this->db->or_where_in('id', $ids);
        $this->db->delete('zonas');

        return $this->db->affected_rows();
    }

    public function batch_insert() {

        $txt = "000004;San Martin,
		000005;Almirante Brown,
		000006;RPI LA PLATA,
		000007;RPI CABA,
		000008;CABA OFICIOS,
		000009;MORON,
		000010;CABA CEDULAS,
		000011;CABA RPA,
		000012;LA PLATA OFICIOS,
		000013;LA PLATA CEDULAS,
		000014;MORENO,
		000015;LA MATANZA,
		000016;SAN MIGUEL,
		000017;SAN ISIDRO,
		000018;TIGRE,
		000019;LANUS,
		000020;LOMAS,
		000021;QUILMES,
		000022;AVELLANEDA,
		000023;ECHEVERRIA,
		000024;GUERNICA SAN VICENTE,
		000025;BERAZATEGUI,
		000026;PILAR,
		000027;ESCOBAR,
		000028;RNP CABA,
		000029;LA PAMPA,
		000030;MATANZA,
		000031;VARELA,
		000032;MAR DEL PLATA,
		000033;MENDOZA,
		000034;MERLO,
		000035;VICENTE LOPEZ,
		000036;VILLA GESEL,
		000037;MERCEDES,
		000038;ZARATE,
		000039;LUJAN,
		000040;SALTA,
		000041;CHUBUT,
		000042;TUCUMAN,
		000043;CORRIENTES,
		000044;DOLLORES,
		000045;DOLORES,
		000046;CABA CEDULA,
		000047;SANTIAGO DEL ESTERO,
		000048;CAÑUELAS,
		000049;CARHUE,
		000050;LA PLATA,
		000051;SANTA FE,
		000052;GRAL RODRIGUEZ,
		000053;SAN ANTONIO DE ARECO,
		000054;RIO NEGRO,
		000055;CHIVILCOY,
		000056;CORDOBA,
		000057;ENTRE RIOS,
		000058;mar chiquita,
		000059;FLORENCIO VARELA,
		000060;RPA CABA,
		000061;SANTA CRUZ,
		000062;MAR DE AJO,
		000063;EZEIZA,
		000064;GENERAL PAZ,
		000065;COMODORO RIVADAVIA,
		000066;GUERNICA,
		000067;AZUL,
		000068;MARCOS PAZ,
		000069;SALADILLO,
		000070;SAN LUIS,
		000071;FORMOSA,
		000072;CHACO,
		000073;NECOCHEA,
		000074;25 DEMAYO,
		000075;BERISSO,
		000076;BURATOVICH,
		000077;misiones,
		000078;exaltacion de la cruz,
		000079;CONESA,
		000080;pergamino,
		000081;PIGUE,
		000082;CAMPANA,
		000083;PARTIDO DE LA COSTA,
		000084;CARILO,
		000085;NEUQUEN,
		000086;san nicolas,
		000087;BOLIVAR,
		000088;TRES ARROYOS,
		000089;TRES DE FEBRERO,
		000090;SAN PEDRO,
		000091;Pellegrini,
		000092;SAN FERNANDO,
		000093;MALVINAS ARGENTINAS,
		000094;JOSE C PAZ,
		000095;HURLINGHAM,
		000096;ITUZAINGO,
		000097;GENERAL LAS HERAS,
		000098;PRESIDENTE PERON,
		000099;SAN VICENTE,
		000100;ENSENADA,
		000101;NAVARRO,
		000102;LOBOS,
		000103;SAN MIGUEL DEL MONTE,
		000104;BRANDSEN,
		000105;TIERRA DEL FUEGO,
		000106;bahia blanca,
		000107;RAUCH,
		000108;CATAMARCA,
		000109;JUJUY,
		000110;LA RIOJA,
		000111;SAN JUAN,
		000112;gral las heras,
		000113;Olavarria,
		000114;LINCOLN,
		000115;chascomus,
		000116;MONTE HERMOSO,
		000117;CORONEL ROSALES,
		000118;GENERAL BELGRANO,
		000119;9 de julio,
		000120;BARADERO,
		000121;ALBERTI,
		000122;mar del tuyu,
		000123;JUNIN,
		000124;BUENOS AIRES,
		000125;Lucas,
		000126;ADOLFO GONZALEZ CHAVEZ,
		000127;vicente casares,
		000128;TRENQUE LAUQUEN,
		000129;CHACABUCO,
		000130;CASILLERO,
		000131;NEUQUEN ZAPALA,
		000132;GENERAL VIAMONTE,
		000134;LAS HERAS,
		000135;BRAGADO,
		000136;MAGDALENA,
		000137;GENERAL LAVALLE
		";

        $arr = explode(',', $txt);

        for ($i = 0; $i < sizeof($arr); $i++) {
            $pos = strpos($arr[$i], ';');
            $substring = strtolower(substr($arr[$i], $pos + 1));
            error_log('substring: ' . ucwords($substring));

            $this->db->set('nombre', ucwords($substring));

            $this->db->insert('zonas');
        }
    }

}
