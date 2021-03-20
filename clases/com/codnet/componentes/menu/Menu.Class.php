<?php
/**
 * Menú.
 * 
 * @author bernardo
 * @since 19-03-2010
 *
 */
class Menu{

	protected $oGrupos;
	
	//Método constructor 
	

	function Menu() {
		$this->oGrupos = new ItemCollection();
	}
	
	//Métodos Get 

	
	function getGrupos() {
		return $this->oGrupos;
	}
	
	//Métodos Set 
	

	function addMenuGroup(MenuGroup $group){
		$this->oGrupos->addItem($group);
	}
	
	
	function getMenuActivo(){
		$menuActivo = null;
		foreach($this->getGrupos() as $key => $grupo) {
			$menuActivo = $grupo->getMenuActivo();
			if($menuActivo!=null)
				break;
		}
		
		return $menuActivo;
		
	}
	
	
	function addMenuGroupAcceso($x, $labelGroup='Acceso', $labelMenuUsuarios='Usuarios', $labelMenuPerfiles='Perfiles', $labelMenuCambiarClave='Cambiar Clave'){
		$menuGroup = new MenuGroup($labelGroup, $x);
		$menuGroup->addMenuOption( $labelMenuUsuarios, WEB_PATH.'usuarios/doAction?action=listar_usuarios', ($ds_menuActivo==$labelMenuUsuarios) ) ;
		$menuGroup->addMenuOption( $labelMenuPerfiles, WEB_PATH.'perfiles/doAction?action=listar_perfiles', ($ds_menuActivo==$labelMenuPerfiles) );
		$menuGroup->addMenuOption( $labelMenuCambiarClave, WEB_PATH.'usuarios/doAction?action=cambiar_clave_init', ($ds_menuActivo==$labelMenuCambiarClave) );
		$this->addMenuGroup($menuGroup);
	}

	function addMenuGroupSalir($x, $labelGroup='Salir', $labelMenuSalir='Cerrar Sesi&oacute;n'){
		$menuGroup = new MenuGroup($labelGroup,$x);
		$menuGroup->addMenuOption( $labelMenuSalir, WEB_PATH.'doAction?action=salir' );
		$this->addMenuGroup($menuGroup);
	}
	
	function getMenuGroupPorId( $id ){

		foreach ($this->getGrupos() as $menuGroup) {
			
			if( $menuGroup->getCd_menugroup() == $id )
				return $menuGroup;
			 
		}
		return null;
	}
	
	function getMenuOptionsPorId( $menuoptionsId ){
		$opciones=array();
		foreach ($menuoptionsId as $id) {
			
			foreach ($this->getGrupos() as $menuGroup) {
				
				foreach ($menuGroup->getOpciones() as $option) {
				
					if( $option->getCd_menuoption() == $id )
						$opciones[] = $option;
					
				}
			}	
		}
		
		return $opciones;
	}
}

	