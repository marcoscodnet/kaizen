<?php

/**
 * Acción para eliminar un remito de ingreso.
 *
 * @author Lucrecia
 * @since 30-01-2011
 *
 */
class EliminarRemitoIngresoAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		$cd_remito = $_GET ['id'];
		return $cd_remito;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new RemitoIngresoManager();
		
		$oRemito = $manager->getRemitoIngresoPorId( $oEntidad );

		if( $manager->seEntregaronProductos( $oRemito ) ){
			
			throw new GenericException( "No se puede eliminar el <b> Remito Nº  $oEntidad </b>  porque ya <br />fueron entregados algunos de sus productos a obra.", ERROR_REMITO_RESTRINGIDO);
		}

		$manager->eliminarRemitoIngreso( $oEntidad );

	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){
		return 'eliminar_remitoIngreso_success';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'eliminar_remitoIngreso_error';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Baja RemitoIngreso";
	}
}