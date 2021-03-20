<?php

/**
 * Acceso a datos para ventas de piezas.
 *
 * @author Mar�a Jes�s
 * @since 16-11-2011
 *
 */
class VentaPiezaQuery {

    static function insertVentaPieza(VentaPieza $obj) {
        $db = DbManager::getConnection();

        $nu_preciocobrado = FormatUtils::ifEmpty($obj->getNu_precioCobrado(), '0');
        $nu_preciomin = FormatUtils::ifEmpty($obj->getNu_precioMin(), '0');
        $ds_apynomcliente = $obj->getDs_apynomCliente();
        $nu_docCliente = $obj->getNu_docCliente();
        $ds_telcliente = $obj->getDs_telCliente();
        $ds_motoCliente = $obj->getDs_motoCliente();
        $cd_sucursal = FormatUtils::ifEmpty($obj->getCd_sucursal(), '0');
        $nu_pedidoreparacion = FormatUtils::ifEmpty($obj->getNu_pedidoReparacion(), '0');
        $dt_ventapieza = $obj->getDt_ventapieza();
        $ds_descripcion = $obj->getDs_descripcion();
        $nu_destino = FormatUtils::ifEmpty($obj->getNu_destino(), '0');
		$cd_usuario = FormatUtils::ifEmpty($obj->getUsuario()->getCd_usuario(), '0');
        $sql = "INSERT INTO ventapieza (nu_preciocobrado, nu_preciomin, ds_apynomcliente, nu_docCliente, ds_telcliente, ds_motocliente, cd_sucursal, nu_pedidoreparacion, dt_ventapieza, ds_descripcion, nu_destino, cd_usuario)";
        $sql .= " VALUES ('$nu_preciocobrado', '$nu_preciomin', '$ds_apynomcliente', '$nu_docCliente', '$ds_telcliente', '$ds_motoCliente', '$cd_sucursal', '$nu_pedidoreparacion', '$dt_ventapieza', '$ds_descripcion','$nu_destino','$cd_usuario')";
       
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());
        $id = VentaPiezaQuery::insert_id($db);
        $obj->setCd_ventapieza($id);
    }

    static function insert_id($db) {
        $db = DbManager::getConnection();
        $sql = "SELECT MAX(`cd_ventapieza`) as id FROM ventapieza ";
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException();
        $next = $db->sql_fetchassoc($result);
        $id = $next['id'];
        $db->sql_freeresult($result);
        return ($id );
    }

    static function getVentasPiezas(CriterioBusqueda $criterio) {
        $db = DbManager::getConnection();
        $sql = "SELECT VP.*, S.*, U.*, SUM(qt_montoacobrar) as nu_monto, GROUP_CONCAT(P.ds_codigo) as group_piezas FROM ventapieza VP";
        $sql .= " LEFT JOIN sucursal S ON S.cd_sucursal = VP.cd_sucursal ";
        $sql .= " LEFT JOIN usuario U ON VP.cd_usuario = U.cd_usuario ";
        $sql .= " LEFT JOIN ventapieza_unidad VPU ON VP.cd_ventapieza = VPU.cd_ventapieza ";
        $sql .= " LEFT JOIN pieza P ON P.cd_pieza = VPU.cd_pieza ";
        $sql .= $criterio->buildFiltro();
		
        $nombreFile=date('Ymd');

				$_Log = fopen(APP_PATH."logs/".$nombreFile.".log", "a+") or die("Operation Failed!");

				FuncionesComunes::_log($_SESSION['ds_usuario'].': '.$sql,$_Log);

				
        
		$result = $db->sql_query ( $sql );
		//FuncionesComunes::_log($_SESSION['ds_usuario'].': '.$result,$_Log);
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

        $ventaspiezas = ResultFactory::toCollection($db, $result, new VentaPiezaFactory());
        $db->sql_freeresult($result);
		
        fclose($_Log); 
        return $ventaspiezas;
    }

   static function getCantVentasPiezas(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT count(*) as count FROM ventapieza VP";
        $sql .= " LEFT JOIN sucursal S ON S.cd_sucursal = VP.cd_sucursal ";
        $sql .= " LEFT JOIN usuario U ON VP.cd_usuario = U.cd_usuario ";
        $sql .= " LEFT JOIN ventapieza_unidad VPU ON VP.cd_ventapieza = VPU.cd_ventapieza ";
        $sql .= " LEFT JOIN pieza P ON P.cd_pieza = VPU.cd_pieza ";
		$sql .= $criterio->buildFiltroSinPaginar();
		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$next = $db->sql_fetchassoc($result);
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return ((int) $cant);
	}

	static function eliminarVentaPieza(VentaPieza $obj) {
		$db = DbManager::getConnection();
		$cd_ventapieza = $obj->getCd_ventapieza();
		$sql = "DELETE FROM ventapieza WHERE cd_ventapieza = $cd_ventapieza";

		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

	static function getVentaPieza(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT VP.*, S.*, U.* FROM ventapieza VP";
        $sql .= " LEFT JOIN sucursal S ON S.cd_sucursal = VP.cd_sucursal ";
        $sql .= " LEFT JOIN usuario U ON VP.cd_usuario = U.cd_usuario ";
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query($sql);
		
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$ventapieza = new VentaPieza();
		if ($db->sql_numrows() > 0) {
			$temp = $db->sql_fetchassoc($result);
			$factory = new VentaPiezaFactory();
			$ventapieza = $factory->build($temp);
		}
		$db->sql_freeresult($result);
		return $ventapieza;
	}

	static function modificarVentaPieza(VentaPieza $obj) {
		$db = DbManager::getConnection();
		$cd_ventapieza = FormatUtils::ifEmpty($obj->getCd_ventapieza(), 'null');
		$nu_preciocobrado = FormatUtils::ifEmpty($obj->getNu_precioCobrado(), 'null');
        $nu_preciomin = FormatUtils::ifEmpty($obj->getNu_precioMin(), 'null');
        $ds_apynomcliente = $obj->getDs_apynomCliente();
        $nu_docCliente = FormatUtils::ifEmpty($obj->getNu_docCliente(), 'null');
        $ds_telcliente = $obj->getDs_telCliente();
        $ds_motocliente = $obj->getDs_motoCliente();
        $cd_sucursal = FormatUtils::ifEmpty($obj->getCd_sucursal(), 'null');
        $nu_pedidoreparacion = FormatUtils::ifEmpty($obj->getNu_pedidoReparacion(), 'null');
        $dt_ventapieza = implode("-", array_reverse(explode("-", $obj->getDt_ventapieza())));
        $ds_descripcion = $obj->getDs_descripcion();
        $nu_destino = FormatUtils::ifEmpty($obj->getNu_destino(), 'null');
        $cd_usuario = FormatUtils::ifEmpty($obj->getUsuario()->getCd_usuario(), 'null');
		$sql = "UPDATE ventapieza SET nu_preciocobrado = '$nu_preciocobrado', nu_preciomin = '$nu_preciomin', ds_apynomcliente = '$ds_apynomcliente', 
		nu_docCliente = '$nu_docCliente', ds_telcliente = '$ds_telcliente', ds_motocliente = '$ds_motocliente', cd_sucursal = '$cd_sucursal',
		nu_pedidoreparacion = '$nu_pedidoreparacion', dt_ventapieza = '$dt_ventapieza', ds_descripcion = '$ds_descripcion', nu_destino = '$nu_destino', cd_usuario = '$cd_usuario'";
		$sql .= " WHERE cd_ventapieza = " . $cd_ventapieza;

		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}
    
}
?>