<?php

/**
 * Acciï¿½n listar Pedidos.
 *
 * @author María Jesús
 * @since 5-09-2011
 *
 */
class ListarPedidosAction extends ListarAction {

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getListarTableModel($items)
	 */
	protected function getListarTableModel( ItemCollection $items ){
		return new PedidoTableModel($items);
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getOpciones()
	 */
	protected function getOpciones(){
		$opciones[]= $this->buildOpcion('altapedido', 'Agregar Pedido', 'alta_pedido_init');
		return $opciones;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getFiltros()
	 */
	protected function getFiltros(){
		$filtros[]= $this->buildFiltro('ds_estadopedido', $this->tableModel->getColumnName(4));
		$filtros[]= $this->buildFiltro('dt_pedido', $this->tableModel->getColumnName(0));
		$filtros[]= $this->buildFiltro('ds_codigo', $this->tableModel->getColumnName(1));
		$filtros[]= $this->buildFiltro('ds_pieza', $this->tableModel->getColumnName(2));
		return $filtros;
	}

	protected function getCriterioBusqueda(){
		//recuperamos los parï¿½metros.
		$filtro = FormatUtils::getParam('filtro');
		$campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault() );


		//$sub_stock = FormatUtils::getParam('sub_stock', null);
		$page = $this->getPagePaginacion();
		$orden = FormatUtils::getParam('orden','DESC');
		$campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault() );

		//obtenemos las entidades a mostrar.
		$criterio = new CriterioBusqueda();
		$this->addSelectedFiltro($criterio,$campoFiltro, $filtro);

		$criterio->addOrden($campoOrden, $orden);
		$criterio->setPage($page);
		$criterio->setRowPerPage(ROW_PER_PAGE);
		return $criterio;
	}

	protected function getUrlPaginador( $orden , $campoFiltro, $filtro, $campoOrden ){
		$url = 'doAction?action='. $this->getUrlAccionListar() . '&orden=' . $orden . '&campoFiltro=' . $campoFiltro . '&filtro=' . $filtro. '&campoOrden=' . $campoOrden.'&sub_stock='.$_GET['sub_stock'];
		return $url;
	}

	protected function parseAccionesDefault(XTemplate $xtpl, $entidad, $id, $nombre_entidad, $lbl_entidad=null, $ver=true, $formulario=true, $modificar = true, $estado=true, $boleto = true, $eliminar = true) {

        if (empty($lbl_entidad))
            $lbl_entidad = $nombre_entidad;
        if ($modificar) {
            $href = 'doAction?action=modificar_pedido_init&id=' . $id;
            $this->parseAccion($xtpl, '', $href, 'img/edit.gif', 'Modificar ' . $lbl_entidad);
        }

        if ($ver) {
            $href = 'doAction?action=ver_pedido&id=' . $id;
            $this->parseAccion($xtpl, '', $href, 'img/search.gif', 'detalles de ' . $lbl_entidad);
        }

        if ($eliminar) {
            $onclick = "javascript: confirmaEliminar('" . $this->getCartelEliminar($entidad) . "', this,'doAction?action=eliminar_pedido&id=" . $id . "'); return false;";
            $this->parseAccion($xtpl, $onclick, '', 'img/del.gif', 'eliminar Pedido');
        }
    }
    
    protected function parseAcciones(XTemplate $xtpl, $item){

		$this->parseAccionesDefault( $xtpl, $item, $item->getCd_pedido(), 'Pedido', 'Pedido' );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Listar pedido";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getEntidadManager()
	 */
	protected function getEntidadManager(){
		return new PedidoManager();
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getCampoOrdenDefault()
	 */
	protected function getCampoOrdenDefault(){
		return 'P.cd_pedido';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getMsjError1()
	 */
	protected function getMsjError1(){
		return 'No se pudo eliminar el pedido. Verifique que no existan datos relacionados';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return 'Administración de Pedidos';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getCartelEliminar($entidad)
	 */
	protected function getCartelEliminar($entidad){
		$xtpl = new XTemplate ( APP_PATH .'/pedidos/eliminarpedido.html' );
		$xtpl->assign ( 'cd_pedido', $entidad->getCd_pedido() );
		$xtpl->assign ( 'ds_pieza', $entidad->getPieza()->getDs_codigo() );

		$xtpl->parse('main');
		return FormatUtils::quitarEnters( $xtpl->text('main') );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionListar()
	 */
	protected function getUrlAccionListar(){
		return 'listar_pedidos';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionExportarPdf()
	 */
	protected function getUrlAccionExportarPdf(){
		return 'pdf_pedidos';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionExportarExcel()
	 */
	protected function getUrlAccionExportarExcel(){
		return 'excel_pedidos';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'listar_pedidos_error';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getMenuActivo()
	 */
	protected function getMenuActivo(){
		return "Pedidos";
	}



}