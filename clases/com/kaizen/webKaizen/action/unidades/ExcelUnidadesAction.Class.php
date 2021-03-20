<?php 

/**
 * Acción para exportar a excel una colección de unidades.
 * 
 * @author Lucrecia
 * @since 03-01-2011
 * 
 */
class ExcelUnidadesAction extends ExportExcelCollectionAction{

	
	protected function getIListar(){
		return new UnidadManager();
	}
	 
	protected function getTableModel(ItemCollection $items){
		return new UnidadTableModel($items);
	}
	
	protected function getCampoOrdenDefault(){
		return 'ds_nombre';
	}
	
	public function getFuncion(){
		return "Listar Unidad";
	}

	protected function getTitulo(){
		return "Listado de Unidades";
	}
	
	protected function getNombreArchivo(){
		return "unidades";
	}	
}