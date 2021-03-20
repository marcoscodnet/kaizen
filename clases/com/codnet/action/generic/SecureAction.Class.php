<?php

/**
 *
 * @author bernardo
 * @since 03-03-2010
 *
 * Para segurizar la llamada a las funciones.
 * Todas aquellas acciones que requieran segurizarse,
 * deber�n extender de SecureAction.
 *
 */
abstract class SecureAction extends Action{

	/**
	 * Previa ejecuci�n de la acci�n, validar� los permisos
	 * de usuario.
	 * (non-PHPdoc)
	 * @see clases/com/codnet/challenge/actions/Action#execute($funcion)
	 */
	public function execute($cd_usuario){

		//se chequea que el usuario est� logueado.

		session_start ();
		if (! isset ( $_SESSION ["cd_usuarioSession"] ) || ($_SESSION ['cd_usuarioSession'] == "")) {
				
			$forward = 'registrarse_error';
			$this->setDs_forward_params('er=2');
				
		}else{

			//se conecta a la base de datos.
			DbManager::connect();
				
			$tienePermiso = true;
				
			if($this->getFuncion()!=null)
			//chequeamos el permiso para ejecutar la acci�n.
			$tienePermiso = PermisoQuery::permisosDeUsuario ( $cd_usuario, $this->getFuncion() );

			if (!$tienePermiso)
			//si no tiene permiso, forward a la p�gina de acceso denegado.
			$forward = 'acceso_denegado';
			else{
				//si tiene permiso, se ejecuta la acci�n.
				$forward = $this->executeImpl();
			}

			//se cierra la conexi�n.
			DbManager::close();
				
		}


		return $forward;
	}


	/**
	 * cargar� el men� en el xtemplate
	 * @param XTemplate $xtpl xtemplate donde cargar� el men�.
	 * @param unknown_type $tag nombre del tag d�nde se insertar� el men�.
	 * @param unknown_type $block nombre del bloque donde se encuentra el tag.
	 * @return unknown_type
	 */
	public function cargarMenu(XTemplate $xtpl, $tag, $block, $ds_menuActivo=''){
		//$xtpl->assign ( $tag, $this->getMenu() );
		$oMenuComponent = $this->getMenuComponent($ds_menuActivo);

		if( !FormatUtils::isEmpty( $oMenuComponent ) ){
			$xtpl->assign ( $tag, $oMenuComponent->show() );
			$xtpl->parse ( $block );
		}

	}

	public function getMenuHTML($ds_menuActivo=''){

		$oMenuComponent = $this->getMenuComponent($ds_menuActivo);
		if( !FormatUtils::isEmpty( $oMenuComponent ) ){
			return $this->getMenuComponent($ds_menuActivo)->show() ;
		}

		return "";
	}

	/**
	 * Cada subclase implementar� la funcionalidad espec�fica.
	 * @return forward.
	 * @throws ChallengeException
	 */
	public abstract function executeImpl();

	/**
	 * Cada subclase retornar� la funci�n asociada
	 * a los permisos.
	 * @return funci�n para permisos.
	 */
	public abstract function getFuncion();


	/**
	 * men�
	 * //TODO se podria armar en funci�n del usuario logueado.
	 * @return menu.html parseado.
	 */
	public function getMenuComponent($ds_menuActivo=''){

		//instanciamos el men� por reflection.
		$default_menu = DEFAULT_MENU;
		if( !empty($default_menu) ){
			$oClass = new ReflectionClass(DEFAULT_MENU);
			$oMenu = $oClass->newInstance();
				
			//recuperamos el usuario de sessi�n.
			$oUsuario = new Usuario();
			$oUsuario->setCd_usuario( $_SESSION ["cd_usuarioSession"] );
			$oUsuario->setFunciones( $_SESSION ["funciones"] );
				
			return new MenuComponent($oMenu, $oUsuario);

		}else {return null;}

	}

	/**
	 * dado un link, se determina si el usuario tiene permiso para accederlo.
	 * @param unknown_type $link
	 */
	public function tienePermisoLink($link){
		//vemos si en el $link podemos obtener una acci�n, si hay algo del estilo 'doAction?action=xxx&' (deber�a)
		//luego chequeamos que el usuario logueado tenga permiso para ejecutar dicha acci�n.

		//obtenemos la acci�n
		$pos_accion = strpos( $link, "action" );
		$ds_action= substr( $link ,  $pos_accion );
		$length = strpos( $ds_action, "&" );
		$ds_action = substr( $ds_action ,  0, $length );

		$pos_equal = strpos( $ds_action, "=" );
		$ds_action_value = substr( $ds_action ,  $pos_equal+1 );

		return $this->tienePermisoAccion( $ds_action_value );

	}

	/**
	 * dada una acci�n retorna si el usuario tiene permiso para realizarla.
	 * @param unknown_type $ds_action
	 */
	public function tienePermisoAccion($ds_action){
		try{

			//1-buscamos la clase asociada.
			//inicializa el mapeo de acciones.
			$map = new ActionMapHelper();
			//obtenemos la acci�n a ejecutar.
			$ds_action_class=$map->getAction($ds_action);
			//instanciamos la acci�n por reflection.
			$oClass = new ReflectionClass($ds_action_class);
			$oAction = $oClass->newInstance();
			//obtenemos la funci�n asociada.
			$ds_funcion = $oAction->getFuncion();
				
			//chequeamos con los permisos del usuario.
			$funciones =  $_SESSION ["funciones"];
				
			if(!empty($funciones)){

				foreach ($funciones as $oFuncion) {
					$tienePermiso =  (  strtoupper( $oFuncion->getDs_funcion() )  ==  strtoupper( $ds_funcion ) );
					if($tienePermiso) break;
				}
					
			}
				
				
			//chequeamos el permiso para ejecutar la acci�n.
			//$tienePermiso = PermisoQuery::permisosDeUsuario ( $cd_usuario, $ds_funcion );
		}catch(Exception $ex){
			$tienePermiso = false;
		}
		return $tienePermiso;

	}

	public function tienePermisoFuncion($ds_funcion){
		try{
			//chequeamos con los permisos del usuario.
			$funciones =  $_SESSION ["funciones"];
				
			if(!empty($funciones)){

				foreach ($funciones as $oFuncion) {
					$tienePermiso =  (  strtoupper( $oFuncion->getDs_funcion() )  ==  strtoupper( $ds_funcion ) );
					if($tienePermiso) break;
				}
					
			}
			//chequeamos el permiso para ejecutar la acci�n.
			//$tienePermiso = PermisoQuery::permisosDeUsuario ( $cd_usuario, $ds_funcion );
		}catch(Exception $ex){
			$tienePermiso = false;
		}
		return $tienePermiso;

	}

}