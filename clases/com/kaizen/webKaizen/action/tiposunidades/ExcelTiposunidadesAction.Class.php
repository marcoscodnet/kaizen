<?php 

/**
 * Acción para exportar a excel una colección de tiposunidades.
 * 
 * @author Lucrecia
 * @since 03-01-2011
 * 
 */
class ExcelTiposunidadesAction extends ExportExcelCollectionAction{

	
	protected function getIListar(){
		return new TipounidadManager();
	}
	 
	protected function getTableModel(ItemCollection $items){
		return new TipounidadTableModel($items);
	}
	
	protected function getCampoOrdenDefault(){
		return 'ds_tipounidad';
	}
	
	public function getFuncion(){
		return "Listar Tipo de unidad";
	}

	protected function getTitulo(){
		return "Listado de Tipos de unidades";
	}
	
	protected function getNombreArchivo(){
		return "tiposunidades";
	}	
}