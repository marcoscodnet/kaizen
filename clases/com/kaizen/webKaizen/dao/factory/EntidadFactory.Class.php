<?php
/**
 * 
 * @author Lucrecia
 * @since 09-01-2011
 * 
 * Factory para país.
 *
 */
class EntidadFactory implements ObjectFactory{

	/**
	 * construye una entidad. 
	 * @param $next
	 * @return unknown_type
	 */
	public function build($next){
		$oEntidad = new Entidad();
		$oEntidad->setCd_entidad( $next ['cd_entidad'] );
		$oEntidad->setDs_entidad( $next ['ds_entidad'] );
		return $oEntidad;
	}
}
?>