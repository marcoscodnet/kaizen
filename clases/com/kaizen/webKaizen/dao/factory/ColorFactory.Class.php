<?php
/**
 * 
 * @author Lucrecia
 * @since 09-01-2011
 * 
 * Factory para país.
 *
 */
class ColorFactory implements ObjectFactory{

	/**
	 * construye un color. 
	 * @param $next
	 * @return unknown_type
	 */
	public function build($next){
		$oColor = new Color();
		$oColor->setCd_color( $next ['cd_color'] );
		$oColor->setDs_color( $next ['ds_color'] );
		return $oColor;
	}
}
?>