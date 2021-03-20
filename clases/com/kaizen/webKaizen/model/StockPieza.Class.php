<?php

/**
 * @author Ma. Jesús
 * @since 20-07-2011
 *
 * Stock Pieza.
 */
class StockPieza{
	private $cd_stockpieza;
	private $cd_pieza;
	private $oPieza;
	private $nu_cantidad;
	private $qt_costo;
	private $qt_minimo;
	private $cd_sucursal;
	private $oSucursal;
	private $cd_proveedor;
	private $oProveedor;
	private $dt_ingreso;		private $ds_remito;

	//Método constructor
	function Pieza(){
		$this->cd_stockpieza = 0;
		$this->cd_pieza = 0;
		$this->oPieza = new Pieza();
		$this->nu_cantidad = 0;
		$this->qt_costo = 0;
		$this->qt_minimo = 0;
		$this->cd_sucursal = 0;
		$this->oSucursal = new Sucursal();
		$this->cd_proveedor = 0;
		$this->oProveedor = new Proveedor();
		$this->dt_ingreso = "";				$this->ds_remito = "";
	}

	//Métodos Get
	
	function getCd_stockPieza() {
		return $this->cd_stockpieza;
	}
	
	function getCd_pieza() {
		return $this->cd_pieza;
	}
	
	function getPieza() {
		return $this->oPieza;
	}
	
	function getNu_cantidad() {
		return $this->nu_cantidad;
	}

	function getQt_costo() {
		return $this->qt_costo;
	}
	
	function getQt_minimo() {
		return $this->qt_minimo;
	}
	
	function getCd_sucursal() {
		return $this->cd_sucursal;
	}
	
	function getSucursal() {
		return $this->oSucursal;
	}
	
	function getCd_proveedor() {
		return $this->cd_proveedor;
	}
	
	function getProveedor() {
		return $this->oProveedor;
	}
	
	function getDt_ingreso() {
		return $this->dt_ingreso;
	}
	
	//Metodos set

	function setCd_stockPieza($value) {
		$this->cd_stockpieza = $value;
	}
	
	function setCd_pieza($value) {
		$this->cd_pieza = $value;
	}
	
	function setPieza($value) {
		$this->oPieza = $value;
	}
	
	function setNu_cantidad($value) {
		$this->nu_cantidad = $value;
	}

	function setQt_costo($value) {
		$this->qt_costo = $value;
	}
	
	function setQt_minimo($value) {
		$this->qt_minimo = $value;
	}
	
	function setCd_sucursal($value) {
		$this->cd_sucursal = $value;
	}
	
	function setSucursal($value) {
		$this->oSucursal = $value;
	}
	
	function setCd_proveedor($value) {
		$this->cd_proveedor = $value;
	}
	
	function setProveedor($value) {
		$this->oProveedor = $value;
	}
	
	function setDt_ingreso($value) {
		$this->dt_ingreso = $value;
	}
	
	public function getDs_remito()	{	    return $this->ds_remito;	}	public function setDs_remito($ds_remito)	{	    $this->ds_remito = $ds_remito;	}}