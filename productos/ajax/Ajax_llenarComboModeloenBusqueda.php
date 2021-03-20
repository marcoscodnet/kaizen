<?php
include '../../includes/include.php';
include '../../includes/datosSession.php';

$action = new LlenarComboModeloAction();
$action->setPath_html('/productos/ajax/combo_modelos_buscar.html');

if(isset($_GET["modelo_required"])&&($_GET["modelo_required"] == 0)){
	$action->setClass("");
	$action->setRequired(false);
}else{
	$action->setClass("fValidate['required']");
	$action->setRequired(true);
}
echo $action->execute($cd_usuario);

?>