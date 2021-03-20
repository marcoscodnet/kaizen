<?php 



/**

 * Acci�n para exportar a pdf una colecci�n de clientes.

 * 

 * @author Lucrecia

 * @since 03-01-2011

 * 

 */

class PDFClientesAction extends ExportPDFCollectionAction{



	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getIListar()

	 */

	protected function getIListar(){

		return new ClienteManager();

	}

	 

	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getTableModel($items)

	 */

	protected function getTableModel(ItemCollection $items){

		return new ClienteTableModel($items);

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

		return "Listar Cliente";

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getOrientacion()

	 */

	protected function getOrientacion(){

		return "L";

	}	

}