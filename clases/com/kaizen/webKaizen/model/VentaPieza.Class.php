<?php

/**
 * @author Marï¿½a Jesï¿½s
 * @since 11-11-2011
 *
 * VentaPieza.
 */
class VentaPieza{

	private $cd_ventapieza;
	private $nu_precioCobrado;
	private $nu_precioMin;
	private $ds_apynomCliente;
	private $nu_docCliente;
	private $ds_telCliente;
	private $ds_motoCliente;
	private $oSucursalOrigen;
	private $oSucursal;
	private $nu_pedidoreparacion;
	private $dt_ventapieza;
	private $ds_descripcion;
	private $oPieza;
	private $nu_destino;
	private $ds_destino;
	private $piezas;
	private $oUsuario;
	private $ds_piezas;
	
	
	//Mï¿½todo constructor
	function VentaPieza(){
		$this->cd_ventapieza=0;
		$this->nu_precioCobrado=0;
		$this->nu_precioMin=0;
		$this->ds_apynomCliente="";
		$this->nu_docCliente="";
		$this->ds_telCliente="";
		$this->ds_motoCliente="";
		$this->oSucursalOrigen= new Sucursal();
		$this->oSucursal= new Sucursal();
		$this->nu_pedidoreparacion=0;
		$this->dt_ventapieza='';
		$this->ds_descripcion = "";
		$this->oPieza = new Pieza();
		$this->nu_destino=0;
		$this->ds_destino="";
		$this->piezas = new ItemCollection();
		$this->oUsuario =new Usuario();
		$this->ds_piezas="";
	}

	//Mï¿½todos Get
	function getCd_ventapieza() {
		return $this->cd_ventapieza;
	}

	function getNu_precioCobrado() {
		return $this->nu_precioCobrado;
	}

	function getNu_precioMin() {
		return $this->nu_precioMin;
	}

	function getDs_apynomCliente() {
		return $this->ds_apynomCliente;
	}

	function getNu_docCliente() {
		return $this->nu_docCliente;
	}

	function getDs_telCliente() {
		return $this->ds_telCliente;
	}
	
	function getDs_motoCliente() {
		return $this->ds_motoCliente;
	}
	
	function getSucursalOrigen() {
		return $this->oSucursalOrigen;
	}
	
	function getSucursal() {
		return $this->oSucursal;
	}

		
	function getCd_sucursal() {
		return $this->getSucursal()->getCd_sucursal();
	}
	
	function getDs_nombre() {
		return $this->getSucursal()->getDs_nombre();
	}

	function getNu_pedidoreparacion() {
		return $this->nu_pedidoreparacion;
	}
	
	function getDt_ventapieza() {
		return $this->dt_ventapieza;
	}
	
	function getDs_descripcion() {
		return $this->ds_descripcion;
	}
	
	function getPiezas() {
		return $this->piezas;
	}

	function getPieza() {
		return $this->oPieza;
	}

	function getCd_pieza() {
		return $this->getPieza()->getCd_pieza();
	}
	
	function getNu_destino() {
		return $this->nu_destino;
	}
	
	function getDs_destino() {
		switch ($this->nu_destino) {
		case 1:
			$ds_destino = "Salón";
			break;
		case 2:
			$ds_destino = "Sucursal";
			break;
		case 3:
			$ds_destino = "Taller";
			break;
		}
		return $ds_destino;
	}
	
function getUsuario() {

		return $this->oUsuario;

	}
	
	//Mï¿½todos Set

	function setCd_ventapieza($value) {
		$this->cd_ventapieza = $value;
	}

	function setNu_precioCobrado($value) {
		$this->nu_precioCobrado = $value;
	}

	function setNu_precioMin($value) {
		$this->nu_precioMin = $value;
	}

	function setDs_apynomCliente($value) {
		$this->ds_apynomCliente = $value;
	}

	function setNu_docCliente($value) {
		$this->nu_docCliente = $value;
	}

	function setDs_telCliente($value) {
		$this->ds_telCliente = $value;
	}
	
	function setDs_motoCliente($value) {
		$this->ds_motoCliente = $value;
	}
	
	function setSucursalOrigen($value) {
		$this->oSucursalOrigen = $value;
	}
	
	function setSucursal($value) {
		$this->oSucursal = $value;
	}
	
	function setCd_sucursal($value) {
		$this->getSucursal()->setCd_sucursal($value);
	}
	
	function setDs_nombre($value) {
		$this->getSucursal()->setDs_nombre($value);
	}

	function setNu_pedidoreparacion($value) {
		$this->nu_pedidoreparacion = $value;
	}
	
	function setDt_ventapieza($value) {
		$this->dt_ventapieza = $value;
	}
	
	function SetDs_descripcion($value) {
		$this->ds_descripcion = $value;
	}
	
	function setPiezas($value) {
		$this->piezas = $value;
	}
	
	function setPieza($value) {
		$this->oPieza = $value;
	}

	function setCd_pieza($value) {
		$this->getPieza()->setCd_pieza($value);
	}
	
	function setNu_destino($value) {
		$this->nu_destino = $value;
	}
	
	function setDs_destino($value) {
		$this->ds_destino = $value;
	}
	
	function setUsuario($value) {

		$this->oUsuario = $value;

	}

	public function getDs_piezas()
	{
	    return $this->ds_piezas;
	}

	public function setDs_piezas($ds_piezas)
	{
	    $this->ds_piezas = $ds_piezas;
	}
}