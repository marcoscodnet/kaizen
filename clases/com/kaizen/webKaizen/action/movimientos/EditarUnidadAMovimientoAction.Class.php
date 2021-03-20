<?php

/**
 * Acci�n para editar un movimiento.
 *
 * @author Lucrecia
 * @since 22-04-2010
 *
 */
abstract class EditarUnidadAMovimientoAction extends EditarAction {

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad() {
		$oMovimiento = new Movimiento();

		if (isset($_POST ['cd_unidad'])){
			$cd_unidad = $_POST ['cd_unidad'];
			$unidadManager = new UnidadManager();
			$oUnidad = $unidadManager->getUnidadPorId($cd_unidad);
			$oMovimiento->setUnidad($oUnidad);
		}

		if (isset($_POST ['cd_sucursalorigen'])){
			$cd_sucursal = $_POST ['cd_sucursalorigen'];
			$sucursalManager = new SucursalManager();
			$oSucursal = $sucursalManager->getSucursalPorId($cd_sucursal);
			$oMovimiento->setSucursalOrigen($oSucursal);
		}
		return $oMovimiento;
	}

}