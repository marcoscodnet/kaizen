<?php
include '../../includes/include.php';
include '../../includes/datosSession.php';

$action = new LlenarComboMarcaAction();
$action->setPath_html('/productos/ajax/combo_marcas.html');
/*$action->setDs_label('Marcas');
$action->setDs_Id('cd_marca');
$action->setDs_parentId('cd_tipounidad');
$action->setDs_codeTag('cd_marca');
$action->setDs_descTag('ds_marca');
$action->setDs_idTag('ds_id');
$action->setDs_labelTag('ds_label');*/
if(isset($_GET["marca_required"])&&($_GET["marca_required"] == 0)){
	$action->setClass("");
	$action->setRequired(false);
}else{
	$action->setClass("fValidate['required']");
	$action->setRequired(true);
}

$action->setOnchange("cargarModelos()");
echo $action->execute($cd_usuario);
	
?>