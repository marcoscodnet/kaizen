<?php 

/**
 * Acción para inicializar el contexto para editar
 * una localidad.
 * 
 * @author bernardo
 * @since 15-04-2010
 * 
 */
abstract class EditarPaisInitAction  extends EditarInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate ( APP_PATH. '/paises/editarpais.html' );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getEntidad()
	 */
	protected function getEntidad(){
		return new Pais();
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oPais = FormatUtils::ifEmpty($entidad, new Pais());
		$this->parsePais( $oPais , $xtpl);
	}
	
	protected function parsePais(Pais $oPais, XTemplate $xtpl){
		//se muestra el localidad.
		$xtpl->assign ( 'cd_pais', $oPais->getCd_pais());
		$xtpl->assign ( 'ds_pais', stripslashes ( $oPais->getDs_pais () ) );
	}
}