<?php 

/**
 * Acción para iniciarlizar el registro en el sistema.
 * (login)
 * 
 * @author bernardo
 * @since 16-03-2010
 * 
 */
class RegistrarseInitAction extends OutputAction{

	/**
	 * se inicializa el contexto para registrarse en el sistema (login).
	 * @return forward.
	 */
	protected function getContenido(){
			
		$xtpl = new XTemplate ( APP_PATH. 'login.html' );

		$msj='';
		if (isset ( $_GET ['code'] )){
			
				$msj = $_GET ['msg'];
			
		}
		
		$xtpl->assign ( 'titulo', $this->getTitulo() );
		$xtpl->assign ( 'MSJ', $msj );
		$xtpl->parse ( 'main.block1' );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}
	
	protected function getTitulo(){
		return 'Login';
	}

	protected function getLayout(){
		$oClass = new ReflectionClass(DEFAULT_LOGIN_LAYOUT);
		$oLayout = $oClass->newInstance();
		
		return $oLayout;
	}
	
	
}