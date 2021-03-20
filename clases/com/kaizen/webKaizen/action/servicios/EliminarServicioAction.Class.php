<?php

/**
 * Acción para eliminar un servicio.
 *
 * @author Marcos
 * @since 22-05-2011
 *
 */
class EliminarServicioAction extends SecureAction {

    /**
     * se elimina un unidad.
     * @return boolean (true=exito).
     */
    public function executeImpl() {

        $cd_servicio = $_GET ['id'];

        //se elimina la servicio.
        $manager = new ServicioManager();
        $vehiculoservicioManager = new VehiculoservicioManager();

        //se inicia una transacción.
        DbManager::begin_tran();

        try {
            $oServicio = new Servicio();
            $oServicio = $manager->getServicioPorId($cd_servicio);
            $manager->eliminarServicio($oServicio);			            						$vehiculoservicioManager->eliminarVehiculoservicio($oServicio->getCd_vehiculoservicio());

            $forward = 'eliminar_servicio_success';
            //commit de la transacción.
            DbManager::save();
           
        } catch (GenericException $ex) {
            $forward = 'eliminar_servicio_error';
            $this->setDs_forward_params('er=1' . '&msg=' . $ex->getMessage() . '&code=' . $ex->getCode());
            //rollback de la transacción.
            DbManager::undo();
        }

        return $forward;
    }

    public function getFuncion() {
        return "Baja Servicio";
    }

}