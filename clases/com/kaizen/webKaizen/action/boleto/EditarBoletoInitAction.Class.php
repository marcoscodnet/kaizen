<?php

/**
 * Acción para inicializar el contexto para editar
 * una localidad.
 *
 * @author Lucrecia
 * @since 15-04-2010
 *
 */
abstract class EditarBoletoInitAction  extends EditarInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate ( APP_PATH. '/boleto/editarboleto.html' );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getEntidad()
	 */
	protected function getEntidad(){
		return new Parametro();
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oParametro = FormatUtils::ifEmpty($entidad, new Parametro());
		$this->parseBoleto( $oParametro , $xtpl);
	}

	protected function parseBoleto(Parametro $oParametro, XTemplate $xtpl){
		$xtpl->assign ( 'cd_parametro', $oParametro->getCd_parametro());
		$xtpl->assign ( 'ds_nombre', $oParametro->getDs_nombre());
		$xtpl->assign ( 'ds_contenido', stripslashes ( $oParametro->getDs_contenido () ) );
	}
}