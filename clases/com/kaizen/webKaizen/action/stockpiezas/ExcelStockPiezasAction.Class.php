<?php

/**
 * Acción para exportar a excel una colección de stock piezas.
 *
 * @author Ma. Jesús
 * @since 15-07-2011
 *
 */
class ExcelStockPiezasAction extends ExportExcelCollectionAction{


	protected function getIListar(){
		return new StockPiezaManager();
	}

	protected function getTableModel(ItemCollection $items){
		return new StockPiezaTableModel($items);
	}

	protected function getCampoOrdenDefault(){
		return 'P.cd_pieza';
	}

	public function getFuncion(){
		return "Listar Stock Pieza";
	}

	protected function getTitulo(){
		return "Listado de Stock Piezas";
	}

	protected function getNombreArchivo(){
		return "stockpiezas";
	}
}