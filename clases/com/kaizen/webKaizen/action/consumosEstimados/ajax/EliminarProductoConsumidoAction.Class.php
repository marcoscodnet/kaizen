<?php
/**
 * AcciÃ­on para eliminar de sesión un producto consumido utilizando Ajax.
 * 
 * @author Lucrecia
 * @since 26-01-2011
 *
 */
class EliminarProductoConsumidoAction extends EditarProductoConsumidoAction{

	

	/**
	 * se elimina de sesión el producto consumido seleccionado.
	 */
	public function editarProductoConsumido(){

		//eliminamos el producto consumido de la sesión.
		if (isset ( $_GET ['indice'] )){
			$indice = $_GET ['indice'];
			
			$consumos = array();
			$count = count($_SESSION['consumos']);
			for($i=0;$i<$count;$i++) {
	    		
				if($i!=$indice){
					array_push ( $consumos,  $_SESSION['consumos'][$i]);
				}
				
			}
			
			$_SESSION['consumos'] = $consumos;
			
		}
	}
}