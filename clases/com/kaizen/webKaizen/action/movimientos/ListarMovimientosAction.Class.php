<?php

/**
 * Acci�n listar Movimientos.
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 */
class ListarMovimientosAction extends ListarAction {

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getListarTableModel($items)
	 */
	protected function getListarTableModel(ItemCollection $items) {
		unset($_SESSION['unidadesamover']);
		return new MovimientoTableModel($items);
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getOpciones()
	 */
	protected function getOpciones() {
		$opciones[] = $this->buildOpcion('altaMovimiento', 'Agregar Movimiento', 'alta_movimiento_init');
		return $opciones;
	}


	protected function getFiltrosEspeciales(){
		$xtpl =  new XTemplate(APP_PATH .  'movimientos/criterio_movimientos.html');
		$usuarioManager = new UsuarioManager();
		$criterio = new CriterioBusqueda();
		$usuarios = $usuarioManager->getUsuarios($criterio);
		$cd_usuario_selected = FormatUtils::getParam('cd_usuario', null);
		foreach ($usuarios as $usuario){
			$xtpl->assign('cd_usuario', FormatUtils::selected($usuario->getCd_usuario(), $cd_usuario_selected));
			$xtpl->assign('ds_nomusuario', $usuario->getDs_nomusuario());
			$xtpl->parse('main.option_usuarios');
		}
		$xtpl->parse('main');
		return $xtpl->text('main');
	}



	protected function getCriterioBusqueda(){
		//recuperamos los par�metros.
		$filtro = FormatUtils::getParam('filtro');
		$campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault() );

		$cd_usuario = FormatUtils::getParam('cd_usuario', null);

		$page = $this->getPagePaginacion();
		$orden = FormatUtils::getParam('orden','DESC');
		$campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault() );


		$criterio = new CriterioBusqueda();
		if($cd_usuario!=null && $cd_usuario!=""){
			$this->addSelectedFiltro($criterio,'U.cd_usuario', $cd_usuario);
		}
		$this->addSelectedFiltro($criterio,$campoFiltro, $filtro);

		$criterio->addOrden($campoOrden, $orden);
		$criterio->setPage($page);
		$criterio->setRowPerPage(ROW_PER_PAGE);
		return $criterio;
	}
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getFiltros()
	 */
	protected function getFiltros() {
		$filtros[] = $this->buildFiltro("SO.ds_nombre", $this->tableModel->getColumnName(2));
		$filtros[] = $this->buildFiltro("SD.ds_nombre", $this->tableModel->getColumnName(3));
		$filtros[] = $this->buildFiltro("dt_movimiento", $this->tableModel->getColumnName(4));
		return $filtros;
	}

	protected function parseAccionesDefault(XTemplate $xtpl, $entidad, $id, $nombre_entidad, $lbl_entidad=null, $ver=true, $remito=true, $autorizar = true, $eliminar = true) {

		if (empty($lbl_entidad))
		$lbl_entidad = $nombre_entidad;

		if ($ver) {
			$href = 'doAction?action=ver_movimiento&id=' . $id;
			$this->parseAccion($xtpl, '', $href, 'img/search.gif', 'detalles de ' . $lbl_entidad);
		}
		if ($remito) {
			$href = 'doAction?action=pdf_detalle_movimiento&id=' . $id;
			$this->parseAccion($xtpl, '', $href, 'img/pdf.png', 'detalles de ' . $lbl_entidad);
		}
		if($eliminar){
			$onclick = "javascript: confirmaEliminar('" . $this->getCartelEliminar($lbl_entidad) . "', this,'doAction?action=eliminar_movimiento&id=" . $id . "'); return false;" ;
			$this->parseAccion( $xtpl, $onclick, '', 'img/del.gif' , 'eliminar '  . $lbl_entidad);
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#parseAcciones($xtpl, $item)
	 */
	protected function parseAcciones(XTemplate $xtpl, $item) {

		$this->parseAccionesDefault($xtpl, $item, $item->getCd_Movimiento(), 'Movimiento', 'Movimiento');
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion() {
		return "Listar Movimiento";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getEntidadManager()
	 */
	protected function getEntidadManager() {
		return new MovimientoManager();
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getCampoOrdenDefault()
	 */
	protected function getCampoOrdenDefault() {
		return 'M.cd_Movimiento';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getMsjError1()
	 */
	protected function getMsjError1() {
		return 'No se pudo eliminar el Movimiento. Verifique que no existan datos relacionados';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo() {
		return 'Administraci&oacute;n de Movimientos';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getCartelEliminar($entidad)
	 */

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionListar()
	 */
	protected function getUrlAccionListar() {
		return 'listar_movimientos';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionExportarPdf()
	 */
	protected function getUrlAccionExportarPdf() {
		return 'pdf_movimientos';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionExportarExcel()
	 */
	protected function getUrlAccionExportarExcel() {
		return 'excel_movimientos';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getForwardError()
	 */
	protected function getForwardError() {
		return 'listar_movimientos_error';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getMenuActivo()
	 */
	protected function getMenuActivo() {
		return "Movimientos";
	}

}