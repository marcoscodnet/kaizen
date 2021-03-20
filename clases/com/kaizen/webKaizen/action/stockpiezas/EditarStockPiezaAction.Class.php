<?php



/**

 * Acci�n para editar stock pieza.

 *

 * @author Ma. Jes�s

 * @since 15-07-2011

 *

 */

abstract class EditarStockPiezaAction extends EditarAction{



	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/action/generic/EditarAction#getEntidad()

	 */

	protected function getEntidad(){

		$oStockPieza = new StockPieza();



		if (isset ( $_POST ['cd_stockpieza'] ))

		$oStockPieza->setCd_stockPieza (  $_POST ['cd_stockpieza']  );



		if (isset ( $_POST ['cd_pieza'] ))

		$oStockPieza->setCd_pieza($_POST ['cd_pieza']  );



		if (isset ( $_POST ['nu_cantidad'] ))

		$oStockPieza->setNu_cantidad( $_POST ['nu_cantidad'] );



		if (isset ( $_POST ['qt_costo'] ))

		$oStockPieza->setQt_costo (  $_POST ['qt_costo'] ) ;



		if (isset ( $_POST ['qt_minimo'] ))

		$oStockPieza->setQt_minimo($_POST ['qt_minimo'] ) ;



		if (isset ( $_POST ['cd_sucursal'] ))

		$oStockPieza->setCd_sucursal ( $_POST ['cd_sucursal'] ) ;



		if (isset ( $_POST ['cd_proveedor'] ))

		$oStockPieza->setCd_proveedor( $_POST ['cd_proveedor'] ) ;



		if (isset ( $_POST ['dt_ingreso'] )){
            $oStockPieza->setDt_ingreso($_POST ['dt_ingreso']);
        }

		;

		if (isset ( $_POST ['ds_remito'] ))

		$oStockPieza->setDs_remito( $_POST ['ds_remito'] ) ;

        //print_r($oStockPieza);
		return $oStockPieza;

	}

}
