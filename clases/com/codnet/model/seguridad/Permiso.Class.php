<?php

class Permiso
{

	/*
	  +-----------------------------------------------------------------------+
      |Esta función administra los permisos. Verifica si el usuario en sesion |
	  |pasado como parámetro como cd_usuario tiene permiso para acceder a la  |
      |función pasada como parámetro nombreFunción. Si no tiene permiso       | 
      |redirecciona a la página de error.                                     |
	  +-----------------------------------------------------------------------+
    */
	
	function usuarioAutorizadoFuncion($cd_usuario, $nombreFuncion)
	{
//		include '../clases/PermisoQuery.Class.php';
		$tienePermiso = PermisoQuery::permisosDeUsuario ( $cd_usuario, $nombreFuncion );
		if (! $tienePermiso)
		{
			header ( 'Location:../includes/accesodenegado.php' );
		}

	}

}
?>