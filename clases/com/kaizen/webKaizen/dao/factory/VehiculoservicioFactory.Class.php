<?php
/**
 *
 * @author Marcos
 * @since 16-05-2012
 *
 * Factory para vehiculoservicio.
 *
 */
class VehiculoservicioFactory implements ObjectFactory{

	/**
	 * construye una vehiculoservicio.
	 * @param $next
	 * @return vehiculoservicio
	 */
	public function build($next){
		$oVehiculoservicio = new Vehiculoservicio();
		if(isset($next['cd_vehiculo_servicio'])){
			$oVehiculoservicio->setCd_vehiculoservicio($next ['cd_vehiculo_servicio']);
		}else{
			$oVehiculoservicio->setCd_vehiculoservicio($next ['id']);
		}
		
		$oVehiculoservicio->setNu_motor($next ['nu_motor']);
		
		$oVehiculoservicio->setNu_chasis($next ['nu_chasis']);
		
		
		$oVehiculoservicio->setNu_anio($next ['nu_anio']);
		$oVehiculoservicio->setDs_modelo($next ['ds_modelo']);
		
		$oVehiculoservicio->setDt_venta( implode("/", array_reverse(explode("-", $next ['dt_venta'] ))));
		

		return $oVehiculoservicio;
	}
}
?>