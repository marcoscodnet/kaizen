<?php

class Permiso
{

	/*
	  +-----------------------------------------------------------------------+
      |Esta funci�n administra los permisos. Verifica si el usuario en sesion |
	  |pasado como par�metro como cd_usuario tiene permiso para acceder a la  |
      |funci�n pasada como par�metro nombreFunci�n. Si no tiene permiso       | 
      |redirecciona a la p�gina de error.                                     |
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