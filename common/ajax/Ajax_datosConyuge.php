<?php
include '../../includes/include.php';
include '../../includes/datosSession.php';

$action = new CargarDatosConyugeAction();
$action->setPath_html('/common/ajax/datos_conyuge.html');

if(isset($_GET["conyuge_required"])&&($_GET["conyuge_required"] == 0)){
	$action->setClass("");
	$action->setRequired(false);
}else{
	$action->setClass("fValidate['required']");
	$action->setRequired(true);
}

echo $action->execute($cd_usuario);

?>