<?php

include '../../includes/include.php';
include '../../includes/datosSession.php';

$action = new AjaxEditarCreditoAction();
$action->setPath_html('ventas/ajax/ajax_altacredito.html');
echo $action->execute($cd_usuario);
?>