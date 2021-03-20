<?php

/**
 * @author Ma. Jesús
 * @since 18-06-2011
 *
 * Pieza.
 */
class Pieza{
	private $cd_pieza;
	private $ds_codigo;
	private $ds_descripcion;
	private $nu_stock_minimo;
	private $nu_stock_actual;
	private $qt_costo;
	private $qt_minimo;
	private $ds_observacion;
	private $nu_cantidadpedida;
	private $qt_montoacobrar;
		

	//Método constructor
	function Pieza(){
		$this->cd_pieza = 0;
		$this->ds_codigo = "";
		$this->ds_descripcion = "";
		$this->nu_stock_minimo = 0;
		$this->nu_stock_actual = 0;
		$this->qt_costo = 0;
		$this->qt_minimo = 0;
		$this->ds_observacion = "";
		$this->nu_cantidadpedida = 0;
		$this->qt_montoacobrar = 0;
	}

	//Métodos Get
	function getCd_pieza() {
		return $this->cd_pieza;
	}

	function getDs_codigo() {
		return $this->ds_codigo;
	}

	function getDs_descripcion() {
		return $this->ds_descripcion;
	}
	
	function getNu_stock_minimo() {
		return $this->nu_stock_minimo;
	}
	
	function getNu_stock_actual() {
		return $this->nu_stock_actual;
	}
	
	function getQt_costo() {
		return $this->qt_costo;
	}
	
	function getQt_minimo() {
		return $this->qt_minimo;
	}
	
	function getDs_observacion() {
		return $this->ds_observacion;
	}
	
	function getNu_cantidadpedida() {
		return $this->nu_cantidadpedida;
	}
	
	function getQt_montoacobrar() {
		return $this->qt_montoacobrar;
	}

	//Metodos set

	function setCd_pieza($value) {
		$this->cd_pieza = $value;
	}

	function setDs_codigo($value) {
		$this->ds_codigo = $value;
	}

	function setDs_descripcion($value) {
		$this->ds_descripcion = $value;
	}

	function setNu_stock_minimo($value) {
		$this->nu_stock_minimo = $value;
	}
	
	function setQt_costo($value) {
		$this->qt_costo = $value;
	}
	
	function setQt_minimo($value) {
		$this->qt_minimo = $value;
	}
	
	function setDs_observacion($value) {
		$this->ds_observacion = $value;
	}
	
	function setNu_stock_actual($value) {
		$this->nu_stock_actual = $value;
	}
	
	function setNu_cantidadpedida($value) {
		$this->nu_cantidadpedida = $value;
	}

	function setQt_montoacobrar($value) {
		$this->qt_montoacobrar = $value;
	}
}