<?php

class ModificarBoletoAction extends EditarBoletoAction{

	protected function editar($oEntidad){
		$manager = new ParametroManager();
		$manager->modificarParametro($oEntidad);
	}

	protected function getForwardSuccess(){
		return 'modificar_boleto_success';
	}

	protected function getForwardError(){
		return 'modificar_boleto_error';
	}

	public function getFuncion(){
		return "Modificar Boleto CV";
	}

}