<?php
/**
 * Acceso a datos para modelo
 * @author Lucrecia
 * @since 11-01-2011
 *
 */	
class ModeloQuery {

	static function getModeloPorId(Modelo $obj) {
		$db = DbManager::getConnection();
		$cd_modelo = $obj->getCd_modelo ();
		$sql = "SELECT M.cd_modelo, M.ds_modelo, MA.cd_marca, MA.ds_marca FROM modelo M";
		$sql .= " LEFT JOIN marca MA ON MA.cd_marca=M.cd_marca ";
		$sql .= " WHERE M.cd_modelo = $cd_modelo";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();

		if ($db->sql_numrows ( $result ) > 0) {
			$prov = $db->sql_fetchassoc ( $result );
			$factory = new ModeloFactory();
			$obj = $factory->build($prov);
		}

		$db->sql_freeresult($res);
		return $obj;
	}

	static function insertModelo(Modelo $obj) {
		$db = DbManager::getConnection();
		$ds_modelo = $obj->getDs_modelo();
		$cd_marca = $obj->getCd_marca();

		$sql  = "INSERT INTO modelo (ds_modelo, cd_marca) ";
		$sql .= " VALUES ('$ds_modelo', '$cd_marca') ";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

	static function eliminarModelo(Modelo $obj) {
		$db = DbManager::getConnection();
		$cd_modelo = $obj->getCd_modelo ();
		$sql = "DELETE FROM modelo WHERE cd_modelo = $cd_modelo";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

	static function modificarModelo(Modelo $obj) {
		$db = DbManager::getConnection();
		$cd_modelo = $obj->getCd_Modelo();
		$ds_modelo = $obj->getDs_modelo();
		$cd_marca = FormatUtils::ifEmpty($obj->getCd_marca(), 'null');
		$sql  = "UPDATE modelo SET cd_modelo=$cd_modelo, ds_modelo='$ds_modelo', cd_marca = $cd_marca";
		$sql .= " WHERE cd_modelo = ". $cd_modelo;
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

	static function getModelos(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();

		$sql = "SELECT MA.*, M.* FROM modelo M";
		$sql .= " LEFT JOIN marca MA ON MA.cd_marca=M.cd_marca ";
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$modelos = ResultFactory::toCollection($db,$result,new ModeloFactory());
		$db->sql_freeresult($result);
		return $modelos;
	}

	static function getCantModelos( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT count(*) as count FROM modelo M ";
		$sql .= " LEFT JOIN marca MA ON MA.cd_marca=M.cd_marca ";
		$sql .= $criterio->buildFiltroSinPaginar();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$next = $db->sql_fetchassoc ( $result );
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return (( int ) $cant);
	}

	static function getModelosDeMarca(Marca $obj) {
		$db = DbManager::getConnection();
		$cd_marca = $obj->getCd_marca ();
		$sql = "SELECT M.cd_modelo, M.ds_modelo FROM modelo M WHERE cd_marca = $cd_marca";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();
		$modelos = ResultFactory::toCollection($db,$result,new ModeloFactory());
		$db->sql_freeresult($res);
		return $modelos;
	}

	static function getModelo( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT * FROM modelo M";
		$sql .= " LEFT JOIN marca MA ON MA.cd_marca=M.cd_marca";
		$sql .= $criterio->buildFiltro();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$modelo = new Modelo();
		if ($db->sql_numrows () > 0) {
			$temp = $db->sql_fetchassoc ( $result );
			$factory = new ModeloFactory();
			$modelo = $factory->build($temp);
		}
		$db->sql_freeresult($result);
		return $modelo;
	}
}
?>