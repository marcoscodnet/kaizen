<?php

class Parametro {
	private $cd_parametro;
	private $ds_nombre;
	private $ds_contenido;

	//Método constructor


	function Parametro() {
		$this->cd_parametro = 0;
		$this->ds_nombre = '';
		$this->ds_contenido = '';
	}

	//Métodos Get


	function getCd_parametro() {
		return $this->cd_parametro;
	}

	function getDs_nombre() {
		return $this->ds_nombre;
	}

	function getDs_contenido() {
		return $this->ds_contenido;
	}
	//Métodos Set


	function setCd_parametro($value) {
		$this->cd_parametro = $value;
	}

	function setDs_nombre($value) {
		$this->ds_nombre = $value;
	}

	function setDs_contenido($value) {
		$this->ds_contenido = $value;
	}
}

