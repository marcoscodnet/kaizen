<?php

/**

 * Acceso a datos para Itempago

 * @author Lucrecia

 * @since 11-01-2011

 *

 */

class ItempagoQuery {



	static function getItempagoPorId(Itempago $obj) {

		$db = DbManager::getConnection();

		$cd_itempago = $obj->getCd_itempago();

		$sql = "SELECT I.* FROM itempago I";

		$sql .= " LEFT JOIN entidad E ON E.cd_entidad = I.cd_entidad ";

		$sql .= " WHERE I.cd_itempago = $cd_itempago";

		$result = $db->sql_query ( $sql );

		if(!$result)//hubo un error en la bbdd.

		throw new DBException();



		if ($db->sql_numrows ( $result ) > 0) {

			$itempago = $db->sql_fetchassoc ( $result );

			$factory = new ItempagoFactory();

			$obj = $factory->build($itempago);

		}



		$db->sql_freeresult($res);

		return $obj;

	}



	static function insertItempago(Itempago $obj) {

		$db = DbManager::getConnection();



		$cd_entidad = $obj->getCd_entidad();

		$cd_venta = $obj->getCd_venta();

		$ds_observacion = $obj->getDs_observacion();

		$ds_detalle = $obj->getDs_detalle();

		$nu_importe = $obj->getNu_importe();

		$nu_pagado = $obj->getNu_pagado();

		$obj->setDt_pago(str_replace("-", "/", $obj->getDt_pago()));

		$dt_pago = implode("-", array_reverse(explode("/",$obj->getDt_pago())));

		/*$obj->setDt_contadora(str_replace("-", "/", $obj->getDt_contadora()));

		$dt_contadora = implode("-", array_reverse(explode("/",$obj->getDt_contadora())));*/

        $dt_contadora = FormatUtils::formatDate($obj->getDt_contadora());



		$sql  = "INSERT INTO itempago (cd_entidad, cd_venta, ds_observacion, ds_detalle, nu_importe,  nu_pagado, dt_pagado, dt_contadora) ";

		$sql .= " VALUES ('$cd_entidad','$cd_venta', '$ds_observacion', '$ds_detalle', '$nu_importe', '$nu_pagado', '$dt_pago', $dt_contadora) ";



		$result = $db->sql_query ( $sql );

		if(!$result)//hubo un error en la bbdd.

		throw new DBException($db->sql_error());

	}



	static function eliminarItempago(Itempago $obj) {

		$db = DbManager::getConnection();

		$cd_itempago = $obj->getCd_itempago ();

		$sql = "DELETE FROM itempago WHERE cd_itempago = $cd_itempago";

		$result = $db->sql_query ( $sql );

		if(!$result)//hubo un error en la bbdd.

		throw new DBException($db->sql_error());

	}





	static function eliminarItemspagos($criterio){

		$db = DbManager::getConnection();

		$sql = "DELETE FROM itempago ";

		$sql .= $criterio->buildFiltro();

		$result = $db->sql_query ( $sql );

		if(!$result)//hubo un error en la bbdd.

		throw new DBException($db->sql_error());

	}





	static function modificarItempago(Itempago $obj) {

		$db = DbManager::getConnection();

		$cd_itempago = $obj->getCd_itempago();

		$ds_detalle = $obj->getDs_detalle();

		$cd_entidad = $obj->getCd_entidad();

		$nu_importe = $obj->getNu_importe();

		$dt_pago = str_replace("/", "-", $obj->getDt_pago());

		$dt_pago = implode("-", array_reverse(explode("-", $dt_pago)));

		/*$dt_contadora = str_replace("/", "-", $obj->getDt_contadora());

		$dt_contadora = implode("-", array_reverse(explode("-", $dt_contadora)));*/

        $dt_contadora = FormatUtils::formatDate($obj->getDt_contadora());

		if($nu_importe ==""){

			$nu_importe = 0;

		}

		$nu_pagado = $obj->getNu_pagado();

		if($nu_pagado ==""){

			$nu_pagado = 0;

		}

		$ds_observacion = $obj->getDs_observacion();





		$sql  = "UPDATE itempago SET ds_detalle='$ds_detalle', ds_observacion='$ds_observacion', cd_entidad='$cd_entidad', nu_importe=$nu_importe, nu_pagado=$nu_pagado, dt_pagado='$dt_pago', dt_contadora=$dt_contadora";

		$sql .= " WHERE cd_itempago = ". $cd_itempago;

		$result = $db->sql_query ( $sql );

		if(!$result)//hubo un error en la bbdd.

		throw new DBException($db->sql_error());

	}



	static function getItemspago(CriterioBusqueda $criterio) {

		$db = DbManager::getConnection();



		$sql = " SELECT I.*, E.* FROM itempago I";

		$sql .= " LEFT JOIN entidad E ON E.cd_entidad=I.cd_entidad ";



		$sql .= $criterio->buildFiltro();

		$result = $db->sql_query ( $sql );

		if(!$result)//hubo un error en la bbdd.

		throw new DBException($db->sql_error());



		$itemspagos = ResultFactory::toCollection($db,$result,new ItempagoFactory());

		$db->sql_freeresult($result);

		return $itemspagos;

	}





	static function getItempago( CriterioBusqueda $criterio) {

		$db = DbManager::getConnection();

		$sql = "SELECT * FROM itempago I";

		$sql .= " LEFT JOIN entidad E ON E.cd_entidad=I.cd_entidad";

		$sql .= $criterio->buildFiltro();



		$result = $db->sql_query ( $sql );

		if(!$result)//hubo un error en la bbdd.

		throw new DBException($db->sql_error());



		$itempago = new Itempago();

		if ($db->sql_numrows () > 0) {

			$temp = $db->sql_fetchassoc ( $result );

			$factory = new ItempagoFactory();

			$itempago = $factory->build($temp);

		}

		$db->sql_freeresult($result);

		return $itempago;

	}

}

?>
