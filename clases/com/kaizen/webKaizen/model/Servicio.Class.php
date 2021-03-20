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
	private $ds_obsgral;	private $ds_diagyreprealizada;	private $ds_repuestosusados;	private $ds_mecanicos;	private $ds_instmedusados;	private $ds_tiempomanoobra;	private $dt_compromisoentrega;	private $nu_monto;	private $bl_pagado;
	private $oSucursal;

	//Método constructor
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
		$this->ds_obsgral = "";				$this->ds_diagyreprealizada = "";		$this->ds_repuestosusados = "";		$this->ds_mecanicos = "";		$this->ds_instmedusados = "";		$this->ds_tiempomanoobra = "";		$this->dt_compromisoentrega = "";		$this->nu_monto=0;		$this->bl_pagado=0;		$this->oSucursal= new Sucursal();
	}

	//Métodos Get
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
	function getSucursal() {		return $this->oSucursal;	}	function getCd_sucursal() {		return $this->getSucursal()->getCd_sucursal();	}	function getDs_nombre() {		return $this->getSucursal()->getDs_nombre();	}
	

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
	}		function getNu_anio() {		return $this->getVehiculoservicio()->getNu_anio();	}		function getNu_chasis() {		return $this->getVehiculoservicio()->getNu_chasis();	}

	function getCd_tiposervicio() {
		return $this->getTiposervicio()->getCd_tiposervicio();
	}		function getDs_tiposervicio() {		return $this->getTiposervicio()->getDs_tiposervicio();	}
	public function getDs_diagyreprealizada()	{	    return $this->ds_diagyreprealizada;	}		public function getDs_repuestosusados()	{	    return $this->ds_repuestosusados;	}		public function getDs_mecanicos()	{	    return $this->ds_mecanicos;	}		public function getDs_instmedusados()	{	    return $this->ds_instmedusados;	}		public function getDs_tiempomanoobra()	{	    return $this->ds_tiempomanoobra;	}		public function getDt_compromisoentrega()	{	    return $this->dt_compromisoentrega;	}		public function getNu_monto()	{	    return $this->nu_monto;	}

	//Métodos Set

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
	function setSucursal($value) {		$this->oSucursal = $value;	}	function setCd_sucursal($value) {		$this->getSucursal()->setCd_sucursal($value);	}	function setDs_nombre($value) {		$this->getSucursal()->setDs_nombre($value);	}
	

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

		public function setDs_diagyreprealizada($ds_diagyreprealizada)	{	    $this->ds_diagyreprealizada = $ds_diagyreprealizada;	}		public function setDs_repuestosusados($ds_repuestosusados)	{	    $this->ds_repuestosusados = $ds_repuestosusados;	}		public function setDs_mecanicos($ds_mecanicos)	{	    $this->ds_mecanicos = $ds_mecanicos;	}		public function setDs_instmedusados($ds_instmedusados)	{	    $this->ds_instmedusados = $ds_instmedusados;	}		public function setDs_tiempomanoobra($ds_tiempomanoobra)	{	    $this->ds_tiempomanoobra = $ds_tiempomanoobra;	}		public function setDt_compromisoentrega($dt_compromisoentrega)	{	    $this->dt_compromisoentrega = $dt_compromisoentrega;	}		public function setNu_monto($nu_monto)	{	    $this->nu_monto = $nu_monto;	}	public function getBl_pagado()	{	    return $this->bl_pagado;	}	public function setBl_pagado($bl_pagado)	{	    $this->bl_pagado = $bl_pagado;	}}