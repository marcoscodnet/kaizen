<?php
/**
 * Acción para ediar de sesión una cuadrilla utilizando Ajax.
 *
 * @author Lucrecia
 * @since 12-04-2010
 *
 */
abstract class EditarCuadrillaDeObraAction extends EditarContratistaDeObraAction{

	protected function getTipoTrabajador(){
		return CUADRILLA;
	}
	
	protected function getXTemplate(){
		return new XTemplate ( APP_PATH. 'obras/cuadrillasasignar.html' );	
	}

	protected function parseTrabajadorObra(TrabajadorObra $oTrabajadorObra, XTemplate $xtpl){
		$xtpl->assign('cd_cuadrilla', $oTrabajadorObra->getCd_trabajadorObra());
		$xtpl->assign('nu_numero', $oTrabajadorObra->getNu_numero());
		$xtpl->assign ( 'ds_responsable', htmlentities ( $oTrabajadorObra->getTrabajador()->getDs_nombre() ) );
	}

}