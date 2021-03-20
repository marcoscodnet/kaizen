<?php

/**
 * @author Marcos
 * @since 16-05-2012
 *
 * VehiculoServicio.
 */
class Vehiculoservicio{

	private $cd_vehiculoservicio;
	
	private $nu_motor;
	
	private $nu_anio;

	private $ds_modelo;
	private $nu_chasis;	private $dt_venta;

	//Método constructor
	function Vehiculoservicio(){
		$this->cd_vehiculoservicio=0;
		
		$this->nu_motor='';
		$this->nu_chasis='';
		
		$this->nu_anio='';
		
		$this->ds_modelo='';				$this->dt_venta='';
		
	}

	//Métodos Get
	function getCd_vehiculoservicio() {
		return $this->cd_vehiculoservicio;
	}

	function getNu_motor() {
		return $this->nu_motor;
	}

	function getNu_chasis() {
		return $this->nu_chasis;
	}

	function getNu_anio() {
		return $this->nu_anio;
	}


	function getDs_modelo() {
		return $this->ds_modelo;
	}

	//Métodos Set

	function setCd_vehiculoservicio($value) {
		$this->cd_vehiculoservicio = $value;
	}

	function setNu_motor($value) {
		$this->nu_motor = $value;
	}

	function setNu_chasis($value) {
		$this->nu_chasis = $value;
	}

	
	function setNu_anio($value) {
		$this->nu_anio = $value;
	}

	function setDs_modelo($value) {
		$this->ds_modelo = $value;
	}

	public function getDt_venta()	{	    return $this->dt_venta;	}	public function setDt_venta($dt_venta)	{	    $this->dt_venta = $dt_venta;	}}