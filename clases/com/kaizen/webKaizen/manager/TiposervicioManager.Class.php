<?php

/**
 *
 * @author Marcos
 * @since 15-05-2012
 *
 * Manager para tipos de servicios.
 *
 */
class TiposervicioManager extends ReferenciaManager{

	protected function getReferenciaQuery(){
		return new TiposervicioQuery();
	}

	public function agregarTiposervicio(Tiposervicio $oTiposervicio){

		//persistir tipo de servicio en la bbdd.
		TiposervicioQuery::insertTiposervicio( $oTiposervicio );

	}

	/**
	 * se modifica un tipo de servicio.
	 * @param Tiposervicio $oTiposervicio a modificar.
	 */

	public function modificarTiposervicio(Tiposervicio $oTiposervicio){

		//persistir los cambios del tipo de servicio en la bbdd.
		TiposervicioQuery::modificarTiposervicio($oTiposervicio);

	}


	/**
	 * eliminar una tipo de servicio.
	 * @param $cd_tiposervicio identificador de el tipo de servicio a eliminar
	 */
	public function eliminarTiposervicio($cd_tiposervicio){
		$oTiposervicio = new Tiposervicio();
		$oTiposervicio->setCd_tiposervicio ( $cd_tiposervicio );
		TiposervicioQuery::eliminarTiposervicio($oTiposervicio);
	}

	/**
	 * se listan tipos de servicios.
	 * @param $criterio
	 * @return unknown_type
	 */
	public function getTiposservicios(CriterioBusqueda $criterio=null){
		$criterio = FormatUtils::ifEmpty( $criterio, new CriterioBusqueda());
		$tiposservicios = TiposervicioQuery::getTiposservicios($criterio);

		return $tiposservicios;
	}



	/**
	 * obtiene un tipo de servicio específico dado un identificador.
	 * @param $cd_tiposervicio identificador del  tipo de servicio a recuperar
	 * @return unknown_type
	 */
	public function getTiposervicioPorId($cd_tiposervicio){
		$criterio = new CriterioBusqueda();
		$criterio->addFiltro('TU.cd_tipo_servicio', $cd_tiposervicio, '=');
		$oTiposervicio =  TiposervicioQuery::getTiposervicio ( $criterio );
		return $oTiposervicio;
	}

	/**
	 * obtiene la cantidad de tipos de servicios dado un filtro.
	 * @param $filtro filtro de búsqueda.
	 * @return cantidad de tipos de servicios
	 */
	public function getCantidadTiposservicios( CriterioBusqueda $criterio){
		$cant =  TiposervicioQuery::getCantTiposservicios( $criterio );
		return $cant;
	}


	//INTERFACE IListar.

	function getEntidades ( CriterioBusqueda $criterio ){
		return  $this->getTiposservicios( $criterio );
	}

	function getCantidadEntidades ( CriterioBusqueda $criterio){
		return $this->getCantidadTiposservicios( $criterio );
	}

}