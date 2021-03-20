<?php 

/**
 * Acción para exportar a pdf un consumo estimado
 * de productos.
 * 
 * @author Lucrecia
 * @since 21-01-2011
 * 
 */
class PDFConsumoEstimadoAction extends SecureAction{

	protected $columnsWidth;
	protected $y_cuadro_destinatario=15;
	protected $y_cuadro_logo_remito=40;
	
	private function getConsumoEstimado(){
		$cd_consumo = FormatUtils::getParam('id',0);
		$manager = new ConsumoEstimadoManager();
		$oConsumoEstimado = $manager->getConsumoEstimadoPorId ( $cd_consumo );
		return $oConsumoEstimado;
	}
	
	protected function getTitle(){
		return 'Consumo Cliente';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#executeImpl()
	 */
	public function executeImpl(){
		
		//tipo de la copia del remito.
		$tipo= FormatUtils::getParam('tipo',0);
		if($tipo==1){
			$tipoCopiaTexto= 'COPIA ORIGINAL';
		}else if($tipo==2){
			$tipoCopiaTexto = 'DUPLICADO';
		}else $tipoCopiaTexto = 'TRIPLICADO';
		
		$oConsumoEstimado = $this->getConsumoEstimado();

		//armamos el pdf.
		$pdf = new PDFPrint("P");
		$pdf->title = $this->getTitle();
		$pdf->SetFont('Arial','', 10);
		$pdf->AddPage();
		$maxWidth = ($pdf->w)-$pdf->lMargin-$pdf->rMargin;
		
		//primero dibujamos el "template" del remito (líneas, cuadros, etc).
		$y_encabezado = $this->dibujarEncabezado( $pdf, $oConsumoEstimado, $pdf->tMargin, $maxWidth );
		$y_encabezado_renglones = $this->dibujarEncabezadoRenglones( $pdf, $y_encabezado, $maxWidth );
		$y_renglones = $this->dibujarRenglones( $pdf, $y_encabezado_renglones, $maxWidth );
		$y_firma = $this->dibujarFirma( $pdf, $y_renglones, $maxWidth );

		//llenamos el pdf con la  info del consumo estimado.
		$this->parseEncabezado( $pdf, $oConsumoEstimado, $pdf->tMargin, $maxWidth );
		$this->parseRenglones( $pdf, $oConsumoEstimado, $y_encabezado_renglones, $maxWidth );
		$this->parseFirma( $pdf, $oConsumoEstimado, $y_renglones, $maxWidth );
		
		//tipo de copia.
		$pdf->SetFontSize(8);
		$pdf->RotatedText(7, $pdf->h/2, $tipoCopiaTexto, 90);
		
		$pdf->Output();
				
		//para que no haga el forward.
		$forward = null;
				
		return $forward;
	}
	
	public function getFuncion(){
		return 'Ver ConsumoEstimado';
	}

	
	/**
	 * dibuja el encabezado del consumo estimado
	 * @param $pdf
	 * @return $y de lo último dibujado.
	 */
	public function dibujarEncabezado(PDFPrint $pdf, ConsumoEstimado  $oConsumoEstimado, $y, $maxWidth){
		//cuadro logo + info remito.
		$pdf->$y = $y;
	 	$pdf->SetLineWidth(.4);		
		$pdf->Cell($maxWidth/2, $this->y_cuadro_logo_remito, '',1,0,'C');
		$pdf->Cell($maxWidth/2, $this->y_cuadro_logo_remito, '' ,1,0,'C');
		$pdf->Ln();

		//cuadro info destinatario
		$pdf->$y = $this->dibujarCuadroInfoDestinatario($pdf, $oConsumoEstimado, $pdf->$y, $maxWidth);
		
		//cuadro remitimos a ud.....
		$pdf->SetLineWidth(.4);
		$pdf->Cell($maxWidth, 8, '',1,0,'C');
		$pdf->Ln();
		
		return $pdf->y; 	
	}
	
	protected function dibujarCuadroInfoDestinatario(PDFPrint $pdf, ConsumoEstimado $oConsumoEstimado, $y, $maxWidth){
		$pdf->$y = $y;
		$pdf->SetLineWidth(.4);		
		$pdf->Cell( $maxWidth, $this->y_cuadro_destinatario, '',1,0,'C');
		$pdf->Ln();		
		$pdf->SetLineWidth(.1);

		
		$y_linea_destinatario = $this->y_cuadro_logo_remito + $this->y_cuadro_destinatario + 1;	
		$y_linea_obra = $y_linea_destinatario + 7;
		
		$pdf->Line(31, $y_linea_destinatario, 198, $y_linea_destinatario);//linea cliente
		
		$pdf->Line(31, $y_linea_obra, 198, $y_linea_obra);//linea obra
		
		
		return $pdf->y;
	}	
	
	public function dibujarEncabezadoRenglones(PDFPrint $pdf, $y, $maxWidth){
		$pdf->y = $y;
		$pdf->SetLineWidth(.4);
		$this->columnsWidth = array(30, 40, ($maxWidth)-90,  20);
		$columns = array('Catálogo', 'Catálogo SAP', 'Descripción', 'Cantidad');
		$pdf->SetFillColor(218,218,218);
		$pdf->Cell($this->columnsWidth[0], 8, $columns[0],1,0,'C',1);
		$pdf->Cell($this->columnsWidth[1], 8, $columns[1],1,0,'C',1);
		$pdf->Cell($this->columnsWidth[2], 8, $columns[2],1,0,'C',1);
		$pdf->Cell($this->columnsWidth[3], 8, $columns[3],1,0,'C',1);
		$pdf->Ln();
		return $pdf->y;
	}
		
	public function dibujarRenglones(PDFPrint $pdf, $y, $maxWidth){
		$pdf->y = $y;
		
		$pdf->SetFontSize(8);
		//DETALLES DEL REMITO.
		$cantidadCeldas = 20;
		$y_detalles = $y + (($cantidadCeldas+1) * 8);
		for ($i=0; $i<$cantidadCeldas; $i++){
				$pdf->Cell($this->columnsWidth[0], 8, '',1,0,'C');
				$pdf->Cell($this->columnsWidth[1], 8, '',1,0,'C');
				$pdf->Cell($this->columnsWidth[2], 8, '',1,0,'C');
				$pdf->Cell($this->columnsWidth[3], 8, '',1,0,'C');
				$pdf->Ln();
		}
		
		return $pdf->y;
	}
	
	public function dibujarFirma(PDFPrint $pdf, $y, $maxWidth){
		//cuadro firma, entregado por.....
		$pdf->y = $y + 5;
		$pdf->Cell(20,7, 'Firma:',0,0,'L');
		$pdf->Ln();
		$pdf->Cell(20,7, 'Entregado por:',0,0,'L');
		$pdf->Ln();
		$pdf->Cell(20,7, 'Recibido por:',0,0,'L');
		$pdf->Ln();
		$pdf->Cell(20,7, 'DNI:',0,0,'L');
		$pdf->Ln();
		
		$pdf->SetLineWidth(.1);
		$y_linea_firma = $y + 11;
		$pdf->Line(23, $y_linea_firma, 100, $y_linea_firma);//linea firma
		
		$y_linea_entregadoPor = $y_linea_firma + 7;
		$pdf->Line(35, $y_linea_entregadoPor, 100, $y_linea_entregadoPor);//linea entregado por
		
		$y_linea_recibidoPor = $y_linea_entregadoPor + 7;
		$pdf->Line(35, $y_linea_recibidoPor, 100, $y_linea_recibidoPor);//linea recibido por
		
		$y_linea_dni = $y_linea_recibidoPor + 7;
		$pdf->Line(23, $y_linea_dni, 100, $y_linea_dni);//linea dni		
	}
	
	public function parseConsumoEstimado(PDFPrint $pdf, ConsumoEstimado $oConsumoEstimado, $maxWidth){
		$this->parseEncabezado( $pdf, $oConsumoEstimado, $maxWidth );
		$this->parseRenglones( $pdf, $oConsumoEstimado, $maxWidth );
		$this->parseFirma( $pdf, $oConsumoEstimado, $maxWidth );
	}
	
	protected function parseLogo(PDFPrint $pdf, ConsumoEstimado $oConsumoEstimado, $y, $maxWidth){
		//IMAGEN KAIZEN.
		$pdf->y = $y;
		
		$pdf->Cell($maxWidth/2,$this->y_cuadro_logo_remito, '',0,0,'C');
		$pdf->Image(APP_PATH . 'img/LogoKaizen.JPG',$pdf->rMargin+10,$pdf->tMargin+4, 70,18);
		return $pdf->y;
	}
	
	protected function parseInfoConsumoEstimado(PDFPrint $pdf, ConsumoEstimado $oConsumoEstimado, $y, $maxWidth){
		$pdf->y = $y;
		
		$pdf->SetFontSize(8);
		$pdf->Cell($maxWidth/2 + 20,10, '' ,0,0,'L');
		$pdf->Cell(12,7, 'Fecha ' ,1,0,'L');
		$pdf->Cell(17,7, FuncionesComunes::fechaMysqlaPHP($oConsumoEstimado->getDt_fecha()) ,1,0,'L');
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
	
	
	protected function parseInfoTituloConsumoEstimado(PDFPrint $pdf, ConsumoEstimado $oConsumoEstimado, $y, $maxWidth){
		$pdf->y = $y;
		
		$pdf->SetFontSize(12);
		$pdf->SetLineWidth(.1);
		$pdf->Cell(5,7, '' ,0,0,'L');
		$pdf->Cell(50,7, 'CONSUMO CLIENTE' ,0,0,'L');
		$pdf->SetFontSize(5);
		$pdf->Cell(40,7, 'DOCUMENTO NO VALIDO COMO FACTURA' ,0,0,'L');
		$pdf->Ln();
		$pdf->SetFontSize(12);
		$pdf->Cell($maxWidth/2 + 5,10, '' ,0,0,'L');
		$pdf->Cell(25,7, 'Código ' . $oConsumoEstimado->getCd_consumo() ,0,0,'L');
		$pdf->Ln();
		
		return $pdf->y;
	}
	
	
	protected function parseInfoDestinatario(PDFPrint $pdf, ConsumoEstimado $oConsumoEstimado, $y, $maxWidth){
		//IMAGEN KAIZEN.
		$pdf->y = $y;
		
		$pdf->SetFontSize(10);
		$pdf->y = $this->y_cuadro_logo_remito + $this->y_cuadro_destinatario-5;
		
		$pdf->Cell(20,7, 'Cliente:',0,0,'R');
		$pdf->Cell(110,7, $oConsumoEstimado->getDs_cliente() ,0,0,'L');
		
		$pdf->Ln();

		$pdf->Cell(20,7, 'Obra:',0,0,'R');
		$pdf->Cell(180,7, $oConsumoEstimado->getObra()->getDs_tipoObraFormateada() . ' - ' . $oConsumoEstimado->getObra()->getDs_subtipoObraFormateada() ,0,0,'L');
		$pdf->Ln();
		
		return $pdf->y;
	}
	
	public function parseEncabezado(PDFPrint $pdf, ConsumoEstimado $oConsumoEstimado, $y, $maxWidth){

		$pdf->y = $y;
		
		//IMAGEN KAIZEN.
		$pdf->y = $this->parseLogo($pdf, $oConsumoEstimado, $pdf->y, $maxWidth);
		
		//INFO DEL REMITO.
		$pdf->y = $this->parseInfoTituloConsumoEstimado($pdf, $oConsumoEstimado, $pdf->y, $maxWidth);
		$pdf->y = $this->parseInfoConsumoEstimado($pdf, $oConsumoEstimado, $pdf->y, $maxWidth);

		//DATOS DEL DESTINATARIO.
		$pdf->y = $this->parseInfoDestinatario($pdf, $oConsumoEstimado, $pdf->y, $maxWidth);

		$pdf->Cell(20,10, 'Remitimos a ud. lo siguiente:',0,0,'L');
		$pdf->Ln();		
		
		return $pdf->y;
	}
	
	public function parseRenglones(PDFPrint $pdf, ConsumoEstimado $oConsumoEstimado, $y, $maxWidth){
		
		$pdf->y = $y;
		$pdf->SetFontSize(8);
		//DETALLES DEL REMITO.
		foreach($oConsumoEstimado->getProductosConsumidos() as $key => $oProductoConsumo) {
	

			$pdf->Cell($this->columnsWidth[0], 8, $oProductoConsumo->getTipoProducto()->getDs_codigoTelefonica(),1,0,'C');
			$pdf->Cell($this->columnsWidth[1], 8, $oProductoConsumo->getTipoProducto()->getDs_codigoSAP(),1,0,'C');
			$pdf->Cell($this->columnsWidth[2], 8, $oProductoConsumo->getTipoProducto()->getDs_tipoProducto(),1,0,'L');
			$pdf->Cell($this->columnsWidth[3], 8, $oProductoConsumo->getDs_cantidad(),1,0,'C');
			$pdf->Ln();
		}			
	}
	
	public function parseFirma(PDFPrint $pdf, ConsumoEstimado $oConsumoEstimado, $y,  $maxWidth){
		
	}
	
}