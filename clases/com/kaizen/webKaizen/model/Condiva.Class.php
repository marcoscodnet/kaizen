<?php

class Condiva {
	private $cd_condiva;
	private $ds_condiva;

	//Método constructor


	function Condiva() {
		$this->cd_condiva = 0;
		$this->ds_condiva = '';
	}

	//Métodos Get
	function getCd_condiva() {
		return $this->cd_condiva;
	}

	function getDs_condiva() {
		return $this->ds_condiva;
	}

	//Métodos Set
	function setCd_condiva($value) {
		$this->cd_condiva = $value;
	}

	function setDs_condiva($value) {
		$this->ds_condiva = $value;
	}

}

