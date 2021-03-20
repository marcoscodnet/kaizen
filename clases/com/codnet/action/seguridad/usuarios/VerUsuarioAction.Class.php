<?php 

/**
 * Acción para visualizar un usuario.
 *  
 * @author bernardo
 * @since 14-03-2010
 * 
 */
class VerUsuarioAction extends SecureOutputAction{

	/**
	 * consulta un usuario.
	 * @return forward.
	 */
	protected function getContenido(){
			
		$xtpl = new XTemplate ( APP_PATH . 'usuarios/verusuario.html' );
		
		if (isset ( $_GET ['id'] )) {
			$cd_usuario = $_GET ['id'];
			
			$manager = new UsuarioManager();
			try{
				$oUsuario = $manager->getUsuarioConPerfilPorId ( $cd_usuario );
			}catch(GenericException $ex){
				$oUsuario = new Usuario();
				//TODO ver si se muestra un mensaje de error.
			}			
			
			//se muestra el usuario.
			$xtpl->assign ( 'cd_usuario', stripslashes ( $oUsuario->getCd_usuario () ) );
			$xtpl->assign ( 'ds_apynom', stripslashes ( $oUsuario->getDs_apynom () ) );
			$xtpl->assign ( 'ds_mail', stripslashes ( $oUsuario->getDs_mail () ) );
			$xtpl->assign ( 'ds_nomusuario', stripslashes ( $oUsuario->getDs_nomusuario () ) );
			$xtpl->assign ( 'ds_perfil', stripslashes ($oUsuario->getDs_perfil () ) );

			//TODO mostrar fixture.
		}
		
		$xtpl->assign ( 'titulo', $this->getTitulo() );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}
	
	public function getFuncion(){
		return "Ver Usuario";
	}
	
	public function getTitulo(){
		return "Detalle de Usuario";
	}
	
	
}