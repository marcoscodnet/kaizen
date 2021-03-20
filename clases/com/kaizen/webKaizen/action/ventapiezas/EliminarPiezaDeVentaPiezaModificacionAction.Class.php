<?php

/**
 * Acción para eliminar un unidad.
 *
 * @author Marcos
 * @since 08-04-2017
 *
 */
class EliminarPiezaDeVentaPiezaModificacionAction extends SecureAction{

	/**
	 * se elimina un unidad.
	 * @return boolean (true=exito).
	 */
	public function executeImpl(){
		//print_r($_SESSION['piezasavender']);
		$indice = $_GET ['id'];
		if(isset($_SESSION['piezasavender']) && (count($_SESSION['piezasavender'])>0)){
			$tmp_piezas = $_SESSION['piezasavender'];			
			unset($tmp_piezas[$indice]);
			$_SESSION['piezasavender'] = $tmp_piezas;
			$forward = "eliminar_piezadeventapieza_modificacion";			$this->setDs_forward_params( 'id='. $_GET ['cd_ventapieza'].'&mod=1');			
		}
		return $forward;
	}

	public function getFuncion(){
		return "Alta Venta Pieza";
	}

}