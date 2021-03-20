<?php

class ComollegoFactory implements ObjectFactory{

	/**
	 * construye una localidad.
	 * @param $next
	 * @return unknown_type
	 */
	public function build($next){
		$oComollego = new Comollego();
		$oComollego->setCd_comollego( $next ['cd_comollego'] );
		$oComollego->setDs_comollego( $next ['ds_comollego'] );
		return $oComollego;
	}
}
?>