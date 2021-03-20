<?php
/**
 * 
 * @author bernardo
 * @since 14-03-2010
 * 
 * Factory para perfil.
 *
 */
class PerfilFactory implements ObjectFactory{

	/**
	 * construye una perfil. 
	 * @param $next
	 * @return unknown_type
	 */
	public function build($next){
		$oPerfil = new Perfil();
		$oPerfil->setCd_perfil( $next ['cd_perfil'] );
		$oPerfil->setDs_perfil( $next ['ds_perfil'] );
		
		return $oPerfil;
	}
}
?>