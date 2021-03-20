<?php

class FuncionQuery {
	
	static function insertFuncion(Funcion $obj) {
		$db = DbManager::getConnection(); 
		$cd_funcion = $obj->getCd_funcion ();
		$ds_funcion = $obj->getDs_funcion ();
		$sql = "INSERT INTO 'funcion' ('cd_funcion' ,'ds_funcion') VALUES ('$cd_funcion' ,'$ds_funcion') ";
		$result = $db->sql_query ( $sql );
		
		if(!$result)//hubo un error en la bbdd.
			throw new DBException();
	}
	
	static function listarFunciones(Array $funciones) {
		$db = DbManager::getConnection();
		$sql = "SELECT cd_funcion, ds_funcion FROM funcion ORDER BY ds_funcion";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException();

		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if (in_array ( ( int ) $usr ['cd_funcion'], $funciones )) {
					$res [$i] = array ('cd_funcion' => "'" . $usr ['cd_funcion'] . "'  checked", 'ds_funcion' => $usr ['ds_funcion'] );
				} else {
					$res [$i] = array ('cd_funcion' => "'".$usr ['cd_funcion']."'", 'ds_funcion' => $usr ['ds_funcion'] );
				}
				$i ++;
			}
		}
		$db->sql_freeresult($result);
		
		return $res;
	}
	
	static function getDs_funcion(Funcion $obj) {
		$db = Db::conectar ();
		$cd_funcion = $obj->getCd_funcion ();
		$sql = "SELECT ds_funcion FROM funcion WHERE cd_funcion = $cd_funcion";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException();

		if ($db->sql_numrows () > 0) {
			$usr = $db->sql_fetchassoc ( $result );
			$res = $usr ['ds_funcion'];
		}
		$db->sql_freeresult($result);
		return $res;
	}
	
	static function listarCheckFunciones() {
		$db = Db::conectar ();
		$sql = "SELECT cd_funcion, ds_funcion FROM funcion ORDER BY ds_funcion";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException();
					
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_funcion' => $usr ['cd_funcion'], 'ds_funcion' => $usr ['ds_funcion'] );
				$i ++;
			}
		}
		$db->sql_freeresult($result);
		return $res;
	}
	
	static function getFuncionesDePerfil(Perfil $obj) {
		$db = DbManager::getConnection();
		$cd_perfil = $obj->getCd_perfil ();
		$sql = "SELECT F.* FROM perfilfuncion PF"; 
		$sql .= " LEFT JOIN funcion F ON F.cd_funcion=PF.cd_funcion "; 
		$sql .= " WHERE PF.cd_perfil = $cd_perfil";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException();
		$funciones = ResultFactory::toCollection($db,$result,new FuncionFactory());	
		$db->sql_freeresult($result);		
		return ($funciones);
	}
	
	static function getFunciones() {
		$db = DbManager::getConnection();
		$sql = "SELECT * FROM funcion order by cd_funcion "; 
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException();
		$funciones = ResultFactory::toCollection($db,$result,new FuncionFactory());	
		$db->sql_freeresult($result);		
		return ($funciones);
	}
	
	static function getFuncionesDeUsuario(Usuario $obj) {
		$db = DbManager::getConnection();
		$cd_usuario = $obj->getCd_usuario ();
		$sql = "SELECT F.* FROM usuario U"; 
		$sql .= " LEFT JOIN perfilfuncion PF ON PF.cd_perfil=U.cd_perfil "; 
		$sql .= " LEFT JOIN funcion F ON F.cd_funcion=PF.cd_funcion ";
		$sql .= " WHERE U.cd_usuario = $cd_usuario";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException();
		$funciones = ResultFactory::toCollection($db,$result,new FuncionFactory());	
		$db->sql_freeresult($result);		
		return ($funciones);
	}	
}
?>