<?php

class Itempago {

	private $cd_itempago;
	private $oEntidad;
	private $oVenta;
	private $nu_importe;
	private $dt_pago;
	private $nu_pagado;
	private $dt_contadora;
	private $ds_detalle;
	private $ds_observacion;

	//M�todo constructor


	function Itempago() {
		$this->cd_itempago = 0;
		$this->oEntidad = new Entidad();
		$this->oVenta = new Venta();
		$this->nu_importe = 0;
		$this->nu_pagado = 0;
		$this->ds_detalle = "";
		$this->ds_observacion = "";
		$this->dt_pago = date("d/m/Y");
		$this->dt_contadora = date("d/m/Y");
	}

	//M�todos Get


	function getCd_itempago() {
		return $this->cd_itempago;
	}

	function getEntidad() {
		return $this->oEntidad;
	}

	function getDs_entidad() {
		return $this->getEntidad()->getDs_entidad();
	}

	function getCd_entidad() {
		return $this->getEntidad()->getCd_entidad();
	}

	function getVenta() {
		return $this->oVenta;
	}

	function getCd_venta() {
		return $this->getVenta()->getCd_venta();
	}

	function getNu_importe() {
		return $this->nu_importe;
	}

	function getNu_pagado() {
		return $this->nu_pagado;
	}

	function getDs_observacion() {
		return $this->ds_observacion;
	}

	function getDs_detalle() {
		return $this->ds_detalle;
	}
	function getDt_pago() {
		return $this->dt_pago;
	}
	function getDt_contadora() {
		return $this->dt_contadora;
	}

	//M�todos Set


	function setCd_itempago($value) {
		$this->cd_itempago = $value;
	}

	function setEntidad($value) {
		$this->oEntidad = $value;
	}

	function setCd_entidad($value) {
		$this->getEntidad()->setCd_entidad($value);
	}

	function setDs_entidad($value) {
		$this->getEntidad()->setDs_entidad($value);
	}

	function setVenta($value) {
		$this->oVenta = $value;
	}

	function setCd_venta($value) {
		$this->getVenta()->setCd_venta($value);
	}

	function setNu_importe($value) {
		$this->nu_importe = $value;
	}

	function setNu_pagado($value) {
		$this->nu_pagado = $value;
	}

	function setDs_observacion($value) {
		$this->ds_observacion = $value;
	}

	function setDs_detalle($value) {
		$this->ds_detalle = $value;
	}

	function setDt_pago($value) {
		$this->dt_pago = $value;
	}

	function setDt_contadora($value) {
		$this->dt_contadora = $value;
	}

}


