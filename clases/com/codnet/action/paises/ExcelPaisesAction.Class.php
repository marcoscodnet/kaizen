<?php 

/**
 * Acci�n para exportar Paises a excel .
 * 
 * @author codnet
 * @since 04-06-2010
 * 
 */
class ExcelPaisesAction extends ExportExcelCollectionAction{

	protected function getIListar(){
		return new PaisManager();
	}

	protected function getTableModel(ItemCollection $items){
		return new PaisTableModel($items);
	}

	protected function getCampoOrdenDefault(){
		return 'cd_pais';
	}

	public function getFuncion(){
		return "Listar Pais";
	}

	public function getTitulo(){
		return "Listado de Paises";
	}

	public function getNombreArchivo(){
		return "Paises";
	}

	
}