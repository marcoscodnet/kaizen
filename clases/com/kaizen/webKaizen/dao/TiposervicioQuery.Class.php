<?php

class TiposervicioQuery {

	static function insertTiposervicio(Tiposervicio $obj) {
		$db = DbManager::getConnection();
		$ds_tiposervicio = $obj->getDs_tiposervicio ();
		$sql = "INSERT INTO tipo_servicio (ds_tipo_servicio) VALUES ('$ds_tiposervicio') ";
		$result = $db->sql_query ( $sql );
		//echo $sql;
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();
	}


	static function getTiposervicio( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT * FROM tipo_servicio TU ";
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$tiposervicio = new Tiposervicio();
		if ($db->sql_numrows () > 0) {
			$temp = $db->sql_fetchassoc ( $result );
			$factory = new TiposervicioFactory();
			$tiposervicio = $factory->build($temp);
		}
		$db->sql_freeresult($result);
		return $tiposervicio;
	}

	static function modificarTiposervicio(Tiposervicio $obj) {
		$db = DbManager::getConnection();
		$cd_tiposervicio = $obj->getCd_tiposervicio();
		$ds_tiposervicio = $obj->getDs_tiposervicio();
		$sql  = "UPDATE tipo_servicio SET ds_tipo_servicio='$ds_tiposervicio' ";
		$sql .= " WHERE cd_tipo_servicio = ". $cd_tiposervicio;
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

	static function listarTiposservicios(Array $tiposservicios) {
		$db = DbManager::getConnection();
		$sql = "SELECT cd_tipo_servicio, ds_tipo_servicio FROM tipo_servicio ORDER BY ds_tipo_servicio";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();

		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if (in_array ( ( int ) $usr ['cd_tipo_servicio'], $tiposservicios )) {
					$res [$i] = array ('cd_tiposervicio' => "'" . $usr ['cd_tipo_servicio'] . "'  checked", 'ds_tiposervicio' => $usr ['ds_tiposervicio'] );
				} else {
					$res [$i] = array ('cd_tiposervicio' => "'".$usr ['cd_tipo_servicio']."'", 'ds_tipo_servicio' => $usr ['ds_tipo_servicio'] );
				}
				$i ++;
			}
		}
		$db->sql_freeresult($result);

		return $res;
	}

	static function getDs_Tiposervicio(Tiposervicio $obj) {
		$db = Db::conectar ();
		$cd_tipo_servicio = $obj->getCd_tiposervicio ();
		$sql = "SELECT ds_tipo_servicio FROM tipo_servicio WHERE cd_tipo_servicio = $cd_tipo_servicio";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();

		if ($db->sql_numrows () > 0) {
			$usr = $db->sql_fetchassoc ( $result );
			$res = $usr ['ds_tiposervicio'];
		}
		$db->sql_freeresult($result);
		return $res;
	}

	static function listarCheckTiposservicios() {
		$db = Db::conectar ();
		$sql = "SELECT cd_tipo_servicio, ds_tipo_servicio FROM tipo_servicio ORDER BY ds_tipo_servicio";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();
			
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_tiposervicio' => $usr ['cd_tipo_servicio'], 'ds_tipo_servicio' => $usr ['ds_tipo_servicio'] );
				$i ++;
			}
		}
		$db->sql_freeresult($result);
		return $res;
	}

	static function getTiposserviciosDeMarca(Marca $obj) {
		$db = DbManager::getConnection();
		$cd_marca = $obj->getCd_marca ();
		$sql = "SELECT TU.* FROM marca_tipo_servicio MTU";
		$sql .= " LEFT JOIN tipo_servicio TU ON TU.cd_tipo_servicio=MTU.cd_tipo_servicio";
		$sql .= " WHERE MTU.cd_marca = $cd_marca";

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();
		$tiposservicios = ResultFactory::toCollection($db,$result,new TiposervicioFactory());
		$db->sql_freeresult($result);
		return ($tiposservicios);
	}

	static function getCantTiposservicios( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT count(*) as count FROM tipo_servicio ";
		$sql .= $criterio->buildFiltroSinPaginar();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$next = $db->sql_fetchassoc ( $result );
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return (( int ) $cant);
	}

	static function getTiposservicios(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT * FROM tipo_servicio ";
		$sql .= $criterio->buildFiltro();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();
		$tiposservicios = ResultFactory::toCollection($db,$result,new TiposervicioFactory());
		$db->sql_freeresult($result);
		return ($tiposservicios);
	}

	static function eliminarTiposervicio(Tiposervicio $obj) {
		$db = DbManager::getConnection();
		$cd_tiposervicio = $obj->getCd_tiposervicio ();
		$sql = "DELETE FROM tipo_servicio WHERE cd_tipo_servicio = $cd_tiposervicio";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

}
?>