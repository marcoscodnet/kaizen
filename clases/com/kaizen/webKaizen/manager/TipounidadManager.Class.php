<?php

/**
 *
 * @author Lucrecia
 * @since 31-01-2011
 *
 * Manager para tipos de unidades.
 *
 */
class TipounidadManager extends ReferenciaManager{

	protected function getReferenciaQuery(){
		return new TipounidadQuery();
	}

	public function agregarTipounidad(Tipounidad $oTipounidad){

		//persistir tipo de unidad en la bbdd.
		TipounidadQuery::insertTipounidad( $oTipounidad );

	}

	/**
	 * se modifica un tipo de unidad.
	 * @param Tipounidad $oTipounidad a modificar.
	 */

	public function modificarTipounidad(Tipounidad $oTipounidad){

		//persistir los cambios del tipo de unidad en la bbdd.
		TipounidadQuery::modificarTipounidad($oTipounidad);

	}


	/**
	 * eliminar una tipo de unidad.
	 * @param $cd_tipounidad identificador de el tipo de unidad a eliminar
	 */
	public function eliminarTipounidad($cd_tipounidad){
		$oTipounidad = new Tipounidad();
		$oTipounidad->setCd_tipounidad ( $cd_tipounidad );
		TipounidadQuery::eliminarTipounidad($oTipounidad);
	}

	/**
	 * se listan tipos de unidades.
	 * @param $criterio
	 * @return unknown_type
	 */
	public function getTiposunidades(CriterioBusqueda $criterio){

		$tiposunidades = TipounidadQuery::getTiposunidades($criterio);

		return $tiposunidades;
	}



	/**
	 * obtiene un tipo de unidad específico dado un identificador.
	 * @param $cd_tipounidad identificador del  tipo de unidad a recuperar
	 * @return unknown_type
	 */
	public function getTipounidadPorId($cd_tipounidad){
		$criterio = new CriterioBusqueda();
		$criterio->addFiltro('TU.cd_tipo_unidad', $cd_tipounidad, '=');
		$oTipounidad =  TipounidadQuery::getTipounidad ( $criterio );
		return $oTipounidad;
	}

	/**
	 * obtiene la cantidad de tipos de unidades dado un filtro.
	 * @param $filtro filtro de búsqueda.
	 * @return cantidad de tipos de unidades
	 */
	public function getCantidadTiposunidades( CriterioBusqueda $criterio){
		$cant =  TipounidadQuery::getCantTiposunidades( $criterio );
		return $cant;
	}


	//INTERFACE IListar.

	function getEntidades ( CriterioBusqueda $criterio ){
		return  $this->getTiposunidades( $criterio );
	}

	function getCantidadEntidades ( CriterioBusqueda $criterio){
		return $this->getCantidadTiposunidades( $criterio );
	}

}