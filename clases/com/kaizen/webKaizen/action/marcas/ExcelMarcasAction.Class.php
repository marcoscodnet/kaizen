<?php 

/**
 * Acción para exportar marcas a excel .
 * 
 * @author Lucrecia
 * @since 04-01-2011
 * 
 */
class ExcelMarcasAction extends ExportExcelCollectionAction{

	protected function getIListar(){
		return new MarcaManager();
	}

	protected function getTableModel(ItemCollection $items){
		return new MarcaTableModel($items);
	}

	protected function getCampoOrdenDefault(){
		return 'M.cd_marca';
	}

	public function getFuncion(){
		return "Listar Marca";
	}

	public function getTitulo(){
		return "Listado de Marcas";
	}

	public function getNombreArchivo(){
		return "marcas";
	}

}