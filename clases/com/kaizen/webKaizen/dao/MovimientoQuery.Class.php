<?php

/**
 * Acceso a datos para movimiento.
 *
 * @author Lucrecia
 * @since 18-03-10
 *
 */
class MovimientoQuery {

	static function insertMovimiento(Movimiento $obj) {
		$db = DbManager::getConnection();

		$cd_sucursalorigen = FormatUtils::ifEmpty($obj->getCd_sucursalorigen(), 'null');
		$cd_sucursaldestino = FormatUtils::ifEmpty($obj->getCd_sucursaldestino(), 'null');
		$cd_usuario = FormatUtils::ifEmpty($obj->getCd_usuario(), 'null');
		$ds_observacion = $obj->getDs_observacion();
		$dt_movimiento = implode("-", array_reverse(explode("-", $obj->getDt_movimiento())));

		$sql = "INSERT INTO movimiento (cd_sucursal_origen, cd_sucursal_destino, dt_movimiento, ds_observacion, cd_usuario)";
		$sql .= " VALUES ('$cd_sucursalorigen', '$cd_sucursaldestino', '$dt_movimiento', '$ds_observacion', $cd_usuario)";

		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$id = MovimientoQuery::insert_id ( $db );
		$obj->setCd_movimiento( $id );
	}

	static function insert_id($db) {
		$db = DbManager::getConnection();
		$sql = "SELECT MAX(`cd_movimiento`) as id FROM movimiento ";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();
		$next = $db->sql_fetchassoc ( $result );
		$id = $next['id'];
		$db->sql_freeresult($result);
		return ($id );
	}

	static function getMovimientos(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();

		$sql = "SELECT M.*, SO.cd_sucursal as cd_sucursalorigen, SO.ds_nombre as ds_sucursalorigen, SD.cd_sucursal as cd_sucursaldestino,SD.ds_nombre as ds_sucursaldestino, U.* FROM movimiento M";
		$sql .= " LEFT JOIN sucursal SO ON SO.cd_sucursal = M.cd_sucursal_origen ";
		$sql .= " LEFT JOIN sucursal SD ON SD.cd_sucursal = M.cd_sucursal_destino ";
		$sql .= " LEFT JOIN usuario U ON U.cd_usuario = M.cd_usuario ";
		$sql .= $criterio->buildFiltro();


		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$movimientos = ResultFactory::toCollection($db, $result, new MovimientoFactory());
		$db->sql_freeresult($result);

		return $movimientos;
	}

	static function getCantMovimientos(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT count(*) as count FROM movimiento M ";
		$sql .= " LEFT JOIN sucursal SO ON SO.cd_sucursal = M.cd_sucursal_origen ";
		$sql .= " LEFT JOIN sucursal SD ON SD.cd_sucursal = M.cd_sucursal_destino ";
		$sql .= " LEFT JOIN usuario U ON U.cd_usuario = M.cd_usuario ";
		$sql .= $criterio->buildFiltroSinPaginar();
		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$next = $db->sql_fetchassoc($result);
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return ((int) $cant);
	}

	static function eliminarMovimiento(Movimiento $obj) {
		$db = DbManager::getConnection();
		$cd_movimiento = $obj->getCd_movimiento();
		$sql = "DELETE FROM movimiento WHERE cd_movimiento = $cd_movimiento";

		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

	static function getMovimiento(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT M.*, SO.ds_nombre as ds_sucursalorigen, SO.ds_telefono as ds_telefonosucursalorigen, SO.ds_domicilio as ds_domiciliosucursalorigen, SD.ds_nombre as ds_sucursaldestino, SD.ds_domicilio as ds_domiciliosucursaldestino, M.ds_observacion as ds_observacionmovimiento, L.ds_localidad as ds_localidadsucursaldestino, LO.ds_localidad as ds_localidadsucursalorigen, U.* FROM movimiento M";
		$sql .= " LEFT JOIN sucursal SO ON SO.cd_sucursal = M.cd_sucursal_origen ";
		$sql .= " LEFT JOIN sucursal SD ON SD.cd_sucursal = M.cd_sucursal_destino ";
		$sql .= " LEFT JOIN localidad L ON SD.cd_localidad = L.cd_localidad ";
		$sql .= " LEFT JOIN localidad LO ON SO.cd_localidad = LO.cd_localidad ";
		$sql .= " LEFT JOIN usuario U ON U.cd_usuario = M.cd_usuario ";
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query($sql);

		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$movimiento = new Movimiento();
		if ($db->sql_numrows() > 0) {
			$temp = $db->sql_fetchassoc($result);
			$factory = new MovimientoFactory();
			$movimiento = $factory->build($temp);
		}
		$db->sql_freeresult($result);
		return $movimiento;
	}

	static function modificarMovimiento(Movimiento $obj) {
		$db = DbManager::getConnection();
		$cd_movimiento = FormatUtils::ifEmpty($obj->getCd_movimiento(), 'null');
		$cd_sucursalorigen = FormatUtils::ifEmpty($obj->getCd_sucursalorigen(), 'null');
		$cd_sucursaldestino = FormatUtils::ifEmpty($obj->getCd_sucursaldestino(), 'null');
		$dt_movimiento = implode("-", array_reverse(explode("-", $obj->getDt_movimiento())));
		$sql = "UPDATE movimiento SET cd_sucursal_origen = '$cd_sucursalorigen', cd_sucursal_destino = '$cd_sucursal_destino', dt_movimiento = '$dt_movimiento'";
		$sql .= " WHERE cd_movimiento = " . $cd_movimiento;

		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

}
?>