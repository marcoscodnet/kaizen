<?php
/**
 *
 * @author Lucrecia
 * @since 09-01-2011
 *
 * Factory para país.
 *
 */
class ParametroFactory implements ObjectFactory{

	/**
	 * construye una entidad.
	 * @param $next
	 * @return unknown_type
	 */
	public function build($next){
		$oParametro = new Parametro();
		$oParametro->setCd_parametro( $next ['cd_parametro'] );
		$oParametro->setDs_nombre( $next ['ds_nombre'] );
		$oParametro->setDs_contenido( $next ['ds_contenido'] );
		return $oParametro;
	}
}
?>