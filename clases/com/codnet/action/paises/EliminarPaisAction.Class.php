<?php 

/**
 * Acci�n para eliminar un pais.
 * 
 * @author bernardo
 * @since 18-03-2010
 * 
 */
class EliminarPaisAction extends SecureAction{

	/**
	 * se elimina un cliente.
	 * @return boolean (true=exito).
	 */
	public function executeImpl(){
		
		$cd_pais = $_GET ['id'];
	
		$manager = new PaisManager();

		//se inicia una transacci�n.
		DbManager::begin_tran();
		
		try{
			
			$manager->eliminarPais( $cd_pais );
			$forward = 'eliminar_pais_success';
			//commit de la transacci�n.
			DbManager::save();
			
		}catch(GenericException $ex){
			$forward = 'eliminar_pais_error';
			$this->setDs_forward_params( 'er=1'.'&msg=' .$ex->getMessage() . '&code=' . $ex->getCode());
			//rollback de la transacci�n.
			DbManager::undo();
		}
		
		return $forward;
	}
	

	public function getFuncion(){
		return "Baja Pais";
	}
	
}