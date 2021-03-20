<?php

/**
 * Acción para eliminar un pedido.
 *
 * @author María Jesús
 * @since 5-09-2011
 *
 */
class EliminarPedidoAction extends SecureAction {

    /**
     * se elimina un pedido.
     * @return boolean (true=exito).
     */
    public function executeImpl() {

        $cd_pedido = $_GET ['id'];

        //se elimina el pedido.
        $manager = new PedidoManager();

        //se inicia una transacción.
        DbManager::begin_tran();

        try {
            $oPedido = new Pedido();
            $oPedido = $manager->getPedidoPorId($cd_pedido);
            $manager->eliminarPedido($cd_pedido);


            $forward = 'eliminar_pedido_success';
            //commit de la transacción.
            DbManager::save();
            //se inicia una nueva transacción.
            DbManager::begin_tran();
            //$uniManager->desautorizarUnidad($oVenta->getCd_unidad());
            DbManager::save();
        } catch (GenericException $ex) {
            $forward = 'eliminar_pedido_error';
            $this->setDs_forward_params('er=1' . '&msg=' . $ex->getMessage() . '&code=' . $ex->getCode());
            //rollback de la transacción.
            DbManager::undo();
        }

        return $forward;
    }

    public function getFuncion() {
        return "Baja Pedido";
    }

}