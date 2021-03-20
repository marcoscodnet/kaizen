<?php



/**

 * Acci�n para inicializar el contexto para editar

 * una pieza.

 *

 * @author Ma. Jes�s

 * @since 18-06-2011

 *

 */

abstract class EditarPiezaInitAction  extends EditarInitAction{



	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/action/generic/EditarInitAction#getXTemplate()

	 */

	protected function getXTemplate(){

		return new XTemplate ( APP_PATH. '/piezas/editarpieza.html' );

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/action/generic/EditarInitAction#getEntidad()

	 */

	protected function getEntidad(){

		return new Pieza();

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)

	 */

	protected function parseEntidad($entidad, XTemplate $xtpl){

		$oPieza = FormatUtils::ifEmpty($entidad, new Pieza());

		//se muestra la pieza.

		$this->parsePieza( $oPieza , $xtpl);

	}





	protected function parsePieza($oPieza, XTemplate $xtpl){

		//se muestra la pieza.

		$xtpl->assign ( 'cd_pieza', $oPieza->getCd_pieza());

		$xtpl->assign ( 'ds_codigo', $oPieza->getDs_codigo());

		$xtpl->assign ( 'ds_descripcion', $oPieza->getDs_descripcion());

		$xtpl->assign ( 'nu_stock_actual', $oPieza->getNu_stock_actual());

		$xtpl->assign ( 'nu_stock_minimo', $oPieza->getNu_stock_minimo());

		$xtpl->assign ( 'qt_costo', stripslashes ( $oPieza->getQt_costo() ) );

		$xtpl->assign ( 'qt_minimo', stripslashes ( $oPieza->getQt_minimo () ) );

		$xtpl->assign ( 'ds_observacion', $oPieza->getDs_observacion());

	}



}