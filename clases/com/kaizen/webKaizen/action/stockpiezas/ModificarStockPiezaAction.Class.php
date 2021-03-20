<?php

/**
 * Acción para modificar stock pieza.
 *
 * @author Ma. Jesús
 * @since 15-07-2011
 *
 */
class ModificarStockPiezaAction extends EditarStockPiezaAction{
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new StockPiezaManager();
		$manager->modificarStockPieza($oEntidad);
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){
		return 'modificar_stockPieza_success';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'modificar_stockPieza_error';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar Stock Pieza";
	}

}