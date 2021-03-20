<?php

class EliminarVentaPiezaAction extends SecureAction {

    /**
     * se elimina un unidad.
     * @return boolean (true=exito).
     */
    public function executeImpl() {

        $cd_ventapieza = $_GET ['id'];

        $manager = new VentaPiezaManager();

        //se inicia una transacción.
        DbManager::begin_tran();

        try {
        	//Elimino la Venta Pieza y las unidades de piezas relacionadas.
            $manager->eliminarVentaPieza($cd_ventapieza);
            $forward = 'eliminar_ventapieza_success';
            DbManager::save();
            } catch (GenericException $ex) {
                $forward = 'eliminar_ventapieza_error';
                $this->setDs_forward_params('er=1' . '&msg=' . $ex->getMessage() . '&code=' . $ex->getCode());
                //rollback de la transacción.
                DbManager::undo();
            }
       
        return $forward;
    }

    public function getFuncion() {
        return "Eliminar Venta Pieza";
    }

}