<?php
/**
 *
 * @author Lucrecia
 * @since 09-01-2011
 *
 * Factory para país.
 *
 */
class FormapagoFactory implements ObjectFactory{

	/**
	 * construye un color.
	 * @param $next
	 * @return unknown_type
	 */
	public function build($next){
		$oFormapago = new Formapago();
		$oFormapago->setCd_formapago( $next ['cd_formapago'] );
		$oFormapago->setDs_formapago( $next ['ds_formapago'] );
		return $oFormapago;
	}
}
?>