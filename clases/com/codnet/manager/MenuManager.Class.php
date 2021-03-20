<?php 

/**
 * 
 * @author bernardo
 * @since 24-06-2010
 * 
 * Manager para men�.
 *
 */
class MenuManager {


	/**
	 * se obtienen las opciones de men�.
	 * @return ItemCollection
	 */
	public function getMenuGroups(){
		
		//obtenemos los grupos.
		$groups = MenuQuery::getMenuGroups();
				
		//por cada grupo buscamos las opciones de men�.
		foreach ($groups as $oMenuGroup) {
			$oMenuGroup->setOpciones( MenuQuery::getMenuOptions($oMenuGroup) );
		}
		
		return $groups;
	}
	
}