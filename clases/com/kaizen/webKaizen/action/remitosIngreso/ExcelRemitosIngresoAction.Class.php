<?php 

/**
 * Acción para exportar remitos de ingreso a excel.
 * 
 * @author Lucrecia
 * @since 04-01-2011
 * 
 */
class ExcelRemitosIngresoAction extends ExportExcelCollectionAction{

	protected function getIListar(){
		return new RemitoIngresoManager();
	}
	 
	protected function getTableModel(ItemCollection $items){
		return new RemitoIngresoTableModel($items);
	}
	
	protected function getCampoOrdenDefault(){
		return 'cd_remito';
	}
	
	public function getFuncion(){
		return "Listar RemitoIngreso";
	}

	public function getTitulo(){
		return "Listado de Remitos de Ingreso";
	}

	public function getNombreArchivo(){
		return "remitos_ingreso";
	}
	
	protected function getCriterioBusqueda(){
		$criterio = parent::getCriterioBusqueda();
		
		//le agregamos el chequeo por número.
		$conNumero = FormatUtils::getParam('chk_conNumero','off');
		if($conNumero!='off')
			$criterio->addNotNull('nu_reserva');
				
		return $criterio;
	}	
	
}