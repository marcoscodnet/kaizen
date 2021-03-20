<?php 

/**
 * Acción para modificar un cliente.
 * 
 * @author Lucrecia
 * @since 18-01-2011
 * 
 */
class ModificarModeloAction extends EditarModeloAction{
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new ModeloManager();
		$manager->modificarModelo($oEntidad);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){
		return 'modificar_modelo_success';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'modificar_modelo_error';
	}
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar Modelo";
	}

}