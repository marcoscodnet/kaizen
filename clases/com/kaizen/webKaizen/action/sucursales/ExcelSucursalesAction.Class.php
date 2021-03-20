<?php 

/**
 * Acción para exportar a excel una colección de clientes.
 * 
 * @author Lucrecia
 * @since 03-01-2011
 * 
 */
class ExcelSucursalesAction extends ExportExcelCollectionAction{

	
	protected function getIListar(){
		return new SucursalManager();
	}
	 
	protected function getTableModel(ItemCollection $items){
		return new SucursalTableModel($items);
	}
	
	protected function getCampoOrdenDefault(){
		return 'ds_nombre';
	}
	
	public function getFuncion(){
		return "Listar Sucursal";
	}

	protected function getTitulo(){
		return "Listado de Sucursales";
	}
	
	protected function getNombreArchivo(){
		return "sucursales";
	}	
}