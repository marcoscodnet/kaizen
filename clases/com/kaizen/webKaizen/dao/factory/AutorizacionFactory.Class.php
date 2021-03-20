<?php
/**
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 * Factory para cliente.
 *
 */
class AutorizacionFactory implements ObjectFactory{

	/**
	 * construye una autorizacion.
	 * @param $next
	 * @return unidad
	 */
	public function build($next){
		$oAutorizacion = new Autorizacion();
		$oAutorizacion->setCd_autorizacion($next ['cd_autorizacion']);
		$oAutorizacion->setCd_usuario($next ['cd_usuario']);
		$dt_autorizacion = implode("/", array_reverse(explode("-", $next ['dt_autorizacion'])));
		$oAutorizacion->setDt_autorizacion($dt_autorizacion);
		if($next ['cd_unidad'] != NULL){
			$cd_unidad =$next ['cd_unidad'];
		}else{
			$cd_unidad =$next ['id'];
		}
		$oAutorizacion->setCd_unidad($cd_unidad);


		if(array_key_exists('ds_nomusuario',$next)){
			$usuarioFactory = new UsuarioFactory();
			$oAutorizacion->setUsuario( $usuarioFactory->build($next) );
		}

		return $oAutorizacion;
	}
}
?>