<?php
include '../../includes/include.php';
include '../../includes/datosSession.php';

$action = new LlenarComboNroCuadroAction();
$action->setPath_html('/movimientos/ajax/combo_nrocuadro.html');

if(isset($_GET["nrocuadro_required"])&&($_GET["nrocuadro_required"] == 0)){
	$action->setClass("");
	$action->setRequired(false);
}else{
	$action->setClass("fValidate['required']");
	$action->setRequired(true);
}

$action->setOnchange("deshabilitarNuMotor()");
echo $action->execute($cd_usuario);

?>