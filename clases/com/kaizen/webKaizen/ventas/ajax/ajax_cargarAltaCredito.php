<?php
include '../../includes/include.php';
include '../../includes/datosSession.php';

$action = new AjaxCargarAltaCreditoAction();
$action->setPath_html('ventas/ajax/ajax_altacredito.html');
echo $action->execute($cd_usuario);

?>