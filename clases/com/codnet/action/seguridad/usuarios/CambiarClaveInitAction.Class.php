<?php 

/**
 * Acción para inicializar el contexto para cambiar la
 * clave del usuario logueado.
 * 
 * @author bernardo
 * @since 16-03-2010
 * 
 */
class CambiarClaveInitAction extends SecureOutputAction{

	/**
	 * inicializa el contexto para cambiar la clave
	 * del usuario.
	 * @return forward.
	 */
	protected function getContenido(){
			
		$xtpl = new XTemplate ( APP_PATH. '/usuarios/cambiarClave.html' );
		
		if (isset ( $_GET ['er'] )) {
				$xtpl->assign ( 'classMsj', 'msjerror' );
				$xtpl->assign ( 'msj', 'Contraseña Actual incorrecta' );
		} else {
			$xtpl->assign ( 'classMsj', '' );
			$xtpl->assign ( 'msj', '' );
		}
		$xtpl->parse ( 'main.msj' );
		
		$xtpl->assign ( 'titulo', 'Cambiar clave' );
		$xtpl->assign ( 'WEB_PATH', WEB_PATH );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}
	
	public function getFuncion(){
		return "Cambiar clave";
	}
	
	public function getTitulo(){
		return "Cambiar clave";
	}
	
	
}