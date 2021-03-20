<?php
/**
 * Acceso a datos para pieza.
 *
 * @author Ma. Jes�s
 * @since 18-06-2011
 *
 */
class PiezaQuery {

	static function insertPieza(Pieza $obj) {
		$db = DbManager::getConnection();

		$ds_codigo = $obj->getDs_codigo ();
		$ds_descripcion = $obj->getDs_descripcion ();
		$nu_stock_minimo = $obj->getNu_stock_minimo ();
		$nu_stock_actual = $obj->getNu_stock_actual();
		$qt_costo = $obj->getQt_costo();
		$qt_minimo = $obj->getQt_minimo();
		$ds_observacion = $obj->getDs_observacion ();

		$sql  = "INSERT INTO pieza (ds_codigo, ds_descripcion, nu_stock_minimo, nu_stock_actual, qt_costo, qt_minimo, ds_observacion)";
		$sql .= " VALUES ('$ds_codigo', '$ds_descripcion', '$nu_stock_minimo', '$nu_stock_actual', '$qt_costo', '$qt_minimo', '$ds_observacion')";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

	static function getPiezas(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT P.* FROM pieza P";
		$sql .= $criterio->buildFiltro();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$piezas = ResultFactory::toCollection($db,$result,new PiezaFactory());
		$db->sql_freeresult($result);
		return $piezas;
	}


	static function getCantPiezas( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT count(*) as count FROM pieza ";
		$sql .= $criterio->buildFiltroSinPaginar();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$next = $db->sql_fetchassoc ( $result );
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return (( int ) $cant);
	}

	static function eliminarPieza(Pieza $obj) {
		$db = DbManager::getConnection();
		$cd_pieza = $obj->getCd_pieza ();
		$sql = "DELETE FROM pieza WHERE cd_pieza = $cd_pieza";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}


	static function getPieza( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT * FROM pieza P";
		$sql .= $criterio->buildFiltro();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$pieza = new Pieza();
		if ($db->sql_numrows () > 0) {
			$temp = $db->sql_fetchassoc ( $result );
			$factory = new PiezaFactory();
			$pieza = $factory->build($temp);
		}
		$db->sql_freeresult($result);
		return $pieza;
	}

	static function modificarPieza(Pieza $obj) {
		$db = DbManager::getConnection();
		$cd_pieza = $obj->getCd_pieza();

		$ds_codigo = $obj->getDs_codigo ();
		$ds_descripcion = $obj->getDs_descripcion ();
		$nu_stock_minimo = $obj->getNu_stock_minimo ();
		$nu_stock_actual = $obj->getNu_stock_actual();
		$qt_costo = $obj->getQt_costo();
		$qt_minimo = $obj->getQt_minimo();
		$ds_observacion = $obj->getDs_observacion ();

		$sql  = "UPDATE pieza SET ds_codigo = '$ds_codigo', ds_descripcion = '$ds_descripcion', nu_stock_minimo = '$nu_stock_minimo', nu_stock_actual = '$nu_stock_actual', qt_costo = '$qt_costo', qt_minimo = '$qt_minimo', ds_observacion = '$ds_observacion'";
		$sql .= " WHERE cd_pieza = ". $cd_pieza;
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

	static function getPiezasPorSucursal(CriterioBusqueda $criterio){
		$db = DbManager::getConnection();
		$filtros = $criterio->getFiltros();
		$ds_nombre=  $criterio->getValorFiltro('S.ds_nombre');




		$sql = self::getPiezasPorSucursalQuery( $criterio, $ds_nombre);

		$sql .= $criterio->buildLIMIT();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());

		$piezas = ResultFactory::toCollection($db,$result,new PiezasPorSucursalFactory());

		$db->sql_freeresult($result);
		return $piezas;
	}

	static function getCantPiezasPorSucursal(CriterioBusqueda $criterio){
		$db = DbManager::getConnection();
		$filtros = $criterio->getFiltros();
		$ds_nombre=  $criterio->getValorFiltro('ds_nombre');



		$sql = self::getPiezasPorSucursalQuery( $criterio, $ds_nombre);

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());

		$piezas = ResultFactory::toCollection($db,$result,new PiezasPorSucursalFactory());
		$db->sql_freeresult($result);
		return $piezas->size();
	}

	private function getPiezasPorSucursalQuery($criterio, $ds_nombre){

		$sql ="SELECT P.cd_pieza, P.ds_codigo, P.ds_descripcion, S.ds_nombre, S.cd_sucursal, SUM(SP.nu_cantidad) as nu_cantidad ";
		$sql .='FROM `pieza` P INNER JOIN stockpieza SP ON P.cd_pieza = SP.cd_pieza ';
		$sql .='INNER JOIN sucursal S ON SP.cd_sucursal = S.cd_sucursal ';
		$sql .="WHERE S.ds_nombre LIKE '%".$ds_nombre."%'";
		$sql .='GROUP BY P.cd_pieza,S.cd_sucursal,S.ds_nombre';

		$sql .= $criterio->buildORDERBY();

		return $sql;

	}

}
?>
