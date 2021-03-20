<?php 

/**
 * Acción para exportar usuarios a pdf .
 * 
 * @author bernardo
 * @since 03-05-2010
 * 
 */
class PDFUsuariosAction extends ExportPDFCollectionAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getIListar()
	 */
	protected function getIListar(){
		return new UsuarioManager();
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getTableModel($items)
	 */
	protected function getTableModel(ItemCollection $items){
		return new UsuarioTableModel($items);
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getCampoOrdenDefault()
	 */
	protected function getCampoOrdenDefault(){
		return 'cd_usuario';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Listar Usuario";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getOrientacion()
	 */
	protected function getOrientacion(){
		return "L";
	}
}