<?php
/**
 * Acceso a datos para remitos.
 * 
 * @author Lucrecia
 * @since 29-03-10
 *
 */
class RemitoIngresoQuery {
	
	static function insertRemitoIngreso(RemitoIngreso $obj) {
		$db = DbManager::getConnection(); 
		
		$dt_fecha = $obj->getDt_fecha();
		$cd_proveedor = FormatUtils::ifEmpty($obj->getCd_proveedor(), 'null');
		$cd_tipo = FormatUtils::ifEmpty($obj->getCd_tipo(), 'null');
		$ds_observaciones = $obj->getDs_observaciones();
		$nu_numero = $obj->getNu_numero();
		
		$sql  = "INSERT INTO remitoingreso (dt_fecha, cd_proveedor, cd_tiporemitoingreso, ds_observaciones, nu_numero) ";
		$sql .= " VALUES ('$dt_fecha',  $cd_proveedor, $cd_tipo, '$ds_observaciones', '$nu_numero') ";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
			
		$cd_remito =  $db->sql_nextid();
		$obj->setCd_remito($cd_remito);
		return $obj;
			
	}
	
	static function getRemitosIngreso(CriterioBusqueda $criterio) {
		
		$db = DbManager::getConnection(); 
		
		$sql = "SELECT RI.*, P.*, TRI.ds_tiporemitoingreso  ";
		$sql .= " FROM remitoingreso RI";
		$sql .= " LEFT JOIN proveedor P ON P.cd_proveedor=RI.cd_proveedor ";
		$sql .= " LEFT JOIN tiporemitoingreso TRI ON TRI.cd_tiporemitoingreso=RI.cd_tiporemitoingreso ";
		
		$sql .= $criterio->buildFiltro();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
					
		$remitos = ResultFactory::toCollection($db,$result,new RemitoIngresoFactory());
		$db->sql_freeresult($result);
		return $remitos;
	}
	
	
	static function getCantRemitosIngreso(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT count(*) as count FROM remitoingreso RI ";
		$sql .= " LEFT JOIN proveedor P ON P.cd_proveedor=RI.cd_proveedor ";
		$sql .= " LEFT JOIN tiporemitoingreso TRI ON TRI.cd_tiporemitoingreso=RI.cd_tiporemitoingreso ";
		$sql .= $criterio->buildFiltroSinPaginar();
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
		
		$next = $db->sql_fetchassoc ( $result );		 
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return (( int ) $cant);
	}
		
	static function eliminarRemitoIngreso(RemitoIngreso $obj) {
		$db = DbManager::getConnection();
		$cd_remito = $obj->getCd_remito ();
		$sql = "DELETE FROM remitoingreso WHERE cd_remito = $cd_remito";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
	}
	
	static function getRemitoIngreso (CriterioBusqueda  $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT RI.*, P.*, TRI.ds_tiporemitoingreso  ";
		$sql .= " FROM remitoingreso RI";
		$sql .= " LEFT JOIN proveedor P ON P.cd_proveedor=RI.cd_proveedor ";
		$sql .= " LEFT JOIN tiporemitoingreso TRI ON TRI.cd_tiporemitoingreso=RI.cd_tiporemitoingreso ";
		$sql .= $criterio->buildFiltro();
		
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
					
		if ($db->sql_numrows () > 0) {
			$temp = $db->sql_fetchassoc ( $result );
			$factory = new RemitoIngresoFactory();
			$obj = $factory->build($temp);
		}else{
			$obj = new RemitoIngreso();
		}
		
		$db->sql_freeresult($result);
		return ($obj);
	}
	
	static function modificarRemitoIngreso(RemitoIngreso $obj) {
		$db = DbManager::getConnection();
		$cd_remito = $obj->getCd_remito();
		$dt_fecha = $obj->getDt_fecha();
		$cd_proveedor = $obj->getCd_proveedor();
		$cd_tipo = $obj->getCd_tipo();
		$nu_numero = $obj->getNu_numero();
		$ds_observaciones = $obj->getDs_observaciones();
								
		$sql  = "UPDATE remitoingreso SET cd_proveedor=$cd_proveedor, dt_fecha='$dt_fecha', cd_tiporemitoingreso=$cd_tipo, nu_numero='$nu_numero',  ds_observaciones='$ds_observaciones' ";
		$sql .= " WHERE cd_remito = ". $cd_remito;
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());	
	}
	
	static function modificarRemitoIngresoRestringido(RemitoIngreso $obj) {
		$db = DbManager::getConnection();
		$cd_remito = $obj->getCd_remito();
		$cd_tipo = $obj->getCd_tipo();
		$nu_numero = $obj->getNu_numero();
		$ds_observaciones = $obj->getDs_observaciones();
								
		$sql  = "UPDATE remitoingreso SET  cd_tiporemitoingreso=$cd_tipo, nu_numero='$nu_numero',  ds_observaciones='$ds_observaciones' ";
		$sql .= " WHERE cd_remito = ". $cd_remito;
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());	
	}
	
	
	
	static function insertProductoEnRemito(Producto $oProducto, RemitoIngreso $oRemito) {
		$db = DbManager::getConnection(); 
		
		$cd_remito = $oRemito->getCd_remito();
		$cd_producto = $oProducto->getCd_producto();
		$nu_cantidad = $oProducto->getNu_cantidad();
		
		//reemplazamos los puntos por las comas.
		$nu_cantidad = str_replace(',',  '.', $nu_cantidad);
		
		
		$sql  = "INSERT INTO producto_remitoingreso (cd_producto, cd_remito, nu_cantidad) ";
		$sql .= " VALUES ($cd_producto, $cd_remito, $nu_cantidad) ";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
	}
	
	static function getProductosDeRemito(RemitoIngreso $oRemito) {
		$db = DbManager::getConnection(); 
		
		$cd_remito = $oRemito->getCd_remito();
	
		$sql  = "SELECT PRI.nu_cantidad as nu_cantidadremito, P.*, TP.*, UM.*, "; 
		$sql .= " PR.ds_producto as ds_productorelacionado, PR.cd_producto as cd_productorelacionado, PR.nu_cantidad as nu_cantidadrelacionado, "; 
		$sql .= " TPR.ds_tipoproducto as ds_tipoproductorelacionado, TPR.cd_tipoproducto as cd_tipoproductorelacionado "; 
		$sql .= " FROM producto_remitoingreso PRI ";
		$sql .= " LEFT JOIN producto P ON P.cd_producto=PRI.cd_producto ";
		$sql .= " LEFT JOIN tipoproducto TP ON TP.cd_tipoproducto=P.cd_tipoproducto ";
		$sql .= " LEFT JOIN unidadmedida UM ON UM.cd_unidadmedida=TP.cd_unidadmedida ";
		$sql .= " LEFT JOIN producto PR ON PR.cd_producto=P.cd_productorelacionado ";
		$sql .= " LEFT JOIN tipoproducto TPR ON TPR.cd_tipoproducto=PR.cd_tipoproducto ";
		$sql .= " WHERE PRI.cd_remito=$cd_remito ";
		$sql .= " ORDER BY ds_producto";
		
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
					
		$productos = ResultFactory::toCollection($db,$result,new ProductoRemitoIngresoFactory());
		$db->sql_freeresult($result);
		return $productos;
			
	}
	
	static function eliminarProductosDeRemito(RemitoIngreso $oRemito) {
		$db = DbManager::getConnection(); 
		
		$cd_remito = $oRemito->getCd_remito();
		
		$sql  = "DELETE FROM producto_remitoingreso ";
		$sql .= " WHERE cd_remito=$cd_remito ";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
	}
	
}
?>