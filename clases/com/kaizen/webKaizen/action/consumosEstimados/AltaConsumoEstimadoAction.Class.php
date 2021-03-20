<?php 

/**
 * Acción para dar de alta un consumo estimado de productos.
 *
 * @author Lucrecia
 * @since 21-01-2011
 * 
 */
class AltaConsumoEstimadoAction extends EditarConsumoEstimadoAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new ConsumoEstimadoManager();
		$manager->agregarConsumoEstimado( $oEntidad );
		$this->setDs_forward_params( 'id='. $oEntidad->getCd_consumo() );
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){
		return 'alta_consumoEstimado_success';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'alta_consumoEstimado_error';
	}
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Alta ConsumoEstimado";
	}


}