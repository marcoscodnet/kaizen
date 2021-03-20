<?php

/**
 *
 * @author Marcos
 * @since 15-06-2012
 *
 * Manager para servicio.
 *
 */
class ServicioManager implements IListar {

	/**
	 * se agrega una servicio nueva.
	 * @param $oServicio a agregar.
	 */
	public function agregarServicio(Servicio $oServicio, Vehiculoservicio $oVehiculoservicio) {
		//persistir cliente en la bbdd.
		VehiculoservicioQuery::insertVehiculoservicio($oVehiculoservicio);		$oServicio->setCd_vehiculoservicio($oVehiculoservicio->getCd_vehiculoservicio());		$oServicio->setDt_carga(date('YmdHis'));
		ServicioQuery::insertServicio($oServicio);
	}

	

	public function modificarServicio(Servicio $oServicio, Vehiculoservicio $oVehiculoservicio) {
		VehiculoservicioQuery::modificarVehiculoservicio($oVehiculoservicio);		$oServicio->setCd_vehiculoservicio($oVehiculoservicio->getCd_vehiculoservicio());
		ServicioQuery::modificarServicio($oServicio);
	}

	public function eliminarServicio(Servicio $oServicio) {
		
		//persistir los cambios del cliente en la bbdd.
		ServicioQuery::eliminarServicio($oServicio);
	}

	/**
	 * se listan servicios.
	 * @param $criterio
	 * @return unknown_type
	 */
	public function getServicios(CriterioBusqueda $criterio=null) {
		$criterio = FormatUtils::ifEmpty($criterio, new CriterioBusqueda());
		$servicios = ServicioQuery::getServicios($criterio);

		return $servicios;
	}

	/**
	 * obtiene una servicio especifico dado un identificador.
	 * @param $cd_servicio identificador de la servicio a recuperar
	 * @return unknown_type
	 */
	public function getServicioPorId($cd_servicio) {
		if (!empty($cd_servicio)) {
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('S.cd_servicio', $cd_servicio, '=');
			$oServicio = ServicioQuery::getServicio($criterio);
		} else {
			$oServicio = new Servicio();
		}
		return $oServicio;
	}		public function getImporteTotalEnServicios(CriterioBusqueda $criterio) {				$suma = ServicioQuery::getImporteTotalEnServicios($criterio);		return $suma;	}	

	/**
	 * obtiene la cantidad de servicios dado un filtro.
	 * @param $filtro filtro de busqueda.
	 * @return cantidad de servicios
	 */
	public function getCantidadServicios(CriterioBusqueda $criterio) {
		$cant = ServicioQuery::getCantServicios($criterio);
		return $cant;
	}

	//INTERFACE IListar.

	function getEntidades(CriterioBusqueda $criterio) {
		return $this->getServicios($criterio);
	}

	function getCantidadEntidades(CriterioBusqueda $criterio) {
		return $this->getCantidadServicios($criterio);
	}

}