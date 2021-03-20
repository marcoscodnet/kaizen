<?php

class Movimiento {

	private $cd_movimiento;
	private $oSucursalOrigen;
	private $oSucursalDestino;
	private $unidades;
	private $oUnidad;
	private $oUsuario;
	private $dt_movimiento;
	private $ds_observacion;

	//M�todo constructor


	function Movimiento() {
		$this->cd_movimiento = '';
		$this->oSucursalOrigen = new Sucursal();
		$this->oSucursalDestino = new Sucursal();
		$this->unidades = new ItemCollection();
		$this->oUnidad = new Unidad();
		$this->oUsuario = new Usuario();
		$this->dt_movimiento = '';
		$this->ds_observacion = '';
	}

	//M�todos Get
	function getCd_movimiento() {
		return $this->cd_movimiento;
	}

	function getSucursalOrigen() {
		return $this->oSucursalOrigen;
	}

	function getCd_sucursalorigen() {
		return $this->getSucursalOrigen()->getCd_sucursal();
	}

	function getDs_sucursalorigen() {
		return $this->getSucursalOrigen()->getDs_nombre();
	}

	function getSucursalDestino() {
		return $this->oSucursalDestino;
	}

	function getCd_sucursaldestino() {
		return $this->getSucursalDestino()->getCd_sucursal();
	}

	function getDs_sucursaldestino() {
		return $this->getSucursalDestino()->getDs_nombre();
	}

	function getDs_localidadsucursaldestino() {
		return $this->getSucursalDestino()->getLocalidad()->getDs_localidad();
	}
	function getDs_domiciliosucursaldestino() {
		return $this->getSucursalDestino()->getDs_domicilio();
	}

	function getDs_localidadsucursalorigen() {
		return $this->getSucursalOrigen()->getLocalidad()->getDs_localidad();
	}

	function getDs_domiciliosucursalorigen() {
		return $this->getSucursalOrigen()->getDs_domicilio();
	}

	function getDs_telefonosucursalorigen() {
		return $this->getSucursalOrigen()->getDs_telefono();
	}

	function getUnidades() {
		return $this->unidades;
	}

	function getUnidad() {
		return $this->oUnidad;
	}

	function getCd_unidad() {
		return $this->getUnidad()->getCd_unidad();
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

	function getDt_movimiento() {
		return $this->dt_movimiento;
	}

	function getDs_observacion() {
		return $this->ds_observacion;
	}

	//M�todos Set

	function setCd_movimiento($value) {
		$this->cd_movimiento = $value;
	}

	function setSucursalOrigen($value) {
		$this->oSucursalOrigen = $value;
	}

	function setCd_sucursalorigen($value) {
		$this->getSucursalOrigen()->setCd_sucursal($value);
	}

	function setDs_sucursalorigen($value) {
		$this->getSucursalOrigen()->setDs_nombre($value);
	}

	function setSucursalDestino($value) {
		$this->oSucursalDestino = $value;
	}

	function setCd_sucursaldestino($value) {
		$this->getSucursalDestino()->setCd_sucursal($value);
	}

	function setDs_sucursaldestino($nombre) {
		$this->getSucursalDestino()->setDs_nombre($nombre);
	}

	function setDs_localidadsucursaldestino($nombre) {
		$this->getSucursalDestino()->getLocalidad()->setDs_localidad($nombre);
	}

	function setDs_localidadsucursalorigen($nombre) {
		$this->getSucursalOrigen()->getLocalidad()->setDs_localidad($nombre);
	}

	function setDs_domiciliosucursaldestino($nombre) {
		$this->getSucursalDestino()->setDs_domicilio($nombre);
	}

	function setDs_domiciliosucursalorigen($nombre) {
		$this->getSucursalOrigen()->setDs_domicilio($nombre);
	}

	function setDs_telefonosucursalorigen($nombre) {
		$this->getSucursalOrigen()->setDs_telefono($nombre);
	}

	function setUnidades($value) {
		$this->unidades = $value;
	}

	function setUnidad($value) {
		$this->oUnidad = $value;
	}

	function setCd_unidad($value) {
		$this->getUnidad()->setCd_unidad($value);
	}

	function setUsuario($value) {
		$this->oUsuario = $value;
	}

	function setCd_usuario($value) {
		$this->getUsuario()->setCd_usuario($value);
	}

	function setDt_movimiento($value) {
		$this->dt_movimiento = $value;
	}

	function setDs_observacion($value) {
		$this->ds_observacion = $value;
	}
}
?>
