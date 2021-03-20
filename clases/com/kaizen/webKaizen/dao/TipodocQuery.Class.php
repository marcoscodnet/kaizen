<?php
/**
 * Acceso a datos para color
 * @author Lucrecia
 * @since 11-01-2011
 *
 */	
class TipodocQuery {

	static function getTipodocPorId(Tipodoc $obj) {
		$db = DbManager::getConnection();
		$cd_tipodoc = $obj->getCd_tipodoc ();
		$sql = "SELECT cd_tipodoc, ds_tipodoc FROM tipodoc WHERE cd_tipodoc = $cd_tipodoc";
		
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();

		if ($db->sql_numrows () > 0) {
			$tipodoc = $db->sql_fetchassoc ( $result );
			$factory = new TipodocFactory();
			$obj = $factory->build($tipodoc);
		}
		$db->sql_freeresult($result);
		return $obj;
	}


	static function gettiposdocs(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();

		$sql = "SELECT TD.* FROM tipodoc TD";
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$tiposdocs = ResultFactory::toCollection($db,$result,new TipodocFactory());
		$db->sql_freeresult($result);
		return $tiposdocs;
	}

	static function getTipodoc( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT * FROM tipodoc TD ";
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$tipodoc = new Tipodoc();
		if ($db->sql_numrows () > 0) {
			$temp = $db->sql_fetchassoc ( $result );
			$factory = new TipodocFactory();
			$tipodoc = $factory->build($temp);
		}
		$db->sql_freeresult($result);
		return $tipodoc;
	}
}
?>