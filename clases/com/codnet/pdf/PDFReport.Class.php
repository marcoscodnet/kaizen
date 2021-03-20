<?php
/**
 * Clase para construir reportes en PDF.
 *
 * @author bernardo
 *
 */
class PDFReport extends PDFPrint {

	private $lblPage = 'Página';
	private $tableModel;
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/PDFPrint#Header()
	 */
	function Header(){
		
		//Título
		$this->Cell($tableWidth,10, NOMBRE_EMPRESA_PDF." / " . $this->title ,0,0,'C');
		$this->Ln();
		
		//obtenmos la cantidad de columnas a mostrar
		$columnCount = $this->tableModel->getColumnCount( $this->tableModel->getRowCount());
		
		//obtenmos el ancho de la tabla.
		$tableWidth = $this->getTableWidth( $this->tableModel, $columnCount );
		
		$this->cabecera($columnCount, $this->tableModel);
		$this->Ln();
		
	
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/PDFPrint#Footer()
	 */
	function Footer(){
		//Posición: a 1,5 cm del final
		$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Arial','I',8);
		//título del listado
		$this->Cell(10,10, NOMBRE_EMPRESA_PDF." / " . $this->title ,0,0,'L');
		//$this->Cell(0,10, $this->lblPage.' '.$this->PageNo() ,0,0,'C');
		//Número de página
		$this->Cell(0,10, $this->lblPage.' '.$this->PageNo() ,0,0,'R');
	}

	
	public function setTableModel(TableModel $tableModel){
		$this->tableModel = $tableModel;
	}
}
