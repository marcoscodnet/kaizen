<?php 

/**
 * Acción para inicializar el contexto para modificar
 * un usuario.
 *  
 * @author bernardo
 * @since 14-03-2010
 * 
 */
class ModificarUsuarioInitAction extends EditarUsuarioInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate ( APP_PATH. '/usuarios/modificarusuario.html' );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar Usuario";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Usuario";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_usuario";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/almacenes/EditarAlmacenInitAction#getEntidad()
	 */
	protected function getEntidad(){
		$oUsuario = null;
		if (isset ( $_GET ['id'] )) {
			//recuperamos dado su identifidor.
			$cd_usuario = $_GET ['id'];			
			
			$manager = new UsuarioManager();
			$oUsuario = $manager->getUsuarioPorId( $cd_usuario );
		}
		
		return $oUsuario;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}
	
}