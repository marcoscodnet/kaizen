<?php 

/**
 * Acción para inicializar el contexto para modificar
 * un cliente.
 *  
 * @author Lucrecia
 * @since 18-01-2011
 * 
 */
class ModificarProductoInitAction extends EditarProductoInitAction{
	

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar Producto";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Producto";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_producto";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/almacenes/EditarAlmacenInitAction#getEntidad()
	 */
	protected function getEntidad(){
		$oCliente = null;
		if (isset ( $_GET ['id'] )) {
			//recuperamos la obra dado su identifidor.
			$cd_producto = $_GET ['id'];			
			
			$manager = new ProductoManager();
			$oProducto = $manager->getProductoPorId( $cd_producto );
		}
		return $oProducto;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}	
}