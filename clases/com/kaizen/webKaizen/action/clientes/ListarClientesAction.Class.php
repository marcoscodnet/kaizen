<?php 

/**
 * Acción listar clientes.
 * 
 * @author Lucrecia
 * @since 18-01-2011
 * 
 */
class ListarClientesAction extends ListarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getListarTableModel($items)
	 */
	protected function getListarTableModel( ItemCollection $items ){
		return new ClienteTableModel($items);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getOpciones()
	 */
	protected function getOpciones(){
		$opciones[]= $this->buildOpcion('altacliente', 'Agregar Cliente', 'alta_cliente_init');
		return $opciones;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getFiltros()
	 */
	protected function getFiltros(){
		$filtros[]= $this->buildFiltro('ds_apynom', $this->tableModel->getColumnName(1));
		return $filtros;
	}
	

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#parseAcciones($xtpl, $item)
	 */
	protected function parseAcciones(XTemplate $xtpl, $item){
		
		$this->parseAccionesDefault( $xtpl, $item, $item->getCd_cliente(), 'cliente', 'cliente' );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Listar Cliente";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getEntidadManager()
	 */
	protected function getEntidadManager(){		
		return new ClienteManager();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getCampoOrdenDefault()
	 */
	protected function getCampoOrdenDefault(){
		return 'ds_apynom';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getMsjError1()
	 */
	protected function getMsjError1(){
		return 'No se pudo eliminar el Cliente. Verifique que no existan datos relacionados';	
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return 'Administración de Clientes';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getCartelEliminar($entidad)
	 */
	protected function getCartelEliminar($entidad){
		$xtpl = new XTemplate ( APP_PATH .'/clientes/eliminarcliente.html' );
		$xtpl->assign ( 'cd_cliente', $entidad->getCd_cliente() );
		$xtpl->assign ( 'ds_apynom', stripslashes (  $entidad->getDs_apynom() ) );
		
		$xtpl->parse('main');
		return FormatUtils::quitarEnters( $xtpl->text('main') );
	}
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionListar()
	 */
	protected function getUrlAccionListar(){
		return 'listar_clientes';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionExportarPdf()
	 */
	protected function getUrlAccionExportarPdf(){
		return 'pdf_clientes';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionExportarExcel()
	 */
	protected function getUrlAccionExportarExcel(){
		return 'excel_clientes';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'listar_clientes_error';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getMenuActivo()
	 */
	protected function getMenuActivo(){
		return "Clientes";
	}
	

	
}