<?php 

/**
 * Acción para inicializar el contexto para editar
 * una localidad.
 * 
 * @author Lucrecia
 * @since 15-04-2010
 * 
 */
abstract class EditarColorInitAction  extends EditarInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate ( APP_PATH. '/colores/editarcolor.html' );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getEntidad()
	 */
	protected function getEntidad(){
		return new Color();
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oColor = FormatUtils::ifEmpty($entidad, new Color());
		$this->parseColor( $oColor , $xtpl);
	}
	
	protected function parseColor(Color $oColor, XTemplate $xtpl){
		//se muestra el localidad.
		$xtpl->assign ( 'cd_color', $oColor->getCd_color());
		$xtpl->assign ( 'ds_color', stripslashes ( $oColor->getDs_color () ) );
	}
}