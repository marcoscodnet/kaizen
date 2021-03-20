<?php 

/**
 * 
 * @author bernardo
 * @since 14-03-2010
 * 
 * Manejador de lógica de negocio para usuarios.
 *
 */
class UsuarioManager implements IListar{

	/**
	 * se agrega un usuario.
	 * @param $oUsuario usuario a agregar.
	 * @return boolean (true=exito).
	 */
	public function agregarUsuario($oUsuario){
		
		//persistir el usuario en la bbdd.
		UsuarioQuery::insertUsuario( $oUsuario );
				
	}
	
	/**
	 * se modifica un usuario.
	 * @param $oUsuario usuario a agregar.
	 * @return boolean (true=exito).
	 */
	public function modificarUsuario($oUsuario){
				
		//persistir los cambios del usuario en la bbdd.		
		UsuarioQuery::modificarUsuario($oUsuario);
				
		//TODO postcondiciones / manejo de errores.
		//throw new Exception('some ErrorMailing Message', 500, $oZFHttpEx);
		 
	}

	
	
	/**
	 * eliminar un usuario.
	 * @param $cd_usuario identificador del usuario a eliminar
	 * @return boolean (true=exito).
	 */
	public function eliminarUsuario($cd_usuario){

		$oUsuario = new Usuario ();
		$oUsuario->setCd_usuario ( $cd_usuario );		
		
		//TODO validaciones.
		
		//persistir el cambio en la bbdd.
		UsuarioQuery::eliminarUsuario($oUsuario);
				
		//TODO postcondiciones / manejo de errores.
	}

	/**
	 * se listan usuarios.
	 * @param $criterio
	 * @return itemCollection
	 */
	public function getUsuarios(CriterioBusqueda $criterio){
				
		$usuarios = UsuarioQuery::getUsuariosConPerfil($criterio);
				
		return $usuarios;
	}
	
	
	/**
	 * obtiene un usuario específico dado un identificador.
	 * @param $cd_usuario identificador del usuario a recuperar 
	 * @return usuario
	 */
	public function getUsuarioPorId($cd_usuario){
		$oUsuario = new Usuario ();
		$oUsuario->setCd_usuario ( $cd_usuario);		
		$oUsuario=UsuarioQuery::getUsuarioPorId( $oUsuario );
		return $oUsuario;
	}
	
	/**
	 * obtiene un usuario específico junto con su perfil dado un identificador.
	 * @param $cd_usuario identificador del usuario a recuperar 
	 * @return usuario con perfil asociado.
	 */
	public function getUsuarioConPerfilPorId($cd_usuario){
		$oUsuario = new Usuario ();
		$oUsuario->setCd_usuario ( $cd_usuario);		
		$oUsuario=UsuarioQuery::getUsuarioConPerfilPorId( $oUsuario );
		return $oUsuario;
	}
	
	/**
	 * obtiene la cantidad de usuarios dado un filtro.
	 * @param $filtro filtro de búsqueda. 
	 * @return cantidad de usuarios
	 */
	public function getCantidadUsuarios( CriterioBusqueda $criterio ){
		return UsuarioQuery::getCantUsuarios( $criterio);
	}

	
	public function cambiarClave($cd_usuario, $clave_actual, $clave_nueva){
		$clave_actual = MD5 ( $clave_actual );

		$oUsuario = $this->getUsuarioPorId($cd_usuario);		
		$pass = $oUsuario->getDs_password ();
		
		if (strcmp ( $clave_actual, $pass ) == 0) {
			$oUsuario->setDs_password ( $clave_nueva );
			UsuarioQuery::modificarUsuario ( $oUsuario );
		}else{
			throw new PasswordIncorrectaException();
		}
		
	}

	public function login($nombre_usuario, $clave){
		
		//construimos el usuario.
		$oUsuario = new Usuario($nombre_usuario, $clave);
		
		//buscamos el usuario.
		$oUsuario = UsuarioQuery::getUsuarioConPerfilPorNombreYPass($oUsuario);
		
		//buscamos las funciones que puede realizar el usuario.
		$oUsuario->setFunciones ( FuncionQuery::getFuncionesDeUsuario( $oUsuario ) ) ;
		
		//iniciamos la sesión.
		$oUsuario->iniciarSesion();
			
	}
	
	//INTERFACE IListar.
	 					 
	function getEntidades ( CriterioBusqueda $criterio ){
		return $this->getUsuarios( $criterio );
	}
	
	function getCantidadEntidades (  CriterioBusqueda $criterio ){
		return $this->getCantidadUsuarios(  $criterio );
	}
	
}