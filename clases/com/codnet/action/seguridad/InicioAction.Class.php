<?php 

/**
 * Acción para redireccionar a la página de incio
 * del usuario logueado.
 * 
 * @author bernardo
 * @since 16-03-2010
 * 
 */
class InicioAction extends SecureOutputAction{

	/**
	 * @return forward.
	 */
	protected function getContenido(){
		$xtpl = new XTemplate ( 'inicio.html' );
		
		$xtpl->assign ( 'titulo', NOMBRE_APLICACION);
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}
	
	public function getFuncion(){
		return null;
	}
	
	public function getTitulo(){
		return NOMBRE_APLICACION;
	}
}