<?php
/**
 * Acciï¿½n para exportar a pdf un formulario de venta
 *
 * @author lucrecia
 * @since 25-02-2011
 *
 */
class PDFBoletoCompraVentaAction extends SecureAction{

	protected function getFormulario(){
		$cd_venta = FormatUtils::getParam('id',0);
		$manager = new VentaManager();
		$oVenta = $manager->getVentaPorId($cd_venta);
		return $oVenta;
	}

	protected function getTextoContrato(){
		$ds_nombre = "boleto_compra_venta";
		$manager = new ParametroManager();
		$criterio = new CriterioBusqueda();
		$criterio->addFiltro("ds_nombre", "'$ds_nombre'", "LIKE");
		$oParametro = $manager->getParametro($criterio);
		return $oParametro->getDs_contenido();
	}

	protected function getTitle(){
		return 'Boleto Compra Venta';
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

		$pdfConcat->concat();
		$pdfConcat->SetTitle( $this->getPDFTitle( $oVenta ) );
		$pdfConcat->Output($this->getPDFTitle( $oVenta ) . ".pdf", "D");

		//para que no haga el forward.
		$forward = null;

		return $forward;
	}

	public function getPDFTitle( $oVenta ){
		return "Boleto de Compra Venta ";
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
		$pdf->SetAutoPageBreak(true, 15);
		$pdf->SetMargins(15, 40, 15);
		$pdf->title = $this->getTitle();
		$pdf->SetFont('Arial','', 11);
		$pdf->AddPage();
		$pdf->align = "j";

		$maxWidth = ($pdf->w)-$pdf->lMargin-$pdf->rMargin;

		//llenamos el pdf con la  info del remito.
		$this->parseContenido($pdf, $oVenta, $pdf->tMargin );
		if($tipoCopiaTexto =="DUPLICADO"){
			$this->parseFooterDuplicado($pdf, $oVenta);
		}

		return $pdf;
	}

	public function getPDFPrint( $oVenta ){
		return new PDFPrintBoleto();
	}

	public function getFuncion(){
		return 'Imprimir Boleto';
	}

	public function parseContenido(PDFPrint $pdf, Venta $oVenta, $y){
		//Relleno las variables de cada dato
		$this->parseCliente($pdf, $oVenta);
		$this->parseUnidad($pdf, $oVenta);
		$vendedor_apynom = $oVenta->getUsuario()->getDs_apynom();
		$localidad_sucursal = $oVenta->getSucursal()->getDs_localidad();
		$celda_width = 180;
		$pdf->Cell(180, 2, "", 1, 1, "L");
		$pdf->SetFont("Arial", "B", 8);
		$pdf->SetFillColor(180, 180, 180);
		$pdf->Cell(40, 4, "Vendedor", "LTB", 0, "L", 1);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetFont("Arial", "", 8);
		$pdf->Cell(140, 4, $vendedor_apynom, "RTB", 1, "L");
		$texto_contrado = $this->getTextoContrato();
		$pdf->MultiCell(180, 4, $texto_contrado, "RLT", "J", false);

		$hoy = date('d-m-Y');
		$array_hoy = explode("-", $hoy);
		$mes = FuncionesComunes::getMesDeNumero($array_hoy[1]);
		$dia_hoy = $array_hoy[0];
		$mes_hoy = $mes;
		$anio_hoy = $array_hoy[2];

		$texto_footer = "En prueba de conformidad se firman dos ejemplares del mismo tenor y a un solo efecto en la ciudad de $localidad_sucursal, a los $dia_hoy días, del mes de $mes_hoy de $anio_hoy";
		$pdf->MultiCell(180, 4, $texto_footer, "RLB", "J", flase);
		$pdf->Ln(20);
		$y = $pdf->GetY();
		$x = $pdf->GetX();

		$pdf->Cell(50, 4, "Firma del Titular", "T", 0, "C");
		$pdf->Cell(15, 4, " ", 0, 0, "C");
		$pdf->Cell(50, 4, "Firma del Autorizado", "T", 0, "C");
		$pdf->Cell(15, 4, " ", 0, 0, "C");
		$pdf->Cell(50, 4, "Sello del concesionario", "T", 0, "C");

	}

	function parseFooterDuplicado($pdf, $oVenta){
		$pdf->Ln(15);
		$pdf->Cell(180, 4, "DETALLE DE LA OPERACIÓN", 0, 1, "C");
		$pdf->Cell(30, 4, "Forma de Pago", 1, 0, "C");
		$pdf->Cell(30, 4, "Entidad", 1, 0, "C");
		$pdf->Cell(20, 4, "Importe", 1, 0, "C");
		$pdf->Cell(20, 4, "Fecha Pago", 1, 0, "C");
		$pdf->Cell(40, 4, "Importe pagado", 1, 0, "C");
		$pdf->Cell(40, 4, "Fecha Cra.", 1, 1, "C");


		$cd_venta = $oVenta->getCd_venta();
		$criterio = new CriterioBusqueda();
		$criterio->addFiltro("cd_venta", $cd_venta, "=");
		$ds_formapago = $oVenta->getDs_formapago();
		$itempagoManager = new ItempagoManager();
		$itemspagos = $itempagoManager->getItemspago($criterio);
		foreach($itemspagos as $itempago){
			$pdf->Cell(30, 4, $ds_formapago, 1, 0, "C");
			$pdf->Cell(30, 4, $itempago->getDs_entidad(), 1, 0, "L");
			$pdf->Cell(20, 4, "$".$itempago->getNu_importe(), 1, 0, "L");
			$pdf->Cell(20, 4, $itempago->getDt_pago(), 1, 0, "L");
			$pdf->Cell(40, 4, "$".$itempago->getNu_pagado(), 1, 0, "L");
			$pdf->Cell(40, 4, $itempago->getDt_contadora(), 1, 1, "L");
		}
		return $pdf;
	}

	function parseUnidad($pdf, $oVenta){
		$unidad_tipo = $oVenta->getUnidad()->getProducto()->getDs_tipounidad();
		$unidad_marca = $oVenta->getUnidad()->getProducto()->getDs_marca();
		$unidad_color = $oVenta->getUnidad()->getProducto()->getDs_color();
		$unidad_modelo = $oVenta->getUnidad()->getProducto()->getDs_modelo();
		$unidad_aniomodelo = $oVenta->getUnidad()->getNu_aniomodelo();
		$unidad_numotor = $oVenta->getUnidad()->getNu_motor();
		$unidad_nucuadro = $oVenta->getUnidad()->getNu_cuadro();
		$unidad_patente = $oVenta->getUnidad()->getNu_patente();

		$pdf->SetFillColor(180, 180, 180);
		$pdf->Cell($celda_width, 4, "DATOS DEL BIEN" ,1,1, "C", true);
		$pdf->SetFillColor(255, 255, 255);
		//TITULOS: Tipo Marca Modelo Aï¿½o Modelo
		$pdf->SetFont("Arial", "B", 8);
		$pdf->Cell(45, 4, "Tipo", "L",0, "L");
		$pdf->Cell(45, 4, "Marca", 0,0, "L");
		$pdf->Cell(45, 4, "Modelo", 0,0, "L");
		$pdf->Cell(45, 4, "Año - Modelo", "R",1, "L");
		$pdf->SetFont("Arial", "", 8);
		$pdf->Cell(45, 4, $unidad_tipo, "L",0, "L");
		$pdf->Cell(45, 4, $unidad_marca, 0,0, "L");
		$pdf->Cell(45, 4, $unidad_modelo, 0,0, "L");
		$pdf->Cell(45, 4, $unidad_aniomodelo, "R",1, "C");
		//Patente Nro Motor, nro cuadro
		$pdf->SetFont("Arial", "B", 8);
		$pdf->Cell(45, 4, "Patente", "L",0, "L");
		$pdf->Cell(45, 4, "Nro Motor", 0,0, "L");
		$pdf->Cell(45, 4, "Nro Cuadro", 0,0, "L");
                $pdf->Cell(45, 4, "Color", "R",1, "L");
		$pdf->SetFont("Arial", "", 8);
		$pdf->Cell(45, 4, $unidad_patente, "L",0, "L");
		$pdf->Cell(45, 4, $unidad_numotor, 0,0, "L");
		$pdf->Cell(45, 4, $unidad_nucuadro, 0,0, "L");
                $pdf->Cell(45, 4, $unidad_color, "R",1, "L");

	}

	function parseCliente($pdf, $oVenta){
		$dir_sucursal = $oVenta->getSucursal()->getDs_domicilio();
		$cliente_apynom = $oVenta->getCliente()->getDs_apynom();
		$cliente_doc = $oVenta->getCliente()->getDs_tipodoc()." ".$oVenta->getCliente()->getNu_doc();
		$cliente_nacionalidad = $oVenta->getCliente()->getDs_nacionalidad();
		$cliente_cp = $oVenta->getCliente()->getDs_cp();
		$cliente_dtnacimiento = $oVenta->getCliente()->getDt_nacimiento();
		$cliente_estadocivil = $oVenta->getCliente()->getDs_estadocivil();
		$cliente_condominio = $oVenta->getCliente()->getDs_conyuge();
		$cliente_calle = $oVenta->getCliente()->getDs_dircalle();
		$cliente_nro = $oVenta->getCliente()->getDs_dirnro();
		$cliente_piso = $oVenta->getCliente()->getDs_dirpiso();
		$cliente_dto = $oVenta->getCliente()->getDs_dirdepto();
		$cliente_localidad = $oVenta->getCliente()->getDs_localidad();
		$cliente_provincia = $oVenta->getCliente()->getDs_provincia();
		$cliente_telparticular = $oVenta->getCliente()->getDs_teparticular();
		$cliente_tellaboral = $oVenta->getCliente()->getDs_telaboral();				$cliente_email = $oVenta->getCliente()->getDs_email();
		$cliente_cuil = $oVenta->getCliente()->getDs_cuil_cuit();
		$celda_width = 180;
		$pdf->SetFont("Arial", "", 8);
		$pdf->Cell($celda_width, 4, "BOLETO DE COMPRA VENTA PARA  MOTOVEHICULOS/Otros Bienes" , "LTR",1, "C");
		$pdf->Cell($celda_width, 4, "BOLETO N.". ($oVenta->getCd_venta()+10000) , "LBR",1, "R");
		$texto = "Conste por el presente que en el lugar y fecha indicados en el pie de la presente, se realiza la operación de Venta detallando los datos del titular y del respectivo bien.";
		$pdf->MultiCell($celda_width, 4, $texto, 1,"L", 0);
		$pdf->SetFillColor(180, 180, 180);
		$pdf->Cell($celda_width, 4, "DATOS DEL TITULAR" ,1,1, "C", true);
		$pdf->SetFillColor(255, 255, 255);
		//Apellido y nombre
		$pdf->SetFont("Arial", "B", 8);
		$pdf->Cell($celda_width - 110, 4, "Apellido y nombre/Razón Social:", "LT",0, "L");
		$pdf->SetFont("Arial", "", 8);
		$pdf->Cell($celda_width - 70, 4, $cliente_apynom, "RT",1, "L");
		//domicilio
		$pdf->SetFont("Arial", "B", 8);
		$pdf->Cell(40, 4, "Domicilio:", "L",0, "L");
		$pdf->SetFont("Arial", "", 8);
		$pdf->Cell(70, 4, $cliente_calle, 0,0, "L");
		$pdf->Cell(20, 4, "N.:".$cliente_nro, 0,0, "L");
		$pdf->Cell(15, 4, "PISO: ".$cliente_piso, 0,0, "L");
		$pdf->SetFont("Arial", "B", 8);
		$pdf->Cell(15, 4, "Depto:", 0,0, "L");
		$pdf->SetFont("Arial", "", 8);
		$pdf->Cell(20, 4, $cliente_dto, "R",1, "L");
		//Localidad y Cdigo postal
		$pdf->SetFont("Arial", "B", 8);
		$pdf->Cell(40, 4, "Localidad:", "L",0, "L");
		$pdf->SetFont("Arial", "", 8);
		$pdf->Cell(40, 4, $cliente_localidad, 0,0, "L");
		$pdf->SetFont("Arial", "B", 8);
		$pdf->Cell(20, 4, "", 0,0, "L");
		$pdf->Cell(20, 4, "Cód. Postal:", 0,0, "L");
		$pdf->SetFont("Arial", "", 8);
		$pdf->Cell(60, 4, $cliente_cp, "R",1, "L");
		//Provincia y Te. Particular
		$pdf->SetFont("Arial", "B", 8);
		$pdf->Cell(40, 4, "Provincia:", "L",0, "L");
		$pdf->SetFont("Arial", "", 8);
		$pdf->Cell(40, 4, $cliente_provincia, 0,0, "L");
		$pdf->SetFont("Arial", "B", 8);
		$pdf->Cell(20, 4, "", 0,0, "L");
		$pdf->Cell(20, 4, "TE. Particular:", 0,0, "L");
		$pdf->SetFont("Arial", "", 8);
		$pdf->Cell(60, 4, $cliente_telparticular, "R",1, "L");
		//fecha nacimiento y tel laboral
		$pdf->SetFont("Arial", "B", 8);
		$pdf->Cell(40, 4, "Fecha nacimiento:", "L",0, "L");
		$pdf->SetFont("Arial", "", 8);
		$pdf->Cell(40, 4, $cliente_dtnacimiento, 0,0, "L");
		$pdf->SetFont("Arial", "B", 8);
		$pdf->Cell(20, 4, "", 0,0, "L");
		$pdf->Cell(20, 4, "TE. Movil:", 0,0, "L");
		$pdf->SetFont("Arial", "", 8);
		$pdf->Cell(60, 4, $cliente_tellaboral, "R",1, "L");
		//Estado civil
		$pdf->SetFont("Arial", "B", 8);
		$pdf->Cell(40, 4, "Estado Civil:", "L",0, "L");
		$pdf->SetFont("Arial", "", 8);
		$pdf->Cell(40, 4, $cliente_estadocivil, 0,0, "L");				$pdf->Cell(20, 4, "", 0,0, "L");				$pdf->SetFont("Arial", "B", 8);		$pdf->Cell(20, 4, "E-mail:", 0,0, "L");		$pdf->SetFont("Arial", "", 8);		$pdf->Cell(60, 4, $cliente_email, "R",1, "L");
		//$pdf->Cell(100, 4, "", "R",1, "C");
		//Conyuge
		$pdf->SetFont("Arial", "B", 8);
		$pdf->Cell(40, 4, "Conyuge:", "L",0, "L");
		$pdf->SetFont("Arial", "", 8);
		$pdf->Cell(40, 4, $cliente_condominio, 0,0, "L");
		$pdf->Cell(100, 4, "", "R",1, "C");
		//Nacionalidad
		$pdf->SetFont("Arial", "B", 8);
		$pdf->Cell(40, 4, "Nacionalidad:", "L",0, "L");
		$pdf->SetFont("Arial", "", 8);
		$pdf->Cell(40, 4, $cliente_nacionalidad, 0,0, "L");
		$pdf->Cell(100, 4, "", "R",1, "C");
		//dni CUIL/CUIT
		$pdf->SetFont("Arial", "B", 8);
		$pdf->Cell(40, 4, "DNI", "L",0, "L");
		$pdf->SetFont("Arial", "", 8);
		$pdf->Cell(40, 4, $cliente_doc, 0,0, "L");
		$pdf->SetFont("Arial", "B", 8);
		$pdf->Cell(20, 4, "", 0,0, "L");
		$pdf->Cell(20, 4, "CUIT/CUIL:", 0,0, "L");
		$pdf->SetFont("Arial", "", 8);
		$pdf->Cell(60, 4, $cliente_cuil, "R",1, "L");
		//$pdf->Cell($celda_width, 3, "", 1,1, "C");
	}
}