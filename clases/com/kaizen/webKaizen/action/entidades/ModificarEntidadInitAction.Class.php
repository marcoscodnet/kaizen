<?php 

/**
 * Acción para inicializar el contexto para modificar
 * un entidad.
 *  
 * @author Lucrecia
 * @since 18-01-2011
 * 
 */
class ModificarEntidadInitAction extends EditarEntidadInitAction{
	

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar Entidad";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Entidad";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_entidad";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/almacenes/EditarAlmacenInitAction#getEntidad()
	 */
	protected function getEntidad(){
		$oEntidad = null;
		if (isset ( $_GET ['id'] )) {
			//recuperamos la obra dado su identifidor.
			$cd_entidad = $_GET ['id'];			
			
			$manager = new EntidadManager();
			$oEntidad = $manager->getEntidadPorId( $cd_entidad );
		}
		
		return $oEntidad;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}	
}