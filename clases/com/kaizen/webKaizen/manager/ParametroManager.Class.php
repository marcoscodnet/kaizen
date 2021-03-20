<?php

class ParametroManager extends ReferenciaManager{
	protected function getReferenciaQuery(){
		return new ParametroQuery();
	}

	public function agregarParametro(Parametro $oParametro){
		//persistir entidad en la bbdd.
		ParametroQuery::insertParametro( $oParametro );
	}

	public function modificarParametro(Parametro $oParametro){
		//persistir los cambios de la entidad en la bbdd.
		ParametroQuery::modificarParametro($oParametro);

	}

	public function getParametroPorId($cd_parametro){
		$oParametro = new Parametro();
		$oParametro->setCd_parametro($cd_entidad);
		$oParametro =  ParametroQuery::getParametroPorId ( $oParametro );
		return $oParametro;
	}

	public function getParametro($criterio){
		$oParametro =  ParametroQuery::getParametro ( $criterio );
		return $oParametro;
	}

}