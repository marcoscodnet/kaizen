<?php
/**
 * Acción para eliminar de sesión un producto utilizando Ajax.
 * 
 * @author Lucrecia
 * @since 29-01-2011
 *
 */
class EliminarProductoRemitoIngresoAction extends EditarProductoRemitoIngresoAction{

	

	/**
	 * se elimina de sesión el producto seleccionado.
	 */
	public function editarProducto(){

		//eliminamos el producto de la sesión.
		if (isset ( $_GET ['indice'] )){
			$indice = $_GET ['indice'];
			
			$productos = array();
			$count = count($_SESSION['productos_nuevos']);
			for($i=0;$i<$count;$i++) {
	    		
				if($i!=$indice){
					array_push ( $productos,  $_SESSION['productos_nuevos'][$i]);
				}
				
			}
			
			$_SESSION['productos_nuevos'] = $productos;
			
		}
	}
}