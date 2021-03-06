<?php

class Subzonas_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function list_subzonas() {

        $this->db->select('*');
        $this->db->from('subzonas');
        $this->db->order_by("nombre", "asc");
        $query = $this->db->get();

        return $query->result();
    }

    public function get_by_id($id) {

        $this->db->select('*');
        $this->db->from('subzonas');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->result()[0];
    }

    public function create($data) {

        $data_obj = json_decode($data);

        $this->db->set('nombre', $data_obj->nombre);
        $this->db->set('id_zona', $data_obj->id_zona);

        $this->db->insert('subzonas');
        $result = $this->db->affected_rows();

        if ($result) {

            $id = $this->db->insert_id();

            $query = $this->db->get_where('subzonas', array('id' => $id));

            $result = $query->result();
        }


        return $result;
    }

    public function update($id, $data) {

        $result = new stdClass();
        $data_obj = json_decode($data);

        $this->db->set('nombre', $data_obj->nombre);
        $this->db->set('id_zona', $data_obj->id_zona);

        $this->db->where('id', $id);
        $this->db->update('subzonas');
        
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
        $this->db->delete('subzonas');

        return $this->db->affected_rows();
    }

    public function batch_insert() {

        $txt = "000074-000076;25 DEMAYO-25 DE MAYO,000074-000089;25 DEMAYO-NEUQUEN,000074-000090;25 DEMAYO-parana,000119-000270;9 de julio-9 de julio,000133-000314;a-a,000126-000285;ADOLFO GONZALEZ CHAVEZ-ADOLFO GONZALEZ CHAVEZ,000121-000272;ALBERTI-BUENOS AIRES,000005-000004;Almirante Brown-Burzaco,000005-000017;Almirante Brown-,000005-000216;Almirante Brown-GLEW,000005-000217;Almirante Brown-LONGCHAMPS,000005-000218;Almirante Brown-ADROGUE,000005-000219;Almirante Brown-JOSE MARMOL,000005-000220;Almirante Brown-RAFAEL CALZADA,000005-000221;Almirante Brown-CLAYPOLE,000005-000269;Almirante Brown-MINISTRO RIVADAVIA,000022-000025;AVELLANEDA-AVELLANEDA,000022-000209;AVELLANEDA-WILDE,000022-000210;AVELLANEDA-SARANDI,000022-000211;AVELLANEDA-VILLA DOMINICO,000067-000068;AZUL-AZUL,000106-000256;bahia blanca-bahia,000120-000271;BARADERO-BARADERO,000025-000043;BERAZATEGUI-BERAZATEGUI,000025-000228;BERAZATEGUI-HUDSON,000025-000229;BERAZATEGUI-VILLA ESPAÑA,000025-000230;BERAZATEGUI-PLATANOS,000025-000231;BERAZATEGUI-RANELAGH,000025-000232;BERAZATEGUI-SOURIGUES,000025-000233;BERAZATEGUI-EL PATO,000075-000077;BERISSO-BERISSO,000087-000094;BOLIVAR-BOLIVAR,000104-000254;BRANDSEN-BRANDSEN,000124-000276;BUENOS AIRES-LAS VAQUERIAS,000124-000277;BUENOS AIRES-GENERAL ALVEAR,000124-000278;BUENOS AIRES-GOWLAND,000124-000279;BUENOS AIRES-LA NEGRA,000124-000280;BUENOS AIRES-SAN NICOLAS,000124-000281;BUENOS AIRES-BARROW,000124-000282;BUENOS AIRES-GENERAL CONESA,000124-000293;BUENOS AIRES-pinamar,000124-000295;BUENOS AIRES-ROQUE PEREZ,000124-000296;BUENOS AIRES-TANDIL,000124-000299;BUENOS AIRES-BALCARCE,000124-000303;BUENOS AIRES-TRES LOMAS,000124-000305;BUENOS AIRES-BRAGADO,000124-000306;BUENOS AIRES-san clemente,000124-000311;BUENOS AIRES-GENERAL VIAMONTE,000124-000312;BUENOS AIRES-san andres de giles,000124-000313;BUENOS AIRES-CORONEL PRINGLES,000124-000315;BUENOS AIRES-nueve de julio,000124-000319;BUENOS AIRES-acevedo,000124-000320;BUENOS AIRES-CORONEL SUAREX,000124-000323;BUENOS AIRES-pehuajo,000124-000324;BUENOS AIRES-SALTO,000124-000325;BUENOS AIRES-ROJAS,000124-000326;BUENOS AIRES-COLON,000076-000078;BURATOVICH-VILARIÑO,000046-000064;CABA CEDULA-CEDULAS,000008-000008;CABA OFICIOS-OFICIOS,000008-000011;CABA OFICIOS-REGISTRO CIVIL,000008-000014;CABA OFICIOS-CASILLEROS CABA,000082-000086;CAMPANA-CAMPANA,000048-000046;CAÑUELAS-CAÑUELAS,000048-000155;CAÑUELAS-MAXIMO PAZ,000048-000156;CAÑUELAS-VICENTE CASARES,000049-000047;CARHUE-CARHUE,000084-000088;CARILO-CARILO,000130-000297;CASILLERO-CAPITAL FEDERAL,000130-000298;CASILLERO-GRAN BUENOS AIRES,000108-000258;CATAMARCA-CATAMARCA,000129-000292;CHACABUCO-CHACABUCO,000072-000074;CHACO-CHACO,000115-000264;chascomus-chascomus,000055-000054;CHIVILCOY-CHIVILCOY,000041-000040;CHUBUT-COMODORO RIVADAVIA,000041-000284;CHUBUT-LAGO PUELO,000041-000300;CHUBUT-DOLAVON,000041-000304;CHUBUT-PUERTO MADRYN,000065-000066;COMODORO RIVADAVIA-CHUBUT,000079-000083;CONESA-CONESA,000056-000055;CORDOBA-CORDOBA,000056-000098;CORDOBA-JESUS MARIA,000117-000266;CORONEL ROSALES-CORONEL ROSALES,000043-000042;CORRIENTES-CORRIENTES,000043-000069;CORRIENTES-ISLA SAN MATEO,000045-000044;DOLORES-DOLORES,000023-000019;ECHEVERRIA-MONTE GRANDE,000023-000160;ECHEVERRIA-LUIS GUILLON,000100-000239;ENSENADA-ENSENADA,000100-000240;ENSENADA-PUNTA LARA,000057-000056;ENTRE RIOS-GUALEGUAY,000057-000062;ENTRE RIOS-ENTRE RIOS,000057-000290;ENTRE RIOS-gualeguaychu,000057-000291;ENTRE RIOS-concepcion del uruguay,000027-000036;ESCOBAR-ESCOBAR,000027-000181;ESCOBAR-GARIN,000027-000182;ESCOBAR-MAQUINISTA SAVIO,000027-000183;ESCOBAR-MATHEU,000027-000184;ESCOBAR-ING MASCHWITZ,000078-000081;exaltacion de la cruz-capilla del señor,000063-000063;EZEIZA-EZEIZA,000063-000157;EZEIZA-UNION FERROVIARIA,000063-000158;EZEIZA-TRISTAN SUAREZ,000063-000159;EZEIZA-SPEGAZZINI,000059-000058;FLORENCIO VARELA-FLORENCIO VARELA,000059-000222;FLORENCIO VARELA-ING ALLAN,000059-000223;FLORENCIO VARELA-KM 36,000059-000224;FLORENCIO VARELA-BOSQUES,000059-000225;FLORENCIO VARELA-ZEBALLOS,000059-000226;FLORENCIO VARELA-MONTEVERDE,000059-000227;FLORENCIO VARELA-ARDIGO,000071-000073;FORMOSA-FORMOSA,000118-000268;GENERAL BELGRANO-GENERAL BELGRANO,000097-000148;GENERAL LAS HERAS-GENERAL LAS HERAS,000097-000149;GENERAL LAS HERAS-GENERAL HORNOS,000097-000150;GENERAL LAS HERAS-VILLAR,000097-000151;GENERAL LAS HERAS-PLOMER,000097-000152;GENERAL LAS HERAS-LOZANO,000097-000153;GENERAL LAS HERAS-FYNN,000097-000154;GENERAL LAS HERAS-LA CHOZA,000137-000322;GENERAL LAVALLE-GENERAL LAVALLE,000064-000065;GENERAL PAZ-RANCHOS,000112-000288;gral las heras-GRAL LAS HERAS,000052-000051;GRAL RODRIGUEZ-GRAL RODRIGUEZ,000052-000143;GRAL RODRIGUEZ-MARIN,000052-000144;GRAL RODRIGUEZ-LAS MALVINAS,000052-000145;GRAL RODRIGUEZ-LA FRATERNIDAD,000024-000067;GUERNICA SAN VICENTE-PERON,000095-000133;HURLINGHAM-HURLINGHAM,000095-000134;HURLINGHAM-WILLIAM MORRIS,000095-000135;HURLINGHAM-LASALLE,000096-000139;ITUZAINGO-ITUZAINGO,000094-000123;JOSE C PAZ-JOSE C PAZ,000094-000124;JOSE C PAZ-PIÑERO,000094-000125;JOSE C PAZ-VUCETICH,000109-000259;JUJUY-JUJUY,000123-000275;JUNIN-JUNIN,000015-000015;LA MATANZA-LA MATANZA,000015-000161;LA MATANZA-INGENIERO BRIAN,000015-000162;LA MATANZA-SAN JUSTO,000015-000163;LA MATANZA-LA TABLADA,000015-000164;LA MATANZA-VILLA MADERO,000015-000165;LA MATANZA-TAPIALES,000015-000166;LA MATANZA-ALDO BONZI,000015-000167;LA MATANZA-JOSE INGENIEROS,000015-000168;LA MATANZA-VILLEGAS,000015-000169;LA MATANZA-ISIDRO CASANOVA,000015-000170;LA MATANZA-RAFAEL CASTILLO,000015-000171;LA MATANZA-LAFERRERE,000015-000172;LA MATANZA-GONZALEZ CATAN,000015-000173;LA MATANZA-20 DE JUNIO,000015-000174;LA MATANZA-VILLA CELINA,000015-000175;LA MATANZA-VIRREY DEL PINO,000029-000013;LA PAMPA-SANTA ROSA,000029-000286;LA PAMPA-CHACHARRAMENDI,000050-000241;LA PLATA-VILLA ELISA,000050-000242;LA PLATA-LA PLATA,000050-000243;LA PLATA-CITIBELL,000050-000244;LA PLATA-GONETT,000050-000245;LA PLATA-TOLOSA,000050-000246;LA PLATA-RINGUELET,000050-000247;LA PLATA-LOS HORNOS,000050-000248;LA PLATA-MELCHOR ROMERO,000050-000249;LA PLATA-OLMOS,000050-000250;LA PLATA-ABASTO,000050-000283;LA PLATA-PUNTA INDIO,000050-000301;LA PLATA-MAGDALENA,000012-000012;LA PLATA OFICIOS-LA PLATA OFICIOS,000110-000260;LA RIOJA-LA RIOJA,000019-000031;LANUS-LANUS,000019-000204;LANUS-GERLY,000019-000205;LANUS-VALENTIN ALSINA,000019-000206;LANUS-VILLA CARAZA,000019-000207;LANUS-MONTE CHINGOLO,000019-000208;LANUS-REMEDIOS DE ESCALADA,000134-000316;LAS HERAS-LAS HERAS,000114-000263;LINCOLN-LINCOLN,000102-000252;LOBOS-LOBOS,000020-000021;LOMAS-LOMAS,000020-000197;LOMAS-LOMAS DE ZAMORA,000020-000198;LOMAS-VILLA FIORITO,000020-000199;LOMAS-ING BUDGE,000020-000200;LOMAS-TEMPERLEY,000020-000201;LOMAS-LLAVALLOL,000020-000202;LOMAS-TURDERA,000020-000203;LOMAS-BANFIELD,000039-000037;LUJAN-LUJAN,000093-000115;MALVINAS ARGENTINAS-PABLO NOGUES,000093-000116;MALVINAS ARGENTINAS-GRAND BOURG,000093-000117;MALVINAS ARGENTINAS-TIERRAS ALTAS,000093-000118;MALVINAS ARGENTINAS-MALVINAS ARGENTINAS,000093-000119;MALVINAS ARGENTINAS-LOS POLVORINES,000093-000120;MALVINAS ARGENTINAS-SORDEAUX,000093-000121;MALVINAS ARGENTINAS-VILLA DE MAYO,000093-000122;MALVINAS ARGENTINAS-TORTUGUITAS,000058-000057;mar chiquita-mar chiquita,000062-000061;MAR DE AJO-MAR DE AJO,000032-000024;MAR DEL PLATA-MAR DEL PLATA,000122-000274;mar del tuyu-MAR DEL TUYU,000068-000070;MARCOS PAZ-MARCOS PAZ,000068-000146;MARCOS PAZ-ROMERO,000068-000147;MARCOS PAZ-KM 53,000033-000026;MENDOZA-CHACRA DE CORIA,000033-000048;MENDOZA-mendoza,000033-000287;MENDOZA-CAÑADA SECA,000037-000033;MERCEDES-MERCEDES,000034-000027;MERLO-MERLO,000077-000079;misiones-misiones,000116-000265;MONTE HERMOSO-MONTE HERMOSO,000014-000016;MORENO-MORENO,000014-000140;MORENO-LA REJA,000014-000141;MORENO-PASO DEL REY,000014-000142;MORENO-FRANCISCO ALVAREZ,000009-000009;MORON-MORON,000009-000136;MORON-HAEDO,000009-000137;MORON-EL PALOMAR,000009-000138;MORON-CASTELAR,000101-000251;NAVARRO-NAVARRO,000073-000075;NECOCHEA-NECOCHEA,000085-000091;NEUQUEN-PLOTTIER,000085-000267;NEUQUEN-CUTRAL CO,000085-000273;NEUQUEN-SENILLOSA,000085-000307;NEUQUEN-zapala,000085-000308;NEUQUEN-VILLA LA ANGOSTURA,000085-000317;NEUQUEN-CIPOLETTI,000085-000318;NEUQUEN-CAPITAL,000113-000262;Olavarria-Olavarria,000083-000087;PARTIDO DE LA COSTA-PARTIDO DE LA COSTA,000091-000099;Pellegrini-Pellegrini,000080-000084;pergamino-pergamino,000081-000085;PIGUE-PIGU,000026-000023;PILAR-PILAR,000026-000176;PILAR-del viso,000026-000177;PILAR-PRESIDENTE DERQUI,000026-000178;PILAR-VILLA ROSA,000026-000179;PILAR-VILLA ASTOLFI,000026-000180;PILAR-ALBERTI,000098-000234;PRESIDENTE PERON-GUERNICA,000098-000235;PRESIDENTE PERON-VILLA NUMANCIA,000021-000020;QUILMES-QUILMES,000021-000212;QUILMES-DON BOSCO,000021-000213;QUILMES-BERNAL,000021-000214;QUILMES-EZPELETA,000021-000215;QUILMES-SAN FRANCISCO SOLANO,000107-000257;RAUCH-RAUCH,000054-000053;RIO NEGRO-CIPOLLETI,000054-000080;RIO NEGRO-VIEDMA,000054-000092;RIO NEGRO-RIO NEGRO,000054-000309;RIO NEGRO-catriel,000054-000321;RIO NEGRO-bariloche,000060-000059;RPA CABA-RPA CABA,000007-000006;RPI CABA-CABA,000006-000005;RPI LA PLATA-REGISTRO INMUEBLE,000006-000007;RPI LA PLATA-REGISTRO INMUEBLE LA PLATA,000006-000010;RPI LA PLATA-PERSONAS JURIDICAS,000069-000071;SALADILLO-SALADILLO,000040-000039;SALTA-SALTA,000053-000052;SAN ANTONIO DE ARECO-SAN ANTONIO DE ARECO,000092-000107;SAN FERNANDO-SAN FERNANDO,000092-000108;SAN FERNANDO-VIRREYES,000092-000109;SAN FERNANDO-CARUPA,000017-000029;SAN ISIDRO-VICTORIA,000017-000035;SAN ISIDRO-ACASUSSO,000017-000038;SAN ISIDRO-OLIVOS,000017-000100;SAN ISIDRO-san isidro,000017-000101;SAN ISIDRO-MARTINEZ,000017-000102;SAN ISIDRO-BOULOGNE,000017-000103;SAN ISIDRO-VILLA ADELINA,000111-000261;SAN JUAN-SAN JUAN,000070-000072;SAN LUIS-SAN LUIS,000004-000003;San Martin-Villa Ballester,000004-000191;San Martin-SAN ANDRES,000004-000192;San Martin-SAN MARTIN,000004-000193;San Martin-CORONEL CHILAVERT,000004-000194;San Martin-JOSE L SUAREZ,000004-000196;San Martin-SAENZ PEÑA,000016-000018;SAN MIGUEL-SAN MIGUEL,000016-000126;SAN MIGUEL-GENERAL SARMIENTO,000016-000127;SAN MIGUEL-GENERAL LEMOS,000016-000128;SAN MIGUEL-MUÑIZ,000016-000129;SAN MIGUEL-BELLA VISTA,000016-000130;SAN MIGUEL-RICHIERI,000016-000131;SAN MIGUEL-CAMPO DE MAYO,000016-000132;SAN MIGUEL-SARGENTO CABRAL,000103-000253;SAN MIGUEL DEL MONTE-SAN MIGUEL DEL MONTE,000086-000093;san nicolas-san nicolsas,000090-000097;SAN PEDRO-SAN PEDRO,000099-000236;SAN VICENTE-ALEJANDRO KORN,000099-000237;SAN VICENTE-SAN VICENTE,000099-000238;SAN VICENTE-DOMSELAAR,000061-000060;SANTA CRUZ-SANTA CRUZ,000051-000049;SANTA FE-ROSARIO,000051-000050;SANTA FE-sunchales,000051-000082;SANTA FE-santa fe,000051-000302;SANTA FE-CASILDA,000051-000310;SANTA FE-san jorge,000047-000045;SANTIAGO DEL ESTERO-SANTIAGO DEL ESTERO,000105-000255;TIERRA DEL FUEGO-RIO GRANDE,000105-000294;TIERRA DEL FUEGO-ushuaia,000018-000028;TIGRE-TIGRE,000018-000110;TIGRE-BENAVIDEZ,000018-000111;TIGRE-EL TALAR DE PACHECO,000018-000112;TIGRE-LOPEZ CAMELO,000018-000113;TIGRE-GENERAL PACHECO,000018-000114;TIGRE-DELTA,000128-000289;TRENQUE LAUQUEN-TRENQUE LAUQUEN,000088-000095;TRES ARROYOS-TRES ARROYOS,000089-000096;TRES DE FEBRERO-CIUDADELA,000089-000185;TRES DE FEBRERO-SANTOS LUGARES,000089-000186;TRES DE FEBRERO-CASEROS,000089-000187;TRES DE FEBRERO-LOURDES,000089-000188;TRES DE FEBRERO-MARTIN CORONADO,000089-000189;TRES DE FEBRERO-TROPEZON,000089-000190;TRES DE FEBRERO-VILLA BOSCH,000089-000195;TRES DE FEBRERO-VILLA LYNCH,000042-000041;TUCUMAN-SAN MIGUEL DE TUCUMAN,000031-000022;VARELA-VARELA,000035-000030;VICENTE LOPEZ-VICENTE LOPEZ,000035-000104;VICENTE LOPEZ-LA LUCILA,000035-000105;VICENTE LOPEZ-MUNRO,000035-000106;VICENTE LOPEZ-CARAPACHAY,000036-000032;VILLA GESEL-VILLA GESEL,000038-000034;ZARATE-ZARATE";

        $arr = explode(',', $txt);

        for ($i = 0; $i < sizeof($arr); $i++) {
            $pos = strpos($arr[$i], ';');
            $substring = strtolower(substr($arr[$i], $pos + 1));


            $this->db->set('nombre', ucwords($substring));

            $this->db->insert('subzonas');
        }
    }

}
