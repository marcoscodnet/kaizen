<?php
/**
 * 
 * @author bernardo
 * @since 14-03-2010
 * 
 * Factory para funcion.
 *
 */
class FuncionFactory implements ObjectFactory{

	/**
	 * construye una funcion. 
	 * @param $next
	 * @return unknown_type
	 */
	public function build($next){
		$oFuncion = new Funcion();
		$oFuncion->setCd_funcion( $next ['cd_funcion'] );
		$oFuncion->setDs_funcion( $next ['ds_funcion'] );
		
		return $oFuncion;
	}
}
?>