<?php 

/**
 * Acción para modificar un perfil.
 * 
 * @author bernardo
 * @since 10-03-2010
 * 
 */
class ModificarPerfilAction extends EditarPerfilAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new PerfilManager();
		$manager->modificarPerfil( $oEntidad[0], $oEntidad[1] );
		$oUsuarioManager = new UsuarioManager();
		$oUsuario = $oUsuarioManager->getUsuarioPorId($_SESSION ["cd_usuarioSession"]);
		$oUsuario->setFunciones ( FuncionQuery::getFuncionesDeUsuario( $oUsuario ) ) ;
		$_SESSION ["funciones"] = $oUsuario->getFunciones() ;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){
		return 'modificar_perfil_success';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'modificar_perfil_error';
	}
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar Perfil";
	}

}