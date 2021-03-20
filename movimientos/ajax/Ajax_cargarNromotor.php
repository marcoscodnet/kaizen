<?php
include '../../includes/include.php';
include '../../includes/datosSession.php';

$action = new LlenarComboNroMotorAction();
$action->setPath_html('/movimientos/ajax/combo_nromotor.html');

$action->setOnchange("deshabilitarNuCuadro()");

if(isset($_GET["nromotor_required"])&&($_GET["nromotor_required"] == 0)){
	$action->setClass("");
	$action->setRequired(false);
}else{
	$action->setClass("fValidate['required']");
	$action->setRequired(true);
}

echo $action->execute($cd_usuario);

?>