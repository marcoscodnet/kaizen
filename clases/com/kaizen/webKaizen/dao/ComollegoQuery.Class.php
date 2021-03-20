<?php
/**
 * Acceso a datos para localidad.
 *
 * @author codnet
 * @since 18-03-10
 *
 */
class ComollegoQuery {

	static function getComollego(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();

		$sql = "SELECT CL.* FROM comollego CL";
		$sql .= $criterio->buildFiltro();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$combo_comollego = ResultFactory::toCollection($db,$result,new ComollegoFactory());
		$db->sql_freeresult($result);
		return $combo_comollego;
	}

	static function getComollegoPorCampo( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT * FROM comollego CL";
		$sql .= $criterio->buildFiltro();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$comollego = new Comollego();
		if ($db->sql_numrows () > 0) {
			$temp = $db->sql_fetchassoc ( $result );
			$factory = new ComollegoFactory();
			$comollego = $factory->build($temp);
		}
		$db->sql_freeresult($result);
		return $comollego;
	}
}
?>