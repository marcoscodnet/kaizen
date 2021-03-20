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
			 $servicios_manager = new ServicioManager();
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
		$campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault());


		$criterio = new CriterioBusqueda();

		if ($cd_usuario != "") {

		//$this->addSelectedFiltro($criterio,$campoFiltro, $filtro);
		$criterio->addOrden($campoOrden, $orden);

		return $criterio;
	}

}