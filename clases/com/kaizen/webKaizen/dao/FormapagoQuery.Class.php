<?php
/**
 * Acceso a datos para color
 * @author Lucrecia
 * @since 11-01-2011
 *
 */
class FormapagoQuery {

	static function getFormapagoPorId(Formapago $obj) {
		$db = DbManager::getConnection();
		$cd_color = $obj->getCd_color ();
		$sql = "SELECT cd_formapago, ds_formapago FROM formapago WHERE cd_formapago = $cd_formapago";

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();

		if ($db->sql_numrows () > 0) {
			$color = $db->sql_fetchassoc ( $result );
			$factory = new FormapagoFactory();
			$obj = $factory->build($color);
		}
		$db->sql_freeresult($result);
		return $obj;
	}

	static function getformasdepago(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();

		$sql = "SELECT FP.* FROM formapago FP";
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$colores = ResultFactory::toCollection($db,$result,new FormapagoFactory());
		$db->sql_freeresult($result);
		return $colores;
	}

	static function getFormapago( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT * FROM formapago FP ";
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$forma_pago = new Formapago();
		if ($db->sql_numrows () > 0) {
			$temp = $db->sql_fetchassoc ( $result );
			$factory = new FormapagoFactory();
			$forma_pago = $factory->build($temp);
		}
		$db->sql_freeresult($result);
		return $forma_pago;
	}
}
?>