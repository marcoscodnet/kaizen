<?php 

/**
 * Acción para exportar a pdf un remito de ingreso.
 * 
 * @author Lucrecia
 * @since 11-01-2011
 * 
 */
class PDFRemitoIngresoAction extends SecureAction{

	protected $columnsWidth;
	protected $y_cuadro_destinatario=15;
	protected $y_cuadro_logo_remito=40;
	
	protected function getRemito(){
		$cd_remito = FormatUtils::getParam('id',0);
		$manager = new RemitoIngresoManager();
		$oRemito = $manager->getRemitoIngresoPorId ( $cd_remito );
		return $oRemito;
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
		
		$oRemito = $this->getRemito();
		
		$pdfConcat = new PDFConcat();
		
		switch ($tipo) {
			case REMITO_COPIA_ORIGINAL:{
			
				$tipoCopiaTexto = "ORIGINAL";
				$pdf = $this->generarCopia( $oRemito, $tipoCopiaTexto);
				$pdf->Output($tipoCopiaTexto . ".pdf");
				$pdfConcat->addFile( $tipoCopiaTexto . ".pdf" );
							
			}break;
			
			case REMITO_COPIA_DUPLICADO:{
			
				$tipoCopiaTexto = "ORIGINAL";
				$pdf = $this->generarCopia( $oRemito, $tipoCopiaTexto);
				$pdf->Output($tipoCopiaTexto . ".pdf");
				$pdfConcat->addFile( $tipoCopiaTexto . ".pdf" );
				
				$tipoCopiaTexto = "DUPLICADO";
				$pdf = $this->generarCopia( $oRemito, $tipoCopiaTexto);
				$pdf->Output($tipoCopiaTexto . ".pdf");
				$pdfConcat->addFile( $tipoCopiaTexto . ".pdf" );
				
			}break;
			
			case REMITO_COPIA_TRIPLICADO:{
				
				$tipoCopiaTexto = "ORIGINAL";
				$pdf = $this->generarCopia( $oRemito, $tipoCopiaTexto);
				$pdf->Output($tipoCopiaTexto . ".pdf");
				$pdfConcat->addFile( $tipoCopiaTexto . ".pdf" );
				
				$tipoCopiaTexto = "DUPLICADO";
				$pdf = $this->generarCopia( $oRemito, $tipoCopiaTexto);
				$pdf->Output($tipoCopiaTexto . ".pdf");
				$pdfConcat->addFile( $tipoCopiaTexto . ".pdf" );
				
				$tipoCopiaTexto = "TRIPLICADO";
				$pdf = $this->generarCopia( $oRemito, $tipoCopiaTexto);
				$pdf->Output($tipoCopiaTexto . ".pdf");
				$pdfConcat->addFile( $tipoCopiaTexto . ".pdf" );
				
			}break;
			
		}
		
		$pdfConcat->concat();
		$pdfConcat->SetTitle( $this->getPDFTitle( $oRemito ) );		
		$pdfConcat->Output($this->getPDFTitle( $oRemito ) . ".pdf", "D");	
		
		//para que no haga el forward.
		$forward = null;
				
		return $forward;
	}
	
	public function getPDFTitle( $oRemito ){
		return "Remito Ingreso Nro " . $oRemito->getCd_remito();
	}
	
	/**
	 * genera una copia de pdf
	 * 
	 * @param  $tipoCopiaTexto
	 */
	public function generarCopia($oRemito, $tipoCopiaTexto='ORIGINAL'){
		
		//armamos el pdf.
		$pdf = $this->getPDFPrint( $oRemito );
		$pdf->setTipoCopia( $tipoCopiaTexto );
		$pdf->SetAutoPageBreak(true,35);
		$pdf->title = $this->getTitle();
		$pdf->SetFont('Arial','', 10);
		$pdf->AddPage();
		$maxWidth = ($pdf->w)-$pdf->lMargin-$pdf->rMargin;
		
		//primero dibujamos el "template" del remito (líneas, cuadros, etc).
		$y_encabezado = $this->dibujarEncabezado( $pdf, $oRemito, $pdf->tMargin, $maxWidth );
		$y_encabezado_renglones = $this->dibujarEncabezadoRenglones( $pdf, $y_encabezado, $maxWidth );
		//$y_renglones = $this->dibujarRenglones( $pdf, $oRemito, $y_encabezado_renglones, $maxWidth );

		//llenamos el pdf con la  info del remito.
		$this->parseEncabezado( $pdf, $oRemito, $pdf->tMargin, $maxWidth );
		$y_renglones = $this->parseRenglones( $pdf, $oRemito, $y_encabezado_renglones, $maxWidth );
		
		return $pdf;
	}
	
	public function getPDFPrint( $oRemito ){
		return new PDFPrintRemito();
	}

	public function getFuncion(){
		return 'Ver RemitoIngreso';
	}

	
	/**
	 * dibuja el encabezado del remito
	 * @param $pdf
	 * @return $y de lo último dibujado.
	 */
	public function dibujarEncabezado(PDFPrint $pdf, Remito $oRemito, $y, $maxWidth){
		//cuadro logo + info remito.
		$pdf->$y = $y;
	 	$pdf->SetLineWidth(.4);		
		$pdf->Cell($maxWidth/2, $this->y_cuadro_logo_remito, '',1,0,'C');
		$pdf->Cell($maxWidth/2, $this->y_cuadro_logo_remito, '' ,1,0,'C');
		$pdf->Ln();

		//cuadro info destinatario
		$pdf->$y = $this->dibujarCuadroInfoDestinatario($pdf, $oRemito, $pdf->$y, $maxWidth);
		
		//cuadro remitimos a ud.....
		$pdf->SetLineWidth(.4);
		$pdf->Cell($maxWidth, 8, '',1,0,'C');
		$pdf->Ln();
		
		return $pdf->y; 	
	}
	
	protected function dibujarCuadroInfoDestinatario(PDFPrint $pdf, Remito $oRemito, $y, $maxWidth){
		$pdf->$y = $y;
		$pdf->SetLineWidth(.4);		
		$pdf->Cell( $maxWidth, $this->y_cuadro_destinatario, '',1,0,'C');
		$pdf->Ln();		
		$pdf->SetLineWidth(.1);
		$y_linea_proveedor = $this->y_cuadro_logo_remito + $this->y_cuadro_destinatario + 1;	
		$y_linea_domicilio = $y_linea_proveedor + 7;
		$pdf->Line(31, $y_linea_proveedor, 145, $y_linea_proveedor);//linea proveedor
		$pdf->Line(160, $y_linea_proveedor, 198, $y_linea_proveedor);//linea cuit
		$pdf->Line(31, $y_linea_domicilio, 138, $y_linea_domicilio);//linea domicilio
		$pdf->Line(160, $y_linea_domicilio, 198, $y_linea_domicilio	);//linea localidad
		return $pdf->y;
	}	
	
	public function dibujarEncabezadoRenglones(PDFPrint $pdf, $y, $maxWidth){
		$pdf->y = $y;
		$pdf->SetLineWidth(.4);
		$this->columnsWidth = array(20, ($maxWidth)-90, 20, 30, 20);
		$columns = array('Código', 'Nombre Material', 'N° Material', 'Catálogo', 'Cantidad');
		$pdf->SetFillColor(218,218,218);
		$pdf->Cell($this->columnsWidth[0], 8, $columns[0],1,0,'C',1);
		$pdf->Cell($this->columnsWidth[1], 8, $columns[1],1,0,'C',1);
		$pdf->Cell($this->columnsWidth[2], 8, $columns[2],1,0,'C',1);
		$pdf->Cell($this->columnsWidth[3], 8, $columns[3],1,0,'C',1);
		$pdf->Cell($this->columnsWidth[4], 8, $columns[4],1,0,'C',1);
		$pdf->Ln();
		return $pdf->y;
	}
		
	/*
	public function dibujarRenglones(PDFPrint $pdf, $oRemito, $y, $maxWidth){
		$pdf->y = $y;
		
		$pdf->SetFontSize(8);
		//DETALLES DEL REMITO.
		$cantidadCeldas = $oRemito->getProductos()->size();
		$y_detalles = $y + (($cantidadCeldas+1) * 8);
		for ($i=0; $i<$cantidadCeldas; $i++){
				$pdf->Cell($this->columnsWidth[0], 8, '',1,0,'C');
				$pdf->Cell($this->columnsWidth[1], 8, '',1,0,'L');
				$pdf->Cell($this->columnsWidth[2], 8, '',1,0,'C');
				$pdf->Cell($this->columnsWidth[3], 8, '',1,0,'C');
				$pdf->Cell($this->columnsWidth[4], 8, '',1,0,'C');
				$pdf->Ln();
		}
		
		return $pdf->y;
	}*/
	
	
	public function parseRemito(PDFPrint $pdf, Remito $oRemito, $maxWidth){
		$this->parseEncabezado( $pdf, $oRemito, $maxWidth );
		$this->parseRenglones( $pdf, $oRemito, $maxWidth );
		$this->parseFirma( $pdf, $oRemito, $maxWidth );
	}
	
	protected function parseLogo(PDFPrint $pdf, Remito $oRemito, $y, $maxWidth){
		//IMAGEN KAIZEN.
		$pdf->y = $y;
		
		$pdf->Cell($maxWidth/2,$this->y_cuadro_logo_remito, '',0,0,'C');
		$pdf->Image(APP_PATH . 'img/LogoKaizen.JPG',$pdf->rMargin+10,$pdf->tMargin+4, 70,18);
		return $pdf->y;
	}
	
	protected function parseInfoRemito(PDFPrint $pdf, Remito $oRemito, $y, $maxWidth){
		//IMAGEN KAIZEN.
		$pdf->y = $y;
		
		$pdf->SetFontSize(8);
		$pdf->Cell($maxWidth/2 + 20,10, '' ,0,0,'L');
		$pdf->Cell(12,7, 'Fecha ' ,1,0,'L');
		$pdf->Cell(17,7, FuncionesComunes::fechaMysqlaPHP($oRemito->getDt_fecha()) ,1,0,'L');
		$pdf->Ln();
		$pdf->SetFontSize(7);
		$pdf->Cell($maxWidth,2, '' ,0,0,'C');
		$pdf->Ln();
		$pdf->Cell($maxWidth/2,5, REMITO_DOMICILIO ,0,0,'C');
		$pdf->Cell(20,5, '' ,0,0,'C');
		$pdf->Cell(12,4, 'C.U.I.T.: ' . REMITO_CUIT ,0,0,'L');
		$pdf->Ln();
		$pdf->Cell($maxWidth/2,5, REMITO_DOMICILIO2 ,0,0,'C');
		$pdf->Cell(20,5, '' ,0,0,'C');
		$pdf->Cell(12,4, 'Ing. Brutos: ' . REMITO_ING_BRUTOS ,0,0,'L');
		$pdf->Ln();
		$pdf->Cell($maxWidth/2,5, 'Tel.: '. REMITO_TEL ,0,0,'C');
		$pdf->Cell(20,5, '' ,0,0,'C');
		$pdf->Cell(12,4, REMITO_AGENTE_RETENCION ,0,0,'L');
		$pdf->Ln();
		$pdf->SetFontSize(5);
		$pdf->Cell($maxWidth/2,5, REMITO_CONDICION_IVA ,0,0,'C');
		$pdf->Cell(20,5, '' ,0,0,'C');
		$pdf->SetFontSize(7);
		$pdf->Cell(12,4, 'Inicio de Actividades: ' . REMITO_INICIO_ACTIVIDADES ,0,0,'L');
		$pdf->Ln();
		return $pdf->y;
	}
	
	
	protected function parseInfoTituloRemito(PDFPrint $pdf, Remito $oRemito, $y, $maxWidth){
		//IMAGEN KAIZEN.
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
		$pdf->Cell(20,7, 'N° ' . $oRemito->getCd_remito() ,0,0,'L');
		$pdf->Ln();
		
		return $pdf->y;
	}
	
	
	protected function parseInfoDestinatario(PDFPrint $pdf, Remito $oRemito, $y, $maxWidth){
		//IMAGEN KAIZEN.
		$pdf->y = $y;
		
		$pdf->SetFontSize(10);
		$pdf->y = $this->y_cuadro_logo_remito + $this->y_cuadro_destinatario-5;
		
		$pdf->Cell(20,7, 'Proveedor:',0,0,'R');
		$pdf->Cell(110,7, $oRemito->getProveedor()->getDs_razonSocial() ,0,0,'L');
		$pdf->Cell(20,7, 'CUIT: ',0,0,'R');
		$pdf->Cell(65,7, $oRemito->getProveedor()->getDs_cuit() ,0,0,'L');
		$pdf->Ln();

		$pdf->Cell(20,7, 'Domicilio:',0,0,'R');
		$pdf->Cell(110,7, $oRemito->getProveedor()->getDs_domicilio() ,0,0,'L');
		$pdf->Cell(20,7, 'Localidad: ',0,0,'R');
		$pdf->Cell(65,7, $oRemito->getProveedor()->getDs_localidad() ,0,0,'L');
		$pdf->Ln();
		
		return $pdf->y;
	}
	
	public function parseEncabezado(PDFPrint $pdf, Remito $oRemito, $y, $maxWidth){

		$pdf->y = $y;
		
		//IMAGEN KAIZEN.
		$pdf->y = $this->parseLogo($pdf, $oRemito, $pdf->y, $maxWidth);
		
		//INFO DEL REMITO.
		$pdf->y = $this->parseInfoTituloRemito($pdf, $oRemito, $pdf->y, $maxWidth);
		$pdf->y = $this->parseInfoRemito($pdf, $oRemito, $pdf->y, $maxWidth);

		//DATOS DEL DESTINATARIO.
		$pdf->y = $this->parseInfoDestinatario($pdf, $oRemito, $pdf->y, $maxWidth);

		$pdf->Cell(20,10, 'Remitimos a ud. lo siguiente:',0,0,'L');
		$pdf->Ln();		
		
		return $pdf->y;
	}
	
	public function parseRenglones(PDFPrint $pdf, Remito $oRemito, $y, $maxWidth){
		
		$pdf->y = $y;
		$pdf->SetFontSize(8);
		//DETALLES DEL REMITO.
		foreach($oRemito->getProductos() as $key => $oProducto) {

			$pdf->Cell($this->columnsWidth[0], 8, $oProducto->getCd_producto(),1,0,'C');
			$pdf->Cell($this->columnsWidth[1], 8, $oProducto->getDs_producto(),1,0,'L');
			$pdf->Cell($this->columnsWidth[2], 8, $oProducto->getDs_numero(),1,0,'C');
			$pdf->Cell($this->columnsWidth[3], 8, $oProducto->getTipoProducto()->getDs_codigoSAP(),1,0,'C');
			$pdf->Cell($this->columnsWidth[4], 8, $oProducto->getDs_cantidad(),1,0,'C');
			$pdf->Ln();
		}			
		return $pdf->y;
	}

	
}