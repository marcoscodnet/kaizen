<?php
include '../../includes/include.php';
include '../../includes/datosSession.php';

$action = new LlenarComboProductosAction();
$action->setPath_html('/movimientos/ajax/combo_productos.html');

if(isset($_GET["producto_required"])&&($_GET["producto_required"] == 0)){
	$action->setClass("");
	$action->setRequired(false);
}else{
	$action->setClass("fValidate['required']");
	$action->setRequired(true);
}

$action->setOnchange("cargarNroMotor()");
echo $action->execute($cd_usuario);
	
?>