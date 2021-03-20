<?php

class TipounidadQuery {

	static function insertTipounidad(Tipounidad $obj) {
		$db = DbManager::getConnection();
		$ds_tipounidad = $obj->getDs_tipounidad ();
		$sql = "INSERT INTO tipo_unidad (ds_tipo_unidad) VALUES ('$ds_tipounidad') ";
		$result = $db->sql_query ( $sql );
		//echo $sql;
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();
	}


	static function getTipounidad( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT * FROM tipo_unidad TU ";
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$tipounidad = new Tipounidad();
		if ($db->sql_numrows () > 0) {
			$temp = $db->sql_fetchassoc ( $result );
			$factory = new TipounidadFactory();
			$tipounidad = $factory->build($temp);
		}
		$db->sql_freeresult($result);
		return $tipounidad;
	}

	static function modificarTipounidad(Tipounidad $obj) {
		$db = DbManager::getConnection();
		$cd_tipounidad = $obj->getCd_tipounidad();
		$ds_tipounidad = $obj->getDs_tipounidad();
		$sql  = "UPDATE tipo_unidad SET ds_tipo_unidad='$ds_tipounidad' ";
		$sql .= " WHERE cd_tipo_unidad = ". $cd_tipounidad;
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

	static function listarTiposunidades(Array $tiposunidades) {
		$db = DbManager::getConnection();
		$sql = "SELECT cd_tipo_unidad, ds_tipo_unidad FROM tipo_unidad ORDER BY ds_tipo_unidad";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();

		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if (in_array ( ( int ) $usr ['cd_tipo_unidad'], $tiposunidades )) {
					$res [$i] = array ('cd_tipounidad' => "'" . $usr ['cd_tipo_unidad'] . "'  checked", 'ds_tipounidad' => $usr ['ds_tipounidad'] );
				} else {
					$res [$i] = array ('cd_tipounidad' => "'".$usr ['cd_tipo_unidad']."'", 'ds_tipo_unidad' => $usr ['ds_tipo_unidad'] );
				}
				$i ++;
			}
		}
		$db->sql_freeresult($result);

		return $res;
	}

	static function getDs_TipoUnidad(Tipounidad $obj) {
		$db = Db::conectar ();
		$cd_tipo_unidad = $obj->getCd_tipounidad ();
		$sql = "SELECT ds_tipo_unidad FROM tipo_unidad WHERE cd_tipo_unidad = $cd_tipo_unidad";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();

		if ($db->sql_numrows () > 0) {
			$usr = $db->sql_fetchassoc ( $result );
			$res = $usr ['ds_tipounidad'];
		}
		$db->sql_freeresult($result);
		return $res;
	}

	static function listarCheckTiposunidades() {
		$db = Db::conectar ();
		$sql = "SELECT cd_tipo_unidad, ds_tipo_unidad FROM tipo_unidad ORDER BY ds_tipo_unidad";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();
			
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_tipounidad' => $usr ['cd_tipo_unidad'], 'ds_tipo_unidad' => $usr ['ds_tipo_unidad'] );
				$i ++;
			}
		}
		$db->sql_freeresult($result);
		return $res;
	}

	static function getTiposUnidadesDeMarca(Marca $obj) {
		$db = DbManager::getConnection();
		$cd_marca = $obj->getCd_marca ();
		$sql = "SELECT TU.* FROM marca_tipo_unidad MTU";
		$sql .= " LEFT JOIN tipo_unidad TU ON TU.cd_tipo_unidad=MTU.cd_tipo_unidad";
		$sql .= " WHERE MTU.cd_marca = $cd_marca";

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();
		$tiposunidades = ResultFactory::toCollection($db,$result,new TipounidadFactory());
		$db->sql_freeresult($result);
		return ($tiposunidades);
	}

	static function getCantTiposunidades( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT count(*) as count FROM tipo_unidad ";
		$sql .= $criterio->buildFiltroSinPaginar();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$next = $db->sql_fetchassoc ( $result );
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return (( int ) $cant);
	}

	static function getTiposunidades(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT * FROM tipo_unidad ";
		$sql .= $criterio->buildFiltro();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();
		$tiposunidades = ResultFactory::toCollection($db,$result,new TipounidadFactory());
		$db->sql_freeresult($result);
		return ($tiposunidades);
	}

	static function eliminarTipounidad(Tipounidad $obj) {
		$db = DbManager::getConnection();
		$cd_tipounidad = $obj->getCd_tipounidad ();
		$sql = "DELETE FROM tipo_unidad WHERE cd_tipo_unidad = $cd_tipounidad";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

}
?>