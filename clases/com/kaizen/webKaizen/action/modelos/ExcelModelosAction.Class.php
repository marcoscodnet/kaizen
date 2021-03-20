<?php 

/**
 * Acción para exportar a excel una colección de colores.
 * 
 * @author Lucrecia
 * @since 03-01-2011
 * 
 */
class ExcelModelosAction extends ExportExcelCollectionAction{

	
	protected function getIListar(){
		return new ModeloManager();
	}
	 
	protected function getTableModel(ItemCollection $items){
		return new ModeloTableModel($items);
	}
	
	protected function getCampoOrdenDefault(){
		return 'ds_modelo';
	}
	
	public function getFuncion(){
		return "Listar modelo";
	}

	protected function getTitulo(){
		return "Listado de modelos";
	}
	
	protected function getNombreArchivo(){
		return "modelos";
	}	
}