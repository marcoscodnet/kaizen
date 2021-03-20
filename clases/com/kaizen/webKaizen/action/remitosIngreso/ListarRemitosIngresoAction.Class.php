<?php 

/**
 * Acción listar remitos de ingreso.
 * 
 * @author Lucrecia
 * @since 30-01-2011
 * 
 */
class ListarRemitosIngresoAction extends ListarAction{

		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getListarTableModel($items)
	 */
	protected function getListarTableModel( ItemCollection $items ){
		return new RemitoIngresoTableModel($items);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getOpciones()
	 */
	protected function getOpciones(){
		$opciones[]= $this->buildOpcion('altaremitoingreso', 'Ingresar Materiales', 'alta_remitoIngreso_init');
		return $opciones;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getFiltros()
	 */
	protected function getFiltros(){
		$filtros[]= $this->buildFiltro('cd_remito', 'N&deg; remito ingreso');
		$filtros[]= $this->buildFiltro('dt_fecha', 'Fecha');
		$filtros[]= $this->buildFiltro('ds_razonSocial', 'Proveedor');
		$filtros[]= $this->buildFiltro('ds_tiporemitoingreso', 'Tipo comprobante proveedor');
		$filtros[]= $this->buildFiltro('nu_numero', 'N&deg; comprobante proveedor');
		return $filtros;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#parseAcciones($xtpl, $item)
	 */
	protected function parseAcciones(XTemplate $xtpl, $item){
		
		$this->parseAccionesDefault( $xtpl, $item, $item->getCd_remito(), 'remitoIngreso', 'remito' );
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Listar remitoIngreso";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getEntidadManager()
	 */
	protected function getEntidadManager(){		
		$oManager =  new RemitoIngresoManager();
		return $oManager;
	}
	
	
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getCampoOrdenDefault()
	 */
	protected function getCampoOrdenDefault(){
		return 'cd_remito';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getMsjError1()
	 *
	protected function getMsjError1(){
		$cd='';
		if (isset ( $_GET ['id'] ))
			$cd = $_GET ['id']; 
		
		return "No se pudo eliminar el Remito N&deg; <b>$cd</b>. <br />Verifique que no existan datos relacionados";
	}*/
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return 'Remitos de Ingreso';
	}

	/**
	 * cartel de confirmación para eliminar.
	 * @param unknown_type $entidad
	 * @return unknown_type
	 */	
	protected function getCartelEliminar($entidad){
		$xtpl = new XTemplate ( APP_PATH .'/remitosIngreso/eliminarremitoingreso.html' );
		$xtpl->assign ( 'cd_remito', $entidad->getCd_remito() );
		$xtpl->assign ( 'ds_proveedor', stripslashes ( $entidad->getDs_proveedor() ) );
		$xtpl->assign ( 'dt_fecha', FuncionesComunes::fechaMysqlaPHP ( $entidad->getDt_fecha() ) );
		$xtpl->parse('main');
		return FormatUtils::quitarEnters( $xtpl->text('main') );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionListar()
	 */
	protected function getUrlAccionListar(){
		return 'listar_remitosIngreso';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionExportarPdf()
	 */
	protected function getUrlAccionExportarPdf(){
		return 'pdf_remitosIngreso';
	}

	protected function getUrlAccionExportarExcel(){
		return 'excel_remitosIngreso';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'listar_remitosIngreso_error';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getMenuActivo()
	 */
	protected function getMenuActivo(){
		return "Remitos de Ingreso";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getCriterioBusqueda()
	 */
	protected function getCriterioBusqueda(){
		$criterio = parent::getCriterioBusqueda();
		
		//le agregamos el chequeo por número.
		$conNumero = FormatUtils::getParam('chk_conNumero','off');
		if($conNumero!='off')
			$criterio->addNotNull('nu_reserva');
				
		return $criterio;
	}	
	
}