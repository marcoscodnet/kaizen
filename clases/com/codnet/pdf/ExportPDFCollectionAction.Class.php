<?php

/**
 * Acción para exportar a pdf una colección ItemCollection.
 *
 * @author bernardo
 * @since 20-04-2010
 *
 */
abstract class ExportPDFCollectionAction extends SecureAction{

	/**
	 * orientación de la hoja.
	 *    P or Portrait
	 *    L or Landscape
	 * @return
	 */
	protected function getOrientacion(){
		return "L";
	}
	protected function getFontSize(){
		return 10;
	}

	/**
	 * campo de ordenación por default.
	 * @return
	 */
	protected abstract function getCampoOrdenDefault();

	/**
	 * encargado de listar las entidades.
	 * @return IListar
	 */
	protected abstract function getIListar();

	/**
	 * descriptor para la colección de entidades.
	 * @return TableModel
	 */
	protected abstract function getTableModel( ItemCollection $items );

	/**
	 * criterio de búsqueda para filtrar el listado.
	 * @return unknown_type
	 */
	protected function getCriterioBusqueda(){
		//recuperamos los parámetros.
		$filtro = FormatUtils::getParam('filtro');
		$campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault() );
		$orden = FormatUtils::getParam('orden','DESC');
		$campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault() );

		//obtenemos las entidades a mostrar.
		$criterio = new CriterioBusqueda();
		$criterio->addFiltro($campoFiltro, $filtro, 'LIKE', new FormatValorLike());
		$criterio->addOrden($campoOrden, $orden);

		return $criterio;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#executeImpl()
	 */
	public function executeImpl(){


		$orden = FormatUtils::getParam('orden','DESC');
		$campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault() );

		$entidades = $this->getIListar()->getEntidades ( $this->getCriterioBusqueda() );
		$tableModel = $this->getTableModel( $entidades );

		//armamos el pdf.
		$pdf = $this->getPDFReport();
		$pdf->title = $this->getTitle($tableModel);
		$pdf->setTableModel( $tableModel );
		$pdf->SetFont('Arial','', $this->getFontSize());
		$pdf->AddPage();
		$pdf->collectionToPDF( $entidades, $tableModel );
		$this->getFooter($pdf, $this->getCriterioBusqueda());
		$pdf->Output();

		//para que no haga el forward.
		$forward = null;

		return $forward;
	}

	protected function getFooter(){
		"";
	}

	protected function getPDFReport(){
		return new PDFReport($this->getOrientacion());
	}

	protected function getTitle($tableModel){
		return $tableModel->getTitle();
	}
}