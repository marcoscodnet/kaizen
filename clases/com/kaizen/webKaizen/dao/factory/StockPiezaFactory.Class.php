<?php
/**
 *
 * @author Ma. Jesús
 * @since 19-07-2011
 *
 * Factory para stock pieza.
 *
 */
class StockPiezaFactory implements ObjectFactory{

	/**
	 * construye un stock pieza.
	 * @param $next
	 * @return stockpieza
	 */
	public function build($next){
		$oStockPieza = new StockPieza();
		
		if(isset($next['cd_stockpieza'])){
			$oStockPieza->setCd_stockPieza($next ['cd_stockpieza']);
		}else{
			$oStockPieza->setCd_stockPieza($next ['id']);
		}
		
		$oStockPieza->setCd_pieza($next ['cd_pieza']);
		$oStockPieza->setNu_cantidad($next ['nu_cantidad']);
		$oStockPieza->setQt_costo($next ['qt_costo']);
		$oStockPieza->setQt_minimo($next ['qt_minimo']);
		$oStockPieza->setCd_sucursal($next ['cd_sucursal']);
		
		/*if($next ['nu_stock_actual'] == NULL){
			$stock_actual = 0;
		}else{
			$stock_actual = $next ['nu_stock_actual'];
		}*/

		$oStockPieza->setCd_proveedor($next ['cd_proveedor']);
				$oStockPieza->setDt_ingreso(implode("/", array_reverse(explode("-",$next ['dt_ingreso']))));				$oStockPieza->setDs_remito($next ['ds_remito']);
				
		if(array_key_exists('cd_pieza',$next)){
			$piezaFactory = new PiezaFactory();
			$oStockPieza->setPieza( $piezaFactory->build($next) );
		}
		
		if(array_key_exists('cd_sucursal',$next)){
			$sucursalFactory = new SucursalFactory();
			$oStockPieza->setSucursal( $sucursalFactory->build($next) );
		}
		
		if(array_key_exists('cd_proveedor',$next)){
			$proveedorFactory = new ProveedorFactory();
			$oStockPieza->setProveedor( $proveedorFactory->build($next) );
		}
		
 		return $oStockPieza;
	}
}
?>