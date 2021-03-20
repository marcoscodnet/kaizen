<?php 

/**
 * Acción para inicializar el contexto para modificar
 * un perfil.
 *  
 * @author bernardo
 * @since 10-03-2010
 * 
 */
class ModificarPerfilInitAction extends EditarPerfilInitAction{

	protected function getEntidad(){
		$oPerfil = null;
		if (isset ( $_GET ['id'] )) {
			//recuperamos dado su identifidor.
			$cd_perfil = $_GET ['id'];			
			
			$manager = new PerfilManager();
			$oPerfil = $manager->getPerfilConFuncionesPorId( $cd_perfil );
		}
		
		return $oPerfil ;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar Perfil";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Perfil";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_perfil";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}	
		
}