<?php
header("Content-type: text/javascript; charset=iso-8859-1");
/**
 * AcciÃ­on para consultar si existe determinado cliente en la BD.
 *
 * @author Lucrecia
 * @since 26-01-2011
 *
 */
class AjaxDatosClienteAction extends SecureAjaxAction{
	protected $path_html;
	protected $class;
	protected $required;
	/**
	 * se elimina de sesión el producto consumido seleccionado.
	 */
	public function executeImpl(){

		if (isset ( $_GET ['cd_cliente'] )){
			$cd_cliente = $_GET ['cd_cliente'];
		}
		$manager = new ClienteManager();
		try{
			$oCliente = $manager->getClientePorId($cd_cliente);
		}catch(GenericException $ex){
			$oCliente = new ItemCollection();
		}

		$xtpl = new XTemplate ( APP_PATH. $this->path_html );
		$this->parseCliente($xtpl, $oCliente);


		//seteamos la función de "onchange" en caso de que se haya indicado una.
		if(!empty($this->onchange)){
			$xtpl->assign( 'onchange', "javascript:".$this->onchange . ";");
		}

		if(!empty($this->class)){
			$xtpl->assign( 'class', "$this->class");
		}

		if($this->required){
			$xtpl->assign( 'required', "(*)");
		}
		$xtpl->assign ( 'WEB_PATH', WEB_PATH );
		$xtpl->parse ( 'main' );
		$texto = $xtpl->text('main');

		return $texto;
	}

	protected function parseCliente($xtpl, Cliente $oCliente){
		$xtpl->assign( 'ds_apynom', $oCliente->getDs_apynom());
		$xtpl->assign( 'ds_direccion', $oCliente->getDs_dircalle()." ".$oCliente->getDs_dirnro()." ".$oCliente->getDs_dirdepto()." ".$oCliente->getDs_dirpiso());		$xtpl->assign( 'ds_telefono', $oCliente->getDs_teparticular());
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