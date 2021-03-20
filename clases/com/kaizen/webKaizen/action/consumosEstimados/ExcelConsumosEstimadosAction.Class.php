<?php 

/**
 * Acción para exportar a excel una colección de consumos estimados.
 * 
 * @author Lucrecia
 * @since 03-01-2011
 * 
 */
class ExcelConsumosEstimadosAction extends ExportExcelCollectionAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getIListar()
	 */
	protected function getIListar(){
		return new ConsumoEstimadoManager();
	}
	 
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getTableModel($items)
	 */
	protected function getTableModel(ItemCollection $items){
		return new ConsumoEstimadoTableModel($items);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getCampoOrdenDefault()
	 */
	protected function getCampoOrdenDefault(){
		return 'cd_consumo';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Listar ConsumoEstimado";
	}
	
	protected function getTitulo(){
		return "Listado de Consumos estimados";
	}
	
	protected function getNombreArchivo(){
		return "consumos_estimados";
	}	
}