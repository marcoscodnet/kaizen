<?php
/**
 * AcciÃ­on para eliminar de sesión un producto consumido utilizando Ajax.
 *
 * @author Lucrecia
 * @since 26-01-2011
 *
 */
class CargarDatosConyugeAction extends SecureAjaxAction{
	protected $path_html;
	protected $class;
	protected $required;
	/**
	 * se elimina de sesión el producto consumido seleccionado.
	 */
	public function executeImpl(){

		$respuesta = false;
		if (isset ( $_GET ['cd_estadocivil'] )){
			$estadocivil_id = $_GET ['cd_estadocivil'];
				
			if($estadocivil_id == CASADO || $estadocivil_id == CONCUBINO){
				$respuesta = true;
			}
		}
		$xtpl = new XTemplate ( APP_PATH. $this->path_html );
		if($respuesta){
			$xtpl->parse ( 'main.nombre_conyuge' );
		}
		$xtpl->assign ( 'WEB_PATH', WEB_PATH );
		$xtpl->parse ( 'main' );
		$texto = $xtpl->text('main');

		return $texto;
	}

	public function getFuncion(){
		return "Alta Cliente";
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