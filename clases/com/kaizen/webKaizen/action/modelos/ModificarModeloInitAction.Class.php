<?php 

/**
 * Acción para inicializar el contexto para modificar
 * una modelo.
 *  
 * @author Lucrecia
 * @since 18-01-2011
 * 
 */
class ModificarModeloInitAction extends EditarModeloInitAction{
	

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar Modelo";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Modelo";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_modelo";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/almacenes/EditarAlmacenInitAction#getEntidad()
	 */
	protected function getEntidad(){
		$oModelo = null;
		if (isset ( $_GET ['id'] )) {
			//recuperamos la obra dado su identifidor.
			$cd_modelo = $_GET ['id'];			
			
			$manager = new ModeloManager();
			$oModelo = $manager->getModeloPorId( $cd_modelo );
		}
		
		return $oModelo;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}	
}