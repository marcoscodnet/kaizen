<?php 

/**
 * Acción para exportar a excel una colección de colores.
 * 
 * @author Lucrecia
 * @since 03-01-2011
 * 
 */
class ExcelColoresAction extends ExportExcelCollectionAction{

	
	protected function getIListar(){
		return new ColorManager();
	}
	 
	protected function getTableModel(ItemCollection $items){
		return new ColorTableModel($items);
	}
	
	protected function getCampoOrdenDefault(){
		return 'ds_nombre';
	}
	
	public function getFuncion(){
		return "Listar COlor";
	}

	protected function getTitulo(){
		return "Listado de Colores";
	}
	
	protected function getNombreArchivo(){
		return "colores";
	}	
}