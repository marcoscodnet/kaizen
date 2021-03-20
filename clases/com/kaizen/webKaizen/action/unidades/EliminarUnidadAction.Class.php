<?php 

/**
 * Acción para eliminar un unidad.
 * 
 * @author Lucrecia
 * @since 18-01-2011
 * 
 */
class EliminarUnidadAction extends SecureAction{

	/**
	 * se elimina un unidad.
	 * @return boolean (true=exito).
	 */
	public function executeImpl(){
		
		$cd_unidad = $_GET ['id'];
	
		//se elimina el unidad.
		$manager = new UnidadManager();

		//se inicia una transacción.
		DbManager::begin_tran();
		
		try{
			
			$manager->eliminarUnidad( $cd_unidad );
			$forward = 'eliminar_unidad_success';
			//commit de la transacción.
			DbManager::save();
			
		}catch(GenericException $ex){
			$forward = 'eliminar_unidad_error';
			$this->setDs_forward_params( 'er=1'.'&msg=' .$ex->getMessage() . '&code=' . $ex->getCode());
			//rollback de la transacción.
			DbManager::undo();
		}
		
		return $forward;
	}

	public function getFuncion(){
		return "Baja unidad";
	}
	
}