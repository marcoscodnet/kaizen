<?php

/**
 * @author Lucrecia
 * @since 18-01-2011
 *
 * Cliente.
 */
class Producto{
	private $cd_producto;
	private $ds_producto;
	private $oTipounidad;
	private $oMarca;
	private $oModelo;
	private $oColor;
	private $nu_monto_sugerido;
	private $nu_stock_minimo;
	private $nu_stock_actual;	private $bl_discontinuo;

	//Método constructor
	function Producto(){
		$this->cd_producto = 0;
		$this->ds_producto = 0;
		$this->oTipounidad = new Tipounidad();
		$this->oMarca = new Marca();
		$this->oModelo = new Modelo();
		$this->oColor = new Color();
		$this->nu_monto_sugerido = 0;
		$this->nu_stock_minimo = 0;
		$this->nu_stock_actual = 0;				$this->bl_discontinuo=0;
	}

	//Métodos Get
	function getCd_producto() {
		return $this->cd_producto;
	}

	function getDs_producto() {
		if($this->ds_producto =="")
		return $this->getDs_tipounidad()." ".$this->getDs_marca()." ".$this->getDs_modelo()." ".$this->getDs_color();
		else
		return $this->ds_producto;
	}

	function getTipounidad() {
		return $this->oTipounidad;
	}

	function getDs_tipounidad() {
		return $this->getTipounidad ()->getDs_tipounidad();
	}

	function getCd_tipounidad() {
		return $this->getTipounidad ()->getCd_tipounidad();
	}

	function getMarca() {
		return $this->oMarca;
	}

	function getDs_marca() {
		return $this->getMarca ()->getDs_marca();
	}

	function getCd_marca() {
		return $this->getMarca ()->getCd_marca();
	}

	function getModelo() {
		return $this->oModelo;
	}

	function getDs_modelo() {
		return $this->getModelo ()->getDs_modelo();
	}

	function getCd_modelo() {
		return $this->getModelo ()->getCd_modelo();
	}

	function getColor() {
		return $this->oColor;
	}

	function getDs_color() {
		return $this->getColor ()->getDs_color();
	}

	function getCd_color() {
		return $this->getColor ()->getCd_color();
	}

	function getNu_monto_sugerido() {
		return $this->nu_monto_sugerido;
	}
	function getNu_stock_minimo() {
		return $this->nu_stock_minimo;
	}
	function getNu_stock_actual() {
		return $this->nu_stock_actual;
	}

	//Metodos set

	function setCd_producto($value) {
		$this->cd_producto = $value;
	}

	function setDs_producto($value) {
		$this->ds_producto = $value;
	}

	function setTipounidad($value) {
		$this->oTipounidad = $value;
	}

	function setDs_tipounidad($value) {
		$this->getTipounidad ()->setDs_tipounidad($value);
	}

	function setCd_tipounidad($value) {
		$this->getTipounidad ()->setCd_tipounidad($value);
	}

	function setMarca($value) {
		$this->oMarca = $value;
	}

	function setDs_marca($value) {
		$this->getMarca ()->setDs_marca($value);
	}

	function setCd_marca($value) {
		$this->getMarca()->setCd_marca($value);
	}

	function setModelo($value) {
		$this->oModelo = $value;
	}

	function setDs_modelo($value) {
		$this->getModelo ()->setDs_modelo($value);
	}

	function setCd_modelo($value) {
		$this->getModelo ()->setCd_modelo($value);
	}

	function setColor($value) {
		$this->oColor = $value;
	}

	function setDs_color($value) {
		$this->getColor ()->setDs_color($value);
	}

	function setCd_color($value) {
		$this->getColor ()->setCd_color($value);
	}

	function setNu_monto_sugerido($value) {
		$this->nu_monto_sugerido = $value;
	}
	function setNu_stock_minimo($value) {
		$this->nu_stock_minimo = $value;
	}
	function setNu_stock_actual($value) {
		$this->nu_stock_actual = $value;
	}
	public function getBl_discontinuo()	{	    return $this->bl_discontinuo;	}	public function setBl_discontinuo($bl_discontinuo)	{	    $this->bl_discontinuo = $bl_discontinuo;	}}