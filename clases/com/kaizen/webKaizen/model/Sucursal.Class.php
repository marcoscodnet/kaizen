<?php

/**
 * @author Lucrecia
 * @since 18-01-2011
 * 
 * Cliente.
 */
class Sucursal{
	
	private $cd_sucursal;
	private $ds_nombre;
	private $ds_email;
	private $ds_domicilio;
	private $ds_telefono;
	private $oLocalidad;
	private $ds_comentario;
		
	//Método constructor
	function Sucursal(){
		$this->cd_sucursal=0;
		$this->ds_nombre='';
		$this->ds_email='';
		$this->ds_domicilio='';
		$this->ds_telefono='';
		$this->oLocalidad=new Localidad();
		$this->ds_comentario='';
	}
	
	//Métodos Get 
	function getCd_sucursal() {
		return $this->cd_sucursal;
	}
	
	function getDs_nombre() {
		return $this->ds_nombre;
	}
	
	
	function getDs_localidad() {
		return $this->oLocalidad->getDs_localidad();
	}
	
	function getDs_provincia() {
		return $this->oLocalidad->getDs_provincia();
	}
	
	function getCd_provincia() {
		return $this->oLocalidad->getCd_provincia();
	}
	
	function getProvincia() {
		return $this->oLocalidad->getProvincia();
	}
	
	function getDs_pais() {
		return $this->oLocalidad->getProvincia()->getDs_pais();
	}
	
	function getCd_pais() {
		return $this->oLocalidad->getProvincia()->getCd_pais();
	}
	
	function getPais() {
		return $this->oLocalidad->getProvincia()->getPais();
	}
	
	function getCd_localidad() {
		return $this->oLocalidad->getCd_localidad();
	}

	function getLocalidad(){
		return $this->oLocalidad;
	}

	function getDs_email() {
		return $this->ds_email;
	}
	
	function getDs_domicilio() {
		return $this->ds_domicilio;
	}
	
	function getDs_telefono() {
		return $this->ds_telefono;
	}
	
	function getDs_comentario() {
		return $this->ds_comentario;
	}
	

	//Métodos Set

	function setCd_sucursal($value) {
		$this->cd_sucursal = $value;
	}
	
	function setDs_nombre($value) {
		$this->ds_nombre = $value;
	}
	
	function setDs_localidad($value) {
		$this->oLocalidad->setDs_localidad( $value );
	}

	function setCd_localidad($value) {
		$this->oLocalidad->setCd_localidad( $value );
	}
	
	function setLocalidad($value){
		$this->oLocalidad = $value;
	}
	
	function setDs_email($value) {
		$this->ds_email = $value;
	}

	function setDs_domicilio($value) {
		$this->ds_domicilio = $value;
	}

	function setDs_telefono($value) {
		$this->ds_telefono = $value;
	}

	function setDs_comentario($value) {
		$this->ds_comentario = $value;
	}
}