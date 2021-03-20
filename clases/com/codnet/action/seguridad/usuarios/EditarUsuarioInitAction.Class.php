<?php 

/**
 * Acción para inicializar el contexto para editar
 * un almacén.
 * 
 * @author bernardo
 * @since 15-04-2010
 * 
 */
abstract class EditarUsuarioInitAction  extends EditarInitAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getEntidad()
	 */
	protected function getEntidad(){
		return new Usuario();
	}
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oUsuario = FormatUtils::ifEmpty($entidad, new Usuario());
		
		$xtpl->assign ( 'ds_apynom', stripslashes ( $oUsuario->getDs_apynom () ) );
		$xtpl->assign ( 'ds_mail', stripslashes ( $oUsuario->getDs_mail () ) );
		$xtpl->assign ( 'ds_nomusuario', stripslashes ( $oUsuario->getDs_nomusuario () ) );
		$xtpl->assign ( 'cd_usuario', $oUsuario->getCd_usuario () );
				
	
		$perfilManager = new PerfilManager();
		$perfiles = $perfilManager->getPerfiles();
		
		foreach($perfiles as $key => $perfil) {
			$xtpl->assign ( 'ds_perfil', $perfil->getDs_perfil() );
			$xtpl->assign ( 'cd_perfil', FormatUtils::selected($perfil->getCd_perfil(), $oUsuario->getCd_perfil()) );
			
			$xtpl->parse ( 'main.option' );
		}
		
	}
	
	
}