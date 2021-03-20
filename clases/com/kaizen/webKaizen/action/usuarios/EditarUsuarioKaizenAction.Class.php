<?php 

/**
 * Acci�n para editar un almac�n.
 * 
 * @author bernardo
 * @since 15-04-2010
 * 
 */
abstract class EditarUsuarioKaizenAction extends EditarUsuarioAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		$oUsuario = new UsuarioKaizen ( );
		
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

        if (isset ( $_POST ['cd_sucursal'] ))
			$oUsuario->setCd_sucursal ( $_POST ['cd_sucursal'] ) ;
			
		if (isset ( $_POST ['bl_resetearclave'] ))
			$oUsuario->setBl_resetearclave ( $_POST ['bl_resetearclave'] ) ;
		$oUsuario->setBl_activo(0);			if ($_POST ['bl_activo']){			$oUsuario->setBl_activo(1);		}
		
		return $oUsuario;
	}
}