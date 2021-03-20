<?php
/**
 * Acceso a datos para producto.
 *
 * @author Lucrecia
 * @since 18-03-10
 *
 */
class ProductoQuery {

	static function insertProducto(Producto $obj) {
		$db = DbManager::getConnection();

		$nu_monto_sugerido = $obj->getNu_monto_sugerido();
		$nu_stock_minimo = $obj->getNu_stock_minimo();
		$cd_tipounidad = FormatUtils::ifEmpty($obj->getTipounidad()->getCd_tipounidad(), 'null');
		$cd_marca = FormatUtils::ifEmpty($obj->getMarca()->getCd_marca(), 'null');
		$cd_modelo = FormatUtils::ifEmpty($obj->getModelo()->getCd_modelo(), 'null');
		$cd_color = FormatUtils::ifEmpty($obj->getColor()->getCd_color(), 'null');
		$bl_discontinuo = $obj->getBl_discontinuo();
		$sql  = "INSERT INTO producto (cd_tipo_unidad, cd_marca, cd_modelo, cd_color, nu_monto_sugerido, nu_stock_minimo, bl_discontinuo)";
		$sql .= " VALUES ('$cd_tipounidad', '$cd_marca', '$cd_modelo', '$cd_color', '$nu_monto_sugerido', '$nu_stock_minimo', '$bl_discontinuo')";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

	static function getProductos(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$subconsulta = "(SELECT COUNT(cd_unidad) FROM unidad U WHERE U.cd_unidad NOT IN (select V.cd_unidad FROM venta V) AND U.cd_producto = P.cd_producto GROUP BY U.cd_producto)";
		$sql = "SELECT P.*, TU.*, MA.*, M.*, C.* , CONCAT(TU.ds_tipo_unidad, ' ', MA.ds_marca, ' ', M.ds_modelo, ' ', C.ds_color)as ds_producto,  IFNULL($subconsulta,0) as stock_actual FROM producto P";
		$sql .= " LEFT JOIN tipo_unidad TU ON P.cd_tipo_unidad=TU.cd_tipo_unidad ";
		$sql .= " LEFT JOIN marca MA ON MA.cd_marca = P.cd_marca ";
		$sql .= " LEFT JOIN modelo M ON M.cd_modelo = P.cd_modelo ";
		$sql .= " LEFT JOIN color C ON C.cd_color = P.cd_color ";
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
			
		$productos = ResultFactory::toCollection($db,$result,new ProductoFactory());
		$db->sql_freeresult($result);
		return $productos;
	}


	static function getCantProductos( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$subconsulta = "(SELECT COUNT(cd_unidad) FROM unidad U WHERE U.cd_unidad NOT IN (select V.cd_unidad FROM venta V) AND U.cd_producto = P.cd_producto GROUP BY U.cd_producto)";
		$sql = "SELECT count(*) as count FROM producto P";
		$sql .= " LEFT JOIN tipo_unidad TU ON P.cd_tipo_unidad=TU.cd_tipo_unidad ";
		$sql .= " LEFT JOIN marca MA ON MA.cd_marca = P.cd_marca ";
		$sql .= " LEFT JOIN modelo M ON M.cd_modelo = P.cd_modelo ";
		$sql .= " LEFT JOIN color C ON C.cd_color = P.cd_color ";
		if($criterio->buildHAVING()){
			$criterio->addFiltro('nu_stock_minimo', 'IFNULL('.$subconsulta.',0)', '>');
		}
		
		$sql .= $criterio->buildFiltroSinPaginar();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$next = $db->sql_fetchassoc ( $result );
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return (( int ) $cant);
	}

	static function eliminarProducto(Producto $obj) {
		$db = DbManager::getConnection();
		$cd_producto = $obj->getCd_producto ();
		$sql = "DELETE FROM producto WHERE cd_producto = $cd_producto";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}


	static function getProducto( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT * FROM producto P";
		$sql .= " LEFT JOIN tipo_unidad TU ON P.cd_tipo_unidad=TU.cd_tipo_unidad ";
		$sql .= " LEFT JOIN marca MA ON MA.cd_marca = P.cd_marca ";
		$sql .= " LEFT JOIN modelo M ON M.cd_modelo = P.cd_modelo ";
		$sql .= " LEFT JOIN color C ON C.cd_color = P.cd_color ";
		$sql .= $criterio->buildFiltro();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$producto = new Producto();
		if ($db->sql_numrows () > 0) {
			$temp = $db->sql_fetchassoc ( $result );
			$factory = new ProductoFactory();
			$producto = $factory->build($temp);
		}
		$db->sql_freeresult($result);
		return $producto;
	}
	
	
	
	function getProductoEnSucursal( $cd_sucursal) {
		$db = DbManager::getConnection();
		$sql = "SELECT P.cd_producto, CONCAT(TU.ds_tipo_unidad, ' ',MA.ds_marca, ' ', M.ds_modelo, ' ', C.ds_color) as ds_producto FROM producto P";
		$sql .= " LEFT JOIN tipo_unidad TU ON P.cd_tipo_unidad=TU.cd_tipo_unidad ";
		$sql .= " LEFT JOIN marca MA ON MA.cd_marca = P.cd_marca ";
		$sql .= " LEFT JOIN modelo M ON M.cd_modelo = P.cd_modelo ";
		$sql .= " LEFT JOIN color C ON C.cd_color = P.cd_color ";
		$sql .= "  WHERE cd_producto IN( SELECT U.cd_producto FROM unidad U WHERE cd_sucursal_actual = $cd_sucursal AND ";
		$sql .= " cd_unidad NOT IN(SELECT cd_unidad FROM venta))";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
			
		$productos = ResultFactory::toCollection($db,$result,new ProductoFactory());
		$db->sql_freeresult($result);

		return $productos;
	}

	static function modificarProducto(Producto $obj) {
		$db = DbManager::getConnection();
		$cd_producto = $obj->getCd_producto();
		$nu_monto_sugerido = $obj->getNu_monto_sugerido();
		$nu_stock_minimo = $obj->getNu_stock_minimo();
		$cd_tipounidad = FormatUtils::ifEmpty($obj->getTipounidad()->getCd_tipounidad(), 'null');
		$cd_marca = FormatUtils::ifEmpty($obj->getMarca()->getCd_marca(), 'null');
		$cd_modelo = FormatUtils::ifEmpty($obj->getModelo()->getCd_modelo(), 'null');
		$cd_color = FormatUtils::ifEmpty($obj->getColor()->getCd_color(), 'null');
		$bl_discontinuo = $obj->getBl_discontinuo();
		$sql  = "UPDATE producto SET cd_tipo_unidad = '$cd_tipounidad', cd_marca = '$cd_marca', cd_modelo = '$cd_modelo', cd_color = '$cd_color', nu_monto_sugerido = '$nu_monto_sugerido', nu_stock_minimo = '$nu_stock_minimo', bl_discontinuo = '$bl_discontinuo'";
		$sql .= " WHERE cd_producto = ". $cd_producto;
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

}
?>