<?php 

/**
 * Acción para exportar a excel el reporte de conciliación de consumos.
 * 
 * @author bernardo
 * @since 04-06-2010
 * 
 */
class ExcelPiezasPorSucursalAction extends ExportExcelCollectionAction{

	
	protected function getIListar(){
		return new PiezasPorSucursalListadoFactory();
	}
	 
	protected function getTableModel( ItemCollection  $items){
		return new PiezasPorSucursalTableModel( $items );
	}
	
	protected function getCampoOrdenDefault(){
		return 'ds_codigo';
	}
	
	public function getFuncion(){
		return "Listar pieza";
	}
	
	/**
	 * criterio de búsqueda para filtrar el listado.
	 * @return unknown_type
	 */
	protected function getCriterioBusqueda(){
		//recuperamos los parámetros.				
		$campoOrden = FormatUtils::getParam('campoOrden', 'ds_codigo' );
		$filtro = FormatUtils::getParam('filtro', '' );
		
	
		
		$criterio = new CriterioBusqueda();
		$criterio->addOrden($campoOrden, $orden);
		$criterio->addFiltro('S.ds_nombre', $filtro, 'LIKE', new FormatValorLike());
			
		return $criterio;
	}
	
	public function getTitulo(){
		$filtro = FormatUtils::getParam('filtro', '' );
	
		return 'Piezas por sucursal - Sucursal: ' . $filtro ;
	}
	
	public function getNombreArchivo(){
		return "piezas_por_sucursal";
	}
	
}