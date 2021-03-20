<?php
/**
 * 
 * @author Lucrecia
 * @since 14-01-2011
 * 
 * Factory para funcion.
 *
 */
class TipounidadFactory implements ObjectFactory{

	/**
	 * construye un tipo de unidad. 
	 * @param $next
	 * @return unknown_type
	 */
	public function build($next){
		$oTipounidad = new Tipounidad();
		$oTipounidad->setCd_tipounidad( $next ['cd_tipo_unidad'] );
		$oTipounidad->setDs_tipounidad( $next ['ds_tipo_unidad'] );
		
		return $oTipounidad;
	}
}
?>