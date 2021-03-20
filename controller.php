<?php

include './includes/include.php';
include './includes/constantes.php';
include './includes/datosSession.php';

if (isset ( $_GET ['action'] )) {
	$action = $_GET ['action'];

}else{
	
	if (isset ( $_GET ['accion'] )) 
		$action = $_GET ['accion'];
	else
 	$action = 'page_not_found' ;
}

$controller = new ActionController();


$controller->execute($action, $cd_usuario);

?>
