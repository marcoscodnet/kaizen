<?php

/**
 * Acci�n para exportar a pdf una colecci�n de servicios.
 *
 * @author Marcos
 * @since 22-05-2012
 *
 */
class PDFServiciosAction extends ExportPDFCollectionAction {

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getIListar()
	 */
	protected function getIListar() {
		return new ServicioManager();
	}

	protected function getFontSize() {
		return 7;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getTableModel($items)
	 */
	protected function getTableModel(ItemCollection $items) {
		return new ServicioTableModel($items);
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getCampoOrdenDefault()
	 */
	protected function getCampoOrdenDefault() {
		return 'dt_carga';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion() {
		return "Listar Servicio";
	}

	protected function getFooter($pdf, CriterioBusqueda $criterio) {
		if($this->tienePermisoFuncion("Ver resumen de servicio")){
			 $servicios_manager = new ServicioManager();            $cant_servicios = $servicios_manager->getCantidadServicios($criterio);            $importe_servicios = $servicios_manager->getImporteTotalEnServicios($criterio);                        $xtpl = new XTemplate(APP_PATH . 'servicios/footer.html');            $xtpl->assign('total_servicios', $cant_servicios);            $xtpl->assign('importe_servicios', FuncionesComunes::Format_toDecimal($importe_servicios));
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

		$cd_cliente = FormatUtils::getParam('cd_cliente');        $cd_usuario = FormatUtils::getParam('cd_usuario');        $cd_sucursal = FormatUtils::getParam('cd_sucursal');        $dt_desde = FormatUtils::getParam('dt_desde');        $dt_hasta = FormatUtils::getParam('dt_hasta');        $orden = FormatUtils::getParam('orden', 'DESC');
		$campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault());


		$criterio = new CriterioBusqueda();

		if ($cd_usuario != "") {            $criterio->addFiltro('S.cd_usuario', $cd_usuario, "=");        }        if ($cd_sucursal != "") {            $criterio->addFiltro('U.cd_sucursal', $cd_sucursal, "=");        }        if ($cd_cliente != "") {            $criterio->addFiltro('S.cd_cliente', $cd_cliente, "=");        }        if ($dt_desde != "") {            $dt_desde = str_replace("/", "-", $dt_desde);            $dt_desde = implode("/", array_reverse(explode("-", $dt_desde)));            $criterio->addFiltro('S.dt_carga', "'$dt_desde 00:00:00'", ">=");        }        if ($dt_hasta != "") {            $dt_hasta = str_replace("/", "-", $dt_hasta);            $dt_hasta = implode("/", array_reverse(explode("-", $dt_hasta)));            $criterio->addFiltro('S.dt_carga', "'$dt_hasta 23:59:59'", "<=");        }

		//$this->addSelectedFiltro($criterio,$campoFiltro, $filtro);
		$criterio->addOrden($campoOrden, $orden);

		return $criterio;
	}

}