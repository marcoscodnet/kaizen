<?php
/**
 * Acceso a datos para entidad
 * @author Lucrecia
 * @since 11-01-2011
 *
 */
class ParametroQuery {

	static function getParametroPorId(Parametro $obj) {
		$db = DbManager::getConnection();
		$cd_parametro = $obj->getCd_parametro ();
		$sql = "SELECT cd_parametro, ds_nombre, ds_contenido FROM parametro WHERE cd_parametro = $cd_parametro";

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();

		if ($db->sql_numrows () > 0) {
			$entidad = $db->sql_fetchassoc ( $result );
			$factory = new ParametroFactory();
			$obj = $factory->build($entidad);
		}
		$db->sql_freeresult($result);
		return $obj;
	}


	static function getParametro(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT cd_parametro, ds_nombre, ds_contenido FROM parametro";
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();

		if ($db->sql_numrows () > 0) {
			$entidad = $db->sql_fetchassoc ( $result );
			$factory = new ParametroFactory();
			$obj = $factory->build($entidad);
		}
		$db->sql_freeresult($result);
		return $obj;
	}

	static function modificarParametro(Parametro $obj) {
		$db = DbManager::getConnection();
		$cd_parametro = $obj->getCd_parametro();
		$ds_nombre = $obj->getDs_nombre();
		$ds_contenido = $obj->getDs_contenido();
		$sql  = "UPDATE parametro SET cd_parametro=$cd_parametro, ds_nombre='$ds_nombre', ds_contenido ='$ds_contenido' ";
		$sql .= " WHERE cd_parametro = ". $cd_parametro;
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}



}
?>