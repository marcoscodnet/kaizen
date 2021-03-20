<?php

class PerfilQuery {
	
	static function insertarPerfil(Perfil $obj) {
		$db = DbManager::getConnection();
		$ds_perfil = $obj->getDs_perfil ();
		$sql = "INSERT INTO perfil (ds_perfil) VALUES ('$ds_perfil') ";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException();
		$id = PerfilQuery::insert_id ( $db );
		$obj->setCd_perfil ( $id );
	}
	
	static function insert_id($db) {
		$db = DbManager::getConnection();
		$sql = "SELECT MAX(`cd_perfil`) as id FROM perfil ";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException();
		$next = $db->sql_fetchassoc ( $result );		 
		$id = $next['id'];
		$db->sql_freeresult($result);
		return ($id );
	}
	
	static function listar($cd_perfil = "") {
		$db = DbManager::getConnection();
		$sql = "SELECT cd_perfil, ds_perfil FROM perfil";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException();
		
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_perfil'] == $cd_perfil) {
					$res [$i] = array ('cd_perfil' => "'" . $usr ['cd_perfil'] . "' selected='selected'", 'ds_perfil' => $usr ['ds_perfil'] );
				} else {
					$res [$i] = array ('cd_perfil' => $usr ['cd_perfil'], 'ds_perfil' => $usr ['ds_perfil'] );
				}
				$i ++;
			}
		}
		$db->sql_freeresult($result);
		
		return $res;
	}
	
	static function getPerfilPorId(Perfil $obj) {
		$db = DbManager::getConnection();
		$cd_perfil = $obj->getCd_perfil ();
		$sql = "SELECT * FROM perfil WHERE cd_perfil = $cd_perfil";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException();
					
		if ($db->sql_numrows () > 0) {
			$temp = $db->sql_fetchassoc ( $result );
			$factory = new PerfilFactory();
			$obj = $factory->build($temp);
			
		}
		$db->sql_freeresult($result);
		return ($obj);
	}
	
	static function getPerfiles(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		
		$sql = "SELECT cd_perfil, ds_perfil FROM perfil ";

		$sql .= $criterio->buildFiltro();			
				
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException();
		
		$perfiles = ResultFactory::toCollection($db,$result,new PerfilFactory());	
		$db->sql_freeresult($result);		
		return ($perfiles);
	}
	
	static function getCountPerfiles( CriterioBusqueda $criterio ) {
		$db = DbManager::getConnection();
		$sql = "SELECT count(*) as count FROM perfil P";
		$sql .= $criterio->buildFiltroSinPaginar();
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException();

		$next = $db->sql_fetchassoc ( $result );		 
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return (( int ) $cant);
	}
	
	static function modificarPerfil(Perfil $obj) {
		$db = DbManager::getConnection();
		$cd_perfil = $obj->getCd_perfil ();
		$ds_perfil = $obj->getDs_perfil ();
		$sql = "UPDATE perfil SET ds_perfil='$ds_perfil'";
		$sql .= " WHERE cd_perfil = $cd_perfil";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException();
		
	}
	
	static function eliminarPerfil(Perfil $obj) {
		$db = DbManager::getConnection();
		$cd_perfil = $obj->getCd_perfil ();
		$sql = "DELETE FROM perfil WHERE cd_perfil = $cd_perfil";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException();
		
	}
}
?>