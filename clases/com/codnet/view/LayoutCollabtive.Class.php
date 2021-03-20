<?php

/**
 * Representa un layout tipo collabtive:
 * 	
 *
 * Este layout debe mostrar menúes, una superior (Solapas) y uno lateral.
 * 
 * vamos a agregar un archivo de configuración donde indicamos para cada acción:
 *  - las solapas a mostrar en el menú superior (menugroups)
 *  - la solapa que debe estar activa (menugroup)
 *  - las opciones a mostrar en el menú lateral (menuoptions)
 *	 
 * (usamos navigation.xml)
 * 
 * @author bernardo
 * @since 03-02-2011
 */
abstract class LayoutCollabtive extends Layout{

	
	//para segurizar los menúes.
	protected $oUsuario;
	
	public function show(){
		
		//buscamos si la acción ejecutada tiene una configuración especial
		//para los menúes.
		$menuGroupActivo = '';
		$menuGroups = '';
		$menuOptions = '';
		
		
		$navegacion = LoadNavigation::getInstance();
		$accionActual = FormatUtils::getCurrentAction();
		$accion = $navegacion->getAccionPorNombre( $accionActual );
		
		if( !empty( $accion ) ) {
			$menuGroupActivo = $accion['menuGroupActivo'];
			$menuGroups = $accion['menuGroups'];
			$menuOptions = $accion['menuOptions'];
		}
		
		
		//seteamos el usuario para chequear permisos sobre los menúes.
		$oUsuario = new Usuario();
		$oUsuario->setCd_usuario( $_SESSION ["cd_usuarioSession"] );
		$oUsuario->setFunciones( $_SESSION ["funciones"] );
		$oUsuario->setDs_nomusuario( $_SESSION ["ds_usuario"] );
		$this->oUsuario = $oUsuario;
		
		
		$xtpl = $this->getXTemplate ( $menuGroupActivo, $menuOptions );
		
		$xtpl->assign('titulo', $this->getTitulo());
		$xtpl->assign('header', $this->getHeader());
		$xtpl->assign('user', $oUsuario->getDs_nomusuario() );
		$xtpl->assign('content', $this->getContenido());
		$xtpl->assign('footer', $this->getFooter());
		$this->parseMetaTags($xtpl);
		$this->parseEstilos($xtpl);
		$this->parseScripts($xtpl);

		$this->parseException($xtpl);
		
		//seteamos los menúes.
		if( !empty($menuGroupActivo) )
			$this->parseMenuSolapas($xtpl, $menuGroups, $menuGroupActivo);
			
		$this->parseMenuSuperiorDerecho($xtpl);
		$this->parseMenuLateral($xtpl, $menuOptions, $menuGroupActivo);
		
		$xtpl->parse('main');

		return $xtpl->text('main');
	}

	protected function getXTemplate( $menuGroupActivo='', $menuOptions ){
		
		//si no tiene menugroupactivo o se indicó que no hay opciones, entonces el template es sin menú lateral.
		if( empty($menuGroupActivo) || (!empty($menuOptions) &&  ($menuOptions=='false') ) )
			return new XTemplate (APP_PATH. CLASS_PATH . 'codnet/view/collabtive_template.html');
		else
			return $this->getXTemplateMenu();
	}
	
	
	protected function getXTemplateMenu(){
		return new XTemplate (APP_PATH. CLASS_PATH . 'codnet/view/collabtive_menu_template.html');
	}
	
	/**
	 * retorna el contenido a mostrar en el header.
	 * @return unknown_type
	 */
	protected abstract function getHeader();
	
	/**
	 * retorna el contenido a mostrar en el footer.
	 * @return unknown_type
	 */
	protected abstract function getFooter();

	/**
	 * parsea meta-tags del contenido.
	 * @param unknown_type $xtpl
	 * @return unknown_type
	 */
	protected abstract function parseMetaTags($xtpl);
	
	/**
	 * parsea los estilos css del contenido.
	 * @param unknown_type $xtpl
	 * @return unknown_type
	 */
	protected abstract function parseEstilos($xtpl);
	
	/**
	 * parsea los scripts incluidos en el contenido.
	 * @param unknown_type $xtpl
	 * @return unknown_type
	 */
	protected abstract function parseScripts($xtpl);
	
	/**
	 * parsea el menu superior derecho.
	 * @param unknown_type $xtpl
	 * @return unknown_type
	 */
	protected abstract function parseMenuSuperiorDerecho($xtpl);

	
	
	/**
	 * parsea el menu lateral.
	 * @param unknown_type $xtpl
	 * @return unknown_type
	 */
	protected function parseMenuLateralAction($action, $xtpl){
	
		$action->parseMenuLateral($this, $xtpl);
	}
	
	/**
	 * parsea el menu lateral.
	 * @param unknown_type $xtpl
	 * @return unknown_type
	 */
	protected function parseMenuLateral($xtpl, $menuOptions, $menuGroupActivo){
		
		if( empty( $menuOptions )){
			$this->parseMenuLateralDeMenuGroupActivo( $xtpl, $menuGroupActivo );
		}else{

			//instanciamos el menú por reflection.
			$default_menu = DEFAULT_MENU;
			if( !empty($default_menu) ){
				$oClass = new ReflectionClass(DEFAULT_MENU);
				$oMenu = $oClass->newInstance();
	
				//obtenemos la lista de menuoptions (id's).
				$menuoptionsId = explode ( "," , $menuOptions );
				
				$menuoptions = $oMenu->getMenuOptionsPorId( $menuoptionsId );
				
				foreach($menuoptions as $key => $opcion){
							
					$this->parseMenuOption( $xtpl, $opcion );
					
				}
			}
		}
		
		
	}
	
	/**
	 * parsea el menu lateral.
	 * @param unknown_type $xtpl
	 * @return unknown_type
	 */
	protected function parseMenuLateralDeMenuGroupActivo($xtpl, $menuGroupActivo){
		//instanciamos el menú por reflection.
		$default_menu = DEFAULT_MENU;
		if( !empty($default_menu) ){
			$oClass = new ReflectionClass(DEFAULT_MENU);
			$oMenu = $oClass->newInstance();

			foreach($oMenu->getGrupos() as $key => $menuGroup) {

				//buscamos el menugroup.				
				if($menuGroupActivo==$menuGroup->getCd_menugroup()){
				
					//mostramos cada item del menugroup.
					
					foreach($menuGroup->getOpciones() as $key => $opcion){
						
						$this->parseMenuOption( $xtpl, $opcion );
							
					}
					
				}
				
			}
		}		
		
	}
	public function getAction(){
		return $this->oAction;
	}
	
	public function setAction($action){
		$this->oAction = $action;
	}
	
	protected function parseMenuSolapas($xtpl, $menuGroups, $menuGroupActivo){
		
		/* si menuGroups está vacío, se muestran todos los menúes */
		
		if( empty($menuGroups) ){
			$this->parseMenuSolapasTodas( $xtpl, $menuGroupActivo );
			
		}else{
			
			//obtenemos la lista de menugroups (id's).
			$menugroupsId = explode ( "," , $menuGroups );
			
			//instanciamos el menú por reflection.
			$default_menu = DEFAULT_MENU;
			if( !empty($default_menu) ){
				$oClass = new ReflectionClass(DEFAULT_MENU);
				$oMenu = $oClass->newInstance();

				foreach($menugroupsId as $key => $id) {
				
					$menuGroup = $oMenu->getMenuGroupPorId( $id );
						
					$css_class = $menuGroup->getDs_cssclass();
					if( !empty($css_class) ){
	
						$this->parseMenuGroup( $xtpl, $menuGroup, $menuGroupActivo );
							
					}
				}
			}
				
		}
		
	}

	protected function parseMenuGroup(XTemplate $xtpl, $menuGroup, $menuGroupActivo){
		
		if( $menuGroup->tieneAcceso( $this->oUsuario->getFunciones() ) ){
			
			$xtpl->assign('css_li_class', $menuGroup->getDs_cssclass() );
				
			if($menuGroupActivo==$menuGroup->getCd_menugroup())
				$xtpl->assign('css_a_class', "active");
			else
				$xtpl->assign('css_a_class', "");
			
			$xtpl->assign('href', 'doAction?action=' . $menuGroup->getDs_action());
			
			$xtpl->assign('action_description', $menuGroup->getDs_nombre());				
			$xtpl->parse('main.menu_solapas');
		
		}
		
	}

	protected function parseMenuOption(XTemplate $xtpl, $menuOption){
		
		if( $menuOption->tieneAcceso( $this->oUsuario->getFunciones() ) ){
			
			$xtpl->assign('css_class', $menuOption->getDs_cssclass());
			$xtpl->assign('action_description', $menuOption->getDs_nombre());
			$xtpl->assign('href', $menuOption->getDs_href());				
			$xtpl->parse('main.menu_lateral');
		
		}
		
	}
	
	
	protected function parseMenuSolapasTodas($xtpl, $menuGroupActivo){
		
		if( !empty($menuGroupActivo) ) {
		
			//instanciamos el menú por reflection.
			$default_menu = DEFAULT_MENU;
			if( !empty($default_menu) ){
				$oClass = new ReflectionClass(DEFAULT_MENU);
				$oMenu = $oClass->newInstance();
	
				foreach($oMenu->getGrupos() as $key => $menuGroup) {
	
					$css_class = $menuGroup->getDs_cssclass();
					if( !empty($css_class) ){
	
						$this->parseMenuGroup( $xtpl, $menuGroup, $menuGroupActivo );
							
					}
				}
			}
		}
		
	}


	protected function parseException(XTemplate $xtpl){
		$exception = $this->getException();
		if( !empty($exception) ){
		
			$xtpl->assign('error_message', $exception->getMessage() );
			$xtpl->parse('main.error_message');
		}		
		
	}
}
