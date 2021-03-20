<?php

/**
 * Acciï¿½n para dar de alta un pedido.
 *
 * @author María Jesús
 * @since 23-08-2011
 *
 */
class AltaPedidoAction extends EditarPedidoAction {

    protected function editar($oEntidad) {
        $manager = new PedidoManager();
        $manager->agregarPedido($oEntidad);
        /*if ($this->tienePermisoFuncion(AUTORIZAR_UNIDAD_ACCION)) {
            if ($_POST['bl_autorizar'] == "1") {
                $cd_unidad = $oEntidad->getCd_unidad();
                $unidadManager = new UnidadManager();
                if (!$unidadManager->estaAutorizada($cd_unidad)) {
                    $unidadManager->autorizarUnidad($cd_unidad);
                }
            }
        }*/
    }

    protected function getForwardSuccess() {

        return 'alta_pedido_success';
    }

    protected function getForwardError() {
        return 'alta_pedido_error';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
     */
    public function getFuncion() {
        return "Alta Pedido";
    }

}