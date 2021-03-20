<?php

/**
 * Acci�n para dar de alta una movimiento.
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 */
class AltaMovimientoAction extends EditarMovimientoAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new MovimientoManager();
		$manager->agregarMovimiento($oEntidad[0], $oEntidad[1]);
		$this->setDs_forward_params( 'id='. $oEntidad[0]->getCd_movimiento());
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){

		return 'alta_movimiento_success';

	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'alta_movimiento_error';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Alta Movimiento";
	}

}