<?php

/**

 * Acci�n para visualizar un movimiento.

 *

 * @author Lucrecia

 * @since 18-01-2011

 *

 */
class VerVentaPiezaAction extends SecureOutputAction {

    /**

     * consulta un movimiento.

     * @return forward.

     */
    protected function getContenido() {



        $xtpl = new XTemplate(APP_PATH . 'ventaspiezas/verventapieza.html');



        if (isset($_GET ['id'])) {

            $cd_ventapieza = $_GET ['id'];



            $manager = new VentaPiezaManager();



            try {

                $oVentaPieza = $manager->getVentaPiezaPorId($cd_ventapieza);
            } catch (GenericException $ex) {

                $oVentaPieza = new VentaPieza();

                //TODO ver si se muestra un mensaje de error.
            }

            $nu_destino = $oVentaPieza->getNu_destino();
            $total = $this->parsePiezas($xtpl, $cd_ventapieza);
            switch ($nu_destino) {

                case 1:
                    $ds_detalle = "<tr><td><p><strong>Apellido y Nombre :</strong></p></td><td><p>" . $oVentaPieza->getDs_apynomCliente() . "</p></td><td><p><strong>Fecha :</strong></p></td><td><p>" . $oVentaPieza->getDt_ventapieza() . "</p></td></tr><tr><td><p><strong>Moto :</strong></p></td><td><p>" . $oVentaPieza->getDs_motoCliente() . "</p></td><td><p><strong>Vendedor :</strong></p></td><td><p>" . $oVentaPieza->getUsuario()->getDs_nomusuario() . "</p></td></tr><tr><td><p><strong>DNI :</strong></p></td><td><p>" . $oVentaPieza->getNu_docCliente() . "</p></td><td></td><td></td></tr><tr><td><p><strong>Tel :</strong></p></td><td><p>" . $oVentaPieza->getDs_telCliente() . "</p></td><td></td><td></td></tr>";
                    $ds_pie = "<tr><td colspan='3'><p><strong>Total :</strong></p></td><td><p>" . $total . "</p></td></tr>";
                    break;

                case 2:
                    $ds_detalle = "<tr><td><p><strong>Sucursal :</strong></p></td><td><p>" . $oVentaPieza->getDs_nombre() . "</p></td><td><p><strong>Fecha :</strong></p></td><td><p>" . $oVentaPieza->getDt_ventapieza() . "</p></td></tr><tr><td></td><td></td><td><p><strong>Vendedor :</strong></p></td><td><p>" . $oVentaPieza->getUsuario()->getDs_nomusuario() . "</p></td></tr>";
                    $ds_pie = "<tr><td><p><strong>Nro. de Reparaci&oacute;n :</strong></p></td><td><p>" . $oVentaPieza->getNu_pedidoreparacion() . "</p></td><td><p><strong>Total :</strong></p></td><td><p>" . $total . "</p></td></tr>";
                    break;
                case 3:
                    $ds_detalle = "<tr><td><p><strong>Destino :</strong></p></td><td><p>Taller</p></td><td><p><strong>Fecha :</strong></p></td><td><p>" . $oVentaPieza->getDt_ventapieza() . "</p></td></tr><tr><td></td><td></td><td><p><strong>Vendedor :</strong></p></td><td><p>" . $oVentaPieza->getUsuario()->getDs_nomusuario() . "</p></td></tr>";
                    $ds_pie = "<tr><td><p><strong>Nro. de Reparaci&oacute;n :</strong></p></td><td><p>" . $oVentaPieza->getNu_pedidoreparacion() . "</p></td><td><p><strong>Total :</strong></p></td><td><p>" . $total . "</p></td></tr>";
                    break;
            }

            if ($oVentaPieza->getDs_descripcion() != "") {
                $ds_descripcion = $oVentaPieza->getDs_descripcion();
                $xtpl->assign('ds_descripcion', stripslashes($ds_descripcion));
                $xtpl->parse('main.descripcion');
            }
            $xtpl->assign('ds_detalle', stripslashes($ds_detalle));

            $xtpl->assign('ds_pie', stripslashes($ds_pie));
        }



        $xtpl->assign('titulo', 'Detalle de la venta de piezas');

        $xtpl->parse('main');

        return $xtpl->text('main');
    }

    protected function parsePiezas(XTemplate $xtpl, $cd_ventapieza = 0) {

        $manager = new VentaPiezaManager();



        try {

            $piezas = $manager->getPiezasDeVentaPieza($cd_ventapieza);
        } catch (GenericException $ex) {

            $piezas = array();

            //TODO ver si se muestra un mensaje de error.
        }
        $total = 0;
        foreach ($piezas as $indice => $pieza) {

            //print_r($pieza);
            $total = $total + $pieza->getQt_montoacobrar();
            $xtpl->assign('cd_pieza', $pieza->getCd_pieza());

            $xtpl->assign('ds_codigo', $pieza->getPieza()->getDs_codigo());
            $xtpl->assign('ds_pieza', $pieza->getPieza()->getDs_descripcion());
			$xtpl->assign('ds_sucursal', $pieza->getSucursal()->getDs_nombre());
            $xtpl->assign('nu_cantidadpedida', $pieza->getNu_cantidadpedida());

            $xtpl->assign('qt_montoacobrar', $pieza->getQt_montoacobrar());



            $xtpl->assign('indice', $indice);

            $xtpl->parse('main.filas');
        }



        return $total;
    }

    public function getFuncion() {

        return "Ver Venta Pieza";
    }

    public function getTitulo() {

        return "Detalle de Venta Pieza";
    }

}
