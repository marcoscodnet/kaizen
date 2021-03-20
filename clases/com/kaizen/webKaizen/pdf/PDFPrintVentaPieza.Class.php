<?php

/**
 * Clase para exportar a PDF un Remito.
 *
 * @author Lucrecia
 *
 */
class PDFPrintVentaPieza extends PDFPrint {

	private $tipoCopia="";
	
	public function setTipoCopia($value){
		$this->tipoCopia = $value;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see fpdf/FPDF#Footer()
	 */
	function Footer(){
		
		$this->SetY(-35);		
		//cuadro firma, entregado por.....
		$this->SetLineWidth(.1);
//		$this->y = $y + 5;
		$this->Cell(20,7, '',0,0,'L');
		$y_linea_firma = $this->y + 6;
		//$this->Line(23, $y_linea_firma, 100, $y_linea_firma);//linea firma

		$this->x  = 120;
		$this->Cell(20,7, '',0,0,'L');
		//$y_linea_recibidoPor = $this->y + 6;
		$y_linea_recibidoPor = $y_linea_firma;
		//$this->Line(140, $y_linea_recibidoPor, 200, $y_linea_recibidoPor);//linea recibido por
		$this->Ln();
		
		$this->Cell(20,7, '',0,0,'L');
		$y_linea_entregadoPor =  $this->y + 6;
		//$this->Line(35, $y_linea_entregadoPor, 100, $y_linea_entregadoPor);//linea entregado por
		
		$this->x  = 120;
		$this->Cell(20,7, '',0,0,'L');
		$y_linea_dni = $y_linea_entregadoPor;
		//$this->Line(130, $y_linea_dni, 200, $y_linea_dni);//linea dni		
		$this->Ln();
		
		
		//tipo de copia.
		$this->SetFontSize(8);
		$this->RotatedText(7, $this->h/2, $this->tipoCopia, 90);

	}
}
