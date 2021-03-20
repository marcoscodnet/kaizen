<?php 

/**
 * Acción para eliminar un consumo estimado de productos.
 * 
 * @author Lucrecia
 * @since 21-01-2011
 * 
 */
class EliminarConsumoEstimadoAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		$cd_consumo = $_GET ['id'];
		return $cd_consumo;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new ConsumoEstimadoManager();
		$manager->eliminarConsumoEstimado( $oEntidad );
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){
		return 'eliminar_consumoEstimado_success';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'eliminar_consumoEstimado_error';
	}
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Baja ConsumoEstimado";
	}	
}