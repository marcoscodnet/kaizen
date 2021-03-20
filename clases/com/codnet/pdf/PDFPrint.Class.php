<?php
require_once( APP_PATH . 'fpdf/fpdf.php' );

/**
 * Clase para exportar a PDF.
 *
 * @author bernardo
 *
 */
class PDFPrint extends FPDF {

	/**
	 * (non-PHPdoc)
	 * @see fpdf/FPDF#Header()
	 */
	function Header(){
	}

	/**
	 * (non-PHPdoc)
	 * @see fpdf/FPDF#Footer()
	 */
	function Footer(){
	}

	
	
	/**
	 * parsea la colección dentro del pdf.
	 * utiliza el descriptor para obtener datos de la colección.
	 * @param $items
	 * @param $tableModel
	 * @return unknown_type
	 */
	function collectionToPDF(ItemCollection $items, TableModel $tableModel){

		//obtenmos la cantidad de columnas a mostrar
		$columnCount = $tableModel->getColumnCount( $items );
		
		//obtenmos el ancho de la tabla.
		$tableWidth = $this->getTableWidth( $tableModel, $columnCount );
		
		$this->SetDrawColor(192,192,192);
		$this->SetLineWidth(.1);
				
		
		//Restauración de colores y fuentes
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('');
		//Datos
		$fill=false;
		
		foreach ($items as $anObject) {
			
			for( $columnIndex=0 ; $columnIndex< $columnCount ; $columnIndex++ ){
				$headerWidth = $tableModel->getColumnWidth($columnIndex);
				$value = $tableModel->getValue($anObject, $columnIndex);
				//$this->Cell( $headerWidth , 6, $value , 'LR' , 0 , 'L' ,$fill);
				$this->Cell( $headerWidth , 6, $value , 1 , 0 , 'L' ,$fill);
				
			}
			$this->Ln();
		}		
		$this->Cell( $tableWidth , 0 , '' , 'T' );
	}

	protected function cabecera($columnCount, TableModel $tableModel){
		//Colores, ancho de línea y fuente en negrita		
		$this->SetFillColor(218,218,218);
		$this->SetTextColor(1,77,137);
		$this->SetDrawColor(192,192,192);
		$this->SetLineWidth(.1);
		
		//Cabecera
		for( $columnIndex=0 ; $columnIndex< $columnCount ; $columnIndex++ ){
			$headerDesc = $tableModel->getColumnName($columnIndex);
			$headerWidth = $tableModel->getColumnWidth($columnIndex);
			//TODO definir de manera similar los demás parámetros para Cell.
			$this->Cell( $headerWidth , 7 , $headerDesc , 1 , 0 , 'C' , 1 );
		}
	}

	/**
	 * retoran el ancho total de la tabla.
	 * @param ICollectionDescriptor $descriptor
	 * @param unknown_type $columnCount
	 * @return unknown_type
	 */
	protected function getTableWidth(TableModel $tableModel, $columnCount){
		$width=0;
		for( $columnIndex=0 ; $columnIndex< $columnCount ; $columnIndex++ ){
			$width += $tableModel->getColumnWidth($columnIndex);
		}
		return $width;	
	} 

	function Rotate($angle, $x=-1, $y=-1){
	    if($x==-1)
	        $x=$this->x;
	    if($y==-1)
	        $y=$this->y;
	    if($this->angle!=0)
	        $this->_out('Q');
	    $this->angle=$angle;
	    if($angle!=0){
	        $angle*=M_PI/180;
	        $c=cos($angle);
	        $s=sin($angle);
	        $cx=$x*$this->k;
	        $cy=($this->h-$y)*$this->k;
	        $this->_out(sprintf('q %.5f %.5f %.5f %.5f %.2f %.2f cm 1 0 0 1 %.2f %.2f cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
	    }
	}

	function RotatedText($x, $y, $txt, $angle){
	    //Text rotated around its origin
	    $this->Rotate($angle, $x, $y);
	    $this->Text($x, $y, $txt);
	    $this->Rotate(0);
	}

	function RotatedCell($x, $y, $txt, $angle, $w, $h, $border=1, $align="C"){
	    //Text rotated around its origin
	    $this->Rotate($angle, $x, $y);
	    $currentX = $this->x;
	    $currentY = $this->y;
	    $this->SetX( $x );
	    $this->SetY( $y );
	    $this->Cell($w,$h, $txt,$border,0,$align);
	    $this->SetX( $currentX );
	    $this->SetY( $currentY );
	    $this->Rotate(0);
	}
	
}
