<?php 

/**
 * Acción para eliminar un centidad.
 * 
 * @author Lucrecia
 * @since 18-01-2011
 * 
 */
class EliminarEntidadAction extends SecureAction{

	/**
	 * se elimina un cliente.
	 * @return boolean (true=exito).
	 */
	public function executeImpl(){
		
		$cd_centidad = $_GET ['id'];
	
		$manager = new EntidadManager();

		//se inicia una transacción.
		DbManager::begin_tran();
		
		try{
			
			$manager->eliminarEntidad( $cd_centidad );
			$forward = 'eliminar_entidad_success';
			//commit de la transacción.
			DbManager::save();
			
		}catch(GenericException $ex){
			$forward = 'eliminar_entidad_error';
			$this->setDs_forward_params( 'er=1'.'&msg=' .$ex->getMessage() . '&code=' . $ex->getCode());
			//rollback de la transacción.
			DbManager::undo();
		}
		
		return $forward;
	}
	

	public function getFuncion(){
		return "Baja Entidad";
	}
	
}