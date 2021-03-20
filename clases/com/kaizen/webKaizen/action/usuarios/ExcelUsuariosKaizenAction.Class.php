<?php 

/**
 * Acci�n para exportar usuarios a excel .
 * 
 * @author bernardo
 * @since 04-06-2010
 * 
 */
class ExcelUsuariosKaizenAction extends ExportExcelCollectionAction{

	protected function getIListar(){
		return new UsuarioKaizenManager();
	}

	protected function getTableModel(ItemCollection $items){
		return new UsuarioKaizenTableModel($items);
	}

	protected function getCampoOrdenDefault(){
		return 'cd_usuario';
	}

	public function getFuncion(){
		return "Listar Usuario";
	}

	public function getTitulo(){
		return "Listado de Usuarios";
	}

	public function getNombreArchivo(){
		return "usuarios";
	}

	
}