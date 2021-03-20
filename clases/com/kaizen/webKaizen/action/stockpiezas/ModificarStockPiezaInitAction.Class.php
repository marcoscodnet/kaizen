<?php

/**
 * Acción para inicializar el contexto para modificar
 * stock pieza.
 *
 * @author Ma. Jesús
 * @since 15-07-2011
 *
 */
class ModificarStockPiezaInitAction extends EditarStockPiezaInitAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar Stock Pieza";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Stock Pieza";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_stockPieza";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/almacenes/EditarAlmacenInitAction#getEntidad()
	 */
	protected function getEntidad(){
		$oStockPieza = null;
		if (isset ( $_GET ['id'] )) {
			//recuperamos el stock pieza dado su identifidor.
			$cd_stockpieza = $_GET ['id'];

			$manager = new StockPiezaManager();
			$oStockPieza = $manager->getStockPiezaPorId( $cd_stockpieza );
		}
		return $oStockPieza;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}
}