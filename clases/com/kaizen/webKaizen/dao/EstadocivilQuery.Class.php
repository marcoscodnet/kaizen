<?php
/**
 * Acceso a datos para color
 * @author Lucrecia
 * @since 11-01-2011
 *
 */	
class EstadocivilQuery {

	static function getEstadocivilPorId(Estadocivil $obj) {
		$db = DbManager::getConnection();
		$cd_estadocivil = $obj->getCd_estadocivil ();
		$sql = "SELECT cd_estadocivil, ds_estadocivil FROM estadocivil WHERE cd_estadocivil = $cd_estadocivil";
		
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();

		if ($db->sql_numrows () > 0) {
			$cestadocivil = $db->sql_fetchassoc ( $result );
			$factory = new EstadocivilFactory();
			$obj = $factory->build($cestadocivil);
		}
		$db->sql_freeresult($result);
		return $obj;
	}


	static function getEstadosciviles(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();

		$sql = "SELECT EC.* FROM estadocivil EC";
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$estadosciviles = ResultFactory::toCollection($db,$result,new EstadocivilFactory());
		$db->sql_freeresult($result);
		return $estadosciviles;
	}

	static function getEstadocivil( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT * FROM estadocivil EC ";
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$estadocivil = new Estadocivil();
		if ($db->sql_numrows () > 0) {
			$temp = $db->sql_fetchassoc ( $result );
			$factory = new EstadocivilFactory();
			$estadocivil = $factory->build($temp);
		}
		$db->sql_freeresult($result);
		return $estadocivil;
	}
}
?>