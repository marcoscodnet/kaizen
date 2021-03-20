<?php

/**
 * Acción para exportar a excel una colección de unidades.
 *
 * @author Lucrecia
 * @since 03-01-2011
 *
 */
class ExcelMovimientosAction extends ExportExcelCollectionAction{


	protected function getIListar(){
		return new MovimientoManager();
	}

	protected function getTableModel(ItemCollection $items){
		return new MovimientoTableModel($items);
	}

	protected function getCampoOrdenDefault(){
		return 'dt_movimiento';
	}

	public function getFuncion(){
		return "Listar Movimiento";
	}

	protected function getTitulo(){
		return "Listado de Movimientos";
	}

	protected function getNombreArchivo(){
		return "movimientos";
	}
}