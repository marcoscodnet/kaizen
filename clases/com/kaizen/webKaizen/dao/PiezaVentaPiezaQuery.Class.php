<?php
class PiezaVentaPiezaQuery {

	function insertPiezaVentaPieza(UnidadMovimiento $obj) {
		$db = DbManager::getConnection();
		$cd_unidad = $obj->getCd_unidad ();
		$cd_movimiento = $obj->getCd_movimiento ();
		$sql = "INSERT INTO 'unidad_movimiento' ('cd_unidad' ,'cd_movimiento') VALUES ('$cd_unidad' ,'$cd_movimiento') ";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();
	}

	function getPiezasDeVentaPieza($cd_ventapieza) {
		$db = DbManager::getConnection();
		$sql = "SELECT P.*, VPU.*, S.* FROM ventapieza_unidad VPU";
		$sql .= " LEFT JOIN pieza P ON P.cd_pieza=VPU.cd_pieza ";
        $sql .= " LEFT JOIN sucursal S ON S.cd_sucursal = VPU.cd_sucursal ";
		$sql .= " WHERE VPU.cd_ventapieza = $cd_ventapieza";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();
		$funciones = ResultFactory::toCollection($db,$result,new VentaPiezaUnidadFactory());
		$db->sql_freeresult($result);
		return ($funciones);
	}

	function getVentaPiezaUnidades($cd_ventapieza) {
		$db = DbManager::getConnection();
		$sql = "SELECT P.*, VPU.* FROM ventapieza_unidad VPU";
		$sql .= " LEFT JOIN pieza P ON P.cd_pieza=VPU.cd_pieza ";
		$sql .= " WHERE VPU.cd_ventapieza = $cd_ventapieza";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();
		$funciones = ResultFactory::toCollection($db,$result,new VentaPiezaUnidadFactory());
		$db->sql_freeresult($result);
		return ($funciones);
	}

	function insertarPiezasDeVentaPieza(VentaPieza $obj, Array $ventapiezaPiezas) {
		//me conecto a la BD
		$db = DbManager::getConnection();
		$i = 0;
		$limit = count ( $ventapiezaPiezas );
		while ( $i < $limit ) {
			$vp = $ventapiezaPiezas [$i];
			$cd_pieza = $vp->getCd_pieza();
			$cd_ventapieza = $obj->getCd_ventapieza ();
			$nu_cantidadpedida = $vp->getPieza()->getNu_cantidadpedida();
			$qt_montoacobrar = $vp->getPieza()->getQt_montoacobrar();
			$cd_sucursal = $vp->getSucursalOrigen()->getCd_sucursal();
			$sql = "INSERT INTO ventapieza_unidad (cd_ventapieza, cd_pieza, cd_sucursal, nu_cantidadpedida, qt_montoacobrar) VALUES('$cd_ventapieza', '$cd_pieza', '$cd_sucursal', '$nu_cantidadpedida', '$qt_montoacobrar')";
			$exitoVP = $db->sql_query ( $sql );
			if (! $exitoVP) {
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

	static function eliminarPiezasDeVentaPieza(VentaPieza $obj) {
		$db = DbManager::getConnection();
		$cd_ventapieza = $obj->getCd_ventapieza();
		$sql = "DELETE FROM ventapieza_unidad WHERE cd_ventapieza = $cd_ventapieza";

		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}
}
?>
