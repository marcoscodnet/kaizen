<?php

/**
 *
 * @author Lucrecia
 * @since 31-01-2011
 *
 * Manager para colores.
 *
 */
class CondivaManager extends ReferenciaManager{

	protected function getReferenciaQuery(){
		return new CondivaQuery();
	}

	/**
	 * se listan los tipos de documentos.
	 * @param $criterio
	 * @return unknown_type
	 */
	public function getCondsiva(CriterioBusqueda $criterio){
		$condicionesiva = CondivaQuery::getCondsiva($criterio);
		return $condicionesiva;
	}

	/**
	 * obtiene un tipo de documento específico dado un filtro.
	 * @param $cd_tipodoc identificador del tipodoc a recuperar
	 * @return unknown_type
	 */
	public function getCondivaPorId($cd_condiva){
		$criterio = new CriterioBusqueda();
		$criterio->addFiltro('CI.cd_condiva', $cd_condiva, '=');
		$oCondiva = CondivaQuery::getCondiva($criterio );
		return $oCondiva;
	}
}