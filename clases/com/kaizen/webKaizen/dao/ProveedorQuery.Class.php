<?php
/**
 * Acceso a datos para proveedor
 * @author María Jesús
 * @since 21-07-2011
 *
 */
class ProveedorQuery {

	static function getProveedorPorId(Proveedor $obj) {
		$db = DbManager::getConnection();
		$cd_proveedor = $obj->getCd_proveedor ();
		$sql = "SELECT P.cd_proveedor, P.ds_proveedor FROM proveedor P";
		$sql .= " WHERE P.cd_proveedor = $cd_proveedor";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();

		if ($db->sql_numrows ( $result ) > 0) {
			$prov = $db->sql_fetchassoc ( $result );
			$factory = new ProveedorFactory();
			$obj = $factory->build($prov);
		}

		$db->sql_freeresult($res);
		return $obj;
	}

	static function insertProveedor(Proveedor $obj) {
		$db = DbManager::getConnection();
		$ds_proveedor = $obj->getDs_proveedor();

		$sql  = "INSERT INTO proveedor (ds_proveedor) ";
		$sql .= " VALUES ('$ds_proveedor') ";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
		$id = ProveedorQuery::insert_id ( $db );
		$obj->setCd_proveedor ( $id );
	}

	static function insert_id($db) {
		$db = DbManager::getConnection();
		$sql = "SELECT MAX(`cd_proveedor`) as id FROM proveedor ";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();
		$next = $db->sql_fetchassoc ( $result );
		$id = $next['id'];
		$db->sql_freeresult($result);
		return ($id );
	}


	static function eliminarProveedor(Proveedor $obj) {
		$db = DbManager::getConnection();
		$cd_proveedor = $obj->getCd_proveedor ();
		$sql = "DELETE FROM proveedor WHERE cd_proveedor = $cd_proveedor";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

	static function modificarProveedor(Proveedor $obj) {
		$db = DbManager::getConnection();
		$cd_proveedor = $obj->getCd_proveedor();
		$ds_proveedor = $obj->getDs_proveedor();
		$cd_proveedor = FormatUtils::ifEmpty($obj->getCd_proveedor(), 'null');
		$sql  = "UPDATE proveedor SET ds_proveedor='$ds_proveedor'";
		$sql .= " WHERE cd_proveedor = ". $cd_proveedor;
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

	static function getProveedores(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();

		$sql = "SELECT P.* FROM proveedor P";
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$proveedores = ResultFactory::toCollection($db,$result,new ProveedorFactory());
		$db->sql_freeresult($result);
		return $proveedores;
	}

	static function getCantProveedores( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT count(*) as count FROM proveedor ";
		$sql .= $criterio->buildFiltroSinPaginar();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$next = $db->sql_fetchassoc ( $result );
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return (( int ) $cant);
	}

	static function getProveedor( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT * FROM proveedor P";
		$sql .= $criterio->buildFiltro();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$proveedor = new Proveedor();
		if ($db->sql_numrows () > 0) {
			$temp = $db->sql_fetchassoc ( $result );
			$factory = new ProveedorFactory();
			$proveedor = $factory->build($temp);
		}
		$db->sql_freeresult($result);
		return $proveedor;
	}
}
?>