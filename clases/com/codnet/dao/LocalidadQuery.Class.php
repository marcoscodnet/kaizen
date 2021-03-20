<?php
/**
 * Acceso a datos para localidad.
 * 
 * @author codnet
 * @since 18-03-10
 *
 */
class LocalidadQuery {

	static function insertLocalidad(Localidad $obj) {
		$db = DbManager::getConnection();
		$ds_localidad = $obj->getDs_localidad();
		$cd_provincia = $obj->getCd_provincia();

		$sql  = "INSERT INTO localidad (ds_localidad, cd_provincia) ";
		$sql .= " VALUES ('$ds_localidad', '$cd_provincia') ";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

	static function getLocalidades(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();

		$sql = "SELECT PA.*, PR.*, L.* FROM localidad L";
		$sql .= " LEFT JOIN provincia PR ON PR.cd_provincia=L.cd_provincia ";
		$sql .= " LEFT JOIN pais PA ON PR.cd_pais=PA.cd_pais ";
		$sql .= $criterio->buildFiltro();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$localidades = ResultFactory::toCollection($db,$result,new LocalidadFactory());
		$db->sql_freeresult($result);
		return $localidades;
	}


	static function getCantLocalidades( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT count(*) as count FROM localidad ";
		$sql .= $criterio->buildFiltroSinPaginar();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$next = $db->sql_fetchassoc ( $result );
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return (( int ) $cant);
	}

	static function eliminarLocalidad(Localidad $obj) {
		$db = DbManager::getConnection();
		$cd_localidad = $obj->getCd_localidad ();
		$sql = "DELETE FROM localidad WHERE cd_localidad = $cd_localidad";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}


	static function getLocalidad( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT * FROM localidad L";
		$sql .= " LEFT JOIN provincia PR ON PR.cd_provincia=L.cd_provincia";
		$sql .= " LEFT JOIN pais PA ON PA.cd_pais=PR.cd_pais";
		$sql .= $criterio->buildFiltro();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$localidad = new Localidad();
		if ($db->sql_numrows () > 0) {
			$temp = $db->sql_fetchassoc ( $result );
			$factory = new LocalidadFactory();
			$localidad = $factory->build($temp);
		}
		$db->sql_freeresult($result);
		return $localidad;
	}


	static function modificarLocalidad(Localidad $obj) {
		$db = DbManager::getConnection();
		$cd_localidad = $obj->getCd_localidad();
		$ds_localidad = $obj->getDs_localidad();
		$cd_provincia = FormatUtils::ifEmpty($obj->getProvincia()->getCd_provincia(), 'null');
		$sql  = "UPDATE localidad SET cd_localidad=$cd_localidad, ds_localidad='$ds_localidad', cd_provincia = $cd_provincia";
		$sql .= " WHERE cd_localidad = ". $cd_localidad;
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

	function getLocalidadesDeProvincia(Provincia $obj) {
		$db = DbManager::getConnection();
		$cd_provincia = $obj->getCd_provincia ();
		$sql = "SELECT cd_localidad, ds_localidad FROM localidad WHERE cd_provincia = $cd_provincia ORDER BY ds_localidad";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();
		$localidads = ResultFactory::toCollection($db,$result,new LocalidadFactory());
		$db->sql_freeresult($res);
		return $localidads;
	}
}
?>