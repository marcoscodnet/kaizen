<?php
include '../../includes/include.php';
include '../../includes/datosSession.php';

$action = new AjaxBuscarProductoAction();
$action->setPath_html('/productos/ajax/buscarproductos.html');

echo $action->execute($cd_usuario);
	
?>