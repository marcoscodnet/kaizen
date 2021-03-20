<?php 

/**
 * Acción para eliminar un perfil.
 * 
 * @author bernardo
 * @since 09-03-2010
 * 
 */
class EliminarPerfilAction extends SecureAction{

	/**
	 * se elimina un perfil.
	 * @return boolean (true=exito).
	 */
	public function executeImpl(){
		
		$cd_perfil = $_GET ['id'];
		
		//se inicia una transacción.
		DbManager::begin_tran();
		
		try{
			$manager = new PerfilManager();			
			$manager->eliminarPerfil( $cd_perfil);
			$forward = 'eliminar_perfil_success';
			//commit de la transacción.
			DbManager::save();
			
		}catch(GenericException $ex){
			$forward = 'eliminar_perfil_error';
			$this->setDs_forward_params( 'er=1'.'&msg=' .$ex->getMessage() . '&code=' . $ex->getCode() );
			//rollback de la transacción.
			DbManager::undo();
		}
		
		return $forward;
	}

	public function getFuncion(){
		return "Baja Perfil";
	}
	
}