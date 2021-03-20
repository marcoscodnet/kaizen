<?php

/**
 * Acción para exportar a pdf un formulario de venta
 *
 * @author lucrecia
 * @since 25-02-2011
 *
 */
class PDFFormularioVentaAction extends SecureAction{

	protected function getFormulario(){
		$cd_venta = FormatUtils::getParam('id',0);
		$manager = new VentaManager();
		$oVenta = $manager->getVentaPorId($cd_venta);

		return $oVenta;
	}

	protected function getTitle(){
		return 'Formulario 12';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#executeImpl()
	 */
	public function executeImpl(){

		//tipo de la copia del remito.
		$tipo= FormatUtils::getParam('tipo',0);

		$oVenta = $this->getFormulario();

		$pdfConcat = new PDFConcat();

		$tipoCopiaTexto = "ORIGINAL";
		$pdf = $this->generarCopia( $oVenta, $tipoCopiaTexto);
		$pdf->Output($tipoCopiaTexto . ".pdf");
		$pdfConcat->addFile( $tipoCopiaTexto . ".pdf" );

		$tipoCopiaTexto = "DUPLICADO";
		$pdf = $this->generarCopia( $oVenta, $tipoCopiaTexto);
		$pdf->Output($tipoCopiaTexto . ".pdf");
		$pdfConcat->addFile( $tipoCopiaTexto . ".pdf" );

		$tipoCopiaTexto = "TRIPLICADO";
		$pdf = $this->generarCopia( $oVenta, $tipoCopiaTexto);
		$pdf->Output($tipoCopiaTexto . ".pdf");
		$pdfConcat->addFile( $tipoCopiaTexto . ".pdf" );

		$pdfConcat->concat();
		$pdfConcat->SetTitle( $this->getPDFTitle( $oVenta ) );
		$pdfConcat->Output($this->getPDFTitle( $oVenta ) . ".pdf", "D");

		//para que no haga el forward.
		$forward = null;

		return $forward;
	}

	public function getPDFTitle( $oVenta ){
		return "Formulario 12 " . $oVenta->getCd_venta();
	}

	/**
	 * genera una copia de pdf
	 *
	 * @param  $tipoCopiaTexto
	 */
	public function generarCopia($oVenta, $tipoCopiaTexto='ORIGINAL'){

		//armamos el pdf.
		$pdf = $this->getPDFPrint( $oVenta );
		$pdf->setTipoCopia( $tipoCopiaTexto );
		$pdf->SetAutoPageBreak(true);
		$pdf->title = $this->getTitle();
		$pdf->SetFont('Arial','', 10);
		$pdf->AddPage();
		$maxWidth = ($pdf->w)-$pdf->lMargin-$pdf->rMargin;

		//llenamos el pdf con la  info del remito.
		$this->parseContenido($pdf, $oVenta, $pdf->tMargin );

		return $pdf;
	}

	public function getPDFPrint( $oVenta ){
		return new PDFPrintFormulario();
	}

	public function getFuncion(){
		return 'Imprimir Formulario 12';
	}

	public function parseContenido(PDFPrint $pdf, Venta $oVenta, $y){

		$margin_top = 4;
		$margin_left = 0;
		$pdf->SetMargins(0, 0, 0);
		
		//3.4 en y incrementar
		//Ahora decrementar 0.3
				
		// marca 6cm x, 7.1 y
		//$pdf->SetXY(60 - $margin_left, 75 - $margin_top);
		//$pdf->SetXY(60 - $margin_left, 41 - $margin_top);
		$pdf->SetXY(60 - $margin_left, 44 - $margin_top);
		$pdf->Cell(110, 5, $oVenta->getUnidad()->getProducto()->getDs_marca(), 0, 1, 'L');

		//Tipo 7.7y, 5.5x
		//$pdf->SetXY(55 - $margin_left, 81 - $margin_top);
		//$pdf->SetXY(55 - $margin_left, 47 - $margin_top);
		$pdf->SetXY(55 - $margin_left, 50 - $margin_top);
		$pdf->Cell(110, 5, $oVenta->getUnidad()->getProducto()->getDs_tipounidad(), 0, 1, 'L');

		//modelo 8.4 y,6.4 x
		//$pdf->SetXY(64 - $margin_left, 87 - $margin_top);
		//$pdf->SetXY(64 - $margin_left, 53 - $margin_top);
		$pdf->SetXY(64 - $margin_left, 56 - $margin_top);
		$pdf->Cell(110, 5, $oVenta->getUnidad()->getProducto()->getDs_modelo(), 0, 1, 'L');

		//Marca motor 9.1 y, 7.7x
		//$pdf->SetXY(77 - $margin_left, 94 - $margin_top);
		//$pdf->SetXY(77 - $margin_left, 60 - $margin_top);
		$pdf->SetXY(77 - $margin_left, 63 - $margin_top);
		$pdf->Cell(110, 5, $oVenta->getUnidad()->getProducto()->getDs_marca(), 0, 1, 'L');

		//Nro motor 9.7 , 7.2x
		//$pdf->SetXY(72 - $margin_left, 100 - $margin_top);
		//$pdf->SetXY(72 - $margin_left, 66 - $margin_top);
		$pdf->SetXY(72 - $margin_left, 69 - $margin_top);
		$pdf->Cell(110, 5, $oVenta->getUnidad()->getNu_motor(), 0, 1, 'L');

		//Marca cuadro 10.3y, 8.4x
		//$pdf->SetXY(84 - $margin_left, 106 - $margin_top);
		//$pdf->SetXY(84 - $margin_left, 72 - $margin_top);
		$pdf->SetXY(84 - $margin_left, 75 - $margin_top);
		$pdf->Cell(110, 5, $oVenta->getUnidad()->getProducto()->getDs_marca(), 0, 1, 'L');

		//Nro cuadro 11y, 7.5x
		//$pdf->SetXY(75 - $margin_left, 112 - $margin_top);
		//$pdf->SetXY(75 - $margin_left, 78 - $margin_top);
		//$pdf->SetXY(75 - $margin_left, 81 - $margin_top);
		$pdf->SetXY(75 - $margin_left, 83 - $margin_top);
		$pdf->Cell(110, 5, $oVenta->getUnidad()->getNu_cuadro(), 0, 1, 'L');

		//Observaciones 13.4 y,4.5x
		//$pdf->SetXY(45 - $margin_left, 135 - $margin_top);
		//$pdf->SetXY(45 - $margin_left, 101 - $margin_top);
		$pdf->SetXY(45 - $margin_left, 104 - $margin_top);
		$pdf->MultiCell(140, 5, "Observaciones?", 0,'L');


		//lugar 20.4 y ,4.5x
		//$pdf->SetXY(45 - $margin_left, 207 - $margin_top);
		//$pdf->SetXY(45 - $margin_left, 173 - $margin_top);
		//$pdf->SetXY(45 - $margin_left, 176 - $margin_top);
		$pdf->SetXY(45 - $margin_left, 180 - $margin_top);
		$pdf->Cell(43, 5, "La Plata", 0, 1, 'L');

		//Fecha 20.4 y , día 9.7 x mes 10.7x año 11.7x
		$dt_fecha = $oVenta->getDt_fecha();
		$dt_fecha = str_replace("/", "-", $oVenta->getDt_fecha());
		$dt_fecha = explode("-", $dt_fecha);

		//$pdf->SetXY(97 - $margin_left, 207 - $margin_top);
		//$pdf->SetXY(97 - $margin_left, 173 - $margin_top);
		//$pdf->SetXY(97 - $margin_left, 176 - $margin_top);
		$pdf->SetXY(97 - $margin_left, 180 - $margin_top);
		$pdf->Cell(9, 5, $dt_fecha[0], 0, 1, 'L');
		//$pdf->SetXY(107 - $margin_left, 207 - $margin_top);
		//$pdf->SetXY(107 - $margin_left, 173 - $margin_top);
		//$pdf->SetXY(107 - $margin_left, 176 - $margin_top);
		$pdf->SetXY(107 - $margin_left, 180 - $margin_top);
		$pdf->Cell(9, 5, $dt_fecha[1], 0, 1, 'L');
		//$pdf->SetXY(117 - $margin_left, 207 - $margin_top);
		//$pdf->SetXY(117 - $margin_left, 173 - $margin_top);
		//$pdf->SetXY(117 - $margin_left, 176 - $margin_top);
		$pdf->SetXY(117 - $margin_left, 180 - $margin_top);
		$pdf->Cell(9, 5, $dt_fecha[2], 0, 1, 'L');

		//DATOS DEL SOLICITANTE
		//Apellido y nombre 233y, 8.8x
		//$pdf->SetXY(88 - $margin_left, 233 - $margin_top);
		//$pdf->SetXY(88 - $margin_left, 199 - $margin_top);
		//$pdf->SetXY(88 - $margin_left, 202 - $margin_top);
		$pdf->SetXY(88 - $margin_left, 206 - $margin_top);
		$pdf->Cell(100, 5, $oVenta->getDs_apynom(), 0, 1, 'L');
		//Nro y tipo de documento 24 y , 9.7x
		//$pdf->SetXY(97 - $margin_left, 239 - $margin_top);
		//$pdf->SetXY(97 - $margin_left, 205 - $margin_top);
		//$pdf->SetXY(97 - $margin_left, 208 - $margin_top);
		$pdf->SetXY(97 - $margin_left, 212 - $margin_top);
		$pdf->Cell(90, 5, $oVenta->getCliente()->getDs_tipodoc()." ".$oVenta->getCliente()->getNu_doc(), 0, 1, 'L');
		//Domicilio 24.6 y, 6.7 X
		//$pdf->SetXY(67 - $margin_left, 245 - $margin_top);
		//$pdf->SetXY(67 - $margin_left, 211 - $margin_top);
		//$pdf->SetXY(67 - $margin_left, 214 - $margin_top);
		$pdf->SetXY(67 - $margin_left, 219 - $margin_top);
		$pdf->Cell(50, 5, $oVenta->getCliente()->getDs_dircalle()." ". $oVenta->getCliente()->getDs_dirpiso()." ". $oVenta->getCliente()->getDs_dirdepto(), 0, 1, 'L');
		//Nro casa 24.6 y, 12 X
		//$pdf->SetXY(120 - $margin_left, 245 - $margin_top);
		//$pdf->SetXY(120 - $margin_left, 211 - $margin_top);
		//$pdf->SetXY(120 - $margin_left, 214 - $margin_top);
		$pdf->SetXY(120 - $margin_left, 219 - $margin_top);
		$pdf->Cell(50, 5, $oVenta->getCliente()->getDs_dirnro(), 0, 1, 'L');
		//Localidad 24.6 y , 15.5x
		//$pdf->SetXY(155 - $margin_left, 245 - $margin_top);
		//$pdf->SetXY(155 - $margin_left, 211 - $margin_top);
		//$pdf->SetXY(155 - $margin_left, 214 - $margin_top);
		$pdf->SetXY(155 - $margin_left, 219 - $margin_top);
		$pdf->Cell(90, 5, $oVenta->getCliente()->getLocalidad()->getDs_localidad(), 0, 1, 'L');
		$this->parseSello($pdf);
		return $pdf->y;
	}

	function parseSello($pdf){
		//$pdf->SetXY(75, 150);
		$pdf->SetXY(80, 120);
		$pdf->SetFont('Arial','', 7);
		$pdf->SetTextColor(123, 123, 123);
		$texto = "He Verificado personalmente la autenticidad de los datos que figuran ";
		$texto .= "en el presente formulario y me hago personalmente responsable civil y criminalmente ";
		$texto .= "por los errores u omisiones en que pudiera incurrir sin perjuicio de las que a la empresa ";
		$texto .= "le correspondan";
		$pdf->MultiCell(55, 3, $texto, 0,'J');
	}

}