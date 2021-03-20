<?php

class EliminarMovimientoAction extends SecureAction {

    /**
     * se elimina un unidad.
     * @return boolean (true=exito).
     */
    public function executeImpl() {

        $cd_movimiento = $_GET ['id'];

        //se elimina la venta.
        $manager = new MovimientoManager();
        $uniManager = new UnidadManager();

        //Primero chequeo que todas las unidades tengan como sucural actual la sucursal destini
        $oMovimiento = $manager->getMovimientoPorId($cd_movimiento);

        $unidades = $manager->getUnidadesDeMovimiento($cd_movimiento);
        $bl_eliminar = true;
        foreach ($unidades as $unidad) {
            if ($unidad->getCd_sucursalactual() != $oMovimiento->getCd_sucursalDestino()) {
                $bl_eliminar = false;
            }
        }
        if ($bl_eliminar) {
            
            //se inicia una transacción.
            DbManager::begin_tran();

            try {
                //Elimino el Movimiento
                $manager->eliminarMovimiento($oMovimiento->getCd_movimiento());
                //Actualizo la sucursal de las unidades que habían sido movidas.
                foreach ($unidades as $unidad) {
                    $unidad->setCd_sucursalactual($oMovimiento->getCd_sucursalOrigen());
                    $unidad->setDt_ingreso(str_replace("/", "-",$unidad->getDt_ingreso())) ;
                    $uniManager->modificarUnidad($unidad);
                }
                $forward = 'eliminar_movimiento_success';

                DbManager::save();
            } catch (GenericException $ex) {
                $forward = 'eliminar_movimiento_error';
                $this->setDs_forward_params('er=1' . '&msg=' . $ex->getMessage() . '&code=' . $ex->getCode());
                //rollback de la transacción.
                DbManager::undo();
            }
        } else {
            $forward = 'eliminar_movimiento_error';
            $this->setDs_forward_params('er=1&msg=No se puede eliminar el movimiento porque alguna  o todas las unidades han sido movidas a otra sucursal.');
        }
        return $forward;
    }

    public function getFuncion() {
        return "Eliminar Movimiento";
    }

}