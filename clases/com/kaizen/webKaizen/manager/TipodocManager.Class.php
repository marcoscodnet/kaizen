<?php

/**
 *
 * @author Lucrecia
 * @since 31-01-2011
 *
 * Manager para colores.
 *
 */
class TipodocManager extends ReferenciaManager{

	protected function getReferenciaQuery(){
		return new TipodocQuery();
	}

	/**
	 * se listan los tipos de documentos.
	 * @param $criterio
	 * @return unknown_type
	 */
	public function getTiposdocs(CriterioBusqueda $criterio){
		$tiposdocs = TipodocQuery::getTiposdocs($criterio);
		return $tiposdocs;
	}

	/**
	 * obtiene un tipo de documento específico dado un filtro.
	 * @param $cd_tipodoc identificador del tipodoc a recuperar
	 * @return unknown_type
	 */
	public function getTipodocPorId($cd_tipodoc){
		$criterio = new CriterioBusqueda();
		$criterio->addFiltro('TD.cd_tipodoc', $cd_tipodoc, '=');
		$oTipodoc = TipodocQuery::getTipodoc($criterio );
		return $oTipodoc;
	}
}