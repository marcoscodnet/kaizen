<?php 

/**
 * Acción listar tiposservicios.
 * 
 * @author Marcos
 * @since 15-05-2012
 * 
 */
class ListarTiposserviciosAction  extends ListarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/ListarAction#getListarTableModel($items)
	 */
	protected function getListarTableModel( ItemCollection $items ){
		return new TiposervicioTableModel($items);
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/ListarAction#getOpciones()
	 */
	protected function getOpciones(){
		$opciones[]= $this->buildOpcion('altatiposervicio', 'Agregar Tipo de servicio', 'alta_tiposervicio_init');
		return $opciones;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/ListarAction#getFiltros()
	 */
	protected function getFiltros(){
		$filtros[]= $this->buildFiltro('ds_tipo_servicio', $this->tableModel->getColumnName(1));
		return $filtros;
	}


	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/ListarAction#parseAcciones($xtpl, $item)
	 */
	protected function parseAcciones(XTemplate $xtpl, $item){

		$this->parseAccionesDefault( $xtpl, $item, $item->getCd_tiposervicio(), 'tiposervicio', 'tiposervicio' );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Listar Tipo de servicio";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/ListarAction#getEntidadManager()
	 */
	protected function getEntidadManager(){
		return new TiposervicioManager();
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/ListarAction#getCampoOrdenDefault()
	 */
	protected function getCampoOrdenDefault(){
		return 'ds_tipo_servicio';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/ListarAction#getMsjError1()
	 */
	protected function getMsjError1(){
		return 'No se pudo eliminar el Tipo de servicio. Verifique que no existan datos relacionados';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return 'Administración de Tipos de servicios';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/ListarAction#getCartelEliminar($entidad)
	 */
	protected function getCartelEliminar($entidad){
		$xtpl = new XTemplate ( APP_PATH .'/tiposservicios/eliminartiposervicio.html' );
		$xtpl->assign ( 'ds_tiposervicio', stripslashes( $entidad->getDs_tiposervicio() ) );
		$xtpl->assign ( 'cd_tiposervicio', stripslashes( $entidad->getCd_tiposervicio() ) );
		$xtpl->parse('main');
		return FormatUtils::quitarEnters( $xtpl->text('main') );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/ListarAction#getUrlAccionListar()
	 */
	protected function getUrlAccionListar(){
		return 'listar_tiposservicios';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/ListarAction#getUrlAccionExportarPdf()
	 */
	protected function getUrlAccionExportarPdf(){
		return 'pdf_tiposservicios';
	}
	
	protected function getUrlAccionExportarExcel(){
		return 'excel_tiposservicios';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/ListarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'listar_tiposservicios_error';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getMenuActivo()
	 */
	protected function getMenuActivo(){
		return "Tiposservicios";
	}



}