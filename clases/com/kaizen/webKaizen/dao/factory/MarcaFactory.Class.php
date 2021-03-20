<?php
/**
 * 
 * @author Lucrecia
 * @since 09-01-2011
 * 
 * Factory para marca.
 *
 */
class MarcaFactory implements ObjectFactory{

	/**
	 * construye una marca. 
	 * @param $next
	 * @return unknown_type
	 */
	public function build($next){
		$oMarca = new Marca();
		$oMarca->setCd_marca( $next ['cd_marca'] );
		$oMarca->setDs_marca( $next ['ds_marca'] );
		
		return $oMarca;
	}
}
?>