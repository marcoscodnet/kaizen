<?php

/**
 * Acción para visualizar stock pieza.
 *
 * @author Ma. Jesús
 * @since 15-07-2011
 *
 */
class VerStockPiezaAction extends SecureOutputAction{

	/**
	 * consulta stock pieza.
	 * @return forward.
	 */
	protected function getContenido(){
			
		$xtpl = new XTemplate ( APP_PATH . 'stockpiezas/verstockpieza.html' );

		if (isset ( $_GET ['id'] )) {
			$cd_stockpieza = $_GET ['id'];

			$manager = new StockPiezaManager();
			$managerpieza = new PiezaManager();
			$managersucursal = new SucursalManager();
			$managerproveedor = new ProveedorManager();

			try{
				$oStockPieza = $manager->getStockPiezaPorId ( $cd_stockpieza );
				$oPieza = $managerpieza->getPiezaPorId ( $oStockPieza->getCd_pieza() );
				$oSucursal = $managersucursal->getSucursalPorId ( $oStockPieza->getCd_sucursal() );
				$oProveedor = $managerproveedor->getProveedorPorId ( $oStockPieza->getCd_proveedor() );
			}catch(GenericException $ex){
				$oStockPieza = new StockPieza();
				//TODO ver si se muestra un mensaje de error.
			}

			//se muestra stock pieza.

			$xtpl->assign ( 'cd_stockpieza', $oStockPieza->getCd_stockPieza());
			$xtpl->assign ( 'ds_codigo', $oPieza->getDs_codigo());
			$xtpl->assign ( 'nu_cantidad', $oStockPieza->getNu_cantidad());
			$xtpl->assign ( 'qt_costo', stripslashes ( $oStockPieza->getQt_costo() ) );
			$xtpl->assign ( 'qt_minimo', stripslashes ( $oStockPieza->getQt_minimo () ) );
			$xtpl->assign ( 'ds_sucursal', $oSucursal->getDs_nombre());
			$xtpl->assign ( 'ds_proveedor', $oProveedor->getDs_proveedor());
			$xtpl->assign ( 'dt_ingreso', stripslashes ( $oStockPieza->getDt_ingreso () ) );
		}

		$xtpl->assign ( 'titulo', 'Detalle de stock pieza' );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}

	public function getFuncion(){
		return "Ver Stock Pieza";
	}

	public function getTitulo(){
		return "Detalle de Stock Pieza";
	}


}