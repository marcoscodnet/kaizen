<?php
/**
 * Acceso a datos para color
 * @author Lucrecia
 * @since 11-01-2011
 *
 */	
class CondivaQuery {

	static function getCondivaPorId(Tipodoc $obj) {
		$db = DbManager::getConnection();
		$cd_condiva = $obj->getCd_condiva ();
		$sql = "SELECT cd_condiva, ds_condiva FROM condiva WHERE cd_condiva = $cd_condiva";
		
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();

		if ($db->sql_numrows () > 0) {
			$condiva = $db->sql_fetchassoc ( $result );
			$factory = new CondivaFactory();
			$obj = $factory->build($condiva);
		}
		$db->sql_freeresult($result);
		return $obj;
	}


	static function getCondsiva(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();

		$sql = "SELECT CI.* FROM condiva CI";
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$condsiva = ResultFactory::toCollection($db,$result,new CondivaFactory());
		$db->sql_freeresult($result);
		return $condsiva;
	}

	static function getCondiva( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT * FROM condiva CI ";
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$condiva = new Condiva();
		if ($db->sql_numrows () > 0) {
			$temp = $db->sql_fetchassoc ( $result );
			$factory = new CondivaFactory();
			$condiva = $factory->build($temp);
		}
		$db->sql_freeresult($result);
		return $condiva;
	}
}
?>