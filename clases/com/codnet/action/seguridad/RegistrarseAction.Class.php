<?php 

/**
 * Acción para registrarse en el sistema.
 * 
 * @author bernardo
 * @since 16-03-2010
 * 
 */
class RegistrarseAction extends Action{

	/**
	 * se registra el usuario en el sistema (login).
	 * @return forward.
	 */
	public function execute($cd_usuario){
		if (isset ( $_POST ['usuario'] ))
			$nomusuario = $_POST ['usuario'] ;
		 else
			$nomusuario = '';
		
		if (isset ( $_POST ['pass'] ))
			$password = $_POST ['pass'] ; 
		else
			$password = '';
		
			
		//se conecta a la base de datos.
		
		
		try{
			DbManager::connect();
			$manager = new UsuarioManager();
			$manager->login($nomusuario,$password);
			$forward = 'registrarse_success';
			//se cierra la conexión.
			DbManager::close();		
		}catch(GenericException $ex){
			$forward = 'registrarse_error';
			$this->setDs_forward_params( 'er=1'.'&msg=' .$ex->getMessage() . '&code=' . $ex->getCode() );			
		}

		
		
		return $forward;
	}
	
}