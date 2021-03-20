<?php

/**
 * Acciï¿½n para visualizar un pedido.
 *
 * @author María Jesús
 * @since 09-09-2011
 *
 */
class VerPedidoAction extends SecureOutputAction {

	/**
	 * consulta un pedido.
	 * @return forward.
	 */
	protected function getContenido() {

		$xtpl = new XTemplate(APP_PATH . 'pedidos/verpedido.html');

		if (isset($_GET ['id'])) {
			$cd_pedido = $_GET ['id'];

			$manager = new PedidoManager();

			try {
				$oPedido = $manager->getPedidoPorId($cd_pedido);
			} catch (GenericException $ex) {
				$oPedido = new Pedido();
				//TODO ver si se muestra un mensaje de error.
			}

			//se muestra el pedido.
			$xtpl->assign ( 'ds_pieza', $oPedido->getDs_pieza());
			
			if ($oPedido->getDs_pieza())
				$xtpl->assign ( 'ds_pieza', $oPedido->getDs_pieza());
			else
				$xtpl->assign ( 'ds_pieza', $oPedido->getPieza()->getDs_codigo());			
					
			$xtpl->assign ( 'nu_cantidad', $oPedido->getNu_cantidad());
			$xtpl->assign ( 'qt_minimo', stripslashes ( $oPedido->getQt_minimo () ) );
			$xtpl->assign ( 'qt_sena', stripslashes ( $oPedido->getQt_sena () ) );
			if ($oPedido->getCd_estado()==0)
				$xtpl->assign ( 'cd_estado', "A PEDIR");
			else
				$xtpl->assign ( 'cd_estado', "PEDIDO");
			$xtpl->assign ( 'dt_pedido', stripslashes ( $oPedido->getDt_pedido()) );
			$xtpl->assign ( 'ds_observacion', $oPedido->getDs_observacion());
		}

		$xtpl->assign('titulo', 'Detalle del Pedido');
		$xtpl->parse('main');
		return $xtpl->text('main');
	}

	public function getFuncion() {
		return "Ver Pedido";
	}

	public function getTitulo() {
		return "Detalle de Pedido";
	}

}