<?php 

/**
 * Acción para modificar un remito de ingreso de productos.
 *
 * La modificación los productos se realiza a modo remito:
 * Fecha-Proveedor-Productos
 * 
 * @author Lucrecia
 * @since 28-04-2010
 * 
 */
class ModificarRemitoIngresoAction extends EditarRemitoIngresoAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new RemitoIngresoManager();
		$manager->modificarRemitoIngreso( $oEntidad );
		$this->setDs_forward_params( 'id='. $oEntidad->getCd_remito() );
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){
		return 'modificar_remitoIngreso_success';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'modificar_remitoIngreso_error';
	}
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar RemitoIngreso";
	}


}