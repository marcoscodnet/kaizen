<?php

/**
 * @author Ma. Jes�s
 * @since 21-07-2011
 * 
 * Proveedor.
 */
class Proveedor{
	
	private $cd_proveedor;
	private $ds_proveedor;
		
	//M�todo constructor
	function Proveedor(){
		$this->cd_proveedor=0;
		$this->ds_proveedor='';
	}
	
	//M�todos Get 
	function getCd_proveedor() {
		return $this->cd_proveedor;
	}
	
	function getDs_proveedor() {
		return $this->ds_proveedor;
	}
	
	//M�todos Set

	function setCd_proveedor($value) {
		$this->cd_proveedor = $value;
	}
	
	function setDs_proveedor($value) {
		$this->ds_proveedor = $value;
	}
	
}