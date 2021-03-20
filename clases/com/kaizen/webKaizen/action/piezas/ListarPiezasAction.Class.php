<?php

/**
 * Acciï¿½n listar piezas.
 *
 * @author Ma. Jesï¿½s
 * @since 18-06-2011
 *
 */
class ListarPiezasAction extends ListarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getListarTableModel($items)
	 */
	protected function getListarTableModel( ItemCollection $items ){
		return new PiezaTableModel($items);
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getOpciones()
	 */
	protected function getOpciones(){
		$opciones[]= $this->buildOpcion('altapieza', 'Agregar Pieza', 'alta_pieza_init');
		return $opciones;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getFiltros()
	 */
	protected function getFiltros(){
		$filtros[]= $this->buildFiltro('ds_codigo', $this->tableModel->getColumnName(0));
		$filtros[]= $this->buildFiltro('ds_descripcion', $this->tableModel->getColumnName(1));				$filtros[]= $this->buildFiltro('sub_stock', "Debajo del min.");				$filtros[]= $this->buildFiltro('por_sucursal', "Por Sucursal");
		return $filtros;
	}

	protected function getCriterioBusqueda(){
		//recuperamos los parï¿½metros.
		$filtro = FormatUtils::getParam('filtro');
		$campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault() );


		
		$page = $this->getPagePaginacion();
		$orden = FormatUtils::getParam('orden','DESC');
		$campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault() );

		//obtenemos las entidades a mostrar.
		$criterio = new CriterioBusqueda();		
		if($campoFiltro == "sub_stock"){
						$criterio->addFiltro("nu_stock_minimo", "nu_stock_actual", ">");
			}												elseif($campoFiltro == "por_sucursal"){			header('location:'. WEB_PATH . 'doAction?action=reporte_piezasporsucursal&filtro='.$filtro);						}												else		 $this->addSelectedFiltro($criterio,$campoFiltro, $filtro);		

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

		$this->parseAccionesDefault( $xtpl, $item, $item->getCd_pieza(), 'pieza', 'pieza' );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Listar pieza";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getEntidadManager()
	 */
	protected function getEntidadManager(){
		return new PiezaManager();
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getCampoOrdenDefault()
	 */
	protected function getCampoOrdenDefault(){
		return 'ds_codigo';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getMsjError1()
	 */
	protected function getMsjError1(){
		return 'No se pudo eliminar la pieza. Verifique que no existan datos relacionados';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return 'Administración de Piezas';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getCartelEliminar($entidad)
	 */
	protected function getCartelEliminar($entidad){
		$xtpl = new XTemplate ( APP_PATH .'/piezas/eliminarpieza.html' );
		$xtpl->assign ( 'cd_pieza', $entidad->getCd_pieza() );
		$xtpl->assign ( 'ds_codigo', $entidad->getDs_codigo() );

		$xtpl->parse('main');
		return FormatUtils::quitarEnters( $xtpl->text('main') );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionListar()
	 */
	protected function getUrlAccionListar(){
		return 'listar_piezas';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionExportarPdf()
	 */
	protected function getUrlAccionExportarPdf(){
		return 'pdf_piezas';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionExportarExcel()
	 */
	protected function getUrlAccionExportarExcel(){
		return 'excel_piezas';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'listar_piezas_error';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getMenuActivo()
	 */
	protected function getMenuActivo(){
		return "Piezas";
	}



}