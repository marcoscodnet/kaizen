<?php

/**
 * Acci�n para exportar a excel una colecci�n de servicios.
 *
 * @author Marcos
 * @since 22-05-2012
 *
 */
class ExcelServiciosAction extends ExportExcelCollectionAction {

	protected function getIListar() {
		return new ServicioManager();
	}

	protected function getTableModel(ItemCollection $items) {
		return new ServicioTableModel($items);
	}

	protected function getCampoOrdenDefault() {
		return 'dt_carga';
	}

	public function getFuncion() {
		return "Listar Servicio";
	}

	protected function getTitulo() {
		return "Listado de Servicios";
	}

	protected function getNombreArchivo() {
		return "Servicios";
	}

	protected function getFooter($entidades, CriterioBusqueda $criterio) {
		if($this->tienePermisoFuncion("Ver resumen de servicio")){
			 $servicios_manager = new ServicioManager();
			$xtpl = new XTemplate(APP_PATH . 'servicios/footer.html');
			 $xtpl->assign('total_servicios', $cant_servicios);
			$xtpl->parse('main');
			return $xtpl->text('main');
		}
	}

	protected function getCriterioBusqueda() {
		//recuperamos los par�metros.
		$filtro = FormatUtils::getParam('filtro');
		$campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault());

		$cd_cliente = FormatUtils::getParam('cd_cliente');


		$criterio = new CriterioBusqueda();

	if ($cd_usuario != "") {

		//$this->addSelectedFiltro($criterio,$campoFiltro, $filtro);
		$criterio->addOrden($campoOrden, $orden);

		return $criterio;
	}

}