<?php
/**
 *
 * @author bernardo
 * @since 16-03-2010
 *
 */
class Comollego {
	private $cd_comollego;
	private $ds_comollego;


	//Método constructor


	function Comollego() {
		$this->cd_comollego = 0;
		$this->ds_comollego = '';
	}

	//Métodos Get
	function getCd_comollego() {
		return $this->cd_comollego;
	}

	function getDs_comollego() {
		return $this->ds_comollego;
	}

		
	//Métodos Set
	function setCd_comollego($value) {
		$this->cd_comollego = $value;
	}

	function setDs_comollego($value) {
		$this->ds_comollego = $value;
	}
}

