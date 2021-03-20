<?php 

/**
 * 
 * @author bernardo
 * @since 24-06-2010
 * 
 * Manager para menú.
 *
 */
class MenuManager {


	/**
	 * se obtienen las opciones de menú.
	 * @return ItemCollection
	 */
	public function getMenuGroups(){
		
		//obtenemos los grupos.
		$groups = MenuQuery::getMenuGroups();
				
		//por cada grupo buscamos las opciones de menú.
		foreach ($groups as $oMenuGroup) {
			$oMenuGroup->setOpciones( MenuQuery::getMenuOptions($oMenuGroup) );
		}
		
		return $groups;
	}
	
}