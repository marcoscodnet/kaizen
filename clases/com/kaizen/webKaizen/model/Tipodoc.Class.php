<?php

class Tipodoc {
	private $cd_tipodoc;
	private $ds_tipodoc;

	//M�todo constructor


	function Tipodoc() {
			
		$this->cd_tipodoc = 0;
		$this->ds_tipodoc = '';
	}

	//M�todos Get


	function getCd_tipodoc() {
		return $this->cd_tipodoc;
	}

	function getDs_tipodoc() {
		return $this->ds_tipodoc;
	}

	//M�todos Set


	function setCd_tipodoc($value) {
		$this->cd_tipodoc = $value;
	}

	function setDs_tipodoc($value) {
		$this->ds_tipodoc = $value;
	}

}

