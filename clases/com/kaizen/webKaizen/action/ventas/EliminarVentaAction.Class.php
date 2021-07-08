<?php



/**

 * Acci�n para eliminar una venta.

 *

 * @author Lucrecia

 * @since 18-01-2011

 *

 */

class EliminarVentaAction extends SecureAction {



    /**

     * se elimina un unidad.

     * @return boolean (true=exito).

     */

    public function executeImpl() {



        $cd_venta = $_GET ['id'];

        //echo $cd_venta;

        //se elimina la venta.

        $manager = new VentaManager();

        $uniManager = new UnidadManager();



        //se inicia una transacci�n.

        DbManager::begin_tran();



        try {

            $oVenta = new Venta();

            $oVenta = $manager->getVentaPorId($cd_venta);

            $manager->eliminarVenta($oVenta);





            $forward = 'eliminar_venta_success';

            //commit de la transacci�n.

            DbManager::save();

            //se inicia una nueva transacci�n.

            DbManager::begin_tran();

            $uniManager->desautorizarUnidad($oVenta->getCd_unidad());

            DbManager::save();

        } catch (GenericException $ex) {

            $forward = 'eliminar_venta_error';

            $this->setDs_forward_params('er=1' . '&msg=' . $ex->getMessage() . '&code=' . $ex->getCode());

            //rollback de la transacci�n.

            DbManager::undo();

        }



        return $forward;

    }



    public function getFuncion() {

        return "Baja Venta";

    }



}
