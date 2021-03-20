<?php
include '../../includes/include.php';
include '../../includes/datosSession.php';

$action = new CargarProvinciasAction();
$action->setPath_html('/common/ajax/combo_provincias.html');
$action->setDs_label('Provincia');
$action->setDs_Id('provincia');
$action->setDs_parentId('pais');
$action->setDs_codeTag('cd_provincia');
$action->setDs_descTag('ds_provincia');
$action->setDs_idTag('ds_id');
$action->setDs_labelTag('ds_label');
if(isset($_GET["provincia_required"])&&($_GET["provincia_required"] == 0)){
	$action->setClass("");
	$action->setRequired(false);
}else{
	$action->setClass("fValidate['required']");
	$action->setRequired(true);
}

echo $action->execute($cd_usuario);
	
?>