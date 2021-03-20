<?php
/**
 * Menú.
 * 
 * @author Lucrecia
 * @since 19-01-2011
 *
 */
class MenuKaizen extends Menu{

	
	//Método constructor 

	function MenuKaizen() {
		$this->oGrupos = new ItemCollection();
		
		$menuManager = new MenuManager();
		$this->oGrupos = $menuManager->getMenuGroups();			
	}
	
}

	