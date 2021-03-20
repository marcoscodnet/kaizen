<?php 

/**
 * Acci�n para inicializar el contexto para editar
 * un almac�n.
 * 
 * @author bernardo
 * @since 15-04-2010
 * 
 */
abstract class EditarUsuarioKaizenInitAction  extends EditarUsuarioInitAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getEntidad()
	 */
	protected function getEntidad(){
		return new UsuarioKaizen();
	}
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oUsuario = FormatUtils::ifEmpty($entidad, new UsuarioKaizen());
		
		$xtpl->assign ( 'ds_apynom', stripslashes ( $oUsuario->getDs_apynom () ) );
		$xtpl->assign ( 'ds_mail', stripslashes ( $oUsuario->getDs_mail () ) );
		$xtpl->assign ( 'ds_nomusuario', stripslashes ( $oUsuario->getDs_nomusuario () ) );
		$xtpl->assign ( 'cd_usuario', $oUsuario->getCd_usuario () );
						$checekd ='';		if ($oUsuario->getBl_activo() == 1) {			$checekd = 'checked=checked';		}				$xtpl->assign('checked', $checekd);
	
		$perfilManager = new PerfilManager();
		$perfiles = $perfilManager->getPerfiles();
		
		foreach($perfiles as $key => $perfil) {
			$xtpl->assign ( 'ds_perfil', $perfil->getDs_perfil() );
			$xtpl->assign ( 'cd_perfil', FormatUtils::selected($perfil->getCd_perfil(), $oUsuario->getCd_perfil()) );
			
			$xtpl->parse ( 'main.option' );
		}

                $sucursalManager = new SucursalManager();
		$sucursales = $sucursalManager->getSucursales();
		foreach($sucursales as $key => $sucursal) {
			$xtpl->assign ( 'ds_nombre', $sucursal->getDs_nombre() );
			$xtpl->assign ( 'cd_sucursal', FormatUtils::selected($sucursal->getCd_sucursal(), $oUsuario->getCd_sucursal()) );

			$xtpl->parse ( 'main.option_sucursal' );
		}
		
	}
	
	
}