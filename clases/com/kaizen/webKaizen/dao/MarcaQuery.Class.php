<?php
/**
 * Acceso a datos para marca
 * @author Lucrecia
 * @since 11-01-2011
 *
 */
class MarcaQuery {

	static function getMarcaPorId(Marca $obj) {
		$db = DbManager::getConnection();
		$cd_marca = $obj->getCd_marca ();
		$sql = "SELECT M.cd_marca, M.ds_marca FROM marca M";
		$sql .= " WHERE M.cd_marca = $cd_marca";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();

		if ($db->sql_numrows ( $result ) > 0) {
			$prov = $db->sql_fetchassoc ( $result );
			$factory = new MarcaFactory();
			$obj = $factory->build($prov);
		}

		$db->sql_freeresult($res);
		return $obj;
	}

	static function insertMarca(Marca $obj) {
		$db = DbManager::getConnection();
		$ds_marca = $obj->getDs_marca();

		$sql  = "INSERT INTO marca (ds_marca) ";
		$sql .= " VALUES ('$ds_marca') ";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
		$id = MarcaQuery::insert_id ( $db );
		$obj->setCd_marca ( $id );
	}

	static function insert_id($db) {
		$db = DbManager::getConnection();
		$sql = "SELECT MAX(`cd_marca`) as id FROM marca ";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();
		$next = $db->sql_fetchassoc ( $result );
		$id = $next['id'];
		$db->sql_freeresult($result);
		return ($id );
	}


	static function eliminarMarca(Marca $obj) {
		$db = DbManager::getConnection();
		$cd_marca = $obj->getCd_marca ();
		$sql = "DELETE FROM marca WHERE cd_marca = $cd_marca";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

	static function modificarMarca(Marca $obj) {
		$db = DbManager::getConnection();
		$cd_marca = $obj->getCd_Marca();
		$ds_marca = $obj->getDs_marca();
		$cd_marca = FormatUtils::ifEmpty($obj->getCd_marca(), 'null');
		$sql  = "UPDATE marca SET ds_marca='$ds_marca'";
		$sql .= " WHERE cd_marca = ". $cd_marca;
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

	static function getMarcas(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();

		$sql = "SELECT M.* FROM marca M";
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$marcas = ResultFactory::toCollection($db,$result,new MarcaFactory());
		$db->sql_freeresult($result);
		return $marcas;
	}

	static function getMarcasPorTipounidad(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();

		$sql = "SELECT DISTINCT M.cd_marca, M.ds_marca FROM marca M";
		$sql .= " INNER JOIN marca_tipo_unidad MTU ON(MTU.cd_marca = M.cd_marca)";
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$marcas = ResultFactory::toCollection($db,$result,new MarcaFactory());
		$db->sql_freeresult($result);
		return $marcas;
	}


	static function getCantMarcas( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT count(*) as count FROM marca ";
		$sql .= $criterio->buildFiltroSinPaginar();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$next = $db->sql_fetchassoc ( $result );
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return (( int ) $cant);
	}

	static function getMarca( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT * FROM marca M";
		$sql .= $criterio->buildFiltro();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$marca = new Marca();
		if ($db->sql_numrows () > 0) {
			$temp = $db->sql_fetchassoc ( $result );
			$factory = new MarcaFactory();
			$marca = $factory->build($temp);
		}
		$db->sql_freeresult($result);
		return $marca;
	}
}
?>