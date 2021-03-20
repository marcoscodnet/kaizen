<?php

/**
 *
 * @author lucrecia
 * @since 31-03-2011
 *
 * Manager para localidades.
 *
 */
class ComollegoManager extends ReferenciaManager{

	protected function getReferenciaQuery(){
		return new ComollegoQuery();
	}

	public function getComollego(CriterioBusqueda $criterio){

		$combo_comollego = ComollegoQuery::getComollego($criterio);

		return $combo_comollego;
	}



	/**
	 * obtiene una localidad específico dado un identificador.
	 * @param $cd_localidad identificador de la localidad a recuperar
	 * @return unknown_type
	 */
	public function getComollegoPorId($cd_comollego){
		$criterio = new CriterioBusqueda();
		$criterio->addFiltro('CL.cd_comollego', $cd_comollego, '=');
		$oComollego =  ComollegoQuery::getComollegoPorCampo ( $criterio );
		return $oComollego;
	}

	/**
	 * obtiene la cantidad de localidades dado un filtro.
	 * @param $filtro filtro de búsqueda.
	 * @return cantidad de localidades
	 */
	/*public function getCantidadLocalidades( CriterioBusqueda $criterio){
		$cant =  LocalidadQuery::getCantLocalidades( $criterio );
		return $cant;
		}


		//INTERFACE IListar.

		function getEntidades ( CriterioBusqueda $criterio ){
		return  $this->getLocalidades( $criterio );
		}

		function getCantidadEntidades ( CriterioBusqueda $criterio){
		return $this->getCantidadLocalidades( $criterio );
		}*/

}