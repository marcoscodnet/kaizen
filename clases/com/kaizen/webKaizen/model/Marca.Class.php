<?php

class Marca {
	private $cd_marca;
	private $ds_marca;
	private $tiposunidades;


	//Método constructor
	function Marca() {
		$this->cd_marca = 0;
		$this->ds_marca = '';
		$tiposunidades = new ItemCollection ();
	}

	//Métodos Get
	function getCd_marca() {
		return $this->cd_marca;
	}

	function getDs_marca() {
		return $this->ds_marca;
	}

	function getTiposunidades(){
		return $this->tiposunidades;
	}

	//Métodos Set
	function setCd_marca($value) {
		$this->cd_marca = $value;
	}

	function setDs_marca($value) {
		$this->ds_marca = $value;
	}
	
	function setTiposunidades($value){
		$this->tiposunidades = $value;
	}
}

