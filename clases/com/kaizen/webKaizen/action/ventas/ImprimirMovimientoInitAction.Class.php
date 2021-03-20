<?php

/**
 * Acciï¿½n para inicializar el contexto para editar
 * un movimiento.
 *
 * @author Lucrecia
 * @since 15-04-2010
 *
 */
class ImprimirMovimientoInitAction extends SecureOutputAction {


	protected function getContenido() {

		$xtpl = new XTemplate(APP_PATH . 'movimientos/imprimirmovimiento.html');

		if (isset($_GET ['id'])) {
			$cd_movimiento = $_GET ['id'];

			$manager = new MovimientoManager();

			try {
				$oMovimiento = $manager->getMovimientoPorId($cd_movimiento);
			} catch (GenericException $ex) {
				$oMovimiento = new Movimiento();
				//TODO ver si se muestra un mensaje de error.
			}

			$xtpl->assign('dt_movimiento', $oMovimiento->getDt_movimiento());
			$xtpl->assign('cd_movimiento', $oMovimiento->getCd_movimiento());
			$xtpl->assign('ds_sucursalorigen', $oMovimiento->getDs_sucursalorigen());
			$xtpl->assign('ds_sucursaldestino', $oMovimiento->getDs_sucursaldestino());

			$this->parseUnidades($xtpl, $oMovimiento->getCd_movimiento());

		}

		$xtpl->assign('titulo', 'Impresión de movimiento');
		$xtpl->parse('main');
		return $xtpl->text('main');
	}


	protected function parseUnidades(XTemplate $xtpl, $cd_movimiento){
		$movimientoManager = new MovimientoManager();
		$unidades = $movimientoManager->getUnidadesDeMovimiento($cd_movimiento);
		foreach($unidades as $unidad){
			$xtpl->assign('cd_unidad', $unidad->getCd_unidad());
			$xtpl->assign('ds_producto', $unidad->getDs_producto());
			$xtpl->assign('nu_motor', $unidad->getNu_motor());
			$xtpl->assign('nu_cuadro', $unidad->getNu_cuadro());
			$xtpl->parse('main.filas');
		}
		return $cd_sucursal;
	}

	public function getFuncion(){
		return "Alta Movimiento";
	}

	protected function getTitulo(){
		return "Movimiento Realizado!";
	}

}