<?php 

/**
 * Acción para modificar un remito de ingreso de productos en el cual
 * ya alguno de los productos fueron entregados a obra.
 *
 * Sólo se puede modicar comprobante y observaciones.
 * 
 * @author Lucrecia
 * @since 25-01-2011
 * 
 */
class ModificarRemitoIngresoRestringidoAction extends ModificarRemitoIngresoAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new RemitoIngresoManager();
		$manager->modificarRemitoIngresoRestringido( $oEntidad );
		$this->setDs_forward_params( 'id='. $oEntidad->getCd_remito() );
		
	}
	
	/**
	 * 
	 */
	protected function getEntidad(){
		$oRemito = new RemitoIngreso();

		if (isset ( $_POST ['cd_remito'] ))
			$oRemito->setCd_remito (  $_POST ['cd_remito'] ) ;
		
		if (isset ( $_POST ['tipo'] ))
			$oRemito->setCd_tipo ( $_POST ['tipo']  );
		
		if (isset ( $_POST ['ds_observaciones'] ))
			$oRemito->setDs_observaciones (  $_POST ['ds_observaciones']  );
		
		if (isset ( $_POST ['nu_numero'] ))
			$oRemito->setNu_numero(  $_POST ['nu_numero']  );
		
		return $oRemito;
	}
}