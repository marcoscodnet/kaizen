<?php 

/**
 * Acción para dar de alta un remito de ingreso de productos.
 *
 * El alta de los productos se realiza a modo remito:
 * Fecha-Proveedor-Productos
 * 
 * @author Lucrecia
 * @since 29-01-2011
 * 
 */
class AltaRemitoIngresoAction extends EditarRemitoIngresoAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new RemitoIngresoManager();
		$manager->agregarRemitoIngreso( $oEntidad );
		$this->setDs_forward_params( 'id='. $oEntidad->getCd_remito() );
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){
		return 'alta_remitoIngreso_success';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'alta_remitoIngreso_error';
	}
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Alta RemitoIngreso";
	}


}