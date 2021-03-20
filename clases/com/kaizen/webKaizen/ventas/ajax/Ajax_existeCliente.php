<?php
include '../../includes/include.php';
include '../../includes/datosSession.php';

$action = new AjaxExisteClienteAction();
echo $action->execute($cd_usuario);

?>