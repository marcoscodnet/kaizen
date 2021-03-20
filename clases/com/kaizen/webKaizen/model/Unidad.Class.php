<?php

/**
 * @author Lucrecia
 * @since 18-01-2011
 *
 * Cliente.
 */
class Unidad{

	private $cd_unidad;
	private $oProducto;
	private $nu_motor;
	private $nu_cuadro;
	private $dt_ingreso;
	private $nu_patente;
	private $nu_remitoingreso;
	private $nu_aniomodelo;
	private $oSucursalactual;
	private $nu_envio;
	private $ds_observacion;
	private $cd_venta;
	private $oAutorizacion;

	//Método constructor
	function Unidad(){
		$this->cd_unidad=0;
		$this->oProducto=new Producto();
		$this->nu_motor='';
		$this->nu_cuadro='';
		$this->dt_ingreso='';
		$this->nu_patente='';
		$this->nu_remitoingreso='';
		$this->nu_aniomodelo='';
		$this->oSucursalactual=new Sucursal();
		$this->nu_envio='';
		$this->ds_observacion='';
		$this->cd_venta = 0;
		$this->oAutorizacion = new Autorizacion();
	}

	//Métodos Get
	function getCd_unidad() {
		return $this->cd_unidad;
	}

	function getProducto() {
		return $this->oProducto;
	}

	function getCd_producto() {
		return $this->getProducto()->getCd_producto();
	}

	function getDs_producto() {
		return $this->getProducto()->getDs_producto();
	}

	function getNu_monto_sugerido() {
		return $this->getProducto()->getNu_monto_sugerido();
	}
	
	function getDs_modelo() {
		return $this->getProducto()->getDs_modelo();
	}

	function getNu_motor() {
		return $this->nu_motor;
	}

	function getNu_cuadro() {
		return $this->nu_cuadro;
	}

	function getDt_ingreso() {
		return $this->dt_ingreso;
	}

	function getNu_patente() {
		return $this->nu_patente;
	}

	function getNu_remitoingreso() {
		return $this->nu_remitoingreso;
	}

	function getNu_aniomodelo() {
		return $this->nu_aniomodelo;
	}

	function getSucursalactual() {
		return $this->oSucursalactual;
	}

	function getCd_sucursalactual() {
		return $this->oSucursalactual->getCd_sucursal();
	}

	function getDs_sucursal() {
		return $this->oSucursalactual->getDs_nombre();
	}

	function getDs_observacion() {
		return $this->ds_observacion;
	}

	function getCd_venta() {
		return $this->cd_venta;
	}

	function getAutorizacion(){
		return $this->oAutorizacion;
	}

	function getCd_autorizacion() {
		return $this->getAutorizacion()->getCd_autorizacion();
	}

	function getDt_autorizacion() {
		return $this->getAutorizacion()->getDt_autorizacion();
	}

	function getNu_envio() {
		return $this->nu_envio;
	}

	//Métodos Set

	function setCd_unidad($value) {
		$this->cd_unidad = $value;
	}

	function setProducto($value) {
		$this->oProducto = $value;
	}

	function setDs_producto($value) {
		$this->getProducto()->setDs_producto( $value );
	}

	function setCd_producto($value) {
		$this->oProducto->setCd_producto( $value );
	}

	function setNu_motor($value) {
		$this->nu_motor = $value;
	}

	function setNu_cuadro($value) {
		$this->nu_cuadro = $value;
	}

	function setDt_ingreso($value) {
		$this->dt_ingreso = $value;
	}

	function setNu_patente($value) {
		$this->nu_patente = $value;
	}

	function setNu_remitoingreso($value) {
		$this->nu_remitoingreso = $value;
	}

	function setNu_aniomodelo($value) {
		$this->nu_aniomodelo = $value;
	}

	function setSucursalactual($value) {
		$this->oSucursalactual = $value;
	}
	function setCd_sucursalactual($value) {
		$this->getSucursalactual()->setCd_sucursal($value);
	}

	function setDs_sucursalactual($value) {
		$this->getSucursalactual()->setDs_nombre($value);
	}

	function setDs_observacion($value) {
		$this->ds_observacion = $value;
	}

	function setNu_envio($value) {
		$this->nu_envio = $value;
	}

	function setCd_venta($value) {
		$this->cd_venta = $value;
	}

	function setAutorizacion($value){
		$this->oAutorizacion = $value;
	}

	function setCd_autorizacion($value) {
		$this->getAutorizacion()->setCd_autorizacion($value);
	}

	function setDt_autorizacion($value) {
		$this->getAutorizacion()->setDt_autorizacion($value);
	}
}