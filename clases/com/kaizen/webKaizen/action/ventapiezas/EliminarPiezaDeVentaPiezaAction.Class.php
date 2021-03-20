<?php

/**
 * Acción para eliminar un unidad.
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 */
class EliminarPiezaDeVentaPiezaAction extends SecureAction{

	/**
	 * se elimina un unidad.
	 * @return boolean (true=exito).
	 */
	public function executeImpl(){

		$indice = $_GET ['id'];
		if(isset($_SESSION['piezasavender']) && (count($_SESSION['piezasavender'])>0)){
			$tmp_piezas = $_SESSION['piezasavender'];
			unset($tmp_piezas[$indice]);
			$_SESSION['piezasavender'] = $tmp_piezas;
			$forward = "eliminar_piezadeventapieza";
		}
		return $forward;
	}

	public function getFuncion(){
		return "Alta Venta Pieza";
	}

}