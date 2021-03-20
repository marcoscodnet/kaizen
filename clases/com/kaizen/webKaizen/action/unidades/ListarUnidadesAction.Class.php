<?php
/**
 * Acciï¿½n listar unidades.
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 */
class ListarUnidadesAction extends ListarAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getListarTableModel($items)
     */
    protected function getListarTableModel(ItemCollection $items) {
        return new UnidadTableModel($items);
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getOpciones()
     */
    protected function getOpciones() {
        $opciones[] = $this->buildOpcion('altaunidad', 'Agregar Unidad', 'alta_unidad_init');
        return $opciones;
    }

    protected function getFiltrosEspeciales() {
        $xtpl = new XTemplate(APP_PATH . 'unidades/criterio_unidades.html');
        $autorizada = FormatUtils::getParam('autorizada', null);
        $sinautorizar = FormatUtils::getParam('sinautorizar', null);
        if ($autorizada == 1) {
            $xtpl->assign('autorizada_checked', 'checked');
        }
        if ($sinautorizar == 1) {
            $xtpl->assign('sinautorizar_checked', 'checked');
        }

        $xtpl->parse('main');
        return $xtpl->text('main');
    }

    protected function getCriterioBusqueda() {
        //recuperamos los parï¿½metros.
        $filtro = FormatUtils::getParam('filtro');
        $campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault());

        $autorizadas = FormatUtils::getParam('autorizada', null);
        $sinautorizar = FormatUtils::getParam('sinautorizar', null);

        $page = $this->getPagePaginacion();
        $orden = FormatUtils::getParam('orden', 'DESC');
        $campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault());

        $criterio = new CriterioBusqueda();
        if ((($autorizadas == null) || ($autorizadas == "")) && (($sinautorizar != "") && ($sinautorizar != null))) {
            $criterio->addNull('cd_autorizacion');
        } elseif ((($sinautorizar == null) || ($sinautorizar == "")) && (($autorizadas != "") && ($autorizadas != null))) {
            $criterio->addNotNull('cd_autorizacion');
        }

        $this->addSelectedFiltro($criterio, $campoFiltro, $filtro);

        $criterio->addOrden($campoOrden, $orden);
        $criterio->setPage($page);
        $criterio->setRowPerPage(ROW_PER_PAGE);
        return $criterio;
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

    protected function parseAccionesDefault(XTemplate $xtpl, $entidad, $id, $nombre_entidad, $lbl_entidad=null, $ver=true, $modificar=true, $eliminar=true, $modificar_nroenvio = true) {

        if (empty($lbl_entidad))
            $lbl_entidad = $nombre_entidad;

        if ($ver) {
            $href = 'doAction?action=ver_' . $nombre_entidad . '&id=' . $id;
            $this->parseAccion($xtpl, '', $href, 'img/search.gif', 'detalles de ' . $lbl_entidad);
        }

        if ($modificar) {
            $href = 'doAction?action=modificar_' . $nombre_entidad . '_init&id=' . $id;
            $this->parseAccion($xtpl, '', $href, 'img/edit.gif', 'editar datos de ' . $lbl_entidad);
        }

        if ($modificar_nroenvio) {
            $href = 'doAction?action=modificar_nroenvio_init&id=' . $id;
            $this->parseAccion($xtpl, '', $href, 'img/edit_nroenvio.png', 'editar Nro envío de Unidad');
        }

        if ($eliminar) {
            $onclick = "javascript: confirmaEliminar('" . $this->getCartelEliminar($entidad) . "', this,'doAction?action=eliminar_" . $nombre_entidad . "&id=" . $id . "'); return false;";
            $this->parseAccion($xtpl, $onclick, '', 'img/del.gif', 'eliminar ' . $lbl_entidad);
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
        return "Listar unidad";
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
        return 'Administraci&oacute;n de Unidades';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getCartelEliminar($entidad)
     */
    protected function getCartelEliminar($entidad) {
        $xtpl = new XTemplate(APP_PATH . '/unidades/eliminarunidad.html');
        $xtpl->assign('cd_unidad', $entidad->getCd_unidad());
        $xtpl->assign('ds_producto', stripslashes($entidad->getDs_producto()));

        $xtpl->parse('main');
        return FormatUtils::quitarEnters($xtpl->text('main'));
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionListar()
     */
    protected function getUrlAccionListar() {
        return 'listar_unidades';
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
        return 'excel_unidades';
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
        return "Unidades";
    }

    protected function getRowClassImpar() {
        return "td_unidad";
    }

    protected function getRowClassPar() {
        return "td_unidad";
    }

}