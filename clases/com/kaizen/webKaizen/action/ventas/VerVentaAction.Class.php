<?php

/**
 * Acci�n para visualizar un movimiento.
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 */
class VerVentaAction extends SecureOutputAction {

	/**
	 * consulta un movimiento.
	 * @return forward.
	 */
	protected function getContenido() {

		$xtpl = new XTemplate(APP_PATH . 'ventas/verventa.html');

		if (isset($_GET ['id'])) {
			$cd_venta = $_GET ['id'];

			$manager = new VentaManager();

			try {
				$oVenta = $manager->getVentaPorId($cd_venta);
			} catch (GenericException $ex) {
				$oVenta = new Venta();
				//TODO ver si se muestra un mensaje de error.
			}

			//se muestra la venta.
			$xtpl->assign('cd_venta', $oVenta->getCd_venta());
			$xtpl->assign('ds_apynom', stripslashes($oVenta->getDs_apynom()));
			$xtpl->assign('ds_nomusuario', stripslashes($oVenta->getDs_nomusuario()));
			$xtpl->assign('ds_sucursal', stripslashes($oVenta->getDs_nombre()));
			$xtpl->assign('importe_venta', stripslashes($oVenta->getNu_montosugerido()));
			$xtpl->assign('dt_fecha', stripslashes($oVenta->getDt_fecha()));
			$xtpl->assign('ds_producto', stripslashes($oVenta->getUnidad()->getDs_producto())."( Nro. Motor: ".$oVenta->getNu_motor()." - Nro. Cuadro: ".$oVenta->getUnidad()->getNu_cuadro().")");
			$this->parseCreditos($xtpl, $oVenta);
		}

		$xtpl->assign('titulo', 'Detalle de Venta');
		$xtpl->parse('main');
		return $xtpl->text('main');
	}

	protected function parseCreditos($xtpl, Venta $oVenta){
		$managerItempago = new ItempagoManager();
		$criterio = new CriterioBusqueda();
		$criterio->addFiltro("cd_venta", $oVenta->getCd_venta(), "=");
		$creditos = $managerItempago->getItemspago($criterio);
		$xtpl->assign('ds_formapago', $oVenta->getDs_formapago());
		foreach($creditos as $credito){
			$xtpl->assign('dt_pagado', $credito->getDt_pago());
			$xtpl->assign('ds_entidad', $credito->getDs_entidad());
			$xtpl->assign('nu_importe', $credito->getNu_importe());
			$xtpl->assign('nu_pagado', $credito->getNu_pagado());
			$xtpl->assign('ds_detalle', $credito->getDs_detalle());
			$xtpl->assign('dt_contadora', $credito->getDt_contadora());
			$xtpl->assign('ds_observacion', $credito->getDs_observacion());
			$xtpl->parse('main.creditos');
		}
	}

	public function getFuncion() {
		return "Ver Venta";
	}

	public function getTitulo() {
		return "Detalle de Venta";
	}

}