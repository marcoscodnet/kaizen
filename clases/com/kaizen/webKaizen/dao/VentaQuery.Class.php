<?php

/**
 * Acceso a datos para ventas.
 *
 * @author Lucrecia
 * @since 18-03-10
 *
 */
class VentaQuery {

    static function insertVenta(Venta $obj) {
        $db = DbManager::getConnection();

        $cd_venta = FormatUtils::ifEmpty($obj->getCd_venta(), 'null');
        $nu_totalventa = $obj->getNu_totalventa();
        $dt_venta = $obj->getDt_fecha();
        $nu_montosugerido = $obj->getNu_montosugerido();
        $cd_unidad = FormatUtils::ifEmpty($obj->getCd_unidad(), 'null');
        $cd_sucursal = FormatUtils::ifEmpty($obj->getCd_sucursal(), 'null');
        $cd_usuario = FormatUtils::ifEmpty($obj->getCd_usuario(), 'null');
        $cd_cliente = FormatUtils::ifEmpty($obj->getCd_cliente(), 'null');
        $ds_observacion = $obj->getDs_observacion();
        $cd_formapago = FormatUtils::ifEmpty($obj->getCd_formapago(), 'null');

        $sql = "INSERT INTO venta (cd_venta, nu_total, dt_venta, nu_montosugerido, cd_unidad, cd_sucursal, cd_usuario, cd_cliente, ds_observacion, cd_formapago)";
        $sql .= " VALUES ($cd_venta, '$nu_totalventa', '$dt_venta', '$nu_montosugerido', $cd_unidad, $cd_sucursal, $cd_usuario, $cd_cliente, '$ds_observacion', $cd_formapago)";
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());
        $id = VentaQuery::insert_id($db);
        $obj->setCd_venta($id);
    }

    static function insertPagosDeVenta(Venta $obj, ItemCollection $pagos) {
        $db = DbManager::getConnection();
        $cd_venta = $obj->getCd_venta();
        $sql = "";
        foreach ($pagos as $pago) {
            $nu_importe = $pago->getNu_importe();
            $nu_pagado = FormatUtils::ifEmpty($pago->getNu_pagado(), 0);
            $ds_detalle = $pago->getDs_detalle();
            $cd_entidad = $pago->getCd_entidad();
            $ds_observacion = $pago->getDs_observacion();
            $pago->setDt_pago(str_replace("-", "/", $pago->getDt_pago()));
            $dt_pagado = implode("-", array_reverse(explode("/", $pago->getDt_pago())));
            //dt_contadora
            /*$pago->setDt_contadora(str_replace("-", "/", $pago->getDt_contadora()));
            $dt_contadora = implode("-", array_reverse(explode("/", $pago->getDt_contadora())));*/
            $dt_contadora = FormatUtils::formatDate($pago->getDt_contadora());

            $sql = " INSERT INTO itempago (cd_venta, nu_importe,nu_pagado, cd_entidad, ds_detalle, ds_observacion, dt_pagado, dt_contadora)";
            $sql .= " VALUES ($cd_venta, '$nu_importe',$nu_pagado, $cd_entidad, '$ds_detalle', '$ds_observacion', '$dt_pagado', $dt_contadora);";

            $result = $db->sql_query($sql);
        }


        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());
    }

    static function insert_id($db) {
        $db = DbManager::getConnection();
        $sql = "SELECT MAX(`cd_venta`) as id FROM venta ";
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException();
        $next = $db->sql_fetchassoc($result);
        $id = $next['id'];
        $db->sql_freeresult($result);
        return ($id );
    }

    static function getVentas(CriterioBusqueda $criterio) {
        $db = DbManager::getConnection();
        $sql = "SELECT A.*, V.*, S.*,P.*, TU.*, MA.*, M.*,CO.*, U.*, UN.*, C.cd_cliente, C.nu_doc, C.cd_tipodoc, C.ds_apynom as cliente_ds_apynom, SUM(IP.nu_pagado) as importeencreditos, FP.* FROM venta V";
        $sql .= " LEFT JOIN unidad UN ON V.cd_unidad = UN.cd_unidad ";
        $sql .= " LEFT JOIN producto P ON P.cd_producto = UN.cd_producto ";
        $sql .= " LEFT JOIN tipo_unidad TU ON P.cd_tipo_unidad = TU.cd_tipo_unidad ";
        $sql .= " LEFT JOIN marca MA ON MA.cd_marca = P.cd_marca ";
        $sql .= " LEFT JOIN modelo M ON M.cd_modelo=P.cd_modelo ";
        $sql .= " LEFT JOIN color CO ON CO.cd_color=P.cd_color ";
        $sql .= " LEFT JOIN autorizacion A ON A.cd_unidad = UN.cd_unidad ";
        $sql .= " LEFT JOIN usuario U ON V.cd_usuario = U.cd_usuario ";
        $sql .= " LEFT JOIN sucursal S ON S.cd_sucursal = V.cd_sucursal ";
        $sql .= " LEFT JOIN cliente C ON C.cd_cliente = V.cd_cliente ";
        $sql .= " LEFT JOIN itempago IP ON IP.cd_venta = V.cd_venta ";
        $sql .= " LEFT JOIN formapago FP ON FP.cd_formapago = V.cd_formapago ";
        $sql .= $criterio->buildWHERE();
        $sql .= " GROUP BY V.cd_venta,A.cd_autorizacion,S.ds_nombre,S.ds_domicilio,S.ds_telefono,S.ds_email,S.ds_comentario,S.cd_localidad";
        $sql .= $criterio->buildORDERBY();
        $sql .= $criterio->buildLIMIT();

        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $ventas = ResultFactory::toCollection($db, $result, new VentaFactory());
        $db->sql_freeresult($result);

        return $ventas;
    }

    static function getImporteTotalEnVentas(CriterioBusqueda $criterio) {
        $suma = 0;
        $db = DbManager::getConnection();
        $sql = "SELECT SUM(V.nu_total) as total_ventas FROM venta V";
        $sql .= " LEFT JOIN unidad UN ON V.cd_unidad = UN.cd_unidad ";
        $sql .= " LEFT JOIN producto P ON P.cd_producto = UN.cd_producto ";
        $sql .= " LEFT JOIN tipo_unidad TU ON P.cd_tipo_unidad = TU.cd_tipo_unidad ";
        $sql .= " LEFT JOIN marca MA ON MA.cd_marca = P.cd_marca ";
        $sql .= " LEFT JOIN modelo M ON M.cd_modelo=P.cd_modelo ";
        $sql .= " LEFT JOIN color CO ON CO.cd_color=P.cd_color ";
        $sql .= " LEFT JOIN autorizacion A ON A.cd_unidad = UN.cd_unidad ";
        $sql .= " LEFT JOIN usuario U ON V.cd_usuario = U.cd_usuario ";
        $sql .= " LEFT JOIN sucursal S ON S.cd_sucursal = V.cd_sucursal ";
        $sql .= " LEFT JOIN cliente C ON C.cd_cliente = V.cd_cliente ";
        $sql .= $criterio->buildWHERE();
        $sql .= $criterio->buildORDERBY();
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $suma = $db->sql_fetchassoc($result);
        return $suma['total_ventas'];
    }

    static function getImporteAcreditadoEnVentasContado(CriterioBusqueda $criterio) {
        $suma = 0;
        $db = DbManager::getConnection();
        $sql = "SELECT SUM(IP.nu_pagado) as total_acreditado FROM venta V";
        $sql .= " LEFT JOIN unidad UN ON V.cd_unidad = UN.cd_unidad ";
        $sql .= " LEFT JOIN producto P ON P.cd_producto = UN.cd_producto ";
        $sql .= " LEFT JOIN tipo_unidad TU ON P.cd_tipo_unidad = TU.cd_tipo_unidad ";
        $sql .= " LEFT JOIN marca MA ON MA.cd_marca = P.cd_marca ";
        $sql .= " LEFT JOIN modelo M ON M.cd_modelo=P.cd_modelo ";
        $sql .= " LEFT JOIN color CO ON CO.cd_color=P.cd_color ";
        $sql .= " LEFT JOIN autorizacion A ON A.cd_unidad = UN.cd_unidad ";
        $sql .= " LEFT JOIN usuario U ON V.cd_usuario = U.cd_usuario ";
        $sql .= " LEFT JOIN sucursal S ON S.cd_sucursal = V.cd_sucursal ";
        $sql .= " LEFT JOIN cliente C ON C.cd_cliente = V.cd_cliente ";
        $sql .= " LEFT JOIN itempago IP ON IP.cd_venta = V.cd_venta ";
        $sql .= $criterio->buildWHERE();
        $sql .= $criterio->buildORDERBY();
        //$sql .= " WHERE UN.cd_unidad IN (SELECT A.cd_unidad FROM autorizacion A)";
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $suma = $db->sql_fetchassoc($result);
        return $suma['total_acreditado'];
    }

    static function getImporteAcreditadoEnVentas(CriterioBusqueda $criterio) {
        $suma = 0;
        $db = DbManager::getConnection();
        $sql = "SELECT SUM(IP.nu_pagado) as total_acreditado FROM venta V";
        $sql .= " LEFT JOIN unidad UN ON V.cd_unidad = UN.cd_unidad ";
        $sql .= " LEFT JOIN producto P ON P.cd_producto = UN.cd_producto ";
        $sql .= " LEFT JOIN tipo_unidad TU ON P.cd_tipo_unidad = TU.cd_tipo_unidad ";
        $sql .= " LEFT JOIN marca MA ON MA.cd_marca = P.cd_marca ";
        $sql .= " LEFT JOIN modelo M ON M.cd_modelo=P.cd_modelo ";
        $sql .= " LEFT JOIN color CO ON CO.cd_color=P.cd_color ";
        $sql .= " LEFT JOIN autorizacion A ON A.cd_unidad = UN.cd_unidad ";
        $sql .= " LEFT JOIN usuario U ON V.cd_usuario = U.cd_usuario ";
        $sql .= " LEFT JOIN sucursal S ON S.cd_sucursal = V.cd_sucursal ";
        $sql .= " LEFT JOIN cliente C ON C.cd_cliente = V.cd_cliente ";
        $sql .= " LEFT JOIN itempago IP ON IP.cd_venta = V.cd_venta ";
        $sql .= $criterio->buildWHERE();
        $sql .= $criterio->buildORDERBY();
        //$sql .= " WHERE UN.cd_unidad IN (SELECT A.cd_unidad FROM autorizacion A)";
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $suma = $db->sql_fetchassoc($result);
        return $suma['total_acreditado'];
    }

    static function getCantVentas(CriterioBusqueda $criterio) {
        $db = DbManager::getConnection();
        $sql = "SELECT count(*) as count1 FROM (";
        $sql .= "SELECT count(*) as count2 FROM venta V ";
        $sql .= " LEFT JOIN unidad UN ON V.cd_unidad = UN.cd_unidad ";
        $sql .= " LEFT JOIN producto P ON P.cd_producto = UN.cd_producto ";
        $sql .= " LEFT JOIN tipo_unidad TU ON P.cd_tipo_unidad = TU.cd_tipo_unidad ";
        $sql .= " LEFT JOIN marca MA ON MA.cd_marca = P.cd_marca ";
        $sql .= " LEFT JOIN modelo M ON M.cd_modelo=P.cd_modelo ";
        $sql .= " LEFT JOIN color CO ON CO.cd_color=P.cd_color ";
        $sql .= " LEFT JOIN autorizacion A ON A.cd_unidad = UN.cd_unidad ";
        $sql .= " LEFT JOIN usuario U ON V.cd_usuario = U.cd_usuario ";
        $sql .= " LEFT JOIN sucursal S ON S.cd_sucursal = V.cd_sucursal ";
        $sql .= " LEFT JOIN cliente C ON C.cd_cliente = V.cd_cliente ";
        $sql .= " LEFT JOIN itempago IP ON IP.cd_venta = V.cd_venta ";
        $sql .= " LEFT JOIN formapago FP ON FP.cd_formapago = V.cd_formapago ";

        $sql .= $criterio->buildFiltroSinPaginar();
        $sql .= " GROUP BY V.cd_venta";
        $sql .= " ) as listado ";

        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $next = $db->sql_fetchassoc($result);
        $cant = $next['count1'];
        $db->sql_freeresult($result);
        return ((int) $cant);
    }

    static function getVenta(CriterioBusqueda $criterio) {
        $db = DbManager::getConnection();
        $sql = "SELECT V.*, TU.*, MA.*, M.*, CO.*, S.*, TD.*, L.*,EC.*, PRO.*, PA.*, SUM(IP.nu_importe) as importeencreditos, FP.*, ";
        $sql .= " UN.cd_unidad, UN.nu_motor,UN.cd_producto, UN.nu_cuadro, UN.nu_envio, UN.nu_envio, UN.nu_aniomodelo, ";
        $sql .= "C.ds_apynom as cliente_ds_apynom,C.nu_doc, C.dt_nacimiento, C.ds_conyuge, C.ds_nacionalidad, C.ds_telparticular, C.ds_tellaboral, ";
        $sql .= "C.ds_dircalle, C.ds_dirnro, C.ds_dirpiso, C.ds_dirdepto, C.cd_tipodoc, C.cd_estadocivil, C.cd_localidad, C.ds_cp, C.ds_email, ";
        $sql .= "U.ds_nomusuario, U.ds_apynom, U.ds_mail, U.ds_password, U.cd_sucursal as cd_sucursalUsuario, U.cd_perfil,";
        $sql .= "LS.cd_localidad as cd_localidad_sucursal, LS.ds_localidad as ds_localidad_sucursal,LS.cd_provincia as cd_provincia_sucursal, ";
        $sql .= "A.dt_autorizacion, A.cd_autorizacion FROM venta V";
        $sql .= " INNER JOIN unidad UN ON V.cd_unidad = UN.cd_unidad ";
        $sql .= " INNER JOIN producto P ON UN.cd_producto = P.cd_producto ";
        $sql .= " INNER JOIN tipo_unidad TU ON P.cd_tipo_unidad = TU.cd_tipo_unidad ";
        $sql .= " INNER JOIN marca MA ON P.cd_marca = MA.cd_marca ";
        $sql .= " INNER JOIN modelo M ON P.cd_modelo = M.cd_modelo ";
        $sql .= " INNER JOIN color CO ON P.cd_color = CO.cd_color ";
        $sql .= " LEFT JOIN autorizacion A ON A.cd_unidad = UN.cd_unidad ";
        $sql .= " INNER JOIN usuario U ON V.cd_usuario = U.cd_usuario ";
        $sql .= " LEFT JOIN sucursal S ON S.cd_sucursal = V.cd_sucursal ";
        $sql .= " LEFT JOIN cliente C ON C.cd_cliente = V.cd_cliente ";
        $sql .= " LEFT JOIN estadocivil EC ON C.cd_estadocivil = EC.cd_estadocivil ";
        $sql .= " LEFT JOIN localidad L ON C.cd_localidad = L.cd_localidad ";
        $sql .= " LEFT JOIN localidad LS ON S.cd_localidad = LS.cd_localidad ";
        $sql .= " LEFT JOIN provincia PRO ON PRO.cd_provincia = L.cd_provincia ";
        $sql .= " LEFT JOIN pais PA ON PRO.cd_pais = PA.cd_pais ";
        $sql .= " LEFT JOIN tipodoc TD ON C.cd_tipodoc = TD.cd_tipodoc ";
        $sql .= " LEFT JOIN itempago IP ON IP.cd_venta = V.cd_venta ";
        $sql .= " LEFT JOIN formapago FP ON FP.cd_formapago = V.cd_formapago ";
        $sql .= $criterio->buildWHERE();
        $sql .= " GROUP BY V.cd_venta,S.ds_nombre,S.ds_domicilio,S.ds_telefono,S.ds_email,S.ds_comentario,S.cd_localidad,A.dt_autorizacion,A.cd_autorizacion";
        $sql .= $criterio->buildORDERBY();
        $sql .= $criterio->buildLIMIT();

        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());
        if ($db->sql_numrows() > 0) {
            $temp = $db->sql_fetchassoc($result);
            $factory = new VentaFactory();
            $venta = $factory->build($temp);
        }
        $db->sql_freeresult($result);
        return $venta;
    }

    static function modificarVenta(Venta $obj) {
        $db = DbManager::getConnection();

        $cd_venta = $obj->getCd_venta();
        $nu_totalventa = $obj->getNu_totalventa();
        //$dt_venta = $obj->getDt_fecha();
        $ds_observacion = $obj->getDs_observacion();
        $nu_montosugerido = $obj->getNu_montosugerido();
        $cd_unidad = FormatUtils::ifEmpty($obj->getCd_unidad(), 'null');
        $cd_formapago = FormatUtils::ifEmpty($obj->getCd_formapago(), 'null');
        $cd_sucursal = FormatUtils::ifEmpty($obj->getCd_sucursal(), 'null');
        $cd_usuario = FormatUtils::ifEmpty($obj->getCd_usuario(), 'null');
        $cd_cliente = FormatUtils::ifEmpty($obj->getCd_cliente(), 'null');

        //$sql = "UPDATE venta SET nu_total = '$nu_totalventa', dt_venta = '$dt_venta', nu_montosugerido = '$nu_montosugerido', cd_unidad = '$cd_unidad', cd_sucursal = '$cd_sucursal', ";
        $sql = "UPDATE venta SET nu_total = '$nu_totalventa', nu_montosugerido = '$nu_montosugerido', cd_unidad = '$cd_unidad', cd_sucursal = '$cd_sucursal', ";
        $sql .= "cd_usuario = '$cd_usuario', cd_cliente = '$cd_cliente', ds_observacion = '$ds_observacion', cd_formapago = '$cd_formapago'";
        $sql .= " WHERE cd_venta = " . $cd_venta;
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());
    }

    static function eliminarVenta(Venta $obj) {
        $db = DbManager::getConnection();
        $cd_venta = $obj->getCd_venta();
        $sql = "DELETE FROM venta WHERE cd_venta = $cd_venta";
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());
    }

}
?>
