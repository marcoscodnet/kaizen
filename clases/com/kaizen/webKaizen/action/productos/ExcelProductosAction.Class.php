<?php

/**
 * Acción para exportar a excel una colección de productos.
 *
 * @author Lucrecia
 * @since 03-01-2011
 *
 */
class ExcelProductosAction extends ExportExcelCollectionAction{


	protected function getIListar(){
		return new ProductoManager();
	}

	protected function getTableModel(ItemCollection $items){
		return new ProductoTableModel($items);
	}

	protected function getCampoOrdenDefault(){
		return 'ds_nombre';
	}

	public function getFuncion(){
		return "Listar Producto";
	}

	protected function getTitulo(){
		return "Listado de Productos";
	}

	protected function getNombreArchivo(){
		return "productos";
	}
}