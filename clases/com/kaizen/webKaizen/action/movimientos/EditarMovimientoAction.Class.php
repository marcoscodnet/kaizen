<?php

/**
 * Acci�n para editar un movimiento.
 *
 * @author Lucrecia
 * @since 22-04-2010
 *
 */
abstract class EditarMovimientoAction extends EditarAction {

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad() {
		$oMovimiento = new Movimiento();

		if(isset($_SESSION['unidadesamover'])&&(count($_SESSION['unidadesamover']))){
			if (isset($_POST ['cd_sucursalorigen']) && (count($_SESSION['unidadesamover'])))
			$otmp_mov = new Movimiento();
			$otmp_mov = current($_SESSION['unidadesamover']);
			$cd_sucursalorigen = $otmp_mov ->getCd_sucursalorigen();
			$oMovimiento->setCd_sucursalorigen($cd_sucursalorigen);

			if (isset($_POST ['cd_sucursaldestino']))
			$oMovimiento->setCd_sucursaldestino($_POST ['cd_sucursaldestino']);

			if (isset($_POST ['dt_movimiento']))
			$oMovimiento->setDt_movimiento(str_replace("/", "-", $_POST ['dt_movimiento']));

			if (isset($_POST ['ds_observacion']))
			$oMovimiento->setDs_observacion($_POST ['ds_observacion']);

			$oMovimiento->setCd_usuario($_SESSION ['cd_usuarioSession']);
				
			$unidadesamover = $_SESSION['unidadesamover'];
			$entidad[0] = $oMovimiento;
			$entidad[1] = $unidadesamover;
			return $entidad;
		}

	}
}