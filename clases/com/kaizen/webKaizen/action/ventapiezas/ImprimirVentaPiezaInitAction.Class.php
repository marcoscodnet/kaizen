<?php

/**
 * Acciï¿½n para inicializar el contexto para editar
 * un movimiento.
 *
 * @author Lucrecia
 * @since 15-04-2010
 *
 */
class ImprimirVentaPiezaInitAction extends SecureOutputAction {


	protected function getContenido() {

		$xtpl = new XTemplate(APP_PATH . 'ventaspiezas/imprimirVentaPieza.html');
		unset($_SESSION['piezasavender']);
		if (isset($_GET ['id'])) {
			$cd_ventapieza = $_GET ['id'];

			$manager = new VentaPiezaManager();

			try {
				$oVentaPieza = $manager->getVentaPiezaPorId($cd_ventapieza);
			} catch (GenericException $ex) {
				$oVentaPieza = new VentaPieza();
				//TODO ver si se muestra un mensaje de error.
			}

			$xtpl->assign('dt_ventapieza', $oVentaPieza->getDt_ventapieza());
			$xtpl->assign('cd_ventapieza', $oVentaPieza->getCd_ventapieza());
			$xtpl->assign('ds_sucursal', $oVentaPieza->getSucursal()->getDs_nombre());
			$xtpl->assign('nu_destino', $oVentaPieza->getNu_destino());
			$xtpl->assign('ds_destino', $oVentaPieza->getDs_destino());

			$this->parsePiezas($xtpl, $oVentaPieza->getCd_ventapieza());

		}

		$xtpl->assign('titulo', 'Impresión de venta de piezas');
		$xtpl->parse('main');
		return $xtpl->text('main');
	}


	protected function parsePiezas(XTemplate $xtpl, $cd_ventapieza){
		$ventapiezaManager = new VentaPiezaManager();
		/*$piezas = $ventapiezaManager->getVentaPiezaUnidades($cd_ventapieza);
		foreach($piezas as $pieza){			print_r($pieza);
			$xtpl->assign('cd_pieza', $pieza->getCd_pieza());
			$xtpl->assign('ds_codigo', $pieza->getDs_codigo());
			$xtpl->assign('ds_descripcion', $pieza->getDs_descripcion());						$xtpl->assign('ds_sucursalOrigen', $pieza->getDs_descripcion());
			$xtpl->assign('nu_cantidadpedida', $pieza->getNu_cantidadpedida());
			$xtpl->assign('qt_montoacobrar', $pieza->getQt_montoacobrar());
			$xtpl->parse('main.filas');
		}*/				$piezasUnidad = $ventapiezaManager->getVentaPiezaUnidades($cd_ventapieza);		foreach($piezasUnidad as $piezaUnidad){			//print_r($piezaUnidad);			$xtpl->assign('cd_pieza', $piezaUnidad->getPieza()->getCd_pieza());			$xtpl->assign('ds_codigo', $piezaUnidad->getPieza()->getDs_codigo());			$xtpl->assign('ds_descripcion', $piezaUnidad->getPieza()->getDs_descripcion());						$managerSucursal = new SucursalManager();					$oSucursal = $managerSucursal->getSucursalPorId( $piezaUnidad->getSucursal()->getCd_sucursal() );						$xtpl->assign('ds_sucursalOrigen', $oSucursal->getDs_nombre());			$xtpl->assign('nu_cantidadpedida', $piezaUnidad->getPieza()->getNu_cantidadpedida());			$xtpl->assign('qt_montoacobrar', $piezaUnidad->getPieza()->getQt_montoacobrar());			$xtpl->parse('main.filas');		}
		//return $cd_sucursal;
	}

	public function getFuncion(){
		return "Alta Venta Pieza";
	}

	protected function getTitulo(){
		return "Venta de Piezas Realizada!";
	}

}