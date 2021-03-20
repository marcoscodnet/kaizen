<?php
/**
 * Acceso a datos para sucursal.
 * 
 * @author Lucrecia
 * @since 18-03-10
 *
 */
class SucursalQuery {
	
	static function insertSucursal(Sucursal $obj) {
		$db = DbManager::getConnection(); 
		
		$cd_localidad = FormatUtils::ifEmpty($obj->getLocalidad()->getCd_localidad(), 'null');
		$ds_nombre = $obj->getDs_nombre();
		$ds_telefono = $obj->getDs_telefono();
		$ds_domicilio = $obj->getDs_domicilio();
		$ds_comentario = $obj->getDs_comentario();
		$ds_email = $obj->getDs_email();
		
		$sql  = "INSERT INTO sucursal (cd_localidad, ds_nombre, ds_telefono, ds_domicilio, ds_comentario, ds_email) ";
		$sql .= " VALUES ($cd_localidad, '$ds_nombre', '$ds_telefono', '$ds_domicilio', '$ds_comentario', '$ds_email') ";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
	}
	
	static function getSucursales(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection(); 
		
		$sql = "SELECT S.*, PR.*, PA.*, L.* FROM sucursal S";
		$sql .= " LEFT JOIN localidad L ON L.cd_localidad=S.cd_localidad ";
		$sql .= " LEFT JOIN provincia PR ON PR.cd_provincia=L.cd_provincia ";
		$sql .= " LEFT JOIN pais PA ON PA.cd_pais=PR.cd_pais ";
		$sql .= $criterio->buildFiltro();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
					
		$sucursales = ResultFactory::toCollection($db,$result,new SucursalFactory());
		$db->sql_freeresult($result);
		return $sucursales;
	}
	
	
	static function getCantSucursales( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT count(*) as count FROM sucursal ";
		$sql .= $criterio->buildFiltroSinPaginar();
		
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
		
		$next = $db->sql_fetchassoc ( $result );		 
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return (( int ) $cant);
	}
		
	static function eliminarSucursal(Sucursal $obj) {
		$db = DbManager::getConnection();
		$cd_sucursal = $obj->getCd_sucursal ();
		$sql = "DELETE FROM sucursal WHERE cd_sucursal = $cd_sucursal";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
	}
	
	
	static function getSucursal( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT * FROM sucursal S";
		$sql .= " LEFT JOIN localidad L ON L.cd_localidad=S.cd_localidad";
		$sql .= " LEFT JOIN provincia PR ON PR.cd_provincia=L.cd_provincia";
		$sql .= " LEFT JOIN pais PA ON PA.cd_pais=PR.cd_pais";
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());

		$sucursal = new Sucursal();
		if ($db->sql_numrows () > 0) {
			$temp = $db->sql_fetchassoc ( $result );
			$factory = new SucursalFactory();
			$sucursal = $factory->build($temp);
		}
		$db->sql_freeresult($result);
		return $sucursal;
	}
	
	
	static function modificarSucursal(Sucursal $obj) {
		$db = DbManager::getConnection();
		$cd_sucursal = $obj->getCd_sucursal();
		$cd_localidad = FormatUtils::ifEmpty($obj->getLocalidad()->getCd_localidad(), 'null');
		$ds_nombre = $obj->getDs_nombre();
		$ds_telefono = $obj->getDs_telefono();
		$ds_domicilio = $obj->getDs_domicilio();
		$ds_comentario = $obj->getDs_comentario();
		$ds_email = $obj->getDs_email();
		
		$sql  = "UPDATE sucursal SET cd_localidad=$cd_localidad, ds_nombre='$ds_nombre', ds_telefono='$ds_telefono', ";
		$sql .= " ds_domicilio='$ds_domicilio', ds_comentario='$ds_comentario', ds_email='$ds_email' ";
		$sql .= " WHERE cd_sucursal = ". $cd_sucursal;
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());		
	}
	
	
	static function getSucursalesPorStockPieza(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection(); 
		
		$sql = "SELECT DISTINCT S.*, PR.*, PA.*, L.* FROM sucursal S";
		$sql .= " LEFT JOIN localidad L ON L.cd_localidad=S.cd_localidad ";
		$sql .= " LEFT JOIN provincia PR ON PR.cd_provincia=L.cd_provincia ";
		$sql .= " LEFT JOIN pais PA ON PA.cd_pais=PR.cd_pais ";
		$sql .= " LEFT JOIN stockpieza SP ON S.cd_sucursal=SP.cd_sucursal ";
		$sql .= $criterio->buildFiltro();
		
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
					
		$sucursales = ResultFactory::toCollection($db,$result,new SucursalFactory());
		$db->sql_freeresult($result);
		return $sucursales;
	}
	
}
?>