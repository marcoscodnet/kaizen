<?php

class Tiposervicio {
	private $cd_tiposervicio;
	private $ds_tiposervicio;
	
	//M�todo constructor 
	

	function Tiposervicio() {
		
		$this->cd_tiposervicio = 0;
		$this->ds_tiposervicio = '';
	}
	
	//M�todos Get 
	

	function getCd_tiposervicio() {
		return $this->cd_tiposervicio;
	}
	
	function getDs_tiposervicio() {
		return $this->ds_tiposervicio;
	}
	
	//M�todos Set 
	

	function setCd_tiposervicio($value) {
		$this->cd_tiposervicio = $value;
	}
	
	function setDs_tiposervicio($value) {
		$this->ds_tiposervicio = $value;
	}

}

