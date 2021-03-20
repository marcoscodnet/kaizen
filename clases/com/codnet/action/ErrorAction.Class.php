<?php 

/**
 * Acción para redireccionar a la página de error.
 * 
 * @author bernardo
 * @since 17-03-2010
 * 
 */
class ErrorAction extends SecureOutputAction{

	protected function getXTemplate(){
		return $xtpl = new XTemplate ( APP_PATH. 'common/error.html' );
	}
	
	/**
	 * @return forward.
	 */
	protected function getContenido(){
		$xtpl = $this->getXTemplate ();
		
		$xtpl->assign ( 'titulo', 'P&aacute;gina de error' );

		$msg='';
		$code=0;
		
		if (isset ( $_GET ['msg'] )) $msg = $_GET ['msg'] ;
		if (isset ( $_GET ['code'] ))$code = $_GET ['code'] ;

		
		//TODO tratamiento de los códigos de error.
		if (!empty ( $code)) {
			
			$xtpl->assign ( 'code', $code );
			if($code==-1)
				$msg = 'Funcionalidad no definida<br><br><br>';
		
			if($code==1064)
				$msg = 'Error en consulta a Base de Datos<br><br><br>' . $msg;
		
		}			

		if (!empty ( $msg))
			$xtpl->assign ( 'msg', $msg );
		
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}
	
	public function getFuncion(){
		return null;
	}
	
	public function getTitulo(){
		return 'Error no esperado';
	}
}