<?php 

/**
 * Acción listar almacenes.
 * 
 * @author Lucrecia
 * @since 15-04-2010
 * 
 */
class ListarAlmacenesAction extends ListarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getListarTableModel($items)
	 */
	protected function getListarTableModel( ItemCollection $items ){
		return new AlmacenTableModel($items);
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getOpciones()
	 */
	protected function getOpciones(){
		$opciones[]= $this->buildOpcion('altaalmacen', 'Agregar Almac&eacute;n', 'alta_almacen_init');
		return $opciones;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getFiltros()
	 */
	protected function getFiltros(){
	 	$filtros[]= $this->buildFiltro('cd_almacen', 'C&oacute;digo');
		$filtros[]= $this->buildFiltro('ds_nombre', 'Nombre');
		return $filtros;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#parseAcciones($xtpl, $item)
	 */
	protected function parseAcciones(XTemplate $xtpl, $item){
		
		$this->parseAccionesDefault( $xtpl, $item, $item->getCd_almacen(), 'almacen', 'almac&eacute;n' );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Listar almacen";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getEntidadManager()
	 */
	protected function getEntidadManager(){		
		return new AlmacenManager();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getCampoOrdenDefault()
	 */
	protected function getCampoOrdenDefault(){
		return 'ds_nombre';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getMsjError1()
	 */
	protected function getMsjError1(){
		return 'No se pudo eliminar el Almac&eacute;n. Verifique que no existan datos relacionados';	
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return 'Administraci&oacute;n de Almacenes';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getCartelEliminar($entidad)
	 */
	protected function getCartelEliminar($entidad){
		$xtpl = new XTemplate ( APP_PATH .'/almacenes/eliminaralmacen.html' );
		$xtpl->assign ( 'cd_almacen', $entidad->getCd_almacen() );
		$xtpl->assign ( 'ds_nombre', stripslashes( htmlentities( $entidad->getDs_nombre() ) ) );
		$xtpl->parse('main');
		return FormatUtils::quitarEnters( $xtpl->text('main') );
	}
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionListar()
	 */
	protected function getUrlAccionListar(){
		return 'listar_almacenes';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionExportarPdf()
	 */
	protected function getUrlAccionExportarPdf(){
		return 'pdf_almacenes';
	}

	/**
	 * 
	 */
	protected function getUrlAccionExportarExcel(){
		return 'excel_almacenes';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'listar_almacenes_error';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getMenuActivo()
	 */
	protected function getMenuActivo(){
		return "Almacenes";
	}
		
}