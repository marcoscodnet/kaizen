<?php

/**
 * 
 *
 * @author Marcos
 * @since 07-04-2017
 *
 */
class ModificarVentaPiezaAction extends EditarVentaPiezaAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new VentaPiezaManager();				$manager->eliminarVentaPieza($oEntidad[0]->getCd_ventapieza());				$manager->agregarVentaPieza($oEntidad[0], $oEntidad[1]);		        $this->setDs_forward_params( 'id='. $oEntidad[0]->getCd_ventapieza());         
		
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){

		return 'alta_ventapieza_success';

	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'alta_ventapieza_error';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Alta Venta Pieza";
	}

}