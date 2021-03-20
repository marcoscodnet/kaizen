<?php

/**
 * @author Lucrecia
 * @since 18-01-2011
 *
 * Cliente.
 */
class Venta{

	private $cd_venta;
	private $oCliente;
	private $nu_totalventa;
	private $oUsuario;
	private $oSucursal;
	private $dt_fecha;
	private $oUnidad;
	private $oFormapago;
	private $nu_montosugerido;
	private $nu_importeencreditos;
	private $ds_observacion;


	//Método constructor
	function Venta(){
		$this->cd_venta=0;
		$this->oCliente=new Cliente();
		$this->nu_totalventa=0;
		$this->oUsuario =new Usuario();
		$this->oSucursal= new Sucursal();
		$this->dt_fecha='';
		$this->oUnidad=new Unidad();
		$this->oFormapago=new Formapago();
		$this->nu_montosugerido = 0;
		$this->nu_importeencreditos = NULL;
		$this->ds_observacion = "";
	}

	//Métodos Get
	function getCd_venta() {
		return $this->cd_venta;
	}

	function getNu_totalventa() {
		return $this->nu_totalventa;
	}

	function getNu_importeencreditos() {
		return $this->nu_importeencreditos;
	}

	function getDt_fecha() {
		return $this->dt_fecha;
	}

	function getDs_observacion() {
		return $this->ds_observacion;
	}

	function getNu_montosugerido() {
		return $this->nu_montosugerido;
	}

	function getCliente() {
		return $this->oCliente;
	}

	function getCd_cliente() {
		return $this->getCliente()->getCd_cliente();
	}

	function getDs_apynom() {
		return $this->getCliente()->getDs_apynom();
	}

	function getNu_montoVenta(){
		if($this->getCd_autorizacion() == NULL || $this->getCd_autorizacion() == 0){
			return "--";
		}else{
			if($this->getNu_importeencreditos() == null){
				return "$ ".$this->getNu_totalventa();
			}else{
				return "$ ".$this->getNu_importeencreditos();
			}

		}
	}

	function getUsuario() {
		return $this->oUsuario;
	}

	function getCd_usuario() {
		return $this->getUsuario()->getCd_usuario();
	}

	function getDs_nomusuario() {
		return $this->getUsuario()->getDs_nomusuario();
	}

	function getDs_apynom_usuario() {
		return $this->getUsuario()->getDs_apynom();
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

	function getUnidad() {
		return $this->oUnidad;
	}

	function getFormapago() {
		return $this->oFormapago;
	}

	function getCd_formapago() {
		return $this->getFormapago()->getCd_formapago();
	}

	function getDs_formapago() {
		return $this->getFormapago()->getDs_formapago();
	}

	function getNu_motor() {
		return $this->getUnidad()->getNu_motor();
	}

	function getDs_modelo() {
		return $this->getUnidad()->getDs_modelo();
	}

	function getCd_unidad() {
		return $this->getUnidad()->getCd_unidad();
	}
	function getCd_autorizacion() {
		return $this->getUnidad()->getCd_autorizacion();
	}

	function getDs_producto() {
		return $this->getUnidad()->getDs_producto();
	}

	function getDs_autorizada() {
		$cd_autorizacion = $this->getUnidad()->getCd_autorizacion();
		if($cd_autorizacion == NULL || $cd_autorizacion == 0){
			return "No Autorizada";
		}else{
			return "Autorizada";
		}
	}

	//Métodos Set

	function setCd_venta($value) {
		$this->cd_venta = $value;
	}

	function setNu_totalventa($value) {
		$this->nu_totalventa = $value;
	}

	function setDs_observacion($value) {
		$this->ds_observacion = $value;
	}

	function setDt_fecha($value) {
		$this->dt_fecha = $value;
	}

	function setNu_montosugerido($value) {
		$this->nu_montosugerido = $value;
	}

	function setNu_importeencreditos($value) {
		$this->nu_importeencreditos = $value;
	}

	function setCliente($value) {
		$this->oCliente = $value;
	}

	function setCd_cliente($value) {
		$this->getCliente()->setCd_cliente($value);
	}

	function setDs_apynom($value) {
		$this->getCliente()->setDs_apynom($value);
	}


	function setUsuario($value) {
		$this->oUsuario = $value;
	}

	function setCd_usuario($value) {
		$this->getUsuario()->setCd_usuario($value);
	}

	function setDs_nomusuario($value) {
		$this->getUsuario()->setDs_nomusuario($value);
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

	function setUnidad($value) {
		$this->oUnidad = $value;
	}
	function setCd_unidad($value) {
		$this->getUnidad()->setCd_unidad($value);
	}

	function setFormapago($value) {
		$this->oFormapago = $value;
	}
	function setCd_formapago($value) {
		$this->getFormapago()->setCd_formapago($value);
	}

}