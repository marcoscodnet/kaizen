<?php

/**
 * Acci�n para editar un movimiento.
 *
 * @author Lucrecia
 * @since 22-04-2010
 *
 */
abstract class EditarPiezaAVentaPiezaAction extends EditarAction {

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad() {
		$oVentaPieza = new VentaPieza();

		if (isset($_POST ['cd_pieza1'])){
			$cd_pieza = $_POST ['cd_pieza1'];
			$piezaManager = new PiezaManager();
			$oPieza = $piezaManager->getPiezaPorId($cd_pieza);
			
			if (isset($_POST ['nu_cantidadpedida']))
				$oPieza->setNu_cantidadpedida($_POST ['nu_cantidadpedida']);
			
			if (isset($_POST ['qt_montoacobrar']))
				$oPieza->setQt_montoacobrar($_POST ['qt_montoacobrar']);
			
			
			$oVentaPieza->setPieza($oPieza);
		}

		
		return $oVentaPieza;
	}

}