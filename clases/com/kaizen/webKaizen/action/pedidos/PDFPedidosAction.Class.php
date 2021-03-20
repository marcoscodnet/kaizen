<?php

/**
 * Acciï¿½n para exportar a pdf una colecciï¿½n de pedidos.
 *
 * @author María Jesús
 * @since 09-09-2011
 *
 */
class PDFPedidosAction extends ExportPDFCollectionAction {

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getIListar()
	 */
	protected function getIListar() {
		return new PedidoManager();
	}

	protected function getFontSize() {
		return 7;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getTableModel($items)
	 */
	protected function getTableModel(ItemCollection $items) {
		return new PedidoTableModel($items);
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getCampoOrdenDefault()
	 */
	protected function getCampoOrdenDefault() {
		return 'dt_pedido';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion() {
		return "Listar Pedido";
	}

	protected function getFooter($pdf, CriterioBusqueda $criterio) {
			$pedidos_manager = new PedidoManager();
			$cant_pedidos = $pedidos_manager->getCantidadPedidos($criterio);
			$cant_pedidos_a_pedir = $pedidos_manager->getCantPedidosAPedir($criterio);
			$cant_pedidos_pedidos = $pedidos_manager->getCantPedidosPedidos($criterio);
			$xtpl = new XTemplate(APP_PATH . 'pedidos/footer.html');
			$xtpl->assign('total_pedidos', $cant_pedidos);
			$xtpl->assign('cant_pedidos_apedir', $cant_pedidos_a_pedir);
			$xtpl->assign('cant_pedidos_pedido', $cant_pedidos_pedidos);
			$xtpl->parse('main');
			$texto = $xtpl->text('main');
			$pdf->Ln();
			$pdf->writeHTML($texto);
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getOrientacion()
	 */
	protected function getOrientacion() {
		return "L";
	}

protected function getCriterioBusqueda() {
		//recuperamos los parï¿½metros.
		$filtro = FormatUtils::getParam('filtro');
		$campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault());

		$dt_desde = FormatUtils::getParam('dt_desde');
		$dt_hasta = FormatUtils::getParam('dt_hasta');

		$orden = FormatUtils::getParam('orden', 'DESC');
		$campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault());


		$criterio = new CriterioBusqueda();

		if ($dt_desde != "") {
			$dt_desde = str_replace("/", "-", $dt_desde);
			$dt_desde = implode("/", array_reverse(explode("-", $dt_desde)));
			$criterio->addFiltro('P.dt_pedido', "'$dt_desde'", ">=");
		}
		if ($dt_hasta != "") {
			$dt_hasta = str_replace("/", "-", $dt_hasta);
			$dt_hasta = implode("/", array_reverse(explode("-", $dt_hasta)));
			$criterio->addFiltro('P.dt_pedidos', "'$dt_hasta'", "<=");
		}

		//$this->addSelectedFiltro($criterio,$campoFiltro, $filtro);
		$criterio->addOrden($campoOrden, $orden);

		return $criterio;
	}

}