<?php
class UsuarioQuery {
	
	static function existe(Usuario $user) {
		$db = DbManager::getConnection();
		$ds_nomusuario = $user->getDs_nomusuario ();
		$ds_password = MD5 ( $user->getDs_password () );
		$sql = "Select count(*) as count FROM usuario WHERE ds_nomusuario ='$ds_nomusuario' AND ds_password = '$ds_password'";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
		
		$next = $db->sql_fetchassoc ( $result );
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return ($cant > 0);
	}

	static function getUsuarioConPerfilPorNombreYPass(Usuario $user) {
		$db = DbManager::getConnection();
		$ds_nomusuario = $user->getDs_nomusuario ();
		$ds_password = MD5 ( $user->getDs_password () );
		$sql = "SELECT U.cd_usuario, U.ds_nomusuario, U.cd_perfil, U.ds_apynom, U.ds_mail, U.ds_password, P.ds_perfil FROM usuario U";
		$sql .= " LEFT JOIN perfil P ON(P.cd_perfil=U.cd_perfil)  ";
		$sql .= " WHERE ds_nomusuario ='$ds_nomusuario' AND ds_password = '$ds_password'";
		
		$result = $db->sql_query ( $sql );
	
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
		
		if ($db->sql_numrows () > 0) {
			$temp = $db->sql_fetchassoc ( $result );
			$factory = new UsuarioFactory();
			$obj = $factory->build($temp);
		}else{
			throw new UsuarioNoValidoException();
		}
		
		$db->sql_freeresult($result);
		return ($obj);
	}
	
	//TODO
	static function getPerfil(Usuario $user, $db) {
		$db = DbManager::getConnection();
		$ds_nomusuario = $user->getDs_nomusuario ();
		$sql = "Select cd_perfil, cd_usuario FROM usuario WHERE ds_nomusuario ='$ds_nomusuario'";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
		
		$usuario = $db->sql_fetchassoc ( $result );
		$cd_perfil = $usuario ['cd_perfil'];
		$cd_usuario = $usuario ['cd_usuario'];
		$user->setCd_perfil ( $cd_perfil );
		$user->setCd_usuario ( $cd_usuario );
		$db->sql_freeresult($result);
	}
	
	static function insertUsuario(Usuario $obj) {
		$db = DbManager::getConnection();
		$ds_nomusuario = $obj->getDs_nomusuario ();
		if (! UsuarioQuery::existeNombreUsuario ( $obj, $db )) {
			$ds_password = MD5 ( $obj->getDs_password () );
			$cd_perfil = $obj->getCd_perfil ();
			$ds_mail = $obj->getDs_mail ();
			$ds_apynom = $obj->getDs_apynom ();
			$sql = "INSERT INTO usuario (ds_nomusuario ,ds_password ,cd_perfil, ds_apynom, ds_mail) VALUES ('$ds_nomusuario' ,'$ds_password' ,'$cd_perfil', '$ds_apynom', '$ds_mail') ";
			$result = $db->sql_query ( $sql );
			if(!$result)//hubo un error en la bbdd.
				throw new DBException($db->sql_error());
			
		} else {
			throw new UsuarioNoValidoException();
			
		}
		
		$db->sql_freeresult($res);
	}
	
	static function getUsuariosConPerfil(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT U.cd_usuario, U.ds_nomusuario, P.cd_perfil, P.ds_perfil, U.ds_apynom, U.ds_mail FROM usuario U";
		$sql .= " LEFT JOIN perfil P ON(P.cd_perfil=U.cd_perfil) ";
		$sql .= $criterio->buildFiltro();
		
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
		$usuarios= ResultFactory::toCollection($db,$result,new UsuarioFactory());	
		$db->sql_freeresult($res);
		return ($usuarios);
	}
	
	static function getCantUsuarios( CriterioBusqueda $criterio ) {
		$db = DbManager::getConnection();
		$sql = "SELECT count(*) as count FROM usuario U";
		$sql .= $criterio->buildFiltroSinPaginar();
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
		
		$next = $db->sql_fetchassoc ( $result );		 
		$cant = $next['count'];
		$db->sql_freeresult($res);
			
		return (( int ) $cant);
	}
	
	static function eliminarUsuario(Usuario $obj) {
		$db = DbManager::getConnection();
		$cd_usuario = $obj->getCd_usuario ();
		$sql = "DELETE FROM usuario WHERE cd_usuario = $cd_usuario";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
		
	}
	
	static function getUsuarioPorId(Usuario $obj) {
		$db = DbManager::getConnection();
		$cd_usuario = $obj->getCd_usuario ();
		$sql = "SELECT U.ds_nomusuario, U.cd_perfil, U.cd_usuario, U.ds_apynom, U.ds_mail, U.ds_password FROM usuario U";
		$sql .= " WHERE U.cd_usuario = $cd_usuario";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
		
		if ($db->sql_numrows () > 0) {
			$temp = $db->sql_fetchassoc ( $result );
			$factory = new UsuarioFactory();
			$obj = $factory->build($temp);
			
		}
		$db->sql_freeresult($result);
		return ($obj);
	}
	
	static function getUsuarioConPerfilPorId(Usuario $obj) {
		$db = DbManager::getConnection();
		$cd_usuario = $obj->getCd_usuario ();
		$sql = "SELECT U.cd_usuario, U.ds_nomusuario, U.cd_perfil, U.ds_apynom, U.ds_mail, U.ds_password, P.ds_perfil FROM usuario U";
		$sql .= " LEFT JOIN perfil P ON(P.cd_perfil=U.cd_perfil)  ";
		$sql .= " WHERE U.cd_usuario = $cd_usuario";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
		
		if ($db->sql_numrows () > 0) {
			$temp = $db->sql_fetchassoc ( $result );
			$factory = new UsuarioFactory();
			$obj = $factory->build($temp);
			
		}
		$db->sql_freeresult($result);
		return ($obj);
	}
	
	static function modificarUsuario(Usuario $obj) {
		$db = DbManager::getConnection();
		$cd_usuario = $obj->getCd_usuario ();
		$ds_nomusuario = $obj->getDs_nomusuario ();
		$cd_perfil = $obj->getCd_perfil ();
		$ds_mail = $obj->getDs_mail ();
		$ds_apynom = $obj->getDs_apynom ();
		$sql = "UPDATE usuario SET ds_nomusuario='$ds_nomusuario',cd_perfil=$cd_perfil,ds_apynom='$ds_apynom', ds_mail= '$ds_mail'";
		if ($obj->getDs_password () != "") {
			$ds_password = MD5 ( $obj->getDs_password () );
			$sql .= ", ds_password = '$ds_password'";
		}
		$sql .= " WHERE cd_usuario = $cd_usuario";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
		
	}
	
	static function existeNombreUsuario(Usuario $user, $db) {
		$ds_nomusuario = $user->getDs_nomusuario ();
		$sql = "Select count(*) as count FROM usuario WHERE ds_nomusuario ='$ds_nomusuario'";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
		
		$next = $db->sql_fetchassoc ( $result );		 
		$cant = $next['count'];
		$db->sql_freeresult($res);
		return ($cant > 0);
	}
	
	static function estaAsignadoAPerfil(Usuario $obj) {
		$db = DbManager::getConnection();
		$cd_perfil = $obj->getCd_perfil();
		$sql = "Select count(*) as count FROM usuario WHERE cd_perfil ='$cd_perfil'";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
		
		$next = $db->sql_fetchassoc ( $result );		 
		$cant = $next['count'];
		$db->sql_freeresult($res);
		return ($cant > 0);
	}
}
?>