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


	//M�todo constructor


	function Comollego() {
		$this->cd_comollego = 0;
		$this->ds_comollego = '';
	}

	//M�todos Get
	function getCd_comollego() {
		return $this->cd_comollego;
	}

	function getDs_comollego() {
		return $this->ds_comollego;
	}

		
	//M�todos Set
	function setCd_comollego($value) {
		$this->cd_comollego = $value;
	}

	function setDs_comollego($value) {
		$this->ds_comollego = $value;
	}
}

