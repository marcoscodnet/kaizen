<?php
/**
 * Acceso a datos para distritos.
 * 
 * @author Lucrecia
 * @since 31-03-10
 *
 */
class DistritoQuery extends ReferenciaQuery{
	
	protected function getTabla(){
		return 'distrito';
	}
	
	protected function getCampoCodigo(){
		return 'cd_distrito';
	}
	
	protected function getCampoDescripcion(){
		return 'ds_distrito';
	}
	
	protected function getFactory(){
		return new DistritoFactory();
	}	
	
	
}
?>