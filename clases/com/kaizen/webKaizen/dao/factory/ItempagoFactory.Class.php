<?php
/**
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 * Factory para cliente.
 *
 */
class ItempagoFactory implements ObjectFactory{

	/**
	 * construye un producto.
	 * @param $next
	 * @return producto
	 */
	public function build($next){
		$oItempago = new Itempago();

		$oItempago->setCd_itempago($next ['cd_itempago']);
		$oItempago->setDs_observacion($next ['ds_observacion']);
		$oItempago->setDs_detalle($next ['ds_detalle']);
		$oItempago->setNu_importe($next ['nu_importe']);
		$oItempago->setNu_pagado($next ['nu_pagado']);
		$dt_pagado = implode("/", array_reverse(explode("-", $next ['dt_pagado'])));
		$oItempago->setDt_pago($dt_pagado);
		$dt_contadora = implode("/", array_reverse(explode("-", $next ['dt_contadora'])));
		$oItempago->setDt_contadora($dt_contadora);

		if(array_key_exists('ds_entidad',$next)){
			$entidadFactory = new EntidadFactory();
			$oItempago->setEntidad( $entidadFactory->build($next) );
		}

		if(array_key_exists('dt_venta',$next)){
			$ventaFactory = new VentaFactory();
			$oItempago->setVenta( $ventaFactory->build($next) );
		}

		return $oItempago;
	}
}
?>