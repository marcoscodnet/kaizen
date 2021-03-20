<?php
/**
 * Acciíon para consultar si existe determinado cliente en la BD.
 *
 * @author Lucrecia
 * @since 26-01-2011
 *
 */
class AjaxValidarAutorizacionAction extends SecureAjaxAction{
	protected $path_html;
	protected $class;
	protected $required;
	/**
	 * se elimina de sesi�n el producto consumido seleccionado.
	 */
	public function executeImpl(){

		$texto = "";
		if (isset ( $_GET ['cd_unidad'] )){
			$cd_unidad = $_GET ['cd_unidad'];
		}

		if (isset ( $_GET ['cd_unidad'] )){
			$cd_unidad = $_GET ['cd_unidad'];
		}
		if(isset($_GET ['nu_doc'])&&(isset($_GET ['cd_tipodoc']))){
			$clienteManager = new ClienteManager();
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('C.cd_tipodoc', $tipodoc_id, "=");
			$criterio->addFiltro('nu_doc', $nu_doc, "=");
			$oCliente = $clienteManager->getCliente($criterio);
			$texto = $oCliente->getCd_cliente();
		}
		return $texto;
	}

	public function getFuncion(){
		return "Alta Venta";
	}

	public function getPath_html(){
		return $this->path_html;
	}

	public function getClass(){
		return $this->class ;
	}

	public function getRequired(){
		return $this->required ;
	}


	/*
	 * setea el value para onchange del combo.
	 */

	public function setPath_html($value){
		$this->path_html = $value;
	}

	public function setOnchange($value){
		$this->onchange = $value;
	}

	public function setClass($value){
		$this->class = $value;
	}

	public function setRequired($value){
		$this->required = $value;
	}
}