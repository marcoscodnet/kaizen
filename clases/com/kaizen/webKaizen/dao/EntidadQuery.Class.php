<?php
/**
 * Acceso a datos para entidad
 * @author Lucrecia
 * @since 11-01-2011
 *
 */	
class EntidadQuery {

	static function getEntidadPorId(Entidad $obj) {
		$db = DbManager::getConnection();
		$cd_entidad = $obj->getCd_entidad ();
		$sql = "SELECT cd_entidad, ds_entidad FROM entidad WHERE cd_entidad = $cd_entidad";
		
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();

		if ($db->sql_numrows () > 0) {
			$entidad = $db->sql_fetchassoc ( $result );
			$factory = new EntidadFactory();
			$obj = $factory->build($entidad);
		}
		$db->sql_freeresult($result);
		return $obj;
	}

	static function insertEntidad(Entidad $obj) {
		$db = DbManager::getConnection();
		$ds_entidad = $obj->getDs_entidad();

		$sql  = "INSERT INTO entidad (ds_entidad) ";
		$sql .= " VALUES ('$ds_entidad') ";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

	static function modificarEntidad(Entidad $obj) {
		$db = DbManager::getConnection();
		$cd_entidad = $obj->getCd_entidad();
		$ds_entidad = $obj->getDs_entidad();
		$sql  = "UPDATE entidad SET cd_entidad=$cd_entidad, ds_entidad='$ds_entidad' ";
		$sql .= " WHERE cd_entidad = ". $cd_entidad;
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}


	static function getCantEntidades( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT count(*) as count FROM entidad ";
		$sql .= $criterio->buildFiltroSinPaginar();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$next = $db->sql_fetchassoc ( $result );
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return (( int ) $cant);
	}

	static function eliminarEntidad(Entidad $obj) {
		$db = DbManager::getConnection();
		$cd_entidad = $obj->getCd_entidad ();
		$sql = "DELETE FROM entidad WHERE cd_entidad = $cd_entidad";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

	static function getentidades(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();

		$sql = "SELECT E.* FROM entidad E";
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$entidades = ResultFactory::toCollection($db,$result,new EntidadFactory());
		$db->sql_freeresult($result);
		return $entidades;
	}

	static function getEntidad( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT * FROM entidad E ";
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$entidad = new Entidad();
		if ($db->sql_numrows () > 0) {
			$temp = $db->sql_fetchassoc ( $result );
			$factory = new EntidadFactory();
			$entidad = $factory->build($temp);
		}
		$db->sql_freeresult($result);
		return $entidad;
	}
}
?>