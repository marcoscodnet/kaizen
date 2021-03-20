<?php 

/**
 * Acción para eliminar un cliente.
 * 
 * @author Lucrecia
 * @since 18-01-2011
 * 
 */
class EliminarClienteAction extends SecureAction{

	/**
	 * se elimina un cliente.
	 * @return boolean (true=exito).
	 */
	public function executeImpl(){
		
		$cd_cliente = $_GET ['id'];
	
		//se elimina el cliente.
		$manager = new ClienteManager();

		//se inicia una transacción.
		DbManager::begin_tran();
		
		try{
			
			$manager->eliminarCliente( $cd_cliente );
			$forward = 'eliminar_cliente_success';
			//commit de la transacción.
			DbManager::save();
			
		}catch(GenericException $ex){
			$forward = 'eliminar_cliente_error';
			$this->setDs_forward_params( 'er=1'.'&msg=' .$ex->getMessage() . '&code=' . $ex->getCode());
			//rollback de la transacción.
			DbManager::undo();
		}
		
		return $forward;
	}

	public function getFuncion(){
		return "Baja cliente";
	}
	
}