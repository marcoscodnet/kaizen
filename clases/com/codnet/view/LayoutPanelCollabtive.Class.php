<?php

/**
 * Representa un layout de la forma:
 *	{<meta-tags>, <scripts>, <estilos>} 
 *  <header>
 *  <content>
 *  <footer>
 * 
 * 
 * @author bernardo
 * @since 06-04-2010
 */
abstract class LayoutPanelCollabtive extends LayoutCollabtive{

/*
	protected function getXTemplate(){
		return new XTemplate (APP_PATH. CLASS_PATH . 'codnet/view/collabtive_panel_template.html');
	}
*/	

	/**
	 * parsea el menu lateral.
	 * @param unknown_type $xtpl
	 * @return unknown_type
	 *
	protected function parseMenuLateral($xtpl){}
*/

	public function showLayout(){
		return $this->show();
	}	
	public function show(){
		
		//buscamos los parámetros para configurar los menúes.
		//para los menúes.
		$menuGroupActivo = FormatUtils::getParam('menuGroupActivo');
		$menuGroups = FormatUtils::getParam('menuGroups');
		$menuOptions = FormatUtils::getParam('menuOptions');

		//seteamos el usuario para chequear permisos sobre los menúes.
		$oUsuario = new Usuario();
		$oUsuario->setCd_usuario( $_SESSION ["cd_usuarioSession"] );
		$oUsuario->setFunciones( $_SESSION ["funciones"] );
		$oUsuario->setDs_nomusuario( $_SESSION ["ds_usuario"] );
		$this->oUsuario = $oUsuario;
				
		$xtpl = $this->getXTemplate ( '', $menuOptions);
		
		$xtpl->assign('titulo', $this->getTitulo());
		$xtpl->assign('header', $this->getHeader());
		$xtpl->assign('user', $oUsuario->getDs_nomusuario() );
		$xtpl->assign('content', $this->getContenido());
		$xtpl->assign('footer', $this->getFooter());
		$this->parseMetaTags($xtpl);
		$this->parseEstilos($xtpl);
		$this->parseScripts($xtpl);
		
		//seteamos los menúes.
		$this->parseMenuSolapas($xtpl, $menuGroups, $menuGroupActivo);
		$this->parseMenuSuperiorDerecho($xtpl);
		$this->parseMenuLateral($xtpl, $menuOptions, $menuGroupActivo);
		
		$xtpl->parse('main');

		return $xtpl->text('main');
	}	
}
