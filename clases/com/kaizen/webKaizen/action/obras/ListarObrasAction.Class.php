<?php 

/**
 * Acción listar obras.
 * 
 * @author Lucrecia
 * @since 31-01-2011
 * 
 */
class ListarObrasAction extends ListarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getListarTableModel($items)
	 */
	protected function getListarTableModel( ItemCollection $items ){
		return new ObraTableModel($items);
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getOpciones()
	 */
	protected function getOpciones(){
		$opciones[]= $this->buildOpcion('altaobra', 'Agregar Obra', 'alta_obra_init');
		return $opciones;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getFiltros()
	 */
	protected function getFiltros(){
		$filtros[]= $this->buildFiltro('O.cd_obra', 'C&oacute;digo');
		$filtros[]= $this->buildFiltro('T.ds_tipoobra', 'Tipo de Obra');
		$filtros[]= $this->buildFiltro('O.nu_tipoobra', 'Nº Tipo de Obra');
		$filtros[]= $this->buildFiltro('S.ds_subtipoobra', 'Subtipo de Obra');
		$filtros[]= $this->buildFiltro('O.nu_subtipoobra', 'Nº Subtipo de Obra');
		$filtros[]= $this->buildFiltro('O.dt_fecha', 'Fecha de Inicio');
		$filtros[]= $this->buildFiltro('O.dt_fechacierre', 'Fecha de Cierre');
		return $filtros;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Listar obra";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getEntidadManager()
	 */
	protected function getEntidadManager(){		
		return new ObraManager();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getCampoOrdenDefault()
	 */
	protected function getCampoOrdenDefault(){
		return 'dt_fecha';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getMsjError1()
	 */
	protected function getMsjError1(){
		return 'No se pudo eliminar el Obra. <br /> <br /> Verifique que no existan datos relacionados';	
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return 'Administración de Obras';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getCartelEliminar($entidad)
	 */
	protected function getCartelEliminar($entidad){
		$xtpl = new XTemplate ( APP_PATH .'/obras/eliminarobra.html' );
		$xtpl->assign ( 'cd_obra', $entidad->getCd_obra() );
		$xtpl->assign ( 'dt_fecha', FuncionesComunes::fechaMysqlaPHP ( $entidad->getDt_fecha() ) );
		$xtpl->assign ( 'ds_titulo', stripslashes ( $entidad->getDs_titulo() ) ) ;
		$xtpl->assign ( 'ds_tipoObra', stripslashes ( $entidad->getDs_tipoObra() ) );
		$xtpl->assign ( 'ds_subtipoObra', stripslashes ( $entidad->getDs_subtipoObra() ) );
		$xtpl->parse('main');
		return FormatUtils::quitarEnters( $xtpl->text('main') );
	}
		
	
	protected function getCartelCerrarObra($entidad){
		$xtpl = new XTemplate ( APP_PATH .'/obras/cerrarobra.html' );
		$xtpl->assign ( 'cd_obra', $entidad->getCd_obra() );
		$xtpl->assign ( 'dt_fecha', FuncionesComunes::fechaMysqlaPHP ( $entidad->getDt_fecha() ) );
		$xtpl->assign ( 'ds_titulo', stripslashes ( $entidad->getDs_titulo() ) ) ;
		$xtpl->assign ( 'ds_tipoObra', stripslashes ( $entidad->getDs_tipoObra() ) );
		$xtpl->assign ( 'ds_subtipoObra', stripslashes ( $entidad->getDs_subtipoObra() ) );
		$xtpl->parse('main');
		return FormatUtils::quitarEnters( $xtpl->text('main') );
	}
		
	/**	
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionListar()
	 */
	protected function getUrlAccionListar(){
		return 'listar_obras';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionExportarPdf()
	 */
	protected function getUrlAccionExportarPdf(){
		return 'pdf_obras';
	}

	protected function getUrlAccionExportarExcel(){
		return 'excel_obras';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'listar_obras_error';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getMenuActivo()
	 */
	protected function getMenuActivo(){
		return "Obras";
	}
	

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#parseAcciones($xtpl, $item)
	 */
	protected function parseAcciones(XTemplate $xtpl, $item){

		$this->parseAccionesDefault( $xtpl, $item, $item->getCd_obra(), 'obra', 'obra');
		

		if(!$item->getBl_cerrada()){
			$onclick = "javascript: confirmaEliminar('" . $this->getCartelCerrarObra($item) . "', this,'doAction?action=cerrar_obra&id=" . $item->getCd_obra() . "'); return false;" ;
			$this->parseAccion( $xtpl, $onclick, '', 'img/psw.jpg' , 'cerrar obra');
		}
		
		$href =  'doAction?action=ver_trabajadores_obra&id=' . $item->getCd_obra() ;
		$this->parseAccion( $xtpl, '', $href, 'img/members.gif' , 'trabajadores de la obra');
		
	}
	
}