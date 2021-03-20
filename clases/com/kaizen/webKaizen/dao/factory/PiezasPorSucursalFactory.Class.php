<?php
/**
 * 
 * @author marcos
 * @since 29-02-2012
 * 
 * Factory para piezas por sucursal.
 *
 */
class PiezasPorSucursalFactory implements ObjectFactory{

	/**
	 * construye un ConciliacionConsumo. 
	 * @param $next
	 * @return conciliación de consumo
	 */
	public function build($next){
		$oStockPieza = new StockPieza();
		$oStockPieza->setCd_pieza($next ['cd_pieza']);

		$oStockPieza->setNu_cantidad($next ['nu_cantidad']);

		
		$oStockPieza->setCd_sucursal($next ['cd_sucursal']);

		if(array_key_exists('cd_pieza',$next)){

			$piezaFactory = new PiezaFactory();

			$oStockPieza->setPieza( $piezaFactory->build($next) );

		}
		
		if(array_key_exists('cd_sucursal',$next)){

			$sucursalFactory = new SucursalFactory();

			$oStockPieza->setSucursal( $sucursalFactory->build($next) );

		}

		return $oStockPieza;
	}
	
}
?>