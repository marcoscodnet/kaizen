<?php
/**
 * 
 * @author bernardo
 * @since 14-03-2010
 * 
 * Factory para usuario.
 *
 */
class UsuarioFactory implements ObjectFactory{

	/**
	 * construye un usuario. 
	 * @param $next
	 * @return unknown_type
	 */
	public function build($next){
		
		$oUsuario = new Usuario();
		$oUsuario->setDs_nomusuario ( $next ['ds_nomusuario'] );
		$oUsuario->setCd_usuario ( $next ['cd_usuario'] );
		$oUsuario->setCd_perfil ( $next ['cd_perfil'] );
		$oUsuario->setDs_apynom ( $next ['ds_apynom'] );
		$oUsuario->setDs_mail ( $next ['ds_mail'] );
		$oUsuario->setDs_password ( $next ['ds_password'] );

		//para el caso que se hace el join con el perfil.
		if(array_key_exists('ds_perfil',$next)){
			$perfilFactory = new PerfilFactory();
			$oUsuario->setPerfil( $perfilFactory->build($next) );
		}
		
		return $oUsuario;
	}
}
?>