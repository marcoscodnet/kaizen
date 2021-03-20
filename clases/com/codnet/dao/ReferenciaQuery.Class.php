<?php
/**
 * Acceso a datos para referencias.
 * 
 * Deberá subclasificarse esta clase para
 * indicar las referencias concretas:
 * 
 * 	- Tabla
 *  - código
 *  - descripción
 * 
 * @author bernardo
 * @since 31-03-10
 *
 */
abstract class ReferenciaQuery {
	
	protected abstract function getTabla();
	protected abstract function getCampoCodigo();
	protected abstract function getCampoDescripcion();
	protected abstract function getFactory();
	
		
	function insertReferencia(Referencia $obj) {
		
		$db = DbManager::getConnection(); 
		
		$ds_referencia = $obj->getDs_referencia();
		
		$tabla = $this->getTabla();
		$campoDescripcion = $this->getCampoDescripcion();
		
		$sql  = "INSERT INTO $table ( $campoDescripcion ) ";
		$sql .= " VALUES ('$ds_referencia'";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
	}
	
	function getReferencias(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection(); 
		
		$tabla = $this->getTabla();
		$campoDescripcion = $this->getCampoDescripcion();
		
		$sql = "SELECT * FROM $tabla";
		$sql .= $criterio->buildFiltro();
		
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
					
		$referencias = ResultFactory::toCollection($db,$result, $this->getFactory());
		$db->sql_freeresult($result);
		return $referencias;
	}
	
	
	function getCantReferencias( CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();

		$tabla = $this->getTabla();
		
		$sql = "SELECT count(*) as count FROM $tabla ";
		$sql .= $criterio->buildFiltroSinPaginar();
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
		
		$next = $db->sql_fetchassoc ( $result );		 
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return (( int ) $cant);
	}
		
	function eliminarReferencia(Referencia $obj) {
		$db = DbManager::getConnection();
		$cd_referencia = $obj->getCd_referencia ();

		$tabla = $this->getTabla();
		$campoCodigo = $this->getCampoCodigo();
		
		$sql = "DELETE FROM $tabla WHERE $campoCodigo = $cd_referencia";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
	}
	
	function getReferenciaPorId(Referencia $obj) {
		$db = DbManager::getConnection();
		$cd_referencia = $obj->getCd_referencia ();
		
		$tabla = $this->getTabla();
		$campoCodigo = $this->getCampoCodigo();
		
		$sql = "SELECT * FROM $tabla";
		$sql .= " WHERE $campoCodigo = $cd_referencia";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
					
		if ($db->sql_numrows () > 0) {
			$temp = $db->sql_fetchassoc ( $result );
			$obj = $this->getFactory()->build($temp);
			
		}
		$db->sql_freeresult($result);
		return ($obj);
	}
	
	function modificarReferencia(Referencia $obj) {
		$db = DbManager::getConnection();
		$cd_referencia = $obj->getCd_referencia();
		$ds_referencia = $obj->getDs_referencia();

		$tabla = $this->getTabla();
		$campoDescripcion = $this->getCampoDescripcion();
		$campoCodigo = $this->getCampoCodigo();
		
		$sql  = "UPDATE $tabla SET $campoDescripcion='$ds_referencia' ";
		$sql .= " WHERE $campoCodigo = ". $cd_referencia;
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());		
	}
	
}
?>