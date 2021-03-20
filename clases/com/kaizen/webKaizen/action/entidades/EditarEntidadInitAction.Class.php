<?php 

/**
 * Acción para inicializar el contexto para editar
 * una localidad.
 * 
 * @author Lucrecia
 * @since 15-04-2010
 * 
 */
abstract class EditarEntidadInitAction  extends EditarInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate ( APP_PATH. '/entidades/editarentidad.html' );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getEntidad()
	 */
	protected function getEntidad(){
		return new Entidad();
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oEntidad = FormatUtils::ifEmpty($entidad, new Entidad());
		$this->parseEntidadDB( $oEntidad , $xtpl);
	}
	
	protected function parseEntidadDB(Entidad $oEntidad, XTemplate $xtpl){
		//se muestra el localidad.
		$xtpl->assign ( 'cd_entidad', $oEntidad->getCd_entidad());
		$xtpl->assign ( 'ds_entidad', stripslashes ( $oEntidad->getDs_entidad () ) );
	}
}