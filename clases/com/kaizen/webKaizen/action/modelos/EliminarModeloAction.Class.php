<?php 

/**
 * Acción para eliminar un modelo.
 * 
 * @author Lucrecia
 * @since 18-01-2011
 * 
 */
class EliminarModeloAction extends SecureAction{

	/**
	 * se elimina un cliente.
	 * @return boolean (true=exito).
	 */
	public function executeImpl(){
		
		$cd_modelo = $_GET ['id'];
	
		//se elimina el cliente.
		$manager = new ModeloManager();

		//se inicia una transacción.
		DbManager::begin_tran();
		
		try{
			
			$manager->eliminarModelo( $cd_modelo );
			$forward = 'eliminar_modelo_success';
			//commit de la transacción.
			DbManager::save();
			
		}catch(GenericException $ex){
			$forward = 'eliminar_modelo_error';
			$this->setDs_forward_params( 'er=1'.'&msg=' .$ex->getMessage() . '&code=' . $ex->getCode());
			//rollback de la transacción.
			DbManager::undo();
		}
		
		return $forward;
	}
	

	public function getFuncion(){
		return "Baja Modelo";
	}
	
}