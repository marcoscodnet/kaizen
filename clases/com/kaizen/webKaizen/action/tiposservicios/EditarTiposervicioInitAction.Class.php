<?php

/**
 * Acción para inicializar el contexto para editar
 * una localidad.
 *
 * @author marcos
 * @since 15-05-2012
 *
 */
abstract class EditarTiposervicioInitAction  extends EditarInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate ( APP_PATH. '/tiposservicios/editartiposervicio.html' );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getEntidad()
	 */
	protected function getEntidad(){
		return new Tiposervicio();
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oTiposervicio = FormatUtils::ifEmpty($entidad, new Tiposervicio());
		$this->parseTiposervicio( $oTiposervicio , $xtpl);
	}

	protected function parseTiposervicio( Tiposervicio $oTiposervicio, XTemplate $xtpl){
		//se muestra el localidad.
		$xtpl->assign ( 'cd_tiposervicio', $oTiposervicio->getCd_tiposervicio());
		$xtpl->assign ( 'ds_tiposervicio', stripslashes ( $oTiposervicio->getDs_tiposervicio () ) );
	}
}