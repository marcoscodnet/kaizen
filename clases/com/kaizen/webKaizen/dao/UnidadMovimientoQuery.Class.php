<?php
class UnidadMovimientoQuery {

	function insertUnidadMovimiento(UnidadMovimiento $obj) {
		$db = DbManager::getConnection();
		$cd_unidad = $obj->getCd_unidad ();
		$cd_movimiento = $obj->getCd_movimiento ();
		$sql = "INSERT INTO 'unidad_movimiento' ('cd_unidad' ,'cd_movimiento') VALUES ('$cd_unidad' ,'$cd_movimiento') ";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();
	}

	function getUnidadesDeMovimiento($cd_movimiento) {
		$db = DbManager::getConnection();
		$sql = "SELECT U.*, U.cd_unidad as id, U.cd_sucursal_actual as cd_sucursal, P.*, TU.*, MA.*, M.*, C.* FROM unidad_movimiento UM";
		$sql .= " LEFT JOIN unidad U ON U.cd_unidad=UM.cd_unidad ";
		$sql .= " LEFT JOIN producto P ON P.cd_producto = U.cd_producto ";
		$sql .= " LEFT JOIN tipo_unidad TU ON P.cd_tipo_unidad = TU.cd_tipo_unidad ";
		$sql .= " LEFT JOIN marca MA ON MA.cd_marca = P.cd_marca ";
		$sql .= " LEFT JOIN modelo M ON M.cd_modelo=P.cd_modelo ";
		$sql .= " LEFT JOIN color C ON C.cd_color=P.cd_color ";
		$sql .= " WHERE UM.cd_movimiento = $cd_movimiento";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();
		$funciones = ResultFactory::toCollection($db,$result,new UnidadFactory());
		$db->sql_freeresult($result);
		return ($funciones);
	}

	function insertarUnidadesDeMovimiento(Movimiento $obj, Array $movimientoUnidades) {
		//me conecto a la BD
		$db = DbManager::getConnection();
		$i = 0;
		$limit = count ( $movimientoUnidades );
		while ( $i < $limit ) {
			$mu = $movimientoUnidades [$i];
			$cd_unidad = $mu->getCd_unidad();
			$cd_movimiento = $obj->getCd_movimiento ();
			$sql = "INSERT INTO unidad_movimiento (cd_movimiento, cd_unidad) VALUES($cd_movimiento, $cd_unidad)";

			$exitoUM = $db->sql_query ( $sql );
			if (! $exitoUM) {
				throw new DBException();
			}
			$i ++;
		}
		$db->sql_freeresult($result);

		return true;
	}

	function tieneMovimientoUnidadesAsignadas (UnidadMovimiento $obj) {
		$db = DbManager::getConnection();
		$cd_movimiento = $obj->getCd_perfil();
		$sql = "Select count(*) as count FROM unidad_movimiento WHERE cd_movimiento ='$cd_movimiento'";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();
		$next = $db->sql_fetchassoc ( $result );
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return ($cant > 0);
	}
}
?>