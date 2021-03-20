<?php

/**
 * Acci�n para dar de alta una movimiento.
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 */
class AltaUnidadAMovimientoAction extends EditarUnidadAMovimientoAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		if(isset($_SESSION['unidadesamover'])){
			$tmp_unidades = $_SESSION['unidadesamover'];
		}else{
			$tmp_unidades = array();
		}
		
		if(! $this->yaExiste($tmp_unidades, $oEntidad)){
			array_push($tmp_unidades, $oEntidad);
		}
		$_SESSION['unidadesamover'] = $tmp_unidades;
	}

	protected function yaExiste($listado, $oEntidad){
		foreach($listado as $movimiento){
			if($movimiento->getCd_unidad() == $oEntidad->getCd_unidad()){
				return true;
			}
		}
		return false;
	}

	protected function getForwardSuccess(){
		return 'alta_unidadamover_success';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'alta_unidadamover_error';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Alta Movimiento";
	}

}