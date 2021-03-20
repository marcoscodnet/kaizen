<?php 

/**
 * Acción para redireccionar a la página de
 * acceso denegado.
 * 
 * @author bernardo
 * @since 16-03-2010
 * 
 */
class AccesoDenegadoAction extends SecureOutputAction{

	/**
	 * @return forward.
	 */
	protected function getContenido(){
		
		$xtpl = new XTemplate ( APP_PATH. 'common/accesodenegado.html' );
		$xtpl->assign ( 'WEB_PATH', WEB_PATH );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}
		
	public function getFuncion(){
		return null;
	}
		
	public function getTitulo(){
		return '';
	}	
}