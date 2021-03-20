<?php
/**
 * Acción obtener productos ingresados de una obra utilizando Ajax.
 * 
 * @author Lucrecia
 * @since 27-04-2010
 *
 */
class GetProductosIngresadosAction extends SecureAjaxAction{

	
	/**
	 * se obtiene un tipo de producto seleccionado
	 * dentro de un combo.
	 */
	public function executeImpl(){
		
		$action = new IngresosDevolucionesReporteAction();	

		$cd_obra = $action->getCd_obra();
		$fechaDesde = FormatUtils::getParam('dt_fechaDesde');
		$fechaHasta = FormatUtils::getParam('dt_fechaHasta');
		$cd_remito = FormatUtils::getParam('cd_remito');
		$cd_trabajadorObra = $action->getCd_trabajadorObra();
		
		$campoOrden = FormatUtils::getParam('campoOrden','cd_producto');
		$orden = FormatUtils::getParam('orden','ASC');
		$page = FormatUtils::getParam('page',1);

		$criterio = new CriterioBusqueda();
		$criterio->addOrden($campoOrden, $orden);
		$criterio->setPage($page);
		$criterio->setRowPerPage(ROW_PER_PAGE);
		
		if(!empty($cd_obra))
			$criterio->addFiltro('cd_obra', $cd_obra, '=', new FormatValor() ); 
		if(!empty($fechaDesde))
			$criterio->addFiltro('RIO.dt_fecha', $fechaDesde, '>=', new FormatValorDate() ); 
		if(!empty($fechaHasta))
			$criterio->addFiltro('RIO.dt_fecha', $fechaHasta, '<=', new FormatValorDate() );
		if(!empty($cd_trabajadorObra))	
			$criterio->addFiltro('TObra.cd_trabajadorObra', $cd_trabajadorObra, '=', new FormatValor() ); 

		//de las salidas tomamos sólo las de los remitos con estado "Entregado".
		$criterio->addFiltro('RIO.cd_estado', ENTREGADO, '=', new FormatValor());
			
		$salidas = $action->getSalidas($criterio, $campoOrden, $orden, true );
		return  $salidas;		
	}
	
	public function getFuncion(){
		return null;
	}
	
}