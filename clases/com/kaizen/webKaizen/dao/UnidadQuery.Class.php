<?php

/**
 * Acceso a datos para unidad.
 *
 * @author Lucrecia
 * @since 18-03-10
 *
 */
class UnidadQuery {

	static function insertUnidad(Unidad $obj) {
		$db = DbManager::getConnection();

		$cd_producto = FormatUtils::ifEmpty($obj->getProducto()->getCd_producto(), 'null');
		$cd_sucursal = FormatUtils::ifEmpty($obj->getSucursalactual()->getCd_sucursal(), 'null');
		$nu_motor = $obj->getNu_motor();
		$nu_cuadro = $obj->getNu_cuadro();
		$dt_ingreso = implode("-", array_reverse(explode("-", $obj->getDt_ingreso())));
		$nu_patente = $obj->getNu_patente();
		$nu_remitoingreso = $obj->getNu_remitoingreso();
		$nu_aniomodelo = $obj->getNu_aniomodelo();
		$ds_observacion = $obj->getDs_observacion();
		$nu_envio = $obj->getNu_envio();

		$sql = "INSERT INTO unidad (cd_producto, cd_sucursal_actual, nu_motor, nu_cuadro, dt_ingreso, nu_patente, nu_remito_ingreso, nu_aniomodelo, ds_observacion, nu_envio)";
		$sql .= " VALUES ('$cd_producto', '$cd_sucursal', '$nu_motor', '$nu_cuadro', '$dt_ingreso', '$nu_patente', '$nu_remitoingreso', '$nu_aniomodelo', '$ds_observacion','$nu_envio')";

		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

	static function estaAutorizada($oUnidad) {
		$db = DbManager::getConnection();
		$cd_unidad = $oUnidad->getCd_unidad();
		$sql = "SELECT count(*) as count FROM unidad U ";
		$sql .= " INNER JOIN autorizacion A ON A.cd_unidad = U.cd_unidad ";
		$sql .= " WHERE A.cd_unidad = $cd_unidad ";                
		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$next = $db->sql_fetchassoc($result);
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return ($cant > 0);
	}

	static function estaVendida($oUnidad) {
                $cd_unidad = $oUnidad->getCd_unidad();
		$db = DbManager::getConnection();
		$sql = "SELECT count(*) as count FROM unidad U ";
		$sql .= " INNER JOIN venta VU ON VU.cd_unidad = U.cd_unidad ";
                $sql .= " WHERE U.cd_unidad = $cd_unidad";
		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$next = $db->sql_fetchassoc($result);
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return ($cant > 0);
	}

	static function autorizarUnidad(Unidad $obj) {
		$db = DbManager::getConnection();

		$cd_unidad = FormatUtils::ifEmpty($obj->getCd_unidad(), 'null');
		$dt_autorizacion = date('Y-m-d');
		$cd_usuario = $_SESSION['cd_usuarioSession'];

		$sql = "INSERT INTO autorizacion (cd_unidad, cd_usuario, dt_autorizacion)";
		$sql .= " VALUES ('$cd_unidad', '$cd_usuario', '$dt_autorizacion')";

		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

	static function desautorizarUnidad(Unidad $obj) {
		$db = DbManager::getConnection();
		$cd_unidad = $obj->getCd_unidad();
		$sql = "DELETE FROM autorizacion WHERE cd_unidad = $cd_unidad";
		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

	static function getUnidades(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();

		$sql = "SELECT U.cd_unidad as id, U.*, P.*, TU.*, MA.*, M.*,C.*, S.*, VU.cd_venta,A.*,  CONCAT(TU.ds_tipo_unidad, ' ', MA.ds_marca, ' ', M.ds_modelo, ' ', C.ds_color) as ds_producto FROM unidad U";
		$sql .= " LEFT JOIN producto P ON P.cd_producto = U.cd_producto ";
		$sql .= " LEFT JOIN tipo_unidad TU ON P.cd_tipo_unidad = TU.cd_tipo_unidad ";
		$sql .= " LEFT JOIN marca MA ON MA.cd_marca = P.cd_marca ";
		$sql .= " LEFT JOIN modelo M ON M.cd_modelo=P.cd_modelo ";
		$sql .= " LEFT JOIN color C ON C.cd_color=P.cd_color ";
		$sql .= " LEFT JOIN sucursal S ON S.cd_sucursal = U.cd_sucursal_actual ";
		$sql .= " LEFT JOIN venta_unidad VU ON VU.cd_unidad = U.cd_unidad ";
		$sql .= " LEFT JOIN autorizacion A ON A.cd_unidad = U.cd_unidad ";
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query($sql);

		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$unidades = ResultFactory::toCollection($db, $result, new UnidadFactory());
		$db->sql_freeresult($result);

		return $unidades;
	}

	static function getCantUnidades(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT count(*) as count FROM unidad U ";
		$sql .= " LEFT JOIN producto P ON P.cd_producto = U.cd_producto ";
		$sql .= " LEFT JOIN tipo_unidad TU ON P.cd_tipo_unidad = TU.cd_tipo_unidad ";
		$sql .= " LEFT JOIN marca MA ON MA.cd_marca = P.cd_marca ";
		$sql .= " LEFT JOIN modelo M ON M.cd_modelo=P.cd_modelo ";
		$sql .= " LEFT JOIN color C ON C.cd_color=P.cd_color ";
		$sql .= " LEFT JOIN sucursal S ON S.cd_sucursal = U.cd_sucursal_actual ";
		$sql .= " LEFT JOIN venta_unidad VU ON VU.cd_unidad = U.cd_unidad ";
		$sql .= " LEFT JOIN autorizacion A ON A.cd_unidad = U.cd_unidad ";
		$sql .= $criterio->buildFiltroSinPaginar();
		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$next = $db->sql_fetchassoc($result);
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return ((int) $cant);
	}

	static function eliminarUnidad(Unidad $obj) {
		$db = DbManager::getConnection();
		$cd_unidad = $obj->getCd_unidad();
		$sql = "DELETE FROM unidad WHERE cd_unidad = $cd_unidad";

		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

	static function getUnidad(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT U.cd_unidad as id, U.*, P.*, TU.*, MA.*, M.*, C.*, S.*, VU.*, A.*, US.ds_nomusuario FROM unidad U";
		$sql .= " INNER JOIN producto P ON P.cd_producto = U.cd_producto ";
		$sql .= " LEFT JOIN tipo_unidad TU ON P.cd_tipo_unidad = TU.cd_tipo_unidad ";
		$sql .= " LEFT JOIN marca MA ON MA.cd_marca = P.cd_marca ";
		$sql .= " LEFT JOIN modelo M ON M.cd_modelo=P.cd_modelo ";
		$sql .= " LEFT JOIN color C ON C.cd_color=P.cd_color ";
		$sql .= " LEFT JOIN sucursal S ON S.cd_sucursal = U.cd_sucursal_actual ";
		$sql .= " LEFT JOIN venta_unidad VU ON VU.cd_unidad = U.cd_unidad ";
		$sql .= " LEFT JOIN autorizacion A ON A.cd_unidad = U.cd_unidad ";
		$sql .= " LEFT JOIN usuario US ON A.cd_usuario = US.cd_usuario ";
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$unidad = new Unidad();
		if ($db->sql_numrows() > 0) {
			$temp = $db->sql_fetchassoc($result);
			$factory = new UnidadFactory();
			$unidad = $factory->build($temp);
		}
		$db->sql_freeresult($result);
		return $unidad;
	}

	static function esHonda($nu_motor) {
		$db = DbManager::getConnection();
		$sql = "SELECT count(*) as count FROM unidad U";
		$sql .= " INNER JOIN producto P ON P.cd_producto = U.cd_producto ";
		
		$sql .= " LEFT JOIN marca MA ON MA.cd_marca = P.cd_marca ";
		$sql .= " WHERE MA.cd_marca =  ".CD_MARCA_HONDA." AND U.nu_motor = '$nu_motor'";                
		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$next = $db->sql_fetchassoc($result);
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return ($cant > 0);
	}
	

	static function getNrosmotorDeProducto($oUnidad) {
		$db = DbManager::getConnection();
		$cd_producto = $oUnidad->getCd_producto();
		$cd_sucursal = $oUnidad->getCd_sucursalactual();
		$sql = "SELECT U.cd_unidad as id, U.nu_motor FROM unidad U ";
		$sql .= "WHERE U.cd_producto = $cd_producto AND U.cd_sucursal_actual = $cd_sucursal";
		$sql .= " AND U.cd_unidad NOT IN(SELECT V.cd_unidad FROM venta V)";
		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$unidades = ResultFactory::toCollection($db, $result, new UnidadFactory());
		$db->sql_freeresult($result);

		return $unidades;
	}

	static function getNroscuadrosDeProducto($oUnidad) {
		$db = DbManager::getConnection();
		$cd_producto = $oUnidad->getCd_producto();
		$cd_sucursal = $oUnidad->getCd_sucursalactual();
		$sql = "SELECT U.cd_unidad as id, U.nu_cuadro FROM unidad U ";
		$sql .= "WHERE U.cd_producto = $cd_producto AND U.cd_sucursal_actual = $cd_sucursal";
		$sql .= " AND U.cd_unidad NOT IN(SELECT V.cd_unidad FROM venta V )";

		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$unidades = ResultFactory::toCollection($db, $result, new UnidadFactory());
		$db->sql_freeresult($result);

		return $unidades;
	}


	static function getNroscuadroDeNromotor($oUnidad) {
		$db = DbManager::getConnection();
		$cd_producto = $oUnidad->getCd_producto();
		$sql = "SELECT U.cd_unidad as id, U.nu_cuadro FROM unidad U ";
		$sql .= "WHERE U.cd_producto = $cd_producto";

		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$unidades = ResultFactory::toCollection($db, $result, new UnidadFactory());
		$db->sql_freeresult($result);

		return $unidades;
	}

	static function modificarUnidad(Unidad $obj) {
		$db = DbManager::getConnection();
		$cd_unidad = $obj->getCd_unidad();
		$cd_producto = FormatUtils::ifEmpty($obj->getProducto()->getCd_producto(), 'null');
		$cd_sucursal_actual = FormatUtils::ifEmpty($obj->getSucursalactual()->getCd_sucursal(), 'null');
		$nu_motor = $obj->getNu_motor();
		$nu_cuadro = $obj->getNu_cuadro();
		$dt_ingreso = implode("-", array_reverse(explode("-", $obj->getDt_ingreso())));
		$nu_patente = $obj->getNu_patente();
		$nu_remitoingreso = $obj->getNu_remitoingreso();
		$nu_aniomodelo = $obj->getNu_aniomodelo();
		$ds_observacion = $obj->getDs_observacion();
		$nu_envio = $obj->getNu_envio();

		$sql = "UPDATE unidad SET cd_producto = '$cd_producto', cd_sucursal_actual = '$cd_sucursal_actual', nu_motor = '$nu_motor', nu_cuadro = '$nu_cuadro', dt_ingreso = '$dt_ingreso', ";
		$sql .= "nu_patente = '$nu_patente', nu_remito_ingreso = '$nu_remitoingreso', nu_aniomodelo = '$nu_aniomodelo', ds_observacion = '$ds_observacion', nu_envio = '$nu_envio'";
		$sql .= " WHERE cd_unidad = " . $cd_unidad;

		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}



	static function modificarSucursalDeUnidad(Unidad $obj) {
		$db = DbManager::getConnection();
		$cd_unidad = $obj->getCd_unidad();
		$cd_sucursal_actual = FormatUtils::ifEmpty($obj->getSucursalactual()->getCd_sucursal(), 'null');
		$sql = "UPDATE unidad SET cd_sucursal_actual = '$cd_sucursal_actual'";
		$sql .= " WHERE cd_unidad = " . $cd_unidad;
		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

}
?>