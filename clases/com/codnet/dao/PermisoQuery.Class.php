<?php
class PermisoQuery {
	
	static function permisosDeUsuario($cd_usuario, $nombreFuncion) {
		//$db = Db::conectar ();
		$db = DbManager::getConnection();
		
		$sql = "SELECT f.ds_funcion nombre FROM funcion f ";
		$sql .= " INNER JOIN perfilfuncion pf ON (f.cd_funcion = pf.cd_funcion)";
		$sql .= " INNER JOIN perfil p ON (p.cd_perfil = pf.cd_perfil)";
		$sql .= " INNER JOIN usuario u ON (u.cd_perfil = p.cd_perfil)";
		$sql .= " WHERE u.cd_usuario='$cd_usuario' AND UPPER(f.ds_funcion)='" . strtoupper($nombreFuncion)."'";
		$res = $db->sql_query ( $sql );
		if(!$res)//hubo un error en la bbdd.
			throw new DBException();
		$tiene =  $db->sql_numrows () > 0;
		$db->sql_freeresult($res);
		return $tiene;
	}
}
?>