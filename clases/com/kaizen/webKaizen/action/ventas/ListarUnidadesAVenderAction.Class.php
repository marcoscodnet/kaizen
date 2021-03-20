<?php

/**
 * Acci�n listar unidades.
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 */
class ListarUnidadesAVenderAction extends ListarAction {

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getListarTableModel($items)
	 */
	protected function getListarTableModel(ItemCollection $items) {
		return new UnidadTableModel($items);
	}

	protected function getXTemplate() {
		return new XTemplate(APP_PATH . 'ventas/listar_unidadesavender.html');
	}

	protected function getOpciones() {
		return array();
	}

	protected function getCartelEliminar($entidad) {
		return '';
	}

	protected function getFiltrosEspeciales(){
		$xtpl =  new XTemplate(APP_PATH .  'ventas/criterio_unidadesavender.html');

		$this->parseProductos($xtpl);
		
		$xtpl->parse('main');
		return $xtpl->text('main');
	}

	protected function parseProductos(XTemplate $xtpl) {
		$cd_producto = FormatUtils::getParam('cd_producto');
		$productoManager = new ProductoManager();
		$criterio = new CriterioBusqueda();
		$criterio->addOrden('ds_tipo_unidad, ds_marca, ds_modelo, ds_color');
		$productos = $productoManager->getProductos($criterio);
		foreach ($productos as $key => $producto) {
			$xtpl->assign('ds_producto', $producto->getDs_producto());
			$xtpl->assign('cd_producto', FormatUtils::selected($producto->getCd_producto(), $cd_producto));
			$xtpl->parse('main.option_producto');
		}
	}

	protected function getFiltros() {
		$filtros[] = $this->buildFiltro("ds_tipo_unidad", $this->tableModel->getColumnName(0));
        $filtros[] = $this->buildFiltro("ds_marca", $this->tableModel->getColumnName(1));
        $filtros[] = $this->buildFiltro("ds_modelo", $this->tableModel->getColumnName(2));
        $filtros[] = $this->buildFiltro("ds_color", $this->tableModel->getColumnName(3));
        $filtros[] = $this->buildFiltro("nu_cuadro", $this->tableModel->getColumnName(9));
        $filtros[] = $this->buildFiltro("nu_motor", $this->tableModel->getColumnName(8));
        $filtros[] = $this->buildFiltro("ds_nombre", $this->tableModel->getColumnName(4));
		return $filtros;
	}

	protected function parseAccionesDefault(XTemplate $xtpl, $entidad, $id, $nombre_entidad, $lbl_entidad=null, $ver=true, $modificar=true, $eliminar=true, $autorizar = true, $mover=true) {

		if (empty($lbl_entidad))
		$lbl_entidad = $nombre_entidad;

		if ($ver) {
			$href = 'doAction?action=ver_' . $nombre_entidad . '&id=' . $id;
			$this->parseAccion($xtpl, '', $href, 'img/search.gif', 'detalles de ' . $lbl_entidad);
		}

		if ($mover) {
			$href = 'doAction?action=alta_venta_init&id=' . $id;
			$this->parseAccion($xtpl, $onClick, $href, 'img/vender.png', 'Vender ' . $lbl_entidad);
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#parseAcciones($xtpl, $item)
	 */
	protected function parseAcciones(XTemplate $xtpl, $item) {

		$this->parseAccionesDefault($xtpl, $item, $item->getCd_unidad(), 'unidad', 'unidad');
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion() {
		return "Alta Venta";
	}

	protected function getCriterioBusqueda(){
		//recuperamos los par�metros.
		$filtro = FormatUtils::getParam('filtro');
		$campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault() );

		$cd_producto = FormatUtils::getParam('cd_producto');

		$page = $this->getPagePaginacion();
		$orden = FormatUtils::getParam('orden','DESC');
		$campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault() );


		$criterio = new CriterioBusqueda();

		$criterio->addFiltro("U.cd_unidad", "select V.cd_unidad from venta V", "NOT IN", new FormatValorIN());
		
		if ($cd_producto != "") {
			$criterio->addFiltro('P.cd_producto', $cd_producto, "=");
		}
		
		//$this->addSelectedFiltro($criterio,'P.cd_producto', $cd_producto);
		$this->addSelectedFiltro($criterio,$campoFiltro, $filtro);

		$criterio->addOrden($campoOrden, $orden);
		$criterio->setPage($page);
		$criterio->setRowPerPage(ROW_PER_PAGE);
		return $criterio;
	}


	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getEntidadManager()
	 */
	protected function getEntidadManager() {
		return new UnidadManager();
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getCampoOrdenDefault()
	 */
	protected function getCampoOrdenDefault() {
		return 'U.cd_unidad';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getMsjError1()
	 */
	protected function getMsjError1() {
		return 'No se pudo eliminar el Unidad. Verifique que no existan datos relacionados';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo() {
		return 'Listar unidades a vender';
	}

	protected function getUrlAccionListar() {
		return 'listar_unidades_a_vender';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionExportarPdf()
	 */
	protected function getUrlAccionExportarPdf() {
		return 'pdf_unidades';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionExportarExcel()
	 */
	protected function getUrlAccionExportarExcel() {
		return 'excel_unidades_a_vender';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getForwardError()
	 */
	protected function getForwardError() {
		return 'listar_unidades_error';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getMenuActivo()
	 */
	protected function getMenuActivo() {
		return "Ventas";
	}

	    protected function getContenido() {

        $xtpl = $this->getXTemplate();
        $xtpl->assign('WEB_PATH', WEB_PATH);

        //recuperamos los par�metros.
        $filtro = FormatUtils::getParam('filtro');

        $page = $this->getPagePaginacion();

        $cd_producto = FormatUtils::getParam('cd_producto');
        $orden = FormatUtils::getParam('orden', 'DESC');

        $campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault());

        $campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault());
        $xtpl->assign('campoOrden', $campoOrden);
        $xtpl->assign('accion_listar', $this->getUrlAccionListar());
        $xtpl->assign('orden', $orden);
        $xtpl->assign('campoFiltro', $campoFiltro);
        $xtpl->assign('filtro', $filtro);
        $xtpl->assign('cd_producto', $cd_producto);


        //t�tulo del listado.
        $xtpl->assign('titulo', $this->getTituloListado());

        //armamos el query string (para la paginaci�n y la ordenaci�n).
        $query_especial = "&cd_producto=$cd_producto&";
        $query_string = $this->getQueryString($filtro, $campoFiltro) . "id=" . $_GET['id'] . $query_especial;

        //obtenemos los elementos a mostrar.
        $criterio = $this->getCriterioBusqueda();

        try {

            $entidades = $this->getEntidadManager()->getEntidades($criterio);
            $num_rows = $this->getEntidadManager()->getCantidadEntidades($criterio);
        } catch (GenericException $ex) {
            //capturamos la excepci�n para terminar de parsear el contenido y luego la volvemos a lanzar para mostrar el error.
            $entidades = new ItemCollection();
            $num_rows = 0;
            $this->getLayoutInstance()->setException($ex);
        }


        $this->tableModel = $this->getListarTableModel($entidades);

        //construimos el paginador.
        $oPaginador = $this->getPaginador($num_rows, $orden, $campoFiltro, $filtro, $campoOrden, $query_especial, $page);



        //generamos el contenido.
        $content = $this->parseContenido($xtpl, $filtro, $oPaginador, $query_string, $entidades, $criterio);

        return $content;
    }

    protected function getPaginador($num_rows, $orden, $campoFiltro, $filtro, $campoOrden, $query_especial, $page){
		$num_pages = ceil ( $num_rows / ROW_PER_PAGE );

		//$url = 'index.php?orden=' . $orden . '&campo=' . $campo . '&filtro=' . $filtro;
		$url = $this->getUrlPaginador( $orden, $campoFiltro, $filtro, $campoOrden, $query_especial );
		$cssclassotherpage = 'paginadorOtraPagina';
		$cssclassactualpage = 'paginadorPaginaActual';
		$ds_pag_anterior = 0; //$gral['pag_ant'];
		$ds_pag_siguiente = 2; //$gral['pag_sig'];
		return new Paginador ( $url, $num_pages, $page, $cssclassotherpage, $cssclassactualpage, $num_rows );
	}

	protected function getUrlPaginador( $orden , $campoFiltro, $filtro, $campoOrden, $query_especial ){
		$url = 'doAction?action='. $this->getUrlAccionListar() . '&orden=' . $orden . '&campoFiltro=' . $campoFiltro . '&filtro=' . $filtro. '&campoOrden=' . $campoOrden. $query_especial;
		return $url;
	}
	
}