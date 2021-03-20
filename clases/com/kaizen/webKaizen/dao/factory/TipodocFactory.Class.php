<?php
/**
 *
 * @author Lucrecia
 * @since 09-01-2011
 *
 * Factory para país.
 *
 */
class TipodocFactory implements ObjectFactory{

	/**
	 * construye un color.
	 * @param $next
	 * @return unknown_type
	 */
	public function build($next){
		$oTipodoc = new Tipodoc();
		$oTipodoc->setCd_tipodoc( $next ['cd_tipodoc'] );
		$oTipodoc->setDs_tipodoc( $next ['ds_tipodoc'] );
		return $oTipodoc;
	}
}
?>