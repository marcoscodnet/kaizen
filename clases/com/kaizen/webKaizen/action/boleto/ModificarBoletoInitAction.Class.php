<?php

/**
 * Acción para inicializar el contexto para modificar
 * un color.
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 */
class ModificarBoletoInitAction extends EditarBoletoInitAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar Boleto CV";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Boleto de Compra Venta";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_boleto";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/almacenes/EditarAlmacenInitAction#getEntidad()
	 */
	protected function getEntidad(){
		$oParametro = null;

		//recuperamos la obra dado su identifidor.
		$ds_nombre = "boleto_compra_venta";
		$manager = new ParametroManager();
		$criterio = new CriterioBusqueda();
		$criterio->addFiltro("ds_nombre", "'$ds_nombre'", "LIKE");
		$oParametro = $manager->getParametro( $criterio );

		return $oParametro;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}
}