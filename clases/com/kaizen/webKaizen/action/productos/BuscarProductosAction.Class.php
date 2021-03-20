<?php

/**
 * Acci�n listar productos.
 * 
 * @author Lucrecia
 * @since 18-01-2011
 * 
 */
class BuscarProductosAction extends ListarAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getListarTableModel($items)
     */
    protected function getContenido() {

        parent::getContenido();
        $xtpl = $this->getXTemplate();
        $xtpl->assign('WEB_PATH', WEB_PATH);

        //recuperamos los par�metros.
        //$filtro = FormatUtils::getParam('filtro');
        $cd_tipounidad = FormatUtils::getParam('cd_tipounidad');
        $cd_marca = FormatUtils::getParam('cd_marca');
        $cd_modelo = FormatUtils::getParam('cd_modelo');
        $cd_color = FormatUtils::getParam('cd_color');

        //$page = $this->getPagePaginacion();
        //$orden = FormatUtils::getParam('orden', 'DESC');
        //$campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault());
        //$campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault());
        $xtpl->assign('campoOrden', $campoOrden);
        $xtpl->assign('orden', $orden);
        $xtpl->assign('campoFiltro', $campoFiltro);
        $xtpl->assign('filtro', $filtro);

        //armamos el query string (para la paginaci�n y la ordenaci�n).
        $query_string = $this->getQueryString($filtro, $campoFiltro) . "id=" . $_GET['id'] . "&";

        //obtenemos los elementos a mostrar.
        $criterio = $this->getCriterioBusqueda();
        $entidades = $this->getEntidadManager()->getEntidades($criterio);
        $num_rows = $this->getEntidadManager()->getCantidadEntidades($criterio);

        $this->tableModel = $this->getListarTableModel($entidades);

        //construimos el paginador.
        $oPaginador = $this->getPaginador($num_rows, $orden, $campoFiltro, $filtro, $campoOrden, $page);

        //t�tulo del listado.
        $xtpl->assign('titulo', $this->getTituloListado());
        $this->parseTipounidades($cd_tipounidad, $xtpl);
        $this->parseMarca($cd_marca, $xtpl);
        $this->parseModelo($cd_modelo, $xtpl);
        $this->parseColor($cd_color, $xtpl);

        //generamos el contenido.
        $content = $this->parseContenido($xtpl, $filtro, $oPaginador, $query_string, $entidades, $criterio);
        return $content;
    }

    protected function parseItem($xtpl, $entidad) {
        $xtpl->assign('cd_producto', $entidad->getCd_producto());
        $xtpl->assign('ds_producto', $entidad->getDs_producto());
    }

    protected function parseTipounidades($cd_selected='', XTemplate $xtpl) {
        $tipounidadManager = new TipounidadManager();
        $criterio = new CriterioBusqueda();
        $criterio->addOrden('ds_tipo_unidad');
        $tiposunidades = $tipounidadManager->getTiposunidades($criterio);

        foreach ($tiposunidades as $key => $tipounidad) {
            $xtpl->assign('ds_tipounidad', $tipounidad->getDs_tipounidad());
            $xtpl->assign('cd_tipounidad', FormatUtils::selected($tipounidad->getCd_tipounidad(), $cd_selected));
            $xtpl->parse('main.option_tipounidad');
        }
    }

    protected function parseMarca($cd_selected='', XTemplate $xtpl) {
        $marcaManager = new MarcaManager();
        $criterio = new CriterioBusqueda();
        $criterio->addOrden('ds_marca');
        $marcas = $marcaManager->getMarcas($criterio);

        foreach ($marcas as $key => $marca) {
            $xtpl->assign('ds_marca', $marca->getDs_marca());
            $xtpl->assign('cd_marca', FormatUtils::selected($marca->getCd_marca(), $cd_selected));
            $xtpl->parse('main.option_marca');
        }
    }

    protected function parseModelo($cd_selected='', XTemplate $xtpl) {
        $modeloManager = new ModeloManager();
        $criterio = new CriterioBusqueda();
        $criterio->addOrden('ds_modelo');
        $modelos = $modeloManager->getModelos($criterio);

        foreach ($modelos as $key => $modelo) {
            $xtpl->assign('ds_modelo', $modelo->getDs_modelo());
            $xtpl->assign('cd_modelo', FormatUtils::selected($modelo->getCd_modelo(), $cd_selected));
            $xtpl->parse('main.option_modelo');
        }
    }

    protected function parseColor($cd_selected='', XTemplate $xtpl) {
        //recupera y parsea pa�ses.
        $colorManager = new ColorManager();
        $criterio = new CriterioBusqueda();
        $colores = $colorManager->getColores($criterio);

        foreach ($colores as $key => $color) {
            $xtpl->assign('ds_color', $color->getDs_color());
            $xtpl->assign('cd_color', FormatUtils::selected($color->getCd_color(), $cd_selected));
            $xtpl->parse('main.option_color');
        }
    }

    protected function getListarTableModel(ItemCollection $items) {
        return new BuscarProductoTableModel($items);
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getOpciones()
     */
    protected function getOpciones() {
        $opciones = array();
        return $opciones;
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getFiltros()
     */
    protected function getFiltros() {
        $filtros[] = $this->buildFiltro('ds_tipo_unidad', $this->tableModel->getColumnName(1));
        $filtros[] = $this->buildFiltro('ds_marca', $this->tableModel->getColumnName(2));
        $filtros[] = $this->buildFiltro('ds_modelo', $this->tableModel->getColumnName(3));
        $filtros[] = $this->buildFiltro('ds_color', $this->tableModel->getColumnName(4));
        return $filtros;
    }

    protected function getXTemplate() {
        return new XTemplate(APP_PATH . 'productos/buscarproductos.html');
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#parseAcciones($xtpl, $item)
     */
    protected function parseAcciones(XTemplate $xtpl, $item) {

        //$this->parseAccionesDefault($xtpl, $item, $item->getCd_producto(), 'producto', 'producto');
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
     */
    public function getFuncion() {
        return "Listar producto";
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getEntidadManager()
     */
    protected function getEntidadManager() {
        return new ProductoManager();
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getCampoOrdenDefault()
     */
    protected function getCampoOrdenDefault() {
        return 'cd_producto';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getMsjError1()
     */
    protected function getMsjError1() {
        return 'No se pudo eliminar el producto. Verifique que no existan datos relacionados';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
     */
    protected function getTitulo() {
        return 'Buscar Productos';
    }

    protected function getUrlAccionListar() {
        return 'buscar_productos';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionExportarPdf()
     */
    protected function getUrlAccionExportarPdf() {
        return 'pdf_productos';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionExportarExcel()
     */
    protected function getUrlAccionExportarExcel() {
        return 'excel_productos';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getForwardError()
     */
    protected function getForwardError() {
        return 'buscar_productos_error';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/codnet/action/generic/SecureOutputAction#getMenuActivo()
     */
    protected function getMenuActivo() {
        return "Productos";
    }

    protected function getSecureLayout() {
        //el layuout ser� definido en la constante DEFAULT_SECURE_LAYOUT
        //instanciamos el layout por reflection.
        $oClass = new ReflectionClass(DEFAULT_POPUP_LAYOUT);
        $oLayout = $oClass->newInstance();

        return $oLayout;
    }

}