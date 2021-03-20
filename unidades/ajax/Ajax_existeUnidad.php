<?php
header('Content-Type: text/html; charset=utf-8');
include '../../includes/include.php';
include '../../includes/datosSession.php';

$action = new AjaxExisteUnidadAction();
echo $action->execute($cd_usuario);

?>