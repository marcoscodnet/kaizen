<?php
/**
 * Acceso a datos para cliente.
 *
 * @author Lucrecia
 * @since 18-03-10
 *
 */
class ClienteQuery {

	static function insertCliente(Cliente $obj) {
		$db = DbManager::getConnection();

		$cd_localidad = FormatUtils::ifEmpty($obj->getLocalidad()->getCd_localidad(), 'null');
		$ds_apynom = $obj->getDs_apynom();
		$cd_tipodoc = FormatUtils::ifEmpty($obj->getTipodoc()->getCd_tipodoc(), 'null');
		$nu_doc = $obj->getNu_doc();
		$obj->setDt_nacimiento(str_replace("/", "-", $obj->getDt_nacimiento()));
		$dt_nacimiento = implode("-", array_reverse(explode("-", $obj->getDt_nacimiento())));
		$cd_estadocivil = FormatUtils::ifEmpty($obj->getEstadocivil()->getCd_estadocivil(),'null');
		$ds_conyuge = $obj->getDs_conyuge();
		$ds_nacionalidad = $obj->getDs_nacionalidad();
		$ds_cp = $obj->getDs_cp();
		$ds_teparticular = $obj->getDs_teparticular();
		$ds_telaboral = $obj->getDs_telaboral();
                $ds_email = $obj->getDs_email();
		$ds_actividad_ocupacion = $obj->getDs_actividad_ocupacion();
		$ds_lugartrabajo = $obj->getDs_lugartrabajo();
		$ds_cuil_cuit = $obj->getDs_cuil_cuit();
		$cd_condiva = FormatUtils::ifEmpty($obj->getCondiva()->getCd_condiva(),'null');
		$cd_comollego = $obj->getCd_comollego();
		$ds_dircalle = $obj->getDs_dircalle();
		$ds_dirnro = $obj->getDs_dirnro();
		$ds_dirpiso = $obj->getDs_dirpiso();
		$ds_dirdepto = $obj->getDs_dirdepto();

		$sql  = "INSERT INTO cliente (cd_localidad, ds_apynom, cd_tipodoc, nu_doc, dt_nacimiento, cd_estadocivil, ds_conyuge, ds_nacionalidad, ds_cp, ds_telparticular,ds_tellaboral, ds_email, ds_actividad_ocupacion, ds_lugar_trabajo, ds_cuil_cuit, cd_condiva, cd_comollego, ds_dircalle, ds_dirnro, ds_dirpiso, ds_dirdepto)";
		$sql .= " VALUES ('$cd_localidad', '$ds_apynom', '$cd_tipodoc', '$nu_doc', '$dt_nacimiento', '$cd_estadocivil', '$ds_conyuge', '$ds_nacionalidad', '$ds_cp','$ds_teparticular','$telaboral', '$ds_email', '$ds_actividad_ocupacion', '$ds_lugartrabajo', '$ds_cuil_cuit', '$cd_condiva','$cd_comollego','$ds_dircalle','$ds_dirnro','$ds_dirpiso','$ds_dirdepto')";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

	static function getClientes(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();

		$sql = "SELECT C.*, PR.*, PA.*, L.* FROM cliente C";
		$sql .= " LEFT JOIN localidad L ON L.cd_localidad=C.cd_localidad ";
		$sql .= " LEFT JOIN provincia PR ON PR.cd_provincia=L.cd_provincia ";
		$sql .= " LEFT JOIN pais PA ON PA.cd_pais=PR.cd_pais ";
		$sql .= $criterio->buildFiltro();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
			
		$clientes = ResultFactory::toCollection($db,$result,new ClienteFactory());
		$db->sql_freeresult($result);
		return $clientes;
	}


	static function getCantClientes( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT count(*) as count FROM cliente ";
		$sql .= $criterio->buildFiltroSinPaginar();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$next = $db->sql_fetchassoc ( $result );
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return (( int ) $cant);
	}

	static function eliminarCliente(Cliente $obj) {
		$db = DbManager::getConnection();
		$cd_cliente = $obj->getCd_cliente ();
		$sql = "DELETE FROM cliente WHERE cd_cliente = $cd_cliente";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}


	static function getCliente( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT * FROM cliente C";
		$sql .= " LEFT JOIN localidad L ON L.cd_localidad=C.cd_localidad";
		$sql .= " LEFT JOIN provincia PR ON PR.cd_provincia=L.cd_provincia";
		$sql .= " LEFT JOIN pais PA ON PA.cd_pais=PR.cd_pais";
		$sql .= " LEFT JOIN estadocivil EC ON C.cd_estadocivil=EC.cd_estadocivil";
		$sql .= " LEFT JOIN condiva CI ON CI.cd_condiva=C.cd_condiva";
		$sql .= " LEFT JOIN tipodoc TD ON TD.cd_tipodoc=C.cd_tipodoc";
		$sql .= " LEFT JOIN comollego CL ON C.cd_comollego=CL.cd_comollego";
		$sql .= $criterio->buildFiltro();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$cliente = new Cliente();
		if ($db->sql_numrows () > 0) {
			$temp = $db->sql_fetchassoc ( $result );
			$factory = new ClienteFactory();
			$cliente = $factory->build($temp);
		}
		$db->sql_freeresult($result);
		return $cliente;
	}


	static function modificarCliente(Cliente $obj) {
		$db = DbManager::getConnection();
		$cd_cliente = $obj->getCd_cliente();
		$cd_localidad = FormatUtils::ifEmpty($obj->getLocalidad()->getCd_localidad(), 'null');
		$ds_apynom = $obj->getDs_apynom();
		$cd_tipodoc = FormatUtils::ifEmpty($obj->getTipodoc()->getCd_tipodoc(), 'null');
		$nu_doc = $obj->getNu_doc();
		$obj->setDt_nacimiento(str_replace("-", "/", $obj->getDt_nacimiento()));
		$dt_nacimiento = implode("-", array_reverse(explode("/", $obj->getDt_nacimiento())));
		$cd_estadocivil = FormatUtils::ifEmpty($obj->getEstadocivil()->getCd_estadocivil(),'null');
		$ds_conyuge = $obj->getDs_conyuge();
		$ds_nacionalidad = $obj->getDs_nacionalidad();
		$ds_cp = $obj->getDs_cp();
		$ds_teparticular = $obj->getDs_teparticular();
		$ds_telaboral = $obj->getDs_telaboral();
                $ds_email = $obj->getDs_email();
		$ds_actividad_ocupacion = $obj->getDs_actividad_ocupacion();
		$ds_lugartrabajo = $obj->getDs_lugartrabajo();
		$ds_cuil_cuit = $obj->getDs_cuil_cuit();
		$cd_condiva = FormatUtils::ifEmpty($obj->getCondiva()->getCd_condiva(),'null');
		$cd_comollego = $obj->getCd_comollego();
		$ds_dircalle = $obj->getDs_dircalle();
		$ds_dirnro = $obj->getDs_dirnro();
		$ds_dirpiso = $obj->getDs_dirpiso();
		$ds_dirdepto = $obj->getDs_dirdepto();

		$sql  = "UPDATE cliente SET cd_localidad = '$cd_localidad', ds_apynom = '$ds_apynom', cd_tipodoc = '$cd_tipodoc', nu_doc = '$nu_doc', dt_nacimiento = '$dt_nacimiento', ";
		$sql .= "cd_estadocivil = '$cd_estadocivil', ds_conyuge = '$ds_conyuge', ds_nacionalidad = '$ds_nacionalidad', ds_cp = '$ds_cp', ds_telparticular = '$ds_teparticular', ds_tellaboral = '$ds_telaboral', ds_email = '$ds_email', ds_actividad_ocupacion = '$ds_actividad_ocupacion',";
		$sql .= "ds_lugar_trabajo = '$ds_lugartrabajo', ds_cuil_cuit = '$ds_cuil_cuit', cd_condiva = '$cd_condiva', cd_comollego = '$cd_comollego', ds_dircalle = '$ds_dircalle', ds_dirnro = '$ds_dirnro', ds_dirpiso = '$ds_dirpiso', ds_dirdepto = '$ds_dirdepto'";
		$sql .= " WHERE cd_cliente = ". $cd_cliente;
                
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

}
?>