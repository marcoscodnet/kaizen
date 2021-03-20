<?php



/**

 * Acci�n para inicializar el contexto para editar

 * stock pieza.

 *

 * @author Ma. Jes�s

 * @since 15-07-2011

 *

 */

abstract class EditarStockPiezaInitAction  extends EditarInitAction{



	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/action/generic/EditarInitAction#getXTemplate()

	 */

	protected function getXTemplate(){

		return new XTemplate ( APP_PATH. '/stockpiezas/editarstockpieza.html' );

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/action/generic/EditarInitAction#getEntidad()

	 */

	protected function getEntidad(){

		return new StockPieza();

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)

	 */

	protected function parseEntidad($entidad, XTemplate $xtpl){

		$oStockPieza = FormatUtils::ifEmpty($entidad, new StockPieza());

		//se muestra el stock pieza.

		$this->parseStockPieza( $oStockPieza , $xtpl);

		$this->parsePiezas($oStockPieza->getCd_pieza(), $xtpl);

        $this->parseSucursales($oStockPieza->getCd_sucursal(), $xtpl);

        $this->parseProveedores($oStockPieza->getCd_proveedor(), $xtpl);

	}



	protected function parseStockPieza(StockPieza $oStockPieza, XTemplate $xtpl){

		//se muestra el stock pieza.

		$xtpl->assign ( 'cd_stockpieza', $oStockPieza->getCd_stockPieza());

		$xtpl->assign ( 'cd_pieza', $oStockPieza->getCd_pieza());

		$xtpl->assign ( 'nu_cantidad', $oStockPieza->getNu_cantidad());

		$xtpl->assign ( 'qt_costo', stripslashes ( $oStockPieza->getQt_costo() ) );

		$xtpl->assign ( 'qt_minimo', stripslashes ( $oStockPieza->getQt_minimo () ) );

		$xtpl->assign ( 'cd_sucursal', $oStockPieza->getCd_sucursal());

		$xtpl->assign ( 'cd_proveedor', $oStockPieza->getCd_proveedor());



		$xtpl->assign ( 'ds_remito', $oStockPieza->getDs_remito());


		//URL para el buscar de piezas

        if ($this->getFuncion() != "Modificar Stock Pieza") {

            $xtpl->assign('url', WEB_PATH . 'piezas/doAction?action=buscar_piezas');

            $xtpl->parse('main.imagen');
            $xtpl->assign('dt_ingreso', date("d/m/Y"));

        } else {

            $xtpl->assign('disabled', "disabled");

            $input = "<input type='hidden' name='cd_pieza' id='cd_pieza' value='" . $oStockPieza->getCd_pieza() . "'/>";

            $xtpl->assign('pieza_hidden', $input);
            $xtpl->assign('dt_ingreso', stripslashes($oStockPieza->getDt_ingreso()));

        }

	}



	protected function parseSucursales($cd_selected='', XTemplate $xtpl) {

        $sucursalManager = new SucursalManager();

        $criterio = new CriterioBusqueda();

        $sucursales = $sucursalManager->getSucursales($criterio);

        foreach ($sucursales as $key => $sucursal) {

            $xtpl->assign('ds_sucursal', $sucursal->getDs_nombre());

            $xtpl->assign('cd_sucursal', FormatUtils::selected($sucursal->getCd_sucursal(), $cd_selected));

            $xtpl->parse('main.option_sucursal');

        }

    }



    protected function parsePiezas($cd_selected='', XTemplate $xtpl) {

        $piezaManager = new PiezaManager();

        $criterio = new CriterioBusqueda();

        $criterio->addOrden('ds_codigo');

        $piezas = $piezaManager->getPiezas($criterio);

        foreach ($piezas as $key => $pieza) {

            $xtpl->assign('ds_codigo', $pieza->getDs_codigo());

            $xtpl->assign('cd_pieza', FormatUtils::selected($pieza->getCd_pieza(), $cd_selected));

            $xtpl->parse('main.option_pieza');

        }

    }



	protected function parseProveedores($cd_selected='', XTemplate $xtpl) {

        $proveedorManager = new ProveedorManager();

        $criterio = new CriterioBusqueda();

        $proveedores = $proveedorManager->getProveedores($criterio);

        foreach ($proveedores as $key => $proveedor) {

            $xtpl->assign('ds_proveedor', $proveedor->getDs_proveedor());

            $xtpl->assign('cd_proveedor', FormatUtils::selected($proveedor->getCd_proveedor(), $cd_selected));

            $xtpl->parse('main.option_proveedor');

        }

    }



}
