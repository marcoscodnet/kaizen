<?php 

/**
 * Acción para exportar a pdf una colección de modelos.
 * 
 * @author Lucrecia
 * @since 03-01-2011
 * 
 */
class PDFModelosAction extends ExportPDFCollectionAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getIListar()
	 */
	protected function getIListar(){
		return new ModeloManager();
	}
	 
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getTableModel($items)
	 */
	protected function getTableModel(ItemCollection $items){
		return new ModeloTableModel($items);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getCampoOrdenDefault()
	 */
	protected function getCampoOrdenDefault(){
		return 'ds_modelo';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Listar Modelo";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getOrientacion()
	 */
	protected function getOrientacion(){
		return "L";
	}	
}