<?php

/**
 *
 * @author Lucrecia
 * @since 31-01-2011
 *
 * Manager para colores.
 *
 */
class FormapagoManager extends ReferenciaManager{

	protected function getReferenciaQuery(){
		return new FormapagoQuery();
	}

	/**
	 * se listan formas de pago.
	 * @param $criterio
	 * @return unknown_type
	 */
	public function getFormasdepago(CriterioBusqueda $criterio){

		$formas_pago = FormapagoQuery::getFormasdepago($criterio);

		return $formas_pago;
	}



	/**
	 * obtiene una color específico dado un identificador.
	 * @param $cd_color identificador de la color a recuperar
	 * @return unknown_type
	 */
	public function getFormapagoPorId($cd_formapago){
		$criterio = new CriterioBusqueda();
		$criterio->addFiltro('FP.cd_formapago', $cd_formapago, '=');
		$oFormapago =  FormapagoQuery::getFormapago( $criterio );
		return $oFormapago;
	}

}