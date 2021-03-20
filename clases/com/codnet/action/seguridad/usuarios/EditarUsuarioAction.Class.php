<?php 

/**
 * Acción para editar un almacén.
 * 
 * @author bernardo
 * @since 15-04-2010
 * 
 */
abstract class EditarUsuarioAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		$oUsuario = new Usuario ( );
		
		if (isset ( $_POST ['cd_usuario'] ))
			$oUsuario->setCd_usuario (  $_POST ['cd_usuario']  );
		
		if (isset ( $_POST ['usuario'] ))
			$oUsuario->setDs_nomusuario (  $_POST ['usuario'] ) ;
		
		if (isset ( $_POST ['apynom'] ))
			$oUsuario->setDs_apynom ( $_POST ['apynom'] ) ;
		
		if (isset ( $_POST ['mail'] ))
			$oUsuario->setDs_mail (  $_POST ['mail'] ) ;
		
		if (isset ( $_POST ['pass'] ))
			$oUsuario->setDs_password (  $_POST ['pass'] ) ;
		
		if (isset ( $_POST ['perfil'] ))
			$oUsuario->setCd_perfil ( $_POST ['perfil'] ) ;
		
		return $oUsuario;
	}
}