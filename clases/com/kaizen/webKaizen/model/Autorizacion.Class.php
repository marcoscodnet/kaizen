<?php

class Autorizacion {
	private $cd_autorizacion;
	private $cd_unidad;
	private $oUsuario;
	private $dt_autorizacion;

	//Método constructor


	function Autorizacion() {
		$this->cd_autorizacion = 0;
		$this->cd_unidad = '';
		$this->oUsuario = new Usuario();
		$this->dt_autorizacion = '';
	}

	//Métodos Get


	function getCd_autorizacion() {
		return $this->cd_autorizacion;
	}

	function getCd_unidad() {
		return $this->cd_unidad;
	}

	function getUsuario(){
		return $this->oUsuario;
	}

	function getCd_usuario() {
		return $this->getUsuario()->getCd_usuario();
	}

	function getDs_usuario() {
		return $this->getUsuario()->getDs_nomusuario();
	}

	function getDt_autorizacion() {
		return $this->dt_autorizacion;
	}

	//Métodos Set


	function setCd_autorizacion($value) {
		$this->cd_autorizacion = $value;
	}

	function setCd_unidad($value) {
		$this->cd_unidad = $value;
	}

	function setUsuario($value) {
		$this->oUsuario = $value;
	}

	function setCd_usuario($value) {
		$this->getUsuario()->setCd_usuario($value);
	}

	function setDt_autorizacion($value) {
		$this->dt_autorizacion = $value;
	}

}

