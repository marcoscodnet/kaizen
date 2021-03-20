<?php 

/**
 * 
 * @author bernardo
 * @since 11-03-2010
 * 
 * Para segurizar la llamada a las funciones mediante ajax.
 * Todas aquellas acciones por ajax que requieran segurizarse,
 * deberán extender de SecureAjaxAction.
 * 
 */
abstract class SecureAjaxAction extends Action{

	/**
	 * Previa ejecución de la acción, validará los permisos
	 * de usuario.
	 * (non-PHPdoc)
	 * @see clases/com/codnet/challenge/actions/Action#execute($funcion)
	 */
	public function execute($cd_usuario){
		
		//se conecta a la base de datos.
		DbManager::connect();
		
		
		$tienePermiso = true;
		
		if($this->getFuncion()!=null)
			//chequeamos el permiso para ejecutar la acción.
			$tienePermiso = PermisoQuery::permisosDeUsuario ( $cd_usuario, $this->getFuncion() );
		
		if (!$tienePermiso)
			//si no tiene permiso, forward a la página de acceso denegado.
			$result = "";
		else{
			//si tiene permiso, se ejecuta la acción.
			$result = $this->executeImpl();
		}
		
		//se cierra la conexión.
		DbManager::close();		
		
		return $result;
	}
	
	/**
	 * Cada subclase implementará la funcionalidad específica.
	 * @return forward.
	 */
	public abstract function executeImpl();
	
	/**
	 * Cada subclase retornará la función asociada
	 * a los permisos.
	 * @return función para permisos.
	 */
	public abstract function getFuncion();
		
}