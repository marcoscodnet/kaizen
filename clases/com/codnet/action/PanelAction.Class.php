<?php 

/**
 * Acción para mostrar un panel de control.
 * 
 * @author bernardo
 * @since 08-03-2011
 * 
 */
class PanelAction extends SecureOutputAction{


	/**
	 * layout a utilizar para la salida.
	 * @return Layout
	 */
	protected function getSecureLayout(){
		//el layuout será definido en la constante DEFAULT_PANEL_LAYOUT
		
		//instanciamos el layout por reflection.
		$oClass = new ReflectionClass(DEFAULT_PANEL_LAYOUT);
		$oLayout = $oClass->newInstance();
		
		return $oLayout;
	}
	
	/**
	 * se muestra un panel de control con íconos para
	 * acceder a las operaciones.
	 */
	protected function getContenido(){

		$xtpl = $this->getXTemplate();
		$xtpl->assign('WEB_PATH', WEB_PATH);	
		

		//título del listado.
		$xtpl->assign( 'titulo', $this->getTitulo() );
		
		//generamos el contenido.
		$this->parsePanel( $xtpl );
		
		$xtpl->parse('main' );
		return $xtpl->text( 'main' );

	}

	/**
	 * template donde parsear la salida.
	 * @return unknown_type
	 */
	protected function getXTemplate(){
		return new XTemplate(APP_PATH. CLASS_PATH . 'codnet/view/collabtive_panel_template.html');
	}

	protected function parsePanel( XTemplate $xtpl ){
	
		$menuGroupActivo = FormatUtils::getParam('menuGroupActivo');

		$menuOptions = FormatUtils::getParam('menuOptions');
		
		//instanciamos el menú por reflection.
		$default_menu = DEFAULT_MENU;
		if( !empty($default_menu) ){
			$oClass = new ReflectionClass(DEFAULT_MENU);
			$oMenu = $oClass->newInstance();
		
		
			//si no hay una solapa activa, mostramos todo el menú.
			if( empty($menuGroupActivo) ){
				$this->parseMenu( $xtpl, $oMenu );
			}else{
			
				//si hay opciones definidas las mostramos, sino mostramos las opciones del menú activo.
				if( empty( $menuOptions) ){
					$this->parseMenuGroup( $xtpl, $oMenu, $menuGroupActivo);
				}else{
					
					$this->parseMenuGroupOptions( $xtpl, $oMenu, $menuGroupActivo, $menuOptions );
				}
			}

		}
	}
	
	/**
	 * se parsea una menú group específico.
	 *
	 */
	protected function parseMenuGroupOptions( XTemplate $xtpl, $oMenu, $menuGroupActivo, $menuOptions, $titulo=''){
		
		if( empty( $titulo ) ){
			$menuGroup = $oMenu->getMenuGroupPorId( $menuGroupActivo );
			$titulo = $menuGroup->getDs_nombre();
		}
		
		$opciones = $oMenu->getMenuOptionsPorId( explode(",", $menuOptions ));
		
		$this->parseOpciones($xtpl, $opciones, $titulo );
		
	}
	
	/**
	 * se parsea una menú group específico.
	 *
	 */
	protected function parseMenuGroup( XTemplate $xtpl, $oMenu, $menuGroupActivo, $titulo=''){
		
		$menuGroup = $oMenu->getMenuGroupPorId( $menuGroupActivo );
		
		if( !empty( $menuGroup) ){

			if( empty( $titulo))
				$titulo = $menuGroup->getDs_nombre();
					
			//mostramos cada item del menugroup.
			$this->parseOpciones($xtpl, $menuGroup->getOpciones(), $titulo );
				
		}
	}

	
	function parseOpciones(XTemplate $xtpl, $opciones, $titulo='' ){
		
		//recuperamos el usuario de sessión para chequear los permisos sobre el menú.
		$oUsuario = new Usuario();
		$oUsuario->setCd_usuario( $_SESSION ["cd_usuarioSession"] );
		$oUsuario->setFunciones( $_SESSION ["funciones"] );
	
		
		foreach($opciones as $key => $opcion){

			if( $opcion->tieneAcceso( $oUsuario->getFunciones() ) ){
				$xtpl->assign('li_class', $opcion->getDs_cssclass());
				
				$descripcion = $opcion->getDs_descripcionpanel();
				
				if(empty($descripcion))
					$xtpl->assign('descripcion', $opcion->getDs_nombre());
				else
					$xtpl->assign('descripcion', $opcion->getDs_descripcionpanel());
				$xtpl->assign('href', $opcion->getDs_href());				
				$xtpl->parse('main.group.item');
			}
		}
		$xtpl->assign('ds_menugroup', $titulo);
		$xtpl->parse('main.group' );

	}	

	
	/**
	 * se parsea todo el menú.
	 *
	 */
	protected function parseMenu( XTemplate $xtpl, $oMenu ){
		
		foreach( $oMenu->getGrupos() as $menuGroup ){
		
			//mostramos cada item del menugroup.
			$this->parseOpciones($xtpl, $menuGroup->getOpciones(), $menuGroup->getDs_nombre() );
		}			
			
			
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return 'Panel de Control';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return null;
	}
	
}