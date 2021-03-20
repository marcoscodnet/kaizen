<?php

/**
 * Acci�n para eliminar un pedido.
 *
 * @author Mar�a Jes�s
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

        //se inicia una transacci�n.
        DbManager::begin_tran();

        try {
            $oPedido = new Pedido();
            $oPedido = $manager->getPedidoPorId($cd_pedido);
            $manager->eliminarPedido($cd_pedido);


            $forward = 'eliminar_pedido_success';
            //commit de la transacci�n.
            DbManager::save();
            //se inicia una nueva transacci�n.
            DbManager::begin_tran();
            //$uniManager->desautorizarUnidad($oVenta->getCd_unidad());
            DbManager::save();
        } catch (GenericException $ex) {
            $forward = 'eliminar_pedido_error';
            $this->setDs_forward_params('er=1' . '&msg=' . $ex->getMessage() . '&code=' . $ex->getCode());
            //rollback de la transacci�n.
            DbManager::undo();
        }

        return $forward;
    }

    public function getFuncion() {
        return "Baja Pedido";
    }

}