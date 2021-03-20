<?php 

/**
 * Acci�n para cambiar la clave del usuario logueado.
 * 
 * @author bernardo
 * @since 16-03-2010
 * 
 */
class CambiarClaveAction extends SecureAction{

	/**
	 * se modifica la clave del usuario logueado.
	 * @return boolean (true=exito).
	 */
	public function executeImpl(){
		
		$clave_actual = $_POST ['clave_actual'];
		$clave_nueva = $_POST ['ds_password'];
		$cd_usuario = $_SESSION ["cd_usuarioSession"]; 
		//se inicia una transacci�n.
		DbManager::begin_tran();
		
		try{  					
			$manager = new UsuarioManager();
			$manager->cambiarClave($cd_usuario,  $clave_actual, $clave_nueva);			
			$forward = 'cambiar_clave_success';
			$this->setDs_forward_params('menuGroupActivo=1');
			//commit de la transacci�n.
			DbManager::save();
		}catch(GenericException $ex){
			$forward = 'cambiar_clave_error';
			$this->setDs_forward_params( 'er=1'.'&msg=' .$ex->getMessage() . '&code=' . $ex->getCode());
			//rollback de la transacci�n.
			DbManager::undo();
		}
			
		return $forward;
	}

	public function getFuncion(){
		return "Cambiar clave";
	}
		
}