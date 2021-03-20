<?php

/**
 * Acción para exportar a excel una colección de piezas.
 *
 * @author Ma. Jesús
 * @since 18-06-2011
 *
 */
class ExcelPiezasAction extends ExportExcelCollectionAction{


	protected function getIListar(){
		return new PiezaManager();
	}

	protected function getTableModel(ItemCollection $items){
		return new PiezaTableModel($items);
	}

	protected function getCampoOrdenDefault(){
		return 'ds_codigo';
	}

	public function getFuncion(){
		return "Listar Pieza";
	}

	protected function getTitulo(){
		return "Listado de Piezas";
	}

	protected function getNombreArchivo(){
		return "piezas";
	}
}