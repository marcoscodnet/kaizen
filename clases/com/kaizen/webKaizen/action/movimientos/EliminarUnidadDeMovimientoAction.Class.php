<?php

/**
 * Acción para eliminar un unidad.
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 */
class EliminarUnidadDeMovimientoAction extends SecureAction{

	/**
	 * se elimina un unidad.
	 * @return boolean (true=exito).
	 */
	public function executeImpl(){

		$indice = $_GET ['id'];
		if(isset($_SESSION['unidadesamover']) && (count($_SESSION['unidadesamover'])>0)){
			$tmp_unidadesamover = $_SESSION['unidadesamover'];
			unset($tmp_unidadesamover[$indice]);
			$_SESSION['unidadesamover'] = $tmp_unidadesamover;
			$forward = "eliminar_unidaddemovimiento";
		}
		return $forward;
	}

	public function getFuncion(){
		return "Alta Movimiento";
	}

}