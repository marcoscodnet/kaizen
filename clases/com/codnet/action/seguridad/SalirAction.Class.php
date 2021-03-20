<?php 

/**
 * Acción para desloguearse del sistema.
 * 
 * @author bernardo
 * @since 16-03-2010
 * 
 */
class SalirAction extends Action{

	/**
	 * se desloguea el usuario logueado.
	 * @return forward.
	 */
	public function execute($cd_usuario){
		
		$oUsuario = new Usuario ( );
		if (unserialize ( $_SESSION ['usuario'] )) {
			$oUsuario = unserialize ( $_SESSION ['usuario'] );
		}

		$oUsuario->cerrarSesion ();
		
		header ( 'location:index.php' );
		
		$forward=null;
		return $forward;
	}
	
}