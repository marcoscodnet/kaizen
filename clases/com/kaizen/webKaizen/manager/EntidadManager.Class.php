<?php 

/**
 * 
 * @author Lucrecia
 * @since 31-01-2011
 * 
 * Manager para entidades.
 * 
 */
class EntidadManager extends ReferenciaManager{

	protected function getReferenciaQuery(){
		return new EntidadQuery();
	}

	public function agregarEntidad(Entidad $oEntidad){

		//persistir entidad en la bbdd.
		EntidadQuery::insertEntidad( $oEntidad );

	}

	/**
	 * se modifica una entidad.
	 * @param Entidad $oEntidad a modificar.
	 */
	
	public function modificarEntidad(Entidad $oEntidad){

		//persistir los cambios de la entidad en la bbdd.
		EntidadQuery::modificarEntidad($oEntidad);

	}


	/**
	 * eliminar una entidad.
	 * @param $cd_entidad identificador de la entidad a eliminar
	 */
	public function eliminarEntidad($cd_entidad){
		$oEntidad = new Entidad();
		$oEntidad->setCd_entidad ( $cd_entidad );
		EntidadQuery::eliminarEntidad($oEntidad);
	}

	/**
	 * se listan entidades.
	 * @param $criterio
	 * @return unknown_type
	 */
	public function getEntidadesDB(CriterioBusqueda $criterio){

		$entidades = EntidadQuery::getentidades($criterio);

		return $entidades;
	}



	/**
	 * obtiene una entidad específico dado un identificador.
	 * @param $cd_entidad identificador de la entidad a recuperar 
	 * @return unknown_type
	 */
	public function getEntidadPorId($cd_entidad){
		$criterio = new CriterioBusqueda();
		$criterio->addFiltro('E.cd_entidad', $cd_entidad, '=');
		$oEntidad =  EntidadQuery::getEntidad ( $criterio );
		return $oEntidad;
	}

	/**
	 * obtiene la cantidad de entidades dado un filtro.
	 * @param $filtro filtro de búsqueda. 
	 * @return cantidad de entidades
	 */
	public function getCantidadEntidadesDB( CriterioBusqueda $criterio){
		$cant =  EntidadQuery::getCantEntidades( $criterio );
		return $cant;
	}


	//INTERFACE IListar.

	function getEntidades ( CriterioBusqueda $criterio ){
		return  $this->getEntidadesDB( $criterio );
	}

	function getCantidadEntidades ( CriterioBusqueda $criterio){
		return $this->getCantidadEntidadesDB( $criterio );
	}

}