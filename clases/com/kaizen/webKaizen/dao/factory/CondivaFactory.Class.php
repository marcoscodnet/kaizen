<?php
/**
 *
 * @author Lucrecia
 * @since 09-01-2011
 *
 * Factory para país.
 *
 */
class CondivaFactory implements ObjectFactory{

	/**
	 * construye un color.
	 * @param $next
	 * @return unknown_type
	 */
	public function build($next){
		$oCondiva = new Condiva();
		$oCondiva->setCd_condiva( $next ['cd_condiva'] );
		$oCondiva->setDs_condiva( $next ['ds_condiva'] );
		return $oCondiva;
	}
}
?>