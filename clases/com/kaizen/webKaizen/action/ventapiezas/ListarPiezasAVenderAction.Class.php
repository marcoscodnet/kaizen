<?php

/**
 * Acci�n listar unidades.
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 */
class ListarPiezasAVenderAction extends ListarAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getListarTableModel($items)
     */
    protected function getListarTableModel(ItemCollection $items) {
        return new PiezaTableModel($items);
    }

    protected function getXTemplate() {
        return new XTemplate(APP_PATH . 'ventaspiezas/listar_piezasavender.html');
    }

    protected function getOpciones() {
        return array();
    }

    protected function getCartelEliminar($entidad) {
        return '';
    }
    
	protected function getFiltrosEspeciales(){
		$xtpl =  new XTemplate(APP_PATH .  'ventaspiezas/criterio_piezasavender.html');
		
		$conNumero = FormatUtils::getParam('chk_conNumero','off');
		if($conNumero!='off')
			$xtpl->assign('checked',"checked='checked'");
		$xtpl->parse('main');
		return $xtpl->text('main');
	}

    protected function getFiltros() {
        $filtros[] = $this->buildFiltro("ds_tipo_unidad", $this->tableModel->getColumnName(1));
        $filtros[] = $this->buildFiltro("ds_marca", $this->tableModel->getColumnName(2));
        $filtros[] = $this->buildFiltro("ds_modelo", $this->tableModel->getColumnName(3));
        $filtros[] = $this->buildFiltro("ds_color", $this->tableModel->getColumnName(4));
        return $filtros;
    }

    protected function parseAccionesDefault(XTemplate $xtpl, $entidad, $id, $nombre_entidad, $lbl_entidad=null, $ver=true, $modificar=true, $eliminar=true, $autorizar = true, $mover=true) {

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

        if ($eliminar) {
            $onclick = "javascript: confirmaEliminar('" . $this->getCartelEliminar($entidad) . "', this,'doAction?action=eliminar_" . $nombre_entidad . "&id=" . $id . "'); return false;";
            $this->parseAccion($xtpl, $onclick, '', 'img/del.gif', 'eliminar ' . $lbl_entidad);
        }

        if ($mover) {
            $href = 'doAction?action=alta_ventapieza_init&id=' . $id;
            $onClick = "moverUnidad('doAction?action=alta_ventapieza_init&id=" . $id . "');return false;\"";
            $this->parseAccion($xtpl, $onClick, $href, 'img/mover.png', 'Vender pieza de sucursal' . $lbl_entidad);
        }
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#parseAcciones($xtpl, $item)
     */
    protected function parseAcciones(XTemplate $xtpl, $item) {

        $this->parseAccionesDefault($xtpl, $item, $item->getCd_unidad(), 'pieza', 'pieza');
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
     */
    public function getFuncion() {
        return "Alta Venta Pieza";
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getEntidadManager()
     */
    protected function getEntidadManager() {
        return new PiezaManager();
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getCampoOrdenDefault()
     */
    protected function getCampoOrdenDefault() {
        return 'P.cd_pieza';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getMsjError1()
     */
    protected function getMsjError1() {
        return 'No se pudo eliminar la Pieza. Verifique que no existan datos relacionados';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
     */
    protected function getTitulo() {
        return 'Listar piezas a vender';
    }

    protected function getUrlAccionListar() {
        return 'listar_piezasavender';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionExportarPdf()
     */
    protected function getUrlAccionExportarPdf() {
        return 'pdf_piezas';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionExportarExcel()
     */
    protected function getUrlAccionExportarExcel() {
        return 'excel_piezas';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getForwardError()
     */
    protected function getForwardError() {
        return 'listar_piezas_error';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/codnet/action/generic/SecureOutputAction#getMenuActivo()
     */
    protected function getMenuActivo() {
        return "Piezas";
    }

}