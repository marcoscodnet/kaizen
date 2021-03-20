<?php

/**
 * Acci�n para inicializar el contexto para modificar una piezaq
 * un movimiento.
 *
 * @author Marcos
 * @since 04-04-2017
 *
 */
class ModificarVentaPiezaInitAction extends EditarVentaPiezaInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar Venta Pieza";
	}	

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Venta Pieza";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_pieza_a_ventapieza";
	}
	/**	 * (non-PHPdoc)	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()	 */	protected function getAccionSubmit2(){		return "modificar_ventaPieza";	}		protected function getAccionEliminarPieza(){		return "eliminar_piezadeventapieza_modificacion";	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return false;
	}
}