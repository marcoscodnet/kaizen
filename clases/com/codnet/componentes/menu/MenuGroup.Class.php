<?php
/**
 * Agrupa opciones de menú.
 * 
 * @author bernardo
 * @since 19-03-2010
 *
 */
class MenuGroup{

	private $cd_menugroup;
	private $ds_nombre;
	protected $oOpciones;
	private $width;
	
	private $ds_action;
	private $ds_cssclass;
	//Método constructor 
	

	function MenuGroup($nombre='',$w=0, $action='' ) {
		$this->ds_nombre = $nombre;
		$this->width=$w;
		$this->oOpciones = new ItemCollection();
		$this->ds_action = $action;
		$this->ds_cssclass='';
	}
	
	//Métodos Get 

	function getDs_cssclass() {
		return $this->ds_cssclass;
	}
	
	function getCd_menugroup() {
		return $this->cd_menugroup;
	}
	
	function getDs_nombre() {
		return $this->ds_nombre;
	}

	function getWidth() {
		return $this->width;
	}
	
	function getOpciones() {
		return $this->oOpciones;
	}
	
	function getDs_action() {
		return $this->ds_action;
	}
	
	//Métodos Set 
	
	function setDs_cssclass($value) {
		$this->ds_cssclass = $value;
	}
	
	function setCd_menugroup($value) {
		$this->cd_menugroup = $value;
	}
	
	function setDs_nombre($value) {
		$this->ds_nombre = $value;
	}

	function setWidth($value) {
		$this->width = $value;
	}
	
	function setOpciones(ItemCollection $items){
		$this->oOpciones = $items;
	}
	
	function setDs_action($value) {
		$this->ds_action = $value;
	}
	
	function addMenuOption($nombre, $href, $active=false){
		$this->oOpciones->addItem( new MenuOption($nombre, $href, $active) );
	}

	function addMenuSecureOption(Funcion $oFuncion, $nombre, $href, $active=false){
		$this->oOpciones->addItem( new MenuSecureOption( $oFuncion, $nombre, $href, $active ) );
	}
	

	
	function getMenuActivo(){
		$menuActivo = null;
		
		foreach($this->getOpciones() as $key => $opcion) {
			if ( $opcion->getBl_activo() ) {
				$menuActivo = $opcion;
				break;
			}				
		}
		
		return $menuActivo;
		
	}
	
	/**
	 * dada una lista de funciones, se determina si se tiene acceso o no
	 * al menuGroup.
	 * @param $funciones
	 */
	function tieneAcceso( ItemCollection $funciones ){
		$tiene = false;
		foreach($this->getOpciones() as $opcion) {
			$tiene = $opcion->tieneAcceso( $funciones );
			if ( $tiene ) 
				break;
		}				
		return $tiene;
	}
}

