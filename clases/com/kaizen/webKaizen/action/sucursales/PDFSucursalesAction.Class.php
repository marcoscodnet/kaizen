<?php 

/**
 * Acción para exportar a pdf una colección de sucursales.
 * 
 * @author Lucrecia
 * @since 03-01-2011
 * 
 */
class PDFSucursalesAction extends ExportPDFCollectionAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getIListar()
	 */
	protected function getIListar(){
		return new SucursalManager();
	}
	 
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getTableModel($items)
	 */
	protected function getTableModel(ItemCollection $items){
		return new SucursalTableModel($items);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getCampoOrdenDefault()
	 */
	protected function getCampoOrdenDefault(){
		return 'ds_nombre';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Listar Sucursal";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getOrientacion()
	 */
	protected function getOrientacion(){
		return "L";
	}	
}