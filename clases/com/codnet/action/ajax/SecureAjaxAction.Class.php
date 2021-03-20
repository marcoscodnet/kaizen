<?php 

/**
 * 
 * @author bernardo
 * @since 11-03-2010
 * 
 * Para segurizar la llamada a las funciones mediante ajax.
 * Todas aquellas acciones por ajax que requieran segurizarse,
 * deber�n extender de SecureAjaxAction.
 * 
 */
abstract class SecureAjaxAction extends Action{

	/**
	 * Previa ejecuci�n de la acci�n, validar� los permisos
	 * de usuario.
	 * (non-PHPdoc)
	 * @see clases/com/codnet/challenge/actions/Action#execute($funcion)
	 */
	public function execute($cd_usuario){
		
		//se conecta a la base de datos.
		DbManager::connect();
		
		
		$tienePermiso = true;
		
		if($this->getFuncion()!=null)
			//chequeamos el permiso para ejecutar la acci�n.
			$tienePermiso = PermisoQuery::permisosDeUsuario ( $cd_usuario, $this->getFuncion() );
		
		if (!$tienePermiso)
			//si no tiene permiso, forward a la p�gina de acceso denegado.
			$result = "";
		else{
			//si tiene permiso, se ejecuta la acci�n.
			$result = $this->executeImpl();
		}
		
		//se cierra la conexi�n.
		DbManager::close();		
		
		return $result;
	}
	
	/**
	 * Cada subclase implementar� la funcionalidad espec�fica.
	 * @return forward.
	 */
	public abstract function executeImpl();
	
	/**
	 * Cada subclase retornar� la funci�n asociada
	 * a los permisos.
	 * @return funci�n para permisos.
	 */
	public abstract function getFuncion();
		
}