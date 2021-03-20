<?php

/**
 * Acción listar stock piezas.
 *
 * @author Ma. Jesús
 * @since 15-07-2011
 *
 */
class ListarStockPiezasAction extends ListarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getListarTableModel($items)
	 */
	protected function getListarTableModel( ItemCollection $items ){
		return new StockPiezaTableModel($items);
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getOpciones()
	 */
	protected function getOpciones(){
		$opciones[]= $this->buildOpcion('altastockpieza', 'Agregar Stock Pieza', 'alta_stockPieza_init');
		return $opciones;
	}

	/**	 * (non-PHPdoc)	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getFiltros()	 */	protected function getFiltros(){		$filtros[]= $this->buildFiltro('ds_codigo', $this->tableModel->getColumnName(1));		$filtros[]= $this->buildFiltro('ds_descripcion', $this->tableModel->getColumnName(2));				$filtros[]= $this->buildFiltro('ds_nombre', $this->tableModel->getColumnName(6));		return $filtros;	}

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
		/*if($sub_stock == 1){
			$criterio->addGroupBy("cd_producto");
			$criterio->addFiltroHaving("nu_stock_minimo", "stock_actual", ">=");
			}*/
		$this->addSelectedFiltro($criterio,$campoFiltro, $filtro);

		$criterio->addOrden($campoOrden, $orden);
		$criterio->setPage($page);
		$criterio->setRowPerPage(ROW_PER_PAGE);
		return $criterio;
	}

	/*protected function getFiltrosEspeciales(){
		$xtpl =  new XTemplate(APP_PATH .  'piezas/criterio_piezas.html');
		$sub_stock = FormatUtils::getParam('sub_stock', null);

		if($sub_stock ==1){
		$xtpl->assign('substock_checked', 'checked');
		}
		$xtpl->parse('main');
		return $xtpl->text('main');
		}*/

	protected function getUrlPaginador( $orden , $campoFiltro, $filtro, $campoOrden ){
		$url = 'doAction?action='. $this->getUrlAccionListar() . '&orden=' . $orden . '&campoFiltro=' . $campoFiltro . '&filtro=' . $filtro. '&campoOrden=' . $campoOrden.'&sub_stock='.$_GET['sub_stock'];
		return $url;
	}

    
	protected function parseAcciones(XTemplate $xtpl, $item){

		$this->parseAccionesDefault( $xtpl, $item, $item->getCd_stockPieza(), 'stockPieza', 'stockPieza' );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Listar stock pieza";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getEntidadManager()
	 */
	protected function getEntidadManager(){
		return new StockPiezaManager();
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getCampoOrdenDefault()
	 */
	protected function getCampoOrdenDefault(){
		return 'dt_ingreso';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getMsjError1()
	 */
	protected function getMsjError1(){
		return 'No se pudo eliminar el stock pieza. Verifique que no existan datos relacionados';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return 'Administración de Stock Piezas';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getCartelEliminar($entidad)
	 */
	protected function getCartelEliminar($entidad){
		$xtpl = new XTemplate ( APP_PATH .'/stockpiezas/eliminarstockpieza.html' );
		$xtpl->assign ( 'cd_stockpieza', $entidad->getCd_stockPieza() );
		$xtpl->assign ( 'ds_codigo', $entidad->getPieza()->getDs_codigo() );

		$xtpl->parse('main');
		return FormatUtils::quitarEnters( $xtpl->text('main') );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionListar()
	 */
	protected function getUrlAccionListar(){
		return 'listar_stockPiezas';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionExportarPdf()
	 */
	protected function getUrlAccionExportarPdf(){
		return 'pdf_stockpiezas';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionExportarExcel()
	 */
	protected function getUrlAccionExportarExcel(){
		return 'excel_stockpiezas';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'listar_stockpiezas_error';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getMenuActivo()
	 */
	protected function getMenuActivo(){
		return "Stock Piezas";
	}



}