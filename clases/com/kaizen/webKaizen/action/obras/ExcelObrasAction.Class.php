<?php 

/**
 * Acción para exportar a excel una colección de obras.
 * 
 * @author Lucrecia
 * @since 03-01-2011
 * 
 */
class ExcelObrasAction extends ExportExcelCollectionAction{

	protected function getIListar(){
		return new ObraManager();
	}
	 
	protected function getTableModel(ItemCollection $items){
		return new ObraTableModel($items);
	}
	
	protected function getCampoOrdenDefault(){
		return 'dt_fecha';
	}
	
	public function getFuncion(){
		return "Listar Obra";
	}

	protected function getTitulo(){
		return "Listado de Obras";
	}
	
	protected function getNombreArchivo(){
		return "obras";
	}
}