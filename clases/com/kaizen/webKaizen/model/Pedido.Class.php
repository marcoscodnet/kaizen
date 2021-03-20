<?php

/**
 * @author María Jesús
 * @since 5-09-2011
 *
 * Pedido.
 */
class Pedido{

	private $cd_pedido;
	private $oPieza;
	private $ds_pieza;
	private $nu_cantidad;
	private $qt_minimo;
	private $qt_sena;
	private $cd_estado;
	private $dt_pedido;
	private $ds_observacion;
	

	//Método constructor
	function Pedido(){
		$this->cd_pedido=0;
		$this->oPieza=new Pieza();
		$this->ds_pieza = "";
		$this->nu_cantidad=0;
		$this->qt_minimo=0;
		$this->qt_sena=0;
		$this->cd_estado=0;
		$this->dt_pedido="";
		$this->ds_observacion = "";
	}

	//Métodos Get
	function getCd_pedido() {
		return $this->cd_pedido;
	}

	function getPieza() {
		return $this->oPieza;
	}

	function getCd_pieza() {
		return $this->getPieza()->getCd_pieza();
	}
	
	function getDs_pieza() {
		return $this->ds_pieza;
	}
	
	function getNu_cantidad() {
		return $this->nu_cantidad;
	}

	function getQt_minimo() {
		return $this->qt_minimo;
	}
	
	function getQt_sena() {
		return $this->qt_sena;
	}

	function getCd_estado() {
		return $this->cd_estado;
	}
	
	function getDt_pedido() {
		return $this->dt_pedido;
	}

	function getDs_observacion() {
		return $this->ds_observacion;
	}

	function getDs_estadopedido() {
		//$cd_estado = $this->getEstado()->getCd_estadopedido();
		$cd_estado = $this->getCd_estado();
		if($cd_estado == NULL || $cd_estado == 0){
			return "A Pedir";
		}else{
			return "Pedido";
		}
	}

	//Métodos Set

	function setCd_pedido($value) {
		$this->cd_pedido = $value;
	}

	function setPieza($value) {
		$this->oPieza = $value;
	}
	
	function setCd_pieza($value) {
		$this->getPieza()->setCd_pieza($value);
	}
	
	function setDs_pieza($value) {
		$this->ds_pieza = $value;
	}

	function setNu_cantidad($value) {
		$this->nu_cantidad = $value;
	}
	
	function setQt_minimo($value) {
		$this->qt_minimo = $value;
	}

	function setQt_sena($value) {
		$this->qt_sena = $value;
	}

	function setCd_estado($value) {
		$this->cd_estado = $value;
	}

	function setDt_pedido($value) {
		$this->dt_pedido = $value;
	}
	
	function setDs_observacion($value) {
		$this->ds_observacion = $value;
	}
}