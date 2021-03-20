<?php 

/**
 * Acción para eliminar una obra.
 * 
 * @author Lucrecia
 * @since 31-01-2011
 * 
 */
class EliminarObraAction extends SecureAction{

	/**
	 * se elimina una obra.
	 * @return boolean (true=exito).
	 */
	public function executeImpl(){
		
		$cd_obra = $_GET ['id'];
	
		//se elimina el obra.
		$manager = new ObraManager();

		//se inicia una transacción.
		DbManager::begin_tran();
		
		try{
			
			$manager->eliminarObra( $cd_obra );
			$forward = 'eliminar_obra_success';
			//commit de la transacción.
			DbManager::save();
			
		}catch(GenericException $ex){
			$forward = 'eliminar_obra_error';
			$this->setDs_forward_params( 'er=1'.'&msg=' .$ex->getMessage() . '&code=' . $ex->getCode());
			//rollback de la transacción.
			DbManager::undo();
		}
		
		return $forward;
	}

	public function getFuncion(){
		return "Baja obra";
	}
	
}