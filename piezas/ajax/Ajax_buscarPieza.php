<?php
include '../../includes/include.php';
include '../../includes/datosSession.php';

$action = new AjaxBuscarPiezaAction();
$action->setPath_html('/piezas/ajax/buscarpiezas.html');

echo $action->execute($cd_usuario);

?>