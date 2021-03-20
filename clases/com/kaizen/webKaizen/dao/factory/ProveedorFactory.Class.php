<?php
/**
 * 
 * @author Ma. Jesús
 * @since 21-07-2011
 * 
 * Factory para proveedor.
 *
 */
class ProveedorFactory implements ObjectFactory{

	/**
	 * construye un proveedor. 
	 * @param $next
	 * @return unknown_type
	 */
	public function build($next){
		$oProveedor = new Proveedor();
		$oProveedor->setCd_proveedor( $next ['cd_proveedor'] );
		$oProveedor->setDs_proveedor( $next ['ds_proveedor'] );
		
		return $oProveedor;
	}
}
?>