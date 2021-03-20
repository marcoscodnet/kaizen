<?php
/**
 *
 * @author Lucrecia
 * @since 26-01-2011
 *
 */
class LlenarComboMarcaAction extends SecureAjaxAction{
	protected $path_html;
	protected $class;
	protected $required;
	/**
	 * se elimina de sesión el producto consumido seleccionado.
	 */
	public function executeImpl(){


		if (isset ( $_GET ['cd_tipounidad'] )){
			$tipounidad_id = $_GET ['cd_tipounidad'];
		}
		$manager = new MarcaManager();
		try{
			$productos = $manager->getMarcaDeTipounidad($tipounidad_id);
		}catch(GenericException $ex){
			$productos = new ItemCollection();
		}

		$xtpl = new XTemplate ( APP_PATH. $this->path_html );
		foreach($productos as $key => $entidad) {
			$this->parseEntidad($entidad, $xtpl );
		}

		$xtpl->assign ( $this->ds_labelTag, $this->ds_label );
		$xtpl->assign ( $this->ds_idTag, $this->ds_id );

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

	protected function parseEntidad ($entidad, $xtpl){
		$xtpl->assign ( 'ds_marca', htmlentities( $entidad->getDs_marca()));
		$xtpl->assign ( 'cd_marca', htmlentities( $entidad->getCd_marca()));
		$xtpl->assign ( 'option', 'option' );
		$xtpl->assign ( 'tag', 'value' );
		$xtpl->assign ( 'style', '' );
		$xtpl->parse ( 'main.option' );
	}

	public function getFuncion(){
		return "Listar Producto";
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
	public function getOnchange(){
		return $this->onchange;
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