<?php

/**
 * Acción para modificar un servicio.
 *
 * @author Marcos
 * @since 21-05-2011
 *
 */
class ModificarServicioAction extends EditarServicioAction{
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$oServicio = $oEntidad["servicio"];		$oVehiculoservicio = $oEntidad["vehiculoservicio"];				$manager = new ServicioManager();
		$manager->modificarServicio($oServicio, $oVehiculoservicio);

		
	}

	


	protected function getForwardSuccess(){
		return 'modificar_servicio_success';
	}

	protected function getForwardError(){
		return 'modificar_servicio_error';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar Servicio";
	}

}