<?php

/**
 * Acci�n para dar de alta una venta.
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 */
class AltaVentaAction extends EditarVentaAction {

    protected function editar($oEntidad) {
        $manager = new VentaManager();
        $manager->agregarVenta($oEntidad);
        $creditos = unserialize($_SESSION['pagos']);
        if ($creditos->size() > 0) {
            $manager->insertPagosDeVenta($oEntidad, $creditos);
        }
        if ($this->tienePermisoFuncion(AUTORIZAR_UNIDAD_ACCION)) {
            if ($_POST['bl_autorizar'] == "1") {
                $cd_unidad = $oEntidad->getCd_unidad();
                $unidadManager = new UnidadManager();
                if (!$unidadManager->estaAutorizada($cd_unidad)) {
                    $unidadManager->autorizarUnidad($cd_unidad);
                }
            }
        }
    }

    protected function getForwardSuccess() {

        return 'alta_venta_success';
    }

    protected function getForwardError() {
        return 'alta_venta_error';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
     */
    public function getFuncion() {
        return "Alta Venta";
    }

}