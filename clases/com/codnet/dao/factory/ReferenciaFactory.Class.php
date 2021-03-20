<?php
/**
 * 
 * @author bernardo
 * @since 31-03-2010
 * 
 * Factory para referencia.
 *
 */
abstract class ReferenciaFactory implements ObjectFactory{
	
	protected abstract function getCampoCodigo();
	protected abstract function getCampoDescripcion();
	
	/**
	 * construye una referencia. 
	 * @param $next
	 * @return unknown_type
	 */
	public function build($next){
		$campoCodigo = $this->getCampoCodigo();
		$campoDescripcion = $this->getCampoDescripcion();
		$oReferencia = new Referencia();
		$oReferencia->setCd_referencia( $next[$campoCodigo] );
		$oReferencia->setDs_referencia( $next[$campoDescripcion] );		
		return $oReferencia;
	}
}
?>