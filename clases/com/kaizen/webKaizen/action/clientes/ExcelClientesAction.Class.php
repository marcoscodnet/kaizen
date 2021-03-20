<?php 

/**
 * Acción para exportar a excel una colección de clientes.
 * 
 * @author Lucrecia
 * @since 03-01-2011
 * 
 */
class ExcelClientesAction extends ExportExcelCollectionAction{

	
	protected function getIListar(){
		return new ClienteManager();
	}
	 
	protected function getTableModel(ItemCollection $items){
		return new ClienteTableModel($items);
	}
	
	protected function getCampoOrdenDefault(){
		return 'ds_nombre';
	}
	
	public function getFuncion(){
		return "Listar Cliente";
	}

	protected function getTitulo(){
		return "Listado de Clientes";
	}
	
	protected function getNombreArchivo(){
		return "clientes";
	}	
}