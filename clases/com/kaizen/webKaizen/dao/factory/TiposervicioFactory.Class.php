<?php
/**
 * 
 * @author Marcos
 * @since 15-05-2012
 * 
 * Factory para funcion.
 *
 */
class TiposervicioFactory implements ObjectFactory{

	/**
	 * construye un tipo de servicio. 
	 * @param $next
	 * @return unknown_type
	 */
	public function build($next){
		$oTiposervicio = new Tiposervicio();
		$oTiposervicio->setCd_tiposervicio( $next ['cd_tipo_servicio'] );
		$oTiposervicio->setDs_tiposervicio( $next ['ds_tipo_servicio'] );
		
		return $oTiposervicio;
	}
}
?>