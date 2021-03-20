<?php

/**
 * @author Marcos
 * @since 16-05-2012
 *
 * Servicio.
 */
class Servicio{

	private $cd_servicio;
	private $oCliente;
	private $ds_kmshoras;
	private $oUsuario;
	private $dt_carga;
	private $oTiposervicio;
	private $oVehiculoservicio;
	private $ds_descpedidocte;
	private $dt_ingresovehiculo;
	private $ds_obsgral;
	private $oSucursal;

	//M�todo constructor
	function Servicio(){
		$this->cd_servicio=0;
		$this->oCliente=new Cliente();
		$this->ds_kmshoras=0;
		$this->oUsuario =new Usuario();
		$this->dt_carga='';
		$this->oTiposervicio=new Tiposervicio();
		$this->oVehiculoservicio=new Vehiculoservicio();
		$this->ds_descpedidocte = 0;
		$this->dt_ingresovehiculo = NULL;
		$this->ds_obsgral = "";
	}

	//M�todos Get
	function getCd_servicio() {
		return $this->cd_servicio;
	}

	function getDs_kmshoras() {
		return $this->ds_kmshoras;
	}

	function getDt_ingresovehiculo() {
		return $this->dt_ingresovehiculo;
	}

	function getDt_carga() {
		return $this->dt_carga;
	}

	function getDs_obsgral() {
		return $this->ds_obsgral;
	}

	function getDs_descpedidocte() {
		return $this->ds_descpedidocte;
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
	function getTiposervicio() {
		return $this->oTiposervicio;
	}

	function getVehiculoservicio() {
		return $this->oVehiculoservicio;
	}

	function getCd_vehiculoservicio() {
		return $this->getVehiculoservicio()->getCd_vehiculoservicio();
	}

	function getNu_motor() {
		return $this->getVehiculoservicio()->getNu_motor();
	}

	function getDs_modelo() {
		return $this->getVehiculoservicio()->getDs_modelo();
	}

	function getCd_tiposervicio() {
		return $this->getTiposervicio()->getCd_tiposervicio();
	}
	public function getDs_diagyreprealizada()

	//M�todos Set

	function setCd_servicio($value) {
		$this->cd_servicio = $value;
	}

	function setDs_kmshoras($value) {
		$this->ds_kmshoras = $value;
	}

	function setDs_obsgral($value) {
		$this->ds_obsgral = $value;
	}

	function setDt_carga($value) {
		$this->dt_carga = $value;
	}

	function setDs_descpedidocte($value) {
		$this->ds_descpedidocte = $value;
	}

	function setDt_ingresovehiculo($value) {
		$this->dt_ingresovehiculo = $value;
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
	

	function setTiposervicio($value) {
		$this->oTiposervicio = $value;
	}
	function setCd_tiposervicio($value) {
		$this->getTiposervicio()->setCd_tiposervicio($value);
	}

	function setVehiculoservicio($value) {
		$this->oVehiculoservicio = $value;
	}
	function setCd_vehiculoservicio($value) {
		$this->getVehiculoservicio()->setCd_vehiculoservicio($value);
	}

