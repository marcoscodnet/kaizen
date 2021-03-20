<?php 

/**
 * Acción para exportar a pdf el reporte de conciliación de consumos.
 * 
 * @author bernardo
 * @since 01-06-2010
 * 
 */
class PDFPiezasPorSucursalAction extends ExportPDFCollectionAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getOrientacion()
	 */
	protected function getOrientacion(){
		return "L";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getIListar()
	 */
	protected function getIListar(){
		return new PiezasPorSucursalListadoFactory();
	}
	 
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getTableModel($items)
	 */
	protected function getTableModel( ItemCollection  $items){
		return new PiezasPorSucursalTableModel( $items );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getCampoOrdenDefault()
	 */
	protected function getCampoOrdenDefault(){
		return 'ds_codigo';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
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
	
}