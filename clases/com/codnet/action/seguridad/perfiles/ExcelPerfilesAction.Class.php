<?php 

/**
 * Acción para exportar perfiles a excel .
 * 
 * @author bernardo
 * @since 04-06-2010
 * 
 */
class ExcelPerfilesAction extends ExportExcelCollectionAction{

	protected function getIListar(){
		return new PerfilManager();
	}

	protected function getTableModel(ItemCollection $items){
		return new PerfilTableModel($items);
	}

	protected function getCampoOrdenDefault(){
		return 'P.cd_perfil';
	}

	public function getFuncion(){
		return "Listar Perfil";
	}

	public function getTitulo(){
		return "Listado de Perfiles";
	}

	public function getNombreArchivo(){
		return "perfiles";
	}

}