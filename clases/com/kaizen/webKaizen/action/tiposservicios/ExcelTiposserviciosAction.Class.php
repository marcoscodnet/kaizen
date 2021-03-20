<?php 

/**
 * Acción para exportar a excel una colección de tiposunidades.
 * 
 * @author Marcos
 * @since 15-05-2012
 * 
 */
class ExcelTiposserviciosAction extends ExportExcelCollectionAction{

	
	protected function getIListar(){
		return new TiposervicioManager();
	}
	 
	protected function getTableModel(ItemCollection $items){
		return new TiposervicioTableModel($items);
	}
	
	protected function getCampoOrdenDefault(){
		return 'ds_tiposervicio';
	}
	
	public function getFuncion(){
		return "Listar Tipo de servicio";
	}

	protected function getTitulo(){
		return "Listado de Tipos de servicios";
	}
	
	protected function getNombreArchivo(){
		return "tiposservicios";
	}	
}