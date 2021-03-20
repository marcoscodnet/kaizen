<?php
/**
 * Acción para cargar objetos en un combo
 * utilizando Ajax.
 * 
 * @author bernardo
 * @since 17-03-2010
 *
 */
abstract class CargarEntidadesAction extends SecureAjaxAction{

	protected $path_html;	
	protected $ds_id;	
	protected $ds_label;	
	protected $ds_parentId;	
	protected $ds_descTag;	
	protected $ds_codeTag;	
	protected $ds_idTag;	
	protected $ds_labelTag;	
	protected $onchange;	
	protected $class;
	protected $required;
	
	/**
	 * se cargan localidades en un combo.
	 */
	public function executeImpl(){

		if (isset ( $_GET [$this->ds_parentId] ))
			$parent = $_GET [$this->ds_parentId]; 
		else
			$parent = 0;
				
		try{
			$entidades = $this->getEntidades($parent);
		}catch(GenericException $ex){
			$entidades = new ItemCollection();
		}
			
		$xtpl = new XTemplate ( APP_PATH. $this->path_html );
		
		foreach($entidades as $key => $entidad) {
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
		$xtpl->assign ( $this->ds_descTag, htmlentities( $this->getDesc($entidad) ) );
		$xtpl->assign ( $this->ds_codeTag, htmlentities( $this->getCode($entidad) ) );				
		$xtpl->assign ( 'option', 'option' );				
		$xtpl->assign ( 'tag', 'value' );
		$xtpl->assign ( 'style', '' );				
		$xtpl->parse ( 'main.option' );
	}
	
	/**
	 * obtiene entidades relacionadas con parent.
	 * @param unknown_type $parent
	 * @return ItemCollection
	 */
	public abstract function getEntidades($parent);
	
	/**
	 * obtiene el código de la entidad
	 * @param unknown_type $entidad
	 * @return unknown_type
	 */
	public abstract function getCode($entidad);
	
	/**
	 * otiene la descripción de la entidad 
	 * @param unknown_type $entidad
	 * @return unknown_type
	 */
	public abstract function getDesc($entidad);

	public function setPath_html($value){
		$this->path_html = $value;
	}

	/*
	 * label a mostrar en el combo.
	 */
	public function setDs_label($value){
		$this->ds_label = $value;
	}
	
	/*
	 * id con el cual luego se recupera el valor seleccionado.
	 */
	public function setDs_Id($value){
		$this->ds_id = $value;
	}
	
	/*
	 * id con el cual se recupera el parent.
	 */
	public function setDs_parentId($value){
		$this->ds_parentId = $value;
	}
	
	/*
	 * tag para parsear la descripción con xtemplate.
	 */
	public function setDs_descTag($value){
		$this->ds_descTag = $value;
	}
	
	
	/*
	 * tag para parsear el código con xtemplate.
	 */
	public function setDs_codeTag($value){
		$this->ds_codeTag = $value;
	}
	
	
	/*
	 * tag para parsear el id del select con xtemplate.
	 */
	public function setDs_idTag($value){
		$this->ds_idTag = $value;
	}
	/*
	 * tag para parsear el label del select con xtemplate.
	 */
	public function setDs_labelTag($value){
		$this->ds_labelTag = $value;
	}

	/*
	 * tag para parsear la descripción con xtemplate.
	 */
	public function getDs_descTag(){
		return $this->ds_descTag ;
	}
	
	
	/*
	 * tag para parsear el código con xtemplate.
	 */
	public function getDs_codeTag(){
		return $this->ds_codeTag;
	}

	/*
	 * value para el onchange del combo.
	 */
	public function getOnchange(){
		return $this->onchange ;
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