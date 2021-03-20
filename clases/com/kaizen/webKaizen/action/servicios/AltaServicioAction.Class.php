<?php

/**
 * Acci�n para dar de alta un servicio.
 *
 * @author Marcos
 * @since 17-05-2012
 *
 */
class AltaServicioAction extends EditarServicioAction {

    protected function editar($oEntidad) {    	$oServicio = $oEntidad["servicio"];		$oVehiculoservicio = $oEntidad["vehiculoservicio"];    	
        $manager = new ServicioManager();
        $manager->agregarServicio($oServicio, $oVehiculoservicio);
        
    }

    protected function getForwardSuccess() {

        return 'alta_servicio_success';
    }

    protected function getForwardError() {
        return 'alta_servicio_error';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
     */
    public function getFuncion() {
        return "Alta Servicio";
    }

}