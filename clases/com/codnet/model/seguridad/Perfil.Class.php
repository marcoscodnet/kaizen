<?php

class Perfil {
	private $cd_perfil;
	private $ds_perfil;
	private $funciones;		
	
	//M�todo constructor 
	

	function Perfil() {
		
		$this->cd_perfil = 0;
		$this->ds_perfil = '';
		$funciones = new ItemCollection ();
	}
	
	//M�todos Get 
	

	function getCd_perfil() {
		return $this->cd_perfil;
	}
	
	function getDs_perfil() {
		return $this->ds_perfil;
	}
	
	function getFunciones(){
		return $this->funciones;
	}
	
	//M�todos Set 
	

	function setCd_perfil($value) {
		$this->cd_perfil = $value;
	}
	
	function setDs_perfil($value) {
		$this->ds_perfil = $value;
	}
	
	function setFunciones($value){
		$this->funciones=$value;
	}
	
}

