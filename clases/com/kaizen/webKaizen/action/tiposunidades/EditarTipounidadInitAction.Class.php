<?php

/**
 * Acción para inicializar el contexto para editar
 * una localidad.
 *
 * @author Lucrecia
 * @since 15-04-2010
 *
 */
abstract class EditarTipounidadInitAction  extends EditarInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate ( APP_PATH. '/tiposunidades/editartipounidad.html' );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getEntidad()
	 */
	protected function getEntidad(){
		return new Tipounidad();
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oTipounidad = FormatUtils::ifEmpty($entidad, new Tipounidad());
		$this->parseTipounidad( $oTipounidad , $xtpl);
	}

	protected function parseTipounidad( Tipounidad $oTipounidad, XTemplate $xtpl){
		//se muestra el localidad.
		$xtpl->assign ( 'cd_tipounidad', $oTipounidad->getCd_tipounidad());
		$xtpl->assign ( 'ds_tipounidad', stripslashes ( $oTipounidad->getDs_tipounidad () ) );
	}
}