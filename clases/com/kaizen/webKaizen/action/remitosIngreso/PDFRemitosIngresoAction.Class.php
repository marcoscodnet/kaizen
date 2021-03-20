<?php 

/**
 * Acción para exportar remitos de ingreso a pdf.
 * 
 * @author Lucrecia
 * @since 03-01-2011
 * 
 */
class PDFRemitosIngresoAction extends ExportPDFCollectionAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getIListar()
	 */
	protected function getIListar(){
		return new RemitoIngresoManager();
	}
	 
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getTableModel($items)
	 */
	protected function getTableModel(ItemCollection $items){
		return new RemitoIngresoTableModel($items);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getCampoOrdenDefault()
	 */
	protected function getCampoOrdenDefault(){
		return 'cd_remito';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Listar RemitoIngreso";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getOrientacion()
	 */
	protected function getOrientacion(){
		return "P";
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