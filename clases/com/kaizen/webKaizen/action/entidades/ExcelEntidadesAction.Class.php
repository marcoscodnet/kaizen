<?php 

/**
 * Acción para exportar a excel una colección de entidades.
 * 
 * @author Lucrecia
 * @since 03-01-2011
 * 
 */
class ExcelEntidadesAction extends ExportExcelCollectionAction{

	
	protected function getIListar(){
		return new EntidadManager();
	}
	 
	protected function getTableModel(ItemCollection $items){
		return new EntidadTableModel($items);
	}
	
	protected function getCampoOrdenDefault(){
		return 'ds_entidad';
	}
	
	public function getFuncion(){
		return "Listar Entidad";
	}

	protected function getTitulo(){
		return "Listado de Entidades";
	}
	
	protected function getNombreArchivo(){
		return "entidades";
	}	
}