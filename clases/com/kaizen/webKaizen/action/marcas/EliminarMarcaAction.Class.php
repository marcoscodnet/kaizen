<?php 

/**
 * Acci�n para eliminar un marca.
 * 
 * @author Lucrecia
 * @since 09-01-2011
 * 
 */
class EliminarMarcaAction extends SecureAction{

	/**
	 * se elimina un marca.
	 * @return boolean (true=exito).
	 */
	public function executeImpl(){
		
		$cd_marca = $_GET ['id'];
		
		//se inicia una transacci�n.
		DbManager::begin_tran();
		
		try{
			$manager = new MarcaManager();			
			$manager->eliminarMarca( $cd_marca);
			$forward = 'eliminar_marca_success';
			//commit de la transacci�n.
			DbManager::save();
			
		}catch(GenericException $ex){
			$forward = 'eliminar_marca_error';
			$this->setDs_forward_params( 'er=1'.'&msg=' .$ex->getMessage() . '&code=' . $ex->getCode() );
			//rollback de la transacci�n.
			DbManager::undo();
		}
		
		return $forward;
	}

	public function getFuncion(){
		return "Baja Marca";
	}
	
}