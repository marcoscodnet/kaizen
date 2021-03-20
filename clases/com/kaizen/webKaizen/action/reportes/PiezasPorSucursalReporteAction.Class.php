<?php 

/**
 * Reporte de piezas por sucursal.
 *  
 * @author marcos
 * @since 29-02-2012
 * 
 */
class PiezasPorSucursalReporteAction extends ReporteAction{
		

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ReporteAction#getAccionReporte()
	 */
	protected function getAccionReporte(){
		return 'reporte_piezasporsucursal';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ReporteAction#getAccionReportePDF()
	 */
	protected function getAccionReportePDF(){
		return 'pdf_reporte_piezasporsucursal'; 
	}
	
	protected function getAccionReporteExcel(){
		return 'excel_reporte_piezasporsucursal'; 
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ReporteAction#getCriterioBusqueda()
	 */
	protected function getCriterioBusqueda(){
		$xtpl = new XTemplate(APP_PATH. 'reportes/criterio_conciliacion.html');
		$xtpl->assign('WEB_PATH', WEB_PATH);
		$xtpl->assign('id', $this->getCd_obra() );
		
		
		$xtpl->parse('main');
		return $xtpl->text('main');
	}
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ReporteAction#getListados()
	 */
	protected function getListados(){
		$listados = new ItemCollection();

		$page = FormatUtils::getParam('page',1);
		$orden = FormatUtils::getParam('orden','DESC');
		$campoOrden = FormatUtils::getParam('campoOrden', 'ds_codigo' );
		

		
		$criterio = new CriterioBusqueda();
		$criterio->addOrden($campoOrden, $orden);
		/*$criterio->setPage($page);
		$criterio->setRowPerPage(ROW_PER_PAGE);*/
				
	
			
		$listados->addItem( $this-> getConciliacionConsumo( $criterio, $campoOrden, $orden ) );
			
		return $listados;
	}

	
	/**
	 * se obtiene el listado parseado de conciliación de consumos.
	 * @return unknown_type
	 */
	public function getConciliacionConsumo(CriterioBusqueda $criterio, $campoOrden=null, $orden=null){
		$factory = new ConciliacionConsumoListadoFactory();
		return $factory->getContenido($criterio, $campoOrden, $orden);
	}

	public function getFuncion(){
		return "Reporte ConciliacionConsumo";//TODO
	}
	
	protected function getTitulo(){
		return "Conciliación de Consumos";
	}
	
	public function getCd_obra(){
		if (isset ( $_GET ['cd_obra'] )) 
			$cd_obra = $_GET ['cd_obra'];
			
		if(empty($cd_obra)){
			if (isset ( $_GET ['id'] ))
				$cd_obra = $_GET ['id'];
		}

		return $cd_obra;	
	}
				
	
	
				
	
	
	
}