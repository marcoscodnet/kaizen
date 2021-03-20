<?php

include '../../includes/include.php';
include '../../includes/datosSession.php';

$action = new AjaxEditarCreditoAction();
$action->setPath_html('ventas/ajax/ajax_altacredito.html');
$action->setFuncion(addslashes($_GET['funcion_ajax']));
echo $action->execute($cd_usuario);
?>