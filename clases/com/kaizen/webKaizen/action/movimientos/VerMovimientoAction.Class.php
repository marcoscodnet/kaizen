<?php

/**
 * Acci�n para visualizar un movimiento.
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 */
class VerMovimientoAction extends SecureOutputAction {

	/**
	 * consulta un movimiento.
	 * @return forward.
	 */
	protected function getContenido() {

		$xtpl = new XTemplate(APP_PATH . 'movimientos/vermovimiento.html');

		if (isset($_GET ['id'])) {
			$cd_movimiento = $_GET ['id'];

			$manager = new MovimientoManager();

			try {
				$oMovimiento = $manager->getMovimientoPorId($cd_movimiento);
			} catch (GenericException $ex) {
				$oMovimiento = new Movimiento();
				//TODO ver si se muestra un mensaje de error.
			}
			
			//se muestra el movimiento.
			$xtpl->assign('cd_movimiento', $oMovimiento->getCd_movimiento());
			$xtpl->assign('dt_movimiento', stripslashes($oMovimiento->getDt_movimiento()));
			$xtpl->assign('ds_sucursalorigen', stripslashes($oMovimiento->getDs_sucursalorigen()));
			$xtpl->assign('ds_sucursaldestino', stripslashes($oMovimiento->getDs_sucursaldestino()));
			$xtpl->assign('ds_observacion', stripslashes($oMovimiento->getDs_observacion()));
			$xtpl->assign('ds_nomusuario', stripslashes($oMovimiento->getDs_nomusuario()));
			$this->parseUnidades($xtpl, $cd_movimiento);
		}

		$xtpl->assign('titulo', 'Detalle de movimiento');
		$xtpl->parse('main');
		return $xtpl->text('main');
	}


	protected function parseUnidades(XTemplate $xtpl, $cd_movimiento = 0){
		$manager = new MovimientoManager();

		try {
			$unidades = $manager->getUnidadesDeMovimiento($cd_movimiento);
		} catch (GenericException $ex) {
			$unidades = array();
			//TODO ver si se muestra un mensaje de error.
		}
		foreach($unidades as $indice=>$unidad){

			$xtpl->assign('cd_unidad', $unidad->getCd_unidad());
			$xtpl->assign('ds_producto', $unidad->getDs_producto());
			$xtpl->assign('nu_motor', $unidad->getNu_motor());
			$xtpl->assign('nu_cuadro', $unidad->getNu_cuadro());

			$xtpl->assign('indice', $indice);
			$xtpl->parse('main.filas');
		}

		return $cd_sucursal;
	}

	public function getFuncion() {
		return "Ver Movimiento";
	}

	public function getTitulo() {
		return "Detalle de Movimiento";
	}

}