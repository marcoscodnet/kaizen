<?php

/**
 * Acceso a datos para servicios.
 *
 * @author Marcos
 * @since 16-05-12
 *
 */
class ServicioQuery {

    static function insertServicio(Servicio $obj) {
        $db = DbManager::getConnection();

        //$cd_servicio = $obj->getCd_servicio();
        $nu_monto = $obj->getNu_monto();
        $dt_carga = $obj->getDt_carga();
        $ds_descpedidocte = $obj->getDs_descpedidocte();
        $cd_vehiculoservicio = FormatUtils::ifEmpty($obj->getCd_vehiculoservicio(), 'null');
        $cd_tiposervicio = FormatUtils::ifEmpty($obj->getCd_tiposervicio(), 'null');
        $cd_usuario = FormatUtils::ifEmpty($obj->getCd_usuario(), 'null');
        $cd_cliente = FormatUtils::ifEmpty($obj->getCd_cliente(), 'null');
        $ds_obsgral = $obj->getDs_obsgral();
        $ds_kmshoras = $obj->getDs_kmshoras();
		$dt_ingresovehiculo = $obj->getDt_ingresovehiculo();
		$ds_diagyreprealizada = $obj->getDs_diagyreprealizada();
		$ds_repuestosusados = $obj->getDs_repuestosusados();
		$ds_mecanicos = $obj->getDs_mecanicos();
		$ds_instmedusados = $obj->getDs_instmedusados();
		$ds_tiempomanoobra = $obj->getDs_tiempomanoobra();
		$dt_compromisoentrega = $obj->getDt_compromisoentrega();
        $bl_pagado = $obj->getBl_pagado();
      	$cd_sucursal = FormatUtils::ifEmpty($obj->getCd_sucursal(), 'null');
        $sql = "INSERT INTO servicio (nu_monto, dt_carga, ds_descpedidocte, cd_vehiculo_servicio, cd_tipo_servicio, cd_usuario, cd_cliente, ds_obsgral, ds_kmshoras, dt_ingresovehiculo, ds_diagyreprealizada, ds_repuestosusados, ds_mecanicos, ds_instmedusados, ds_tiempomanoobra, dt_compromisoentrega,bl_pagado,cd_sucursal)";
        $sql .= " VALUES ( '$nu_monto', '$dt_carga', '$ds_descpedidocte', '$cd_vehiculoservicio', '$cd_tiposervicio', '$cd_usuario', '$cd_cliente', '$ds_obsgral', '$ds_kmshoras', '$dt_ingresovehiculo', '$ds_diagyreprealizada', '$ds_repuestosusados', '$ds_mecanicos', '$ds_instmedusados', '$ds_tiempomanoobra', '$dt_compromisoentrega','$bl_pagado',$cd_sucursal)";

        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());
        $id = ServicioQuery::insert_id($db);
        $obj->setCd_servicio($id);
    }

    static function insert_id($db) {
        $db = DbManager::getConnection();
        $sql = "SELECT MAX(`cd_servicio`) as id FROM servicio ";
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException();
        $next = $db->sql_fetchassoc($result);
        $id = $next['id'];
        $db->sql_freeresult($result);
        return ($id );
    }

    static function getServicios(CriterioBusqueda $criterio) {
        $db = DbManager::getConnection();
        $sql = "SELECT S.*, date_format(S.dt_carga,'%d/%m/%Y %H:%i:%s') dt_carga, VS.*, TS.*,SU.*, U.*, C.cd_cliente, C.nu_doc, C.cd_tipodoc, C.ds_apynom as cliente_ds_apynom FROM servicio S";
        $sql .= " LEFT JOIN vehiculo_servicio VS ON S.cd_vehiculo_servicio = VS.cd_vehiculo_servicio ";

        $sql .= " LEFT JOIN usuario U ON S.cd_usuario = U.cd_usuario ";
        $sql .= " LEFT JOIN tipo_servicio TS ON S.cd_tipo_servicio = TS.cd_tipo_servicio ";
        $sql .= " LEFT JOIN cliente C ON C.cd_cliente = S.cd_cliente ";

        $sql .= " LEFT JOIN sucursal SU ON S.cd_sucursal = SU.cd_sucursal ";
        $sql .= $criterio->buildWHERE();

        $sql .= $criterio->buildORDERBY();
        $sql .= $criterio->buildLIMIT();

        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $servicios = ResultFactory::toCollection($db, $result, new ServicioFactory());
        $db->sql_freeresult($result);

        return $servicios;
    }

	static function getImporteTotalEnServicios(CriterioBusqueda $criterio) {
        $suma = 0;
		$db = DbManager::getConnection();
        $sql = "SELECT SUM(S.nu_monto) as total_servicios FROM servicio S";
        $sql .= " LEFT JOIN vehiculo_servicio VS ON S.cd_vehiculo_servicio = VS.cd_vehiculo_servicio ";

        $sql .= " LEFT JOIN usuario U ON S.cd_usuario = U.cd_usuario ";
        $sql .= " LEFT JOIN tipo_servicio TS ON S.cd_tipo_servicio = TS.cd_tipo_servicio ";
        $sql .= " LEFT JOIN cliente C ON C.cd_cliente = S.cd_cliente ";

        $sql .= " LEFT JOIN sucursal SU ON S.cd_sucursal = SU.cd_sucursal ";
        $sql .= $criterio->buildWHERE();



        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $suma = $db->sql_fetchassoc($result);
        return $suma['total_servicios'];
    }



    static function getCantServicios(CriterioBusqueda $criterio) {
        $db = DbManager::getConnection();

        $sql .= "SELECT count(*) as count1 FROM servicio S ";
        $sql .= " LEFT JOIN vehiculo_servicio VS ON S.cd_vehiculo_servicio = VS.cd_vehiculo_servicio ";

        $sql .= " LEFT JOIN usuario U ON S.cd_usuario = U.cd_usuario ";
        $sql .= " LEFT JOIN tipo_servicio TS ON S.cd_tipo_servicio = TS.cd_tipo_servicio ";
        $sql .= " LEFT JOIN cliente C ON C.cd_cliente = S.cd_cliente ";

        $sql .= " LEFT JOIN sucursal SU ON S.cd_sucursal = SU.cd_sucursal ";

        $sql .= $criterio->buildFiltroSinPaginar();


        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $next = $db->sql_fetchassoc($result);
        $cant = $next['count1'];
        $db->sql_freeresult($result);
        return ((int) $cant);
    }

    static function getServicio(CriterioBusqueda $criterio) {
        $db = DbManager::getConnection();
        $sql = "SELECT S.*, VS.*, TS.*,SU.*, U.*, C.cd_cliente, C.nu_doc, C.cd_tipodoc, C.ds_apynom as cliente_ds_apynom, C.ds_telparticular,C.ds_dircalle, C.ds_dirnro, C.ds_dirpiso, C.ds_dirdepto FROM servicio S";


        $sql .= " LEFT JOIN vehiculo_servicio VS ON S.cd_vehiculo_servicio = VS.cd_vehiculo_servicio ";

        $sql .= " LEFT JOIN usuario U ON S.cd_usuario = U.cd_usuario ";
        $sql .= " LEFT JOIN tipo_servicio TS ON S.cd_tipo_servicio = TS.cd_tipo_servicio ";
        $sql .= " LEFT JOIN cliente C ON C.cd_cliente = S.cd_cliente ";

        $sql .= " LEFT JOIN sucursal SU ON S.cd_sucursal = SU.cd_sucursal ";
        $sql .= $criterio->buildWHERE();

        $sql .= $criterio->buildORDERBY();
        $sql .= $criterio->buildLIMIT();

        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());
        if ($db->sql_numrows() > 0) {
            $temp = $db->sql_fetchassoc($result);
            $factory = new ServicioFactory();
            $servicio = $factory->build($temp);
        }
        $db->sql_freeresult($result);
        return $servicio;
    }

    static function modificarServicio(Servicio $obj) {
        $db = DbManager::getConnection();

        $cd_servicio = $obj->getCd_servicio();
        $nu_monto = $obj->getNu_monto();
       // $dt_carga = $obj->getDt_carga();
        $ds_obsgral = $obj->getDs_obsgral();
        $ds_descpedidocte = $obj->getDs_descpedidocte();
        $cd_vehiculoservicio = FormatUtils::ifEmpty($obj->getCd_vehiculoservicio(), 'null');
        $ds_kmshoras = $obj->getDs_kmshoras();
        $cd_tiposervicio = FormatUtils::ifEmpty($obj->getCd_tiposervicio(), 'null');
        $cd_usuario = FormatUtils::ifEmpty($obj->getCd_usuario(), 'null');
        $cd_cliente = FormatUtils::ifEmpty($obj->getCd_cliente(), 'null');
		$dt_ingresovehiculo = $obj->getDt_ingresovehiculo();
		$ds_diagyreprealizada = $obj->getDs_diagyreprealizada();
		$ds_repuestosusados = $obj->getDs_repuestosusados();
		$ds_mecanicos = $obj->getDs_mecanicos();
		$ds_instmedusados = $obj->getDs_instmedusados();
		$ds_tiempomanoobra = $obj->getDs_tiempomanoobra();
		$dt_compromisoentrega = $obj->getDt_compromisoentrega();
		 $bl_pagado = $obj->getBl_pagado();
		$cd_sucursal = FormatUtils::ifEmpty($obj->getCd_sucursal(), 'null');
        $sql = "UPDATE servicio SET nu_monto = '$nu_monto', ds_descpedidocte = '$ds_descpedidocte', cd_vehiculo_servicio = '$cd_vehiculoservicio', cd_tipo_servicio = '$cd_tiposervicio', ";
        $sql .= "cd_usuario = '$cd_usuario', cd_cliente = '$cd_cliente', ds_obsgral = '$ds_obsgral', ds_kmshoras = '$ds_kmshoras', dt_ingresovehiculo = '$dt_ingresovehiculo', ds_diagyreprealizada = '$ds_diagyreprealizada', ds_repuestosusados = '$ds_repuestosusados', ds_mecanicos = '$ds_mecanicos', ds_instmedusados = '$ds_instmedusados', ds_tiempomanoobra = '$ds_tiempomanoobra', dt_compromisoentrega = '$dt_compromisoentrega', bl_pagado = '$bl_pagado', cd_sucursal = $cd_sucursal";
        $sql .= " WHERE cd_servicio = " . $cd_servicio;
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());
    }

    static function eliminarServicio(Servicio $obj) {
        $db = DbManager::getConnection();
        $cd_servicio = $obj->getCd_servicio();
        $sql = "DELETE FROM servicio WHERE cd_servicio = $cd_servicio";
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());
    }

}
?>
