<?php

/**

 * Acci�n para inicializar el contexto para editar

 * un movimiento.

 *

 * @author Lucrecia

 * @since 15-04-2010

 *

 */
abstract class EditarVentaPiezaInitAction extends EditarInitAction {

    /**

     * (non-PHPdoc)

     * @see clases/com/codnet/action/generic/EditarInitAction#getXTemplate()

     */
    protected function getXTemplate() {

        return new XTemplate(APP_PATH . '/ventaspiezas/editarVentaPieza.html');
    }

    protected function getEntidad() {

        $oVentaPieza = null;

		if (isset ( $_GET ['id'] )) {

			$manager = new VentaPiezaManager();

			$oVentaPieza = $manager->getVentaPiezaPorId( $_GET ['id'] );

			if(isset($_SESSION['piezasavender'])){

				$tmp_piezas = $_SESSION['piezasavender'];

			}else{

				$tmp_piezas = array();

			}
			if (!isset ( $_GET ['mod'] )) {
				//print_r($tmp_piezas);
				$oVentaPiezaUnidades = $manager->getVentaPiezaUnidades( $_GET ['id'] );
				//print_r($oVentaPiezaUnidades);
				foreach ($oVentaPiezaUnidades as $oVentaPiezaUnidad) {
					//if (!FuncionesComunes::existObjectComparator($tmp_piezas, $oVentaPiezaUnidad, new VentaPiezaComparator())) {
						$oVentaPiezaAux = new VentaPieza();
						$oVentaPiezaAux->setPieza($oVentaPiezaUnidad->getPieza());
						$managerSucursal = new SucursalManager();

						$oSucursal = $managerSucursal->getSucursalPorId( $oVentaPiezaUnidad->getSucursal()->getCd_sucursal() );
						$oVentaPiezaAux->setSucursalOrigen($oSucursal);
						//print_r($oVentaPiezaAux);
						array_push($tmp_piezas, $oVentaPiezaAux);
					//}




				}
			}





			$_SESSION['piezasavender'] = $tmp_piezas;


		}

		return $oVentaPieza;
    }

    protected function parseEntidad($entidad, XTemplate $xtpl) {

        $oVentaPieza = FormatUtils::ifEmpty($entidad, new VentaPieza());

        //se muestra el Movimiento.
        $xtpl->assign('ds_descripcion', $oVentaPieza->getDs_descripcion());




        if (isset ( $_GET ['id'] )) {
        	$usuario_actual = $oVentaPieza->getUsuario()->getCd_usuario();
        	$dt_fecha = $oVentaPieza->getDt_ventapieza();
        	$this->parseDestino($xtpl, $oVentaPieza->getNu_destino());
        	$xtpl->assign('ds_descripcion_venta', $oVentaPieza->getDs_descripcion());
        	$xtpl->assign('cd_ventapieza', $oVentaPieza->getCd_ventapieza());
        	$accionId = '&cd_ventapieza='.$_GET ['id'];
        }
        else{
        	 $usuario_actual = $_SESSION['cd_usuarioSession'];
        	 $dt_fecha = date('d/m/Y');
        	 $accionId = '';
        }

         $this->parsePiezas($xtpl, $accionId);

        $this->parseSucursales($xtpl);

        $this->parseVendedores($xtpl, $usuario_actual);

        $this->parseDtVenta($xtpl, $dt_fecha);

        $this->parseUnidadesPiezas($xtpl);

        $xtpl->assign ( 'submit2', $this->getAccionSubmit2() );

    }

    protected function parsePiezas(XTemplate $xtpl, $accionId, $cd_selected ="") {

        $piezaManager = new PiezaManager();

        $criterio = new CriterioBusqueda();

        $criterio->addOrden('ds_codigo');

        $piezas = $piezaManager->getPiezas($criterio);

        foreach ($piezas as $pieza) {

            $xtpl->assign('ds_codigo', $pieza->getDs_codigo());

            $xtpl->assign('cd_pieza', FormatUtils::selected($pieza->getCd_pieza(), $cd_selected));

			$xtpl->assign ( 'action_eliminar_pieza', $this->getAccionEliminarPieza().$accionId );
            $xtpl->parse('main.option_pieza');
        }
    }

    protected function parseUnidadesPiezas(XTemplate $xtpl) {

        //$cd_sucursal = "";

        $xtpl->assign('msj', $_SESSION['sinstock']);
        $_SESSION['sinstock'] = '';
        if (isset($_SESSION['piezasavender']) && (count($_SESSION['piezasavender']) > 0)) {

            $xtpl->assign('listado_piezas', "1");

            foreach ($_SESSION['piezasavender'] as $indice => $ventapieza) {

            	//print_r($ventapieza);
                //	$cd_sucursal = $movimiento->getSucursalOrigen()->getCd_sucursal();

                $xtpl->assign('ds_codigo', $ventapieza->getPieza()->getDs_codigo());

                $xtpl->assign('ds_descripcion', $ventapieza->getPieza()->getDs_descripcion());

                $xtpl->assign('ds_sucursal', $ventapieza->getSucursalOrigen()->getDs_nombre());

                $xtpl->assign('qt_costo', $ventapieza->getPieza()->getQt_costo());

                $xtpl->assign('qt_minimo', $ventapieza->getPieza()->getQt_minimo());

                $xtpl->assign('nu_cantidadpedida', $ventapieza->getPieza()->getNu_cantidadpedida());

                $xtpl->assign('qt_montoacobrar', $ventapieza->getPieza()->getQt_montoacobrar());

                $xtpl->assign('indice', $indice);

                $xtpl->parse('main.filas');
            }
        } else {
            $xtpl->assign('qt_montoacobrar', 0);
            $xtpl->assign('listado_piezas', "");
        }



        //return $cd_sucursal;
    }

    protected function parseDtVenta($xtpl, $dt_fecha) {

        $xtpl->assign('dt_ventapieza', $dt_fecha);
    }

	protected function parseDestino($xtpl, $nu_destino) {

		switch ($nu_destino) {
			case CD_SALON:
				$xtpl->assign('salonSelected', "Selected='selected'");
			break;

			case CD_SUCURSAL:
				$xtpl->assign('sucursalSelected', "Selected='selected'");
			break;

			case CD_TALLER:
				$xtpl->assign('tallerSelected', "Selected='selected'");
			break;
		}

    }

    private function getSucursales() {

        $sucursalManager = new SucursalManager();

        $criterio = new CriterioBusqueda();

        $sucursales = $sucursalManager->getSucursales($criterio);

        return $sucursales;
    }

    protected function parseSucursales(XTemplate $xtpl, $sucursal_actual="") {

        $sucursales = $this->getSucursales();



        foreach ($sucursales as $key => $sucursal) {

            if ($sucursal->getCd_sucursal() != $sucursal_actual) {

                $xtpl->assign('ds_sucursal', $sucursal->getDs_nombre());

                $xtpl->assign('cd_sucursal', $sucursal->getCd_sucursal());

                $xtpl->parse('main.option_sucursal');
            }
        }
    }

    protected function parseVendedores(XTemplate $xtpl, $vendedor_actual="") {
        $usuarioManager = new UsuarioKaizenManager();
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro('bl_activo', 1, '=');
        $vendedores = $usuarioManager->getUsuarios($criterio);
        foreach ($vendedores as $key => $vendedor) {
            $xtpl->assign('ds_nomusuario', $vendedor->getDs_nomusuario());
            $xtpl->assign('cd_usuario', $vendedor->getCd_usuario());
            if ($vendedor->getCd_usuario() != $vendedor_actual) {
                $xtpl->assign('selected', "");
            } else {
                $xtpl->assign('selected', "selected = 'selected'");
            }
            $xtpl->parse('main.option_vendedores');
        }
    }


}
