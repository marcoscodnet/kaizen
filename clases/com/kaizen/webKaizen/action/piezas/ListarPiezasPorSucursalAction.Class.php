<?php 

/**
 * Reporte de piezas por sucursal.
 *  
 * @author marcos
 * @since 29-02-2012
 * 
 */
class ListarPiezasPorSucursalAction extends ReporteAction{
		

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
		$xtpl = new XTemplate(APP_PATH. 'piezas/criterio_piezas.html');
		$xtpl->assign('WEB_PATH', WEB_PATH);
		
		$xtpl->assign('ds_nombre', $this->getDs_nombre() );
		
		
		
		
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
		$filtro = FormatUtils::getParam('filtro', '' );
		
	
		
		$criterio = new CriterioBusqueda();
		$criterio->addOrden($campoOrden, $orden);
		$criterio->addFiltro('S.ds_nombre', $filtro, 'LIKE', new FormatValorLike());
		$criterio->setPage($page);
		$criterio->setRowPerPage(10000);
				
		 
		
			
		$listados->addItem( $this-> getPiezasPorSucursal( $criterio, $campoOrden, $orden ) );
			
		return $listados;
	}

	
	/**
	 * se obtiene el listado parseado de conciliación de consumos.
	 * @return unknown_type
	 */
	public function getPiezasPorSucursal(CriterioBusqueda $criterio, $campoOrden=null, $orden=null){
		
		$factory = new PiezasPorSucursalListadoFactory();
		return $factory->getContenido($criterio, $campoOrden, $orden);
	}

	public function getFuncion(){
		return "Listar pieza";
	}
	
	protected function getTitulo(){
		return "Piezas por sucursal";
	}
	
	protected function getMenuActivo(){

		return "Piezas";

	}
				
public function getDs_nombre(){
		if (isset ( $_GET ['filtro'] )) 
			$ds_nombre = $_GET ['filtro'];
			
		if(empty($ds_nombre)){
			if (isset ( $_GET ['id'] ))
				$ds_nombre = $_GET ['id'];
		}

		return $ds_nombre;	
	}
	
				
	
	
	
}