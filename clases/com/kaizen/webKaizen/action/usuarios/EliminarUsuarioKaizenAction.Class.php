<?php 

/**
 * Acci�n para eliminar un usuario.
 * 
 * @author bernardo
 * @since 04-03-2010
 * 
 */
class EliminarUsuarioKaizenAction extends SecureAction{

	/**
	 * se elimina un usuario.
	 * @return boolean (true=exito).
	 */
	public function executeImpl(){
		
		$cd_usuario = $_GET ['id'];
	
		//se inicia una transacci�n.
		DbManager::begin_tran();
		
		try{  					
			//se elimina el usuario.
			$manager = new UsuarioKaizenManager();
			$manager->eliminarUsuario( $cd_usuario );
			$forward = 'eliminar_usuarioKaizen_success';
			//commit de la transacci�n.
			DbManager::save();
		}catch(GenericException $ex){
			$forward = 'eliminar_usuarioKaizen_error';
			$this->setDs_forward_params( 'er=1'.'&msg=' .$ex->getMessage() . '&code=' . $ex->getCode());
			//rollback de la transacci�n.
			DbManager::undo();
		}

		return $forward;
	}

	public function getFuncion(){
		return "Baja Usuario";
	}
	
}