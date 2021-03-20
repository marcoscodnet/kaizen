<?php
include '../../includes/include.php';
include '../../includes/datosSession.php';

$action = new AjaxBuscarPrecioAction();
$action->setPath_html('/piezas/ajax/buscarprecio.html');

echo $action->execute($cd_usuario);

?>