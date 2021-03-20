<?php
include '../../includes/include.php';
include '../../includes/datosSession.php';

$action = new AjaxCargarAltaDestinoAction();
$action->setFuncion(addslashes($_GET['funcion_ajax']));
echo $action->execute($cd_usuario);

?>