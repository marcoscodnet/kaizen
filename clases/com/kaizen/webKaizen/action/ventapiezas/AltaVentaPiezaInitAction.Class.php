<?php

/**
 * Acci�n para inicializar el contexto para dar de alta
 * un movimiento.
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 */
class AltaVentaPiezaInitAction extends EditarVentaPiezaInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Alta Venta Pieza";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Alta Venta Pieza";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "alta_pieza_a_ventapieza";
	}
	/**	 * (non-PHPdoc)	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()	 */	protected function getAccionSubmit2(){		return "alta_ventaPieza";	}
	protected function getAccionEliminarPieza(){		return "eliminar_piezadeventapieza";	}
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return false;
	}
}