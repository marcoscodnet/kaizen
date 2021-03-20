<?php
/**
 *
 * @author María Jesús
 * @since 16-11-2011
 *
 * Factory para ventas de piezas.
 *
 */
class VentaPiezaUnidadFactory implements ObjectFactory{

	/**
	 * construye una venta pieza.
	 * @param $next
	 * @return unknown_type
	 */
	public function build($next){
		$oVentaPiezaUnidad = new VentaPiezaUnidad();
		
		if(array_key_exists('cd_pieza',$next)){

			$piezaFactory = new PiezaFactory();

			$oVentaPiezaUnidad->setPieza( $piezaFactory->build($next) );

		}
		
		$oVentaPiezaUnidad->setCd_ventapieza($next ['cd_piezapieza']);
		$oVentaPiezaUnidad->setNu_cantidadpedida($next ['nu_cantidadpedida']);
		$oVentaPiezaUnidad->setQt_montoacobrar($next ['qt_montoacobrar']);
		
		if(array_key_exists('cd_sucursal',$next)){

			$sucursalFactory = new SucursalFactory();

			$oVentaPiezaUnidad->setSucursal( $sucursalFactory->build($next) );

		}

		

		
		
		
		

		return $oVentaPiezaUnidad;
	}
}
?>