<?php
class VentaPiezaUnidad {
	private $cd_ventapieza;
	private $oPieza;
	private $nu_cantidadpedida;
	private $qt_montoacobrar;
	private $oSucursal;

	//Método constructor


	function VentaPiezaUnidad() {
		$this->cd_ventapieza = 0;
		$this->oPieza=new Pieza();
		$this->nu_cantidadpedida = 0;
		$this->qt_montoacobrar = 0;
		$this->oSucursal=new Sucursal();
	}

	//Métodos Get


	function getCd_ventapieza() {
		return $this->cd_ventapieza;
	}

	function getPieza() {
		return $this->oPieza;
	}

	function getCd_pieza() {
		return $this->getPieza()->getCd_pieza();
	}
	
	function getNu_cantidadpedida() {
		return $this->nu_cantidadpedida;
	}
	
	function getQt_montoacobrar() {
		return $this->qt_montoacobrar;
	}
	
	function getSucursal() {
		return $this->oSucursal;
	}

	//Métodos Set

	function setCd_ventapieza($value) {
		$this->cd_ventapieza = $value;
	}

	function setPieza($value) {
		$this->oPieza = $value;
	}

	function setCd_pieza($value) {
		$this->getPieza()->setCd_pieza($value);
	}
	
	function setNu_cantidadpedida($value) {
		$this->nu_cantidadpedida = $value;
	}

	function setQt_montoacobrar($value) {
		$this->qt_montoacobrar = $value;
	}
	
	function setSucursal($value) {
		$this->oSucursal = $value;
	}
}
?>
