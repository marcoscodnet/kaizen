<?php

/**
 * Acci�n para exportar a pdf una colecci�n de movimientos.
 *
 * @author Lucrecia
 * @since 03-01-2011
 *
 */
class PDFVentasAction extends ExportPDFCollectionAction {

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getIListar()
	 */
	protected function getIListar() {
		return new VentaManager();
	}

	protected function getFontSize() {
		return 7;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getTableModel($items)
	 */
	protected function getTableModel(ItemCollection $items) {
		return new VentaTableModel($items);
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getCampoOrdenDefault()
	 */
	protected function getCampoOrdenDefault() {
		return 'dt_fecha';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion() {
		return "Listar Ventas";
	}

	protected function getFooter($pdf, CriterioBusqueda $criterio) {
		if($this->tienePermisoFuncion("Ver resumen de venta")){
			$ventas_manager = new VentaManager();
			$cant_ventas = $ventas_manager->getCantidadVentas($criterio);
			$importe_ventas = $ventas_manager->getImporteTotalEnVentas($criterio);
			$importe_acreditado = $ventas_manager->getImporteAcreditadoEnVentas($criterio);
			$cant_ventas_autorizadas = $ventas_manager->getCantVentasAutorizadas($criterio);
			$cant_ventas_no_autorizadas = $ventas_manager->getCantVentasNoAutorizadas($criterio);
			$xtpl = new XTemplate(APP_PATH . 'ventas/footer.html');
			$xtpl->assign('total_ventas', $cant_ventas);
			$xtpl->assign('importe_ventas', $importe_ventas);
			$xtpl->assign('importe_acreditado', $importe_acreditado);
			$xtpl->assign('cant_ventas_aut', $cant_ventas_autorizadas);
			$xtpl->assign('cant_ventas_noaut', $cant_ventas_no_autorizadas);
			$xtpl->parse('main');
			$texto = $xtpl->text('main');
			$pdf->Ln();
			$pdf->writeHTML($texto);
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getOrientacion()
	 */
	protected function getOrientacion() {
		return "L";
	}

	protected function getCriterioBusqueda() {
		//recuperamos los par�metros.
		$filtro = FormatUtils::getParam('filtro');
		$campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault());

		$cd_cliente = FormatUtils::getParam('cd_cliente');
		$cd_usuario = FormatUtils::getParam('cd_usuario');
		$cd_sucursal = FormatUtils::getParam('cd_sucursal');
		$dt_desde = FormatUtils::getParam('dt_desde');
		$dt_hasta = FormatUtils::getParam('dt_hasta');

		$orden = FormatUtils::getParam('orden', 'DESC');
		$campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault());


		$criterio = new CriterioBusqueda();

		if ($cd_usuario != "") {
			$criterio->addFiltro('V.cd_usuario', $cd_usuario, "=");
		}
		if ($cd_sucursal != "") {
			$criterio->addFiltro('V.cd_sucursal', $cd_sucursal, "=");
		}
		if ($cd_cliente != "") {
			$criterio->addFiltro('V.cd_cliente', $cd_cliente, "=");
		}
		if ($dt_desde != "") {            $dt_desde = str_replace("/", "-", $dt_desde);            $dt_desde = implode("/", array_reverse(explode("-", $dt_desde))).' 00:00:00';            $criterio->addFiltro('V.dt_venta', "'$dt_desde'", ">=");        }        if ($dt_hasta != "") {            $dt_hasta = str_replace("/", "-", $dt_hasta);            $dt_hasta = implode("/", array_reverse(explode("-", $dt_hasta))).' 23:59:59';            $criterio->addFiltro('V.dt_venta', "'$dt_hasta'", "<=");        }

		//$this->addSelectedFiltro($criterio,$campoFiltro, $filtro);
		$criterio->addOrden($campoOrden, $orden);

		return $criterio;
	}

}