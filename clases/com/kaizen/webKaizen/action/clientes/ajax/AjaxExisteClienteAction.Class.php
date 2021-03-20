<?php
/**
 * AcciÃ­on para consultar si existe determinado cliente en la BD.
 *
 * @author Lucrecia
 * @since 26-01-2011
 *
 */
class AjaxExisteClienteAction extends SecureAjaxAction{
	protected $path_html;
	protected $class;
	protected $required;
	protected $funcion ="";
	/**
	 * se elimina de sesión el producto consumido seleccionado.
	 */
	public function executeImpl(){

		$texto = "";
		if (isset ( $_GET ['cd_tipodoc'] )){
			$tipodoc_id = $_GET ['cd_tipodoc'];
		}

		if (isset ( $_GET ['nu_doc'] )){
			$nu_doc = $_GET ['nu_doc'];
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
		if($this->funcion ==""){
			return "Alta Cliente";
		}else{
			return $this->funcion;
		}
	}

	public function setFuncion($value){
		return $this->funcion = $value;
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