<?php

/**
 * Acción para exportar a pdf un movimiento
 *
 * @author lucrecia
 * @since 25-02-2011
 *
 */
class PDFDetalleMovimientoAction extends SecureAction{

	protected $columnsWidth;
	protected $y_cuadro_destinatario=15;
	protected $y_cuadro_logo_remito=40;

	protected function getRemito(){
		$cd_movimiento = FormatUtils::getParam('id',0);
		$manager = new MovimientoManager();
		$oMovimiento = $manager->getMovimientoPorId($cd_movimiento);
		$unidades = $manager->getUnidadesDeMovimiento($cd_movimiento);
		$oMovimiento->setUnidades($unidades);
		return $oMovimiento;
	}

	protected function getTitle(){
		return 'Remito';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#executeImpl()
	 */
	public function executeImpl(){

		//tipo de la copia del remito.
		$tipo= FormatUtils::getParam('tipo',0);

		$oMovimiento = $this->getRemito();

		$pdfConcat = new PDFConcat();

		$tipoCopiaTexto = "ORIGINAL";
		$pdf = $this->generarCopia( $oMovimiento, $tipoCopiaTexto);
		$pdf->Output($tipoCopiaTexto . ".pdf");
		$pdfConcat->addFile( $tipoCopiaTexto . ".pdf" );

		$tipoCopiaTexto = "DUPLICADO";
		$pdf = $this->generarCopia( $oMovimiento, $tipoCopiaTexto);
		$pdf->Output($tipoCopiaTexto . ".pdf");
		$pdfConcat->addFile( $tipoCopiaTexto . ".pdf" );


		$pdfConcat->concat();
		$pdfConcat->SetTitle( $this->getPDFTitle( $oMovimiento ) );
		$pdfConcat->Output($this->getPDFTitle( $oMovimiento ) . ".pdf", "D");

		//para que no haga el forward.
		$forward = null;

		return $forward;
	}

	public function getPDFTitle( $oMovimiento ){
		return "Remito Nro " . $oMovimiento->getCd_movimiento();
	}

	/**
	 * genera una copia de pdf
	 *
	 * @param  $tipoCopiaTexto
	 */
	public function generarCopia($oMovimiento, $tipoCopiaTexto='ORIGINAL'){

		//armamos el pdf.
		$pdf = $this->getPDFPrint( $oMovimiento );
		$pdf->setTipoCopia( $tipoCopiaTexto );
		$pdf->SetAutoPageBreak(true,35);
		$pdf->title = $this->getTitle();
		$pdf->SetFont('Arial','', 10);
		$pdf->AddPage();
		$maxWidth = ($pdf->w)-$pdf->lMargin-$pdf->rMargin;

		//primero dibujamos el "template" del remito (líneas, cuadros, etc).
		$y_encabezado = $this->dibujarEncabezado( $pdf, $oMovimiento, $pdf->tMargin, $maxWidth );
		$y_encabezado_renglones = $this->dibujarEncabezadoRenglones( $pdf, $y_encabezado, $maxWidth );
		//$y_renglones = $this->dibujarRenglones( $pdf, $oRemito, $y_encabezado_renglones, $maxWidth );

		//llenamos el pdf con la  info del remito.
		$this->parseEncabezado( $pdf, $oMovimiento, $pdf->tMargin, $maxWidth );
		$y_renglones = $this->parseRenglones( $pdf, $oMovimiento, $y_encabezado_renglones, $maxWidth );

		return $pdf;
	}

	public function getPDFPrint( $oMovimiento ){
		return new PDFPrintRemito();
	}

	public function parseObservaciones($pdf, Movimiento $oMovimiento, $maxWidth){
		$pdf->Ln();
		$pdf->setFont("Arial", "B", 8);
		$pdf->Cell($maxWidth, 8, "Observaciones: ",0,1,'L');
		$pdf->setFont("Arial", "", 8);
		$pdf->MultiCell($maxWidth, 7, $oMovimiento->getDs_observacion(), 0 ,"J",0);
	}

	public function getFuncion(){
		return 'Imprimir remito';
	}


	/**
	 * dibuja el encabezado del remito
	 * @param $pdf
	 * @return $y de lo último dibujado.
	 */
	public function dibujarEncabezado(PDFPrint $pdf, Movimiento $oMovimiento, $y, $maxWidth){
		//cuadro logo + info remito.
		$pdf->$y = $y;
		$pdf->SetLineWidth(.4);
		$pdf->Cell($maxWidth/2, $this->y_cuadro_logo_remito, '',1,0,'C');
		$pdf->Cell($maxWidth/2, $this->y_cuadro_logo_remito, '' ,1,0,'C');
		$pdf->Ln();

		//cuadro info destinatario
		$pdf->$y = $this->dibujarCuadroInfoDestinatario($pdf, $oMovimiento, $pdf->$y, $maxWidth);

		//cuadro remitimos a ud.....
		$pdf->SetLineWidth(.4);
		$pdf->Cell($maxWidth, 8, '',1,0,'C');
		$pdf->Ln();

		return $pdf->y;
	}

	protected function dibujarCuadroInfoDestinatario(PDFPrint $pdf, Movimiento $oMovimiento, $y, $maxWidth){
		$pdf->$y = $y;
		$pdf->SetLineWidth(.4);
		$pdf->Cell( $maxWidth, $this->y_cuadro_destinatario, '',1,0,'C');
		$pdf->Ln();
		$pdf->SetLineWidth(.1);
		$y_linea_proveedor = $this->y_cuadro_logo_remito + $this->y_cuadro_destinatario + 1;
		$y_linea_domicilio = $y_linea_proveedor + 7;
		$pdf->Line(41, $y_linea_proveedor, 198, $y_linea_proveedor);//linea proveedor
		$pdf->Line(31, $y_linea_domicilio, 138, $y_linea_domicilio);//linea domicilio
		$pdf->Line(160, $y_linea_domicilio, 198, $y_linea_domicilio	);//linea localidad
		return $pdf->y;
	}

	public function dibujarEncabezadoRenglones(PDFPrint $pdf, $y, $maxWidth){
		$pdf->y = $y;
		$pdf->SetLineWidth(.4);
		$this->columnsWidth = array(20, ($maxWidth)-90, 35, 35);
		$columns = array('Código', 'Producto', 'Nro. motor', 'Nro. Cuadro');
		$pdf->SetFillColor(218,218,218);
		$pdf->Cell($this->columnsWidth[0], 8, $columns[0],1,0,'C',1);
		$pdf->Cell($this->columnsWidth[1], 8, $columns[1],1,0,'C',1);
		$pdf->Cell($this->columnsWidth[2], 8, $columns[2],1,0,'C',1);
		$pdf->Cell($this->columnsWidth[3], 8, $columns[3],1,0,'C',1);
		$pdf->Ln();
		return $pdf->y;
	}

	public function parseRemito(PDFPrint $pdf, Movimiento $oMovimiento, $maxWidth){
		$this->parseEncabezado( $pdf, $oMovimiento, $maxWidth );
		$y = $this->parseRenglones( $pdf, $oMovimiento, $maxWidth );

		//$this->parseObservaciones($pdf, $oMovimiento, $maxWidth, $y);
		$this->parseFirma( $pdf, $oMovimiento, $maxWidth );
	}

	protected function parseLogo(PDFPrint $pdf, Movimiento $oMoviemiento, $y, $maxWidth){
		//IMAGEN ELECNOR.
		$pdf->y = $y;

		$pdf->Cell($maxWidth/2,$this->y_cuadro_logo_remito, '',0,0,'C');
		$pdf->Image(APP_PATH . 'img/logo_kaizen.jpg',$pdf->rMargin+10,$pdf->tMargin+4, 70,18);
		return $pdf->y;
	}

	protected function parseInfoRemito(PDFPrint $pdf, Movimiento $oMovimiento, $y, $maxWidth){
		//IMAGEN ELECNOR.
		$pdf->y = $y;

		$pdf->SetFontSize(8);
		$pdf->Cell($maxWidth/2 + 20,10, '' ,0,0,'L');
		$pdf->Cell(12,7, 'Fecha ' ,1,0,'L');
		$pdf->Cell(17,7, $oMovimiento->getDt_movimiento(),1,0,'L');
		$pdf->Ln();
		$pdf->SetFontSize(7);
		$pdf->Cell($maxWidth,2, '' ,0,0,'C');
		$pdf->Ln();
		$pdf->Cell($maxWidth/2,5, $oMovimiento->getDs_domiciliosucursalorigen() ,0,0,'C');
		$pdf->Cell(20,5, '' ,0,0,'C');
		$pdf->Cell(12,4, "" ,0,0,'L');
		$pdf->Ln();
		$pdf->Cell($maxWidth/2,5, $oMovimiento->getDs_localidadsucursalorigen() ,0,0,'C');
		$pdf->Cell(20,5, '' ,0,0,'C');
		$pdf->Cell(12,4, "" ,0,0,'L');
		$pdf->Ln();
		$pdf->Cell($maxWidth/2,5, 'Tel.: '. $oMovimiento->getDs_telefonosucursalorigen() ,0,0,'C');
		$pdf->Cell(20,5, '' ,0,0,'C');
		$pdf->Cell(12,4, "" ,0,0,'L');
		$pdf->Ln();
		$pdf->SetFontSize(5);
		$pdf->Cell($maxWidth/2,5, REMITO_CONDICION_IVA ,0,0,'C');
		$pdf->Cell(20,5, '' ,0,0,'C');
		$pdf->SetFontSize(7);
		$pdf->Cell(12,4, "" ,0,0,'L');
		$pdf->Ln();
		return $pdf->y;
	}


	protected function parseInfoTituloRemito(PDFPrint $pdf, Movimiento $oMovimiento, $y, $maxWidth){
		//IMAGEN ELECNOR.
		$pdf->y = $y;

		$pdf->SetFontSize(12);
		$pdf->SetLineWidth(.1);
		$pdf->Cell(20,7, '' ,0,0,'L');
		$pdf->Cell(20,7, 'REMITO' ,0,0,'L');
		$pdf->SetFontSize(5);
		$pdf->Cell(40,7, 'DOCUMENTO NO VALIDO COMO FACTURA' ,0,0,'L');
		$pdf->Ln();
		$pdf->SetFontSize(12);
		$pdf->Cell($maxWidth/2 + 20,10, '' ,0,0,'L');
		$pdf->Cell(20,7, 'N° ' . $oMovimiento->getCd_movimiento() ,0,0,'L');
		$pdf->Ln();

		return $pdf->y;
	}


	protected function parseInfoDestinatario(PDFPrint $pdf, Movimiento $oMovimiento, $y, $maxWidth){
		//IMAGEN ELECNOR.
		$pdf->y = $y;

		$pdf->SetFontSize(10);
		$pdf->y = $this->y_cuadro_logo_remito + $this->y_cuadro_destinatario-5;

		$pdf->Cell(30,7, 'Sucursal Destino:',0,0,'R');
		$pdf->Cell(165,7, $oMovimiento->getDs_sucursaldestino() ,0,0,'L');
		$pdf->Ln();

		$pdf->Cell(20,7, 'Domicilio:',0,0,'R');
		$pdf->Cell(110,7, $oMovimiento->getDs_domiciliosucursaldestino() ,0,0,'L');
		$pdf->Cell(20,7, 'Localidad: ',0,0,'R');
		$pdf->Cell(65,7, $oMovimiento->getDs_localidadsucursaldestino() ,0,0,'L');
		$pdf->Ln();

		return $pdf->y;
	}

	public function parseEncabezado(PDFPrint $pdf, Movimiento $oMovimiento, $y, $maxWidth){

		$pdf->y = $y;

		//IMAGEN ELECNOR.
		$pdf->y = $this->parseLogo($pdf, $oMovimiento, $pdf->y, $maxWidth);

		//INFO DEL REMITO.
		$pdf->y = $this->parseInfoTituloRemito($pdf, $oMovimiento, $pdf->y, $maxWidth);
		$pdf->y = $this->parseInfoRemito($pdf, $oMovimiento, $pdf->y, $maxWidth);

		//DATOS DEL DESTINATARIO.
		$pdf->y = $this->parseInfoDestinatario($pdf, $oMovimiento, $pdf->y, $maxWidth);

		$pdf->Cell(20,10, 'Remitimos a ud. lo siguiente:',0,0,'L');
		$pdf->Ln();

		return $pdf->y;
	}

	public function parseRenglones(PDFPrint $pdf, Movimiento $oMovimiento, $y, $maxWidth){

		$pdf->y = $y;
		$pdf->SetFontSize(8);
		//DETALLES DEL REMITO.
		foreach($oMovimiento->getUnidades() as $key => $oUnidad) {

			$pdf->Cell($this->columnsWidth[0], 8, $oUnidad->getCd_unidad(),1,0,'C');
			$pdf->Cell($this->columnsWidth[1], 8, $oUnidad->getDs_producto(),1,0,'L');
			$pdf->Cell($this->columnsWidth[2], 8, $oUnidad->getNu_motor(),1,0,'C');
			$pdf->Cell($this->columnsWidth[4], 8, $oUnidad->getNu_cuadro(),1,0,'C');
			$pdf->Ln();
		}
		$this->parseObservaciones($pdf, $oMovimiento, $maxWidth);
		return $pdf->y;
	}


}