<?php

class MenuQuery {
	
	static function getMenuGroups() {
		$db = DbManager::getConnection();
		$sql = "SELECT * FROM menugroup order by orden "; 
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException();
		$groups = ResultFactory::toCollection($db,$result,new MenuGroupFactory());	
		$db->sql_freeresult($result);		
		return ($groups);
	}
	
	static function getMenuOptions(MenuGroup $group){
		$db = DbManager::getConnection();
		$cd_menugroup = $group->getCd_menugroup();
		
		$sql   = " SELECT MO.*, ds_funcion FROM menuoption MO ";
		$sql .= " LEFT JOIN funcion F ON MO.cd_funcion=F.cd_funcion ";
		$sql .= " WHERE cd_menugroup=$cd_menugroup ORDER BY orden ";
		 
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException();
		$options = ResultFactory::toCollection($db,$result,new MenuOptionFactory());	
		$db->sql_freeresult($result);		
		return ($options);
	}
	
		
}
?>