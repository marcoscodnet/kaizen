<?php

/**
 *
 * @author Lucrecia
 * @since 31-01-2011
 *
 * Manager para colores.
 *
 */
class EstadocivilManager extends ReferenciaManager{

	protected function getReferenciaQuery(){
		return new EstadocivilQuery();
	}

	/**
	 * se listan los estados civiles.
	 * @param $criterio
	 * @return unknown_type
	 */
	public function getEstadosciviles(CriterioBusqueda $criterio){

		$estadosciviles = EstadocivilQuery::getEstadosciviles($criterio);

		return $estadosciviles;
	}

	/**
	 * obtiene una color específico dado un filtro.
	 * @param $cd_color identificador de la color a recuperar
	 * @return unknown_type
	 */
	public function getEstadocivilPorId($cd_estadocivil){
		$criterio = new CriterioBusqueda();
		$criterio->addFiltro('EC.cd_estadocivil', $cd_estadocivil, '=');
		$oEstadocivil =  EstadocivilQuery::getEstadocivil($criterio );
		return $oEstadocivil;
	}
}