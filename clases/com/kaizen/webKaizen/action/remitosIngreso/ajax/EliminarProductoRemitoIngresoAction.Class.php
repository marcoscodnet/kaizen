<?php
/**
 * Acci�n para eliminar de sesi�n un producto utilizando Ajax.
 * 
 * @author Lucrecia
 * @since 29-01-2011
 *
 */
class EliminarProductoRemitoIngresoAction extends EditarProductoRemitoIngresoAction{

	

	/**
	 * se elimina de sesi�n el producto seleccionado.
	 */
	public function editarProducto(){

		//eliminamos el producto de la sesi�n.
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