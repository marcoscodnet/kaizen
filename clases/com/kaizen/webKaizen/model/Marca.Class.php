<?php

class Marca {
	private $cd_marca;
	private $ds_marca;
	private $tiposunidades;


	//M�todo constructor
	function Marca() {
		$this->cd_marca = 0;
		$this->ds_marca = '';
		$tiposunidades = new ItemCollection ();
	}

	//M�todos Get
	function getCd_marca() {
		return $this->cd_marca;
	}

	function getDs_marca() {
		return $this->ds_marca;
	}

	function getTiposunidades(){
		return $this->tiposunidades;
	}

	//M�todos Set
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

