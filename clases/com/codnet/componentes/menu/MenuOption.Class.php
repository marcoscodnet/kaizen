<?php
/**
 * Opción de menú.
 * 
 * @author bernardo
 * @since 19-03-2010
 *
 */
class MenuOption{
	
	private $cd_menuoption;
	private $ds_nombre;
	private $ds_href;
	private $bl_activo;
	private $ds_cssclass;
	private $ds_descripcionpanel;
	
	//Método constructor 
	
	function MenuOption($nombre='', $href='#', $activo=false) {
		$this->ds_nombre =$nombre;
		$this->ds_href = $href;
		$this->bl_activo = $activo;
	}
	
	//Métodos Get 
	
	function getCd_menuoption() {
		return $this->cd_menuoption;
	}
	
	function getDs_nombre() {
		return $this->ds_nombre;
	}
	
	function getDs_href() {
		return $this->ds_href;
	}
	
	function getBl_activo() {
		return $this->bl_activo;
	}
	
	function getDs_cssclass() {
		return $this->ds_cssclass;
	}
	
	function getDs_descripcionpanel() {
		return $this->ds_descripcionpanel;
	}
	
	//Métodos Set 
	
	function setDs_descripcionpanel($value) {
		$this->ds_descripcionpanel = $value;
	}
	
	function setCd_menuoption($value) {
		$this->cd_menuoption = $value;
	}
	function setDs_nombre($value) {
		$this->ds_nombre = $value;
	}

	function setDs_href($value) {
		$this->ds_href = $value;
	}

	function setBl_activo($value) {
		$this->bl_activo = $value;
	}
	
	function setDs_cssclass($value) {
		$this->ds_cssclass = $value;
	}
	
	/**
	 * dada una lista de funciones, se determina si se tiene acceso o no
	 * a la opción de menú.
	 * @param $funciones
	 */
	function tieneAcceso( ItemCollection $funciones ){
		return true;
	}

}

