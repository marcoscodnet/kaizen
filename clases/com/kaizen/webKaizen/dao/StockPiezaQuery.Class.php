<?php

/**

 * Acceso a datos para stock pieza.

 *

 * @author Ma. Jes�s

 * @since 19-07-2011

 *

 */

class StockPiezaQuery {



	static function insertStockPieza(StockPieza $obj) {

		$db = DbManager::getConnection();




		$cd_pieza = $obj->getCd_pieza ();

		$nu_cantidad = $obj->getNu_cantidad ();

		$qt_costo = FormatUtils::ifEmpty($obj->getQt_costo(), '0');

		$qt_minimo = FormatUtils::ifEmpty($obj->getQt_minimo(), '0');

		$cd_sucursal = $obj->getCd_sucursal ();

		$cd_proveedor = FormatUtils::ifEmpty($obj->getCd_proveedor(), '0');

		//$dt_ingreso = implode("-", array_reverse(explode("-", $obj->getDt_ingreso())));

        $dt_ingreso = FormatUtils::formatDate($obj->getDt_ingreso());

		$ds_remito = $obj->getDs_remito();


		$sql  = "INSERT INTO stockpieza (cd_pieza, nu_cantidad, qt_costo, qt_minimo, cd_sucursal, cd_proveedor, dt_ingreso, ds_remito)";

		$sql .= " VALUES ('$cd_pieza', '$nu_cantidad', '$qt_costo', '$qt_minimo', '$cd_sucursal', '$cd_proveedor', $dt_ingreso, '$ds_remito')";

		$result = $db->sql_query ( $sql );

		if(!$result)//hubo un error en la bbdd.

		throw new DBException($db->sql_error());

	}



	static function getStockPiezas(CriterioBusqueda $criterio) {

		$db = DbManager::getConnection();

		$sql = "SELECT SP.cd_stockpieza as id, SP.*, P.ds_codigo, P.ds_descripcion, S.*, Pr.* FROM stockpieza SP";

		$sql .= " LEFT JOIN pieza P ON P.cd_pieza = SP.cd_pieza ";

		$sql .= " LEFT JOIN sucursal S ON S.cd_sucursal = SP.cd_sucursal ";

		$sql .= " LEFT JOIN proveedor Pr ON Pr.cd_proveedor = SP.cd_proveedor ";



		$sql .= $criterio->buildFiltro();



		$result = $db->sql_query ( $sql );

		if(!$result)//hubo un error en la bbdd.

		throw new DBException($db->sql_error());



		$stockpiezas = ResultFactory::toCollection($db,$result,new StockPiezaFactory());

		$db->sql_freeresult($result);

		return $stockpiezas;

	}





	static function getCantStockPiezas( CriterioBusqueda $criterio) {

		$db = DbManager::getConnection();

		$sql = "SELECT count(*) as count FROM stockpieza SP";

		$sql .= " LEFT JOIN pieza P ON P.cd_pieza = SP.cd_pieza ";

		$sql .= " LEFT JOIN sucursal S ON S.cd_sucursal = SP.cd_sucursal ";

		$sql .= " LEFT JOIN proveedor Pr ON Pr.cd_proveedor = SP.cd_proveedor ";



		$sql .= $criterio->buildFiltroSinPaginar();



		$result = $db->sql_query ( $sql );

		if(!$result)//hubo un error en la bbdd.

		throw new DBException($db->sql_error());



		$next = $db->sql_fetchassoc ( $result );

		$cant = $next['count'];

		$db->sql_freeresult($result);

		return (( int ) $cant);

	}

	static function getSumStockPiezas( CriterioBusqueda $criterio) {

		$db = DbManager::getConnection();

		$sql = "SELECT sum(nu_cantidad) as cant FROM stockpieza SP";




		$sql .= $criterio->buildFiltro();



		$result = $db->sql_query ( $sql );

		if(!$result)//hubo un error en la bbdd.

		throw new DBException($db->sql_error());



		$next = $db->sql_fetchassoc ( $result );

		$cant = $next['cant'];

		$db->sql_freeresult($result);

		return (( int ) $cant);

	}



	static function eliminarStockPieza(StockPieza $obj) {

		$db = DbManager::getConnection();

		$cd_stockpieza = $obj->getCd_stockPieza ();

		$sql = "DELETE FROM stockpieza WHERE cd_stockpieza = $cd_stockpieza";

		$result = $db->sql_query ( $sql );

		if(!$result)//hubo un error en la bbdd.

		throw new DBException($db->sql_error());

	}





	static function getStockPieza( CriterioBusqueda $criterio) {

		$db = DbManager::getConnection();

		$sql = "SELECT * FROM stockpieza SP";

		$sql .= $criterio->buildFiltro();



		$result = $db->sql_query ( $sql );

		if(!$result)//hubo un error en la bbdd.

		throw new DBException($db->sql_error());



		$stockpieza = new StockPieza();

		if ($db->sql_numrows () > 0) {

			$temp = $db->sql_fetchassoc ( $result );

			$factory = new StockPiezaFactory();

			$stockpieza = $factory->build($temp);

		}

		$db->sql_freeresult($result);

		return $stockpieza;

	}



	static function modificarStockPieza(StockPieza $obj) {

		$db = DbManager::getConnection();

		$cd_stockpieza = $obj->getCd_stockPieza();





		$cd_pieza = $obj->getCd_pieza ();

		$nu_cantidad = $obj->getNu_cantidad ();

		$qt_costo = FormatUtils::ifEmpty($obj->getQt_costo(), '0');

		$qt_minimo = FormatUtils::ifEmpty($obj->getQt_minimo(), '0');

		$cd_sucursal = $obj->getCd_sucursal ();

		$cd_proveedor = FormatUtils::ifEmpty($obj->getCd_proveedor(), '0');

		//$dt_ingreso = implode("-", array_reverse(explode("-", $obj->getDt_ingreso())));
        $dt_ingreso = FormatUtils::formatDate($obj->getDt_ingreso());
		$ds_remito = $obj->getDs_remito();

		$sql  = "UPDATE stockpieza SET cd_pieza = '$cd_pieza', nu_cantidad = '$nu_cantidad', qt_costo = '$qt_costo', qt_minimo = '$qt_minimo', cd_sucursal = '$cd_sucursal', cd_proveedor = '$cd_proveedor', dt_ingreso = $dt_ingreso, ds_remito = '$ds_remito'";

		$sql .= " WHERE cd_stockpieza = ". $cd_stockpieza;

		$result = $db->sql_query ( $sql );


		if(!$result)//hubo un error en la bbdd.

		throw new DBException($db->sql_error());

	}

	static function actualizarStock(StockPieza $obj) {
		$db = DbManager::getConnection();
		$cd_stockpieza = $obj->getCd_stockPieza();

		$nu_cantidad = $obj->getNu_cantidad ();

		//reemplazamos los puntos por las comas.
		$nu_cantidad = str_replace(',',  '.', $nu_cantidad);

		$sql  = "UPDATE stockpieza SET nu_cantidad=$nu_cantidad";
		$sql .= " WHERE cd_stockpieza = ". $cd_stockpieza;
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
	}



}

?>
