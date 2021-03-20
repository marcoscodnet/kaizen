<?php

/**
 * Representa el layout para kaizen en el cuál
 * se incluye el menú:
 * 
 *  <header>
 *  <menu>
 *  <content>
 *  <footer>
 * 
 * 
 * @author Lucrecia
 * @since 07-04-2010
 */
class LayoutPanelKaizen extends LayoutPanelCollabtive{

	protected function getHeader(){
		$xtpl = new XTemplate (APP_PATH.  'common/header.html');
		$xtpl->parse('main');
		return $xtpl->text('main');
	}
	
	protected function getFooter(){
		$xtpl = new XTemplate (APP_PATH.  'common/footer.html');
		$xtpl->parse('main');
		return $xtpl->text('main');
	}
	
	protected function parseMetaTags($xtpl){
		$xtpl->assign('http_equiv', 'X-UA-Compatible');
		$xtpl->assign('meta_content', 'IE=7');
		$xtpl->parse('main.meta_tag');
				
		$xtpl->assign('http_equiv', 'Content-Type');
		$xtpl->assign('meta_content', 'text/html; charset=ISO-8859-1');
		$xtpl->parse('main.meta_tag');
				
	}
	
	protected function parseEstilos($xtpl){
		$xtpl->assign('css', WEB_PATH ."css/collabtive/css/calendar.css");
		$xtpl->parse('main.estilo');		
		
		$xtpl->assign('css', WEB_PATH ."css/collabtive/css/export.css");
		$xtpl->parse('main.estilo');		
		
		$xtpl->assign('css', WEB_PATH ."css/collabtive/css/lytebox.css");
		$xtpl->parse('main.estilo');		
		
		//$xtpl->assign('css', WEB_PATH ."css/collabtive/css/style_form_cake.css");
		//$xtpl->parse('main.estilo');		
		
		$xtpl->assign('css', WEB_PATH ."css/collabtive/css/style_form.css");
		$xtpl->parse('main.estilo');
		
		$xtpl->assign('css', WEB_PATH ."css/collabtive/css/style_iefix.css");
		$xtpl->parse('main.estilo');		
		
		$xtpl->assign('css', WEB_PATH ."css/collabtive/css/css_menu_panel.css");
		$xtpl->parse('main.estilo');		
		
		$xtpl->assign('css', WEB_PATH ."css/collabtive/css/estilos.css");
		$xtpl->parse('main.estilo');
	}
	
	protected function parseScripts($xtpl){
		/*
		$xtpl->assign('js', WEB_PATH ."js/collabtive/prototype.js");
		$xtpl->parse('main.script');
		
		$xtpl->assign('js', WEB_PATH ."js/collabtive/ajax.js");
		$xtpl->parse('main.script');
		
		$xtpl->assign('js', WEB_PATH ."js/collabtive/jsval.js");
		$xtpl->parse('main.script');
		
		$xtpl->assign('js', WEB_PATH ."js/collabtive/chat.js");
		$xtpl->parse('main.script');
		
		$xtpl->assign('js', WEB_PATH ."js/collabtive/mycalendar.js");
		$xtpl->parse('main.script');
		
		$xtpl->assign('js', WEB_PATH ."js/collabtive/lytebox.js");
		$xtpl->parse('main.script');
		
		$xtpl->assign('js', WEB_PATH ."js/collabtive/tiny_mce.js");
		$xtpl->parse('main.script');
		*/
		$xtpl->assign('js', WEB_PATH ."js/funciones.js");
		$xtpl->parse('main.script');
	}
	
	protected function parseMenuSuperiorDerecho($xtpl){
		
		$xtpl->assign('css_class', "desktop");
		$xtpl->assign('action', "inicio");
		$xtpl->assign('action_description', "Inicio");
		$xtpl->parse('main.menu_superior_derecha');

		/*
		$xtpl->assign('css_class', "user-settings");
		$xtpl->assign('action', "listar_usuarios");
		$xtpl->assign('action_description', "Usuarios");
		$xtpl->parse('main.menu_superior_derecha.hijos.hijos_item');

		$xtpl->assign('css_class', "parametrizacion");
		$xtpl->assign('action', "listar_sucursales");
		$xtpl->assign('action_description', "Parametrización");
		$xtpl->parse('main.menu_superior_derecha.hijos.hijos_item');
			
		$xtpl->parse('main.menu_superior_derecha.hijos');
		
		$xtpl->assign('css_class', "admin");
		$xtpl->assign('action', "#");
		$xtpl->assign('action_description', "Administración");
		
		$xtpl->parse('main.menu_superior_derecha');
		*/
		
	}
	
	public function setMenu($_menu){}
}
