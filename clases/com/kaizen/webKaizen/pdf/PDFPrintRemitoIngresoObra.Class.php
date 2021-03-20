<?php

/**
 * Clase para exportar a PDF un Remito de ingreso a obra.
 *
 * @author Lucrecia
 *
 */
class PDFPrintRemitoIngresoObra extends PDFPrintRemito {

	private $oEstado;
	private $fechaEntrega;
	
	function Header(){
		
		if( $this->oEstado->getCd_referencia() == ENTREGADO ){
			
			//estado.
			$this->SetFontSize(36);
			$this->SetTextColor(190, 190, 190);
			$this->SetDrawColor(190, 190, 190);
			$this->SetLineWidth( 2 );
			$this->RotatedCell( $this->h/3, $this->w/2, $this->oEstado->getDs_referencia() , 45, 100, 30, 1, "C");
			$this->SetFontSize(18);
			$this->RotatedText($this->h/3 - 10 , $this->w/2 + 50, $this->fechaEntrega, 45 );	
		}
		
	}
	
	function setEstadoRemito( $oEstado ){
		$this->oEstado = $oEstado;
	}
	
	function setFechaEntrega( $value ){
		$this->fechaEntrega = $value;
	}
}
