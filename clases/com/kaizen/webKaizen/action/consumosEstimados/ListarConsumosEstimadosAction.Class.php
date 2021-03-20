<?php 

/**
 * Acción listar consumos estimados de productos.
 * 
 * @author Lucrecia
 * @since 21-01-2011
 * 
 */
class ListarConsumosEstimadosAction extends ListarAction{
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getListarTableModel($items)
	 */
	protected function getListarTableModel( ItemCollection $items ){
		return new ConsumoEstimadoTableModel($items);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getOpciones()
	 */
	protected function getOpciones(){
		$opciones[]= $this->buildOpcion('altaconsumoestimado', 'Ingresar Consumo Cliente', 'alta_consumoEstimado_init');
		return $opciones;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getFiltros()
	 */
	protected function getFiltros(){
		$filtros[]= $this->buildFiltro('cd_consumo', 'Código Consumo');
		$filtros[]= $this->buildFiltro('dt_fecha', 'Fecha');
		$filtros[]= $this->buildFiltro('ds_nombre', 'Cliente');
		$filtros[]= $this->buildFiltro('O.cd_obra', 'Código Obra');
		return $filtros;
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#parseAcciones($xtpl, $item)
	 */
	protected function parseAcciones(XTemplate $xtpl, $item){
		
		$this->parseAccionesDefault( $xtpl, $item, $item->getCd_consumo(), 'consumoEstimado', 'consumo' );
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Listar ConsumoEstimado";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getEntidadManager()
	 */
	protected function getEntidadManager(){		
		$oManager =  new ConsumoEstimadoManager();
		return $oManager;
	}
	
	
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getCampoOrdenDefault()
	 */
	protected function getCampoOrdenDefault(){
		return 'cd_consumo';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getMsjError1()
	 */
	protected function getMsjError1(){
		$cd='';
		if (isset ( $_GET ['id'] ))
			$cd = $_GET ['id']; 
		
		return "No se pudo eliminar el Consumo con C&oacute;digo <b>$cd</b>. <br />Verifique que no existan datos relacionados";
	}
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return 'Consumo Clientes';
	}

	/**
	 * cartel de confirmaciï¿½n para eliminar.
	 * @param unknown_type $entidad
	 * @return unknown_type
	 */	
	protected function getCartelEliminar($entidad){
		$xtpl = new XTemplate ( APP_PATH .'/consumosEstimados/eliminarconsumoestimado.html' );
		$xtpl->assign ( 'cd_consumo', $entidad->getCd_consumo() );
		$xtpl->assign ( 'ds_cliente', stripslashes ( $entidad->getDs_cliente() ) );
		$xtpl->assign ( 'dt_fecha', FuncionesComunes::fechaMysqlaPHP ( $entidad->getDt_fecha() ) );
		$xtpl->parse('main');
		return FormatUtils::quitarEnters( $xtpl->text('main') );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionListar()
	 */
	protected function getUrlAccionListar(){
		return 'listar_consumosEstimados';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionExportarPdf()
	 */
	protected function getUrlAccionExportarPdf(){
		return 'pdf_consumosEstimados';
	}

	/**
	 * 
	 */
	protected function getUrlAccionExportarExcel(){
		return 'excel_consumosEstimados';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'listar_consumosEstimados_error';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getMenuActivo()
	 */
	protected function getMenuActivo(){
		return "Consumo Clientes";
	}

	
}