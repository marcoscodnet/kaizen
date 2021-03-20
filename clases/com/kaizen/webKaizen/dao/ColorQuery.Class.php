<?php
/**
 * Acceso a datos para color
 * @author Lucrecia
 * @since 11-01-2011
 *
 */	
class ColorQuery {

	static function getColorPorId(Color $obj) {
		$db = DbManager::getConnection();
		$cd_color = $obj->getCd_color ();
		$sql = "SELECT cd_color, ds_color FROM color WHERE cd_color = $cd_color";
		
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();

		if ($db->sql_numrows () > 0) {
			$color = $db->sql_fetchassoc ( $result );
			$factory = new ColorFactory();
			$obj = $factory->build($color);
		}
		$db->sql_freeresult($result);
		return $obj;
	}

	static function insertColor(Color $obj) {
		$db = DbManager::getConnection();
		$ds_color = $obj->getDs_color();

		$sql  = "INSERT INTO color (ds_color) ";
		$sql .= " VALUES ('$ds_color') ";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

	static function modificarColor(Color $obj) {
		$db = DbManager::getConnection();
		$cd_color = $obj->getCd_color();
		$ds_color = $obj->getDs_color();
		$sql  = "UPDATE color SET cd_color=$cd_color, ds_color='$ds_color' ";
		$sql .= " WHERE cd_color = ". $cd_color;
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}


	static function getCantColores( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT count(*) as count FROM color ";
		$sql .= $criterio->buildFiltroSinPaginar();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$next = $db->sql_fetchassoc ( $result );
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return (( int ) $cant);
	}

	static function eliminarColor(Color $obj) {
		$db = DbManager::getConnection();
		$cd_color = $obj->getCd_color ();
		$sql = "DELETE FROM color WHERE cd_color = $cd_color";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

	static function getcolores(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();

		$sql = "SELECT C.* FROM color C";
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$colores = ResultFactory::toCollection($db,$result,new ColorFactory());
		$db->sql_freeresult($result);
		return $colores;
	}

	static function getColor( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT * FROM color C ";
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$color = new Color();
		if ($db->sql_numrows () > 0) {
			$temp = $db->sql_fetchassoc ( $result );
			$factory = new ColorFactory();
			$color = $factory->build($temp);
		}
		$db->sql_freeresult($result);
		return $color;
	}
}
?>