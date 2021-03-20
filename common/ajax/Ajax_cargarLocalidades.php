<?php
include '../../includes/include.php';
include '../../includes/datosSession.php';

$action = new CargarLocalidadesAction();
$action->setPath_html('/common/ajax/combo_localidades.html');
$action->setDs_label('Localidad');
$action->setDs_Id('localidad');
$action->setDs_parentId('provincia');
$action->setDs_codeTag('cd_localidad');
$action->setDs_descTag('ds_localidad');
if(isset($_GET["localidad_required"])&&($_GET["localidad_required"] == 0)){
	$action->setClass("");
	$action->setRequired(false);
}else{
	$action->setClass("fValidate['required']");
	$action->setRequired(true);
}
$action->setDs_idTag('ds_id');
$action->setDs_labelTag('ds_label');

echo $action->execute($cd_usuario);
	
?>