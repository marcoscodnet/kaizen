<?php

/**
 * Clase para exportar a PDF un Remito.
 *
 * @author Lucrecia
 *
 */
class PDFPrintBoleto extends PDFPrint {

	private $tipoCopia="";

	public function setTipoCopia($value){
		$this->tipoCopia = $value;
	}

	/**
	 * (non-PHPdoc)
	 * @see fpdf/FPDF#Footer()
	 */
	function Footer(){
	}
}
