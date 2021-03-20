<?php 

/**
 * Acción para exportar usuarios a excel .
 * 
 * @author bernardo
 * @since 04-06-2010
 * 
 */
class ExcelUsuariosAction extends ExportExcelCollectionAction{

	protected function getIListar(){
		return new UsuarioManager();
	}

	protected function getTableModel(ItemCollection $items){
		return new UsuarioTableModel($items);
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