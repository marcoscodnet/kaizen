<?php 

/**
 * Acción para exportar a excel una colección de almacenes.
 * 
 * @author Lucrecia
 * @since 03-01-2011
 * 
 */
class ExcelAlmacenesAction extends ExportExcelCollectionAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/excel/ExportExcelCollectionAction#getIListar()
	 */
	protected function getIListar(){
		return new AlmacenManager();
	}
	 
	/**
	 * 
	 * @param $items
	 */
	protected function getTableModel(ItemCollection $items){
		return new AlmacenTableModel($items);
	}
	
	/**
	 * 
	 */
	protected function getCampoOrdenDefault(){
		return 'ds_nombre';
	}
	
	/**
	 * 
	 */
	public function getFuncion(){
		return "Listar Almacen";
	}

	protected function getTitulo(){
		return "Listado de Almacenes";
	}
	
	protected function getNombreArchivo(){
		return "almacenes";
	}	
		
}