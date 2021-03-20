<?php 

/**
 * Acción para eliminar un producto.
 * 
 * @author Lucrecia
 * @since 18-01-2011
 * 
 */
class EliminarProductoAction extends SecureAction{

	/**
	 * se elimina un producto.
	 * @return boolean (true=exito).
	 */
	public function executeImpl(){
		
		$cd_producto = $_GET ['id'];
	
		//se elimina el producto.
		$manager = new ProductoManager();

		//se inicia una transacción.
		DbManager::begin_tran();
		
		try{
			
			$manager->eliminarProducto( $cd_producto );
			$forward = 'eliminar_producto_success';
			//commit de la transacción.
			DbManager::save();
			
		}catch(GenericException $ex){
			$forward = 'eliminar_producto_error';
			$this->setDs_forward_params( 'er=1'.'&msg=' .$ex->getMessage() . '&code=' . $ex->getCode());
			//rollback de la transacción.
			DbManager::undo();
		}
		
		return $forward;
	}

	public function getFuncion(){
		return "Baja producto";
	}
	
}