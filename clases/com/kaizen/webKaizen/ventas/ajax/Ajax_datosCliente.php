<?php
include '../../includes/include.php';
include '../../includes/datosSession.php';

$action = new AjaxDatosClienteAction();
$action->setPath_html('ventas/ajax/ajax_datoscliente.html');
echo $action->execute($cd_usuario);

?>