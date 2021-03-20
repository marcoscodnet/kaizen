<?php
/**
 * 
 * @author Lucrecia
 * @since 09-01-2011
 * 
 * Factory para país.
 *
 */
class EstadocivilFactory implements ObjectFactory{

	/**
	 * construye un estado civil. 
	 * @param $next
	 * @return unknown_type
	 */
	public function build($next){
		$oEstadocivil = new Estadocivil();
		$oEstadocivil->setCd_estadocivil( $next ['cd_estadocivil'] );
		$oEstadocivil->setDs_estadocivil( $next ['ds_estadocivil'] );
		return $oEstadocivil;
	}
}
?>