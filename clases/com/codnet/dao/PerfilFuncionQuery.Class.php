<?php
class PerfilFuncionQuery {
	
	function insertPerfilfuncion(Perfilfuncion $obj) {
		$db = DbManager::getConnection();
		$cd_perfil = $obj->getCd_perfil ();
		$cd_funcion = $obj->getCd_funcion ();
		$sql = "INSERT INTO 'perfilfuncion' ('cd_perfil' ,'cd_funcion') VALUES ('$cd_perfil' ,'$cd_funcion') ";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException();
	}
	
	function getFuncionesDePerfil(Perfilfuncion $obj) {
		$db = DbManager::getConnection();
		$cd_perfil = $obj->getCd_perfil ();
		$sql = "SELECT F.* FROM perfilfuncion PF"; 
		$sql = " LEFT JOIN funcion F ON F.cd_funcion=PF.cd_funcion "; 
		$sql .= " WHERE PF.cd_perfil = $cd_perfil";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException();
		$funciones = ResultFactory::toCollection($db,$result,new FuncionFactory());	
		$db->sql_freeresult($result);		
		return ($funciones);
	}
	
	function modificarFuncionesDePerfil(Perfil $obj, Array $perfilFunciones) {
		//me conecto a la BD
		$db = DbManager::getConnection();
		//Borro todas las filas de ese perfil
		$cd_perfil = $obj->getCd_perfil ();
		$sql = "DELETE  FROM perfilfuncion WHERE cd_perfil = $cd_perfil";
		$exito = $db->sql_query ( $sql );
		if(!$exito)//hubo un error en la bbdd.
			throw new DBException();
		else {
			$i = 0;
			$limit = count ( $perfilFunciones );
			while ( $i < $limit ) {
				$pf = $perfilFunciones [$i];
				$cd_perfil = $pf->getCd_perfil ();
				$cd_funcion = $pf->getCd_funcion ();
				$sql = "INSERT INTO perfilfuncion (cd_perfil, cd_funcion) VALUES($cd_perfil, $cd_funcion)";
				$exitoPF = $db->sql_query ( $sql );
				
				if (! $exitoPF) {
					throw new DBException();
				}
				$i ++;
			}
		}
		
		$db->sql_freeresult($result);
	}
	
	function insertarFuncionesDePerfil(Perfil $obj, Array $perfilFunciones) {
		//me conecto a la BD
		$db = DbManager::getConnection();
		$i = 0;
		$limit = count ( $perfilFunciones );
		while ( $i < $limit ) {
			$pf = $perfilFunciones [$i];
			$cd_perfil = $obj->getCd_perfil();
			$cd_funcion = $pf->getCd_funcion ();
			$sql = "INSERT INTO perfilfuncion (cd_perfil, cd_funcion) VALUES($cd_perfil, $cd_funcion)";
			$exitoPF = $db->sql_query ( $sql );
			if (! $exitoPF) {
				throw new DBException();
			}
			$i ++;
		}
		$db->sql_freeresult($result);
		return true;
	}

	function tienePerfilFuncionesAsignadas (Perfilfuncion $obj) {
		$db = DbManager::getConnection();
		$cd_perfil = $obj->getCd_perfil();
		$sql = "Select count(*) as count FROM perfilfuncion WHERE cd_perfil ='$cd_perfil'";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException();
		$next = $db->sql_fetchassoc ( $result );		 
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return ($cant > 0);
	}
}
?>