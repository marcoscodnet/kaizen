<?php
include '../../includes/include.php';
include '../../includes/datosSession.php';

$action = new AjaxCargarSucursalAction();

echo $action->execute($cd_usuario);

?>