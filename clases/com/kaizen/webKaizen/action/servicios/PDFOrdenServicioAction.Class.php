<?php
//include 'fpdf/fpdfhtml.php';


/**

 * Acci�n para exportar a pdf una orden de servicio

 *

 * @author Marcos

 * @since 23-05-2012

 *

 */

class PDFOrdenServicioAction extends SecureAction{



	protected function getFormulario(){

		$cd_servicio = FormatUtils::getParam('id',0);

		$manager = new ServicioManager();

		$oServicio = $manager->getServicioPorId($cd_servicio);



		return $oServicio;

	}



	protected function getTitle(){

		return 'R 270 Orden de servicio';

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/action/generic/SecureAction#executeImpl()

	 */

	public function executeImpl(){



		//tipo de la copia del remito.

		$tipo= FormatUtils::getParam('tipo',0);



		$oServicio = $this->getFormulario();






		$pdfConcat = new PDFConcat();


		$pdf = $this->generarCopia( $oServicio);

		$pdf->Output($this->getTitle() . ".pdf");

		$pdfConcat->addFile( $this->getTitle() . ".pdf" );







		$pdfConcat->concat();

		$pdfConcat->SetTitle( $this->getPDFTitle( $oServicio ) );

		$pdfConcat->Output($this->getPDFTitle( $oServicio ) . ".pdf", "D");



		//para que no haga el forward.

		$forward = null;



		return $forward;

	}



	public function getPDFTitle( $oServicio ){

		return "R 270 Orden de servicio " . $oServicio->getCd_servicio();

	}



	/**

	 * genera una copia de pdf

	 *

	 * @param  $tipoCopiaTexto

	 */

	public function generarCopia($oServicio){



		//armamos el pdf.

		$pdf = $this->getPDFPrint( $oServicio );

		$pdf->setServicio( $oServicio );

		$pdf->SetAutoPageBreak(true);

		$pdf->title = $this->getTitle();

		$pdf->SetFont('Arial','', 8);

		$pdf->AddPage();

		$maxWidth = ($pdf->w)-$pdf->lMargin-$pdf->rMargin;



		//llenamos el pdf con la  info del remito.

		$this->parseContenido($pdf, $oServicio, $pdf->tMargin );



		return $pdf;

	}



	public function getPDFPrint( $oServicio ){

		return new PDFPrintOrdenServicio();

	}



	public function getFuncion(){

		return 'Imprimir Orden de Servicio';

	}



	public function parseContenido(PDFPrint $pdf, Servicio $oServicio, $y){



		/*$margin_top = 4;

		$margin_left = 0;

		$pdf->SetMargins(0, 0, 0);*/

		$pdf->SetFont('Arial','B', 6);
		$pdf->Cell(110, 4, 'ESTADO GENERAL DEL VEH�CULO', 'LTB', 0, 'L');
		$pdf->SetFont('Arial','', 6);
		$pdf->SetFillColor(210,210,210);
		$pdf->Cell(80, 4, 'Compromiso de entrega: '.$oServicio->getDt_compromisoentrega(), 'LTR', 1, 'L',1);
		$pdf->Cell(110, 4, 'KILOMETRAJE / HORAS: '.$oServicio->getDs_kmshoras(), 'LTB', 0, 'L');
		$pdf->Cell(80, 4, '', 'LBR', 1, 'L',1);
		$pdf->Cell(110, 40, '', 'LTB', 0, 'L');
		$pdf->Cell(80, 40, '', 'BR', 1, 'L');
		/*$pdf->Image('img/moto_1.jpg',11,73,55,36);
		$pdf->Image('img/moto_2.jpg',65,75,53,33);
		$pdf->Image('img/combustible.jpg',125,75,70,36);*/
		$pdf->Image('img/orden-st-motos.jpg',20,73,170,38);
		$pdf->SetFont('Arial','B', 6);
		$pdf->Cell(190, 4, 'OBSERVACIONES', 'LTBR', 1, 'L');
		$pdf->SetFont('Arial','', 6);
		$pdf->MultiCell(190, 4, $oServicio->getDs_obsgral(),'LBTR');
		$currentYposition = $pdf->GetY();
		$currentXposition = $pdf->GetX();
		$pdf->Cell(190, 60, '', 'LTBR', 1, 'L');
		$pdf->Image('img/orden-st-items.jpg',$currentXposition+1,$currentYposition,188,58);
		$pdf->SetFont('Arial','B', 6);
		$pdf->Cell(100, 4, 'DESCRIPCION DEL PEDIDO DEL CLIENTE', 'LTB', 0, 'L');
		$pdf->Cell(90, 4, 'SERVICIO: '.$oServicio->getDs_tiposervicio(), 'LTBR', 1, 'L');
		$pdf->SetFont('Arial','', 6);
		/*$ensanchar = '';
		for ($i = 0; $i < 800; $i++) {
			$ensanchar .= ' ';
		}
		$ds_descpedidocte = (strlen($oServicio->getDs_descpedidocte())>800)?$oServicio->getDs_descpedidocte():$oServicio->getDs_descpedidocte().$ensanchar;*/
		$pdf->MultiCell(190, 4, $oServicio->getDs_descpedidocte(),'LBTR');
		$pdf->SetFont('Arial','', 5);
		$pdf->Cell(190, 2, '', 'LTR', 1, 'L');
		$pdf->MultiCell(190, 2, 'Me declaro en conocimiento de la condicion en la que se encuentra la unidad, afirmando que los da�os en la carrocer�a detectados en el momento de la recepci�n, son los indicados en la figura. Autorizo a realizar todos los trabajos descriptos a mi exclusiva cuenta y cargo, y a efectuar todas las pruebas necesarias (inclu�das en ruta) de la unidad.','LR');
		$pdf->Cell(190, 2, '', 'LBR', 1, 'L');
		$pdf->SetFont('Arial','B', 5);
		$pdf->Cell(190, 6, 'VEHICULO INGRESADO EL', 'LTR', 1, 'L');
		$pdf->Cell(190, 4, '', 'LR', 1, 'L');
		$pdf->SetFont('Arial','', 5);
		$pdf->Cell(10, 4, '', 'L', 0, 'L');
		$pdf->Cell(20, 4, $oServicio->getDt_ingresovehiculo(), '', 0, "C");
		$pdf->Cell(160, 4, '', 'R', 1, 'L');
		$pdf->Cell(10, 4, '', 'LB', 0, 'L');
		$pdf->Cell(20, 4, FECHA, 'TB', 0, "C");
		$pdf->Cell(15, 4, '', 'B', 0, 'L');
		$pdf->Cell(70, 4, 'FIRMA DEL CLIENTE Y ACLARACI�N', 'T', 0, 'C');
		$pdf->Cell(15, 4, '', '', 0, 'L');
		$pdf->Cell(55, 4, 'FIRMA Y ACLARACI�N DEL RECEPCIONISTA', 'T', 0, 'C');
		$pdf->Cell(5, 4, '', 'R', 1, '');
		$pdf->SetFont('Arial','B', 6);
		$pdf->Cell(190, 4, 'DIAGNOSTICO Y REPARACION REALIZADA', 'LTBR', 1, 'L');
		$pdf->SetFont('Arial','', 6);

		for ($i = 0; $i < (800-strlen($oServicio->getDs_diagyreprealizada())); $i++) {
			$ensanchar .= ' ';
		}

		$pdf->MultiCell(190, 4, $oServicio->getDs_diagyreprealizada().$ensanchar,'LBTR');
		/*$pdf->SetFont('Arial','B', 8);
		$pdf->Cell(95, 4, 'REPUESTOS UTILIZADOS', 'LTBR', 0, 'L');
		$pdf->Cell(95, 4, 'MECANICOS', 'LTBR', 1, 'L');*/
		$pdf->SetFont('Arial','', 6);
		$pdf->ln(-5);
		$html ='<table border="1" cellpadding="0" cellspacing="0"><tbody><tr><td width= "90"><B>REPUESTOS UTILIZADOS</B></td><td width= "100"><B>MECANICOS</B></td></tr><tr><td rowspan="4">'.$oServicio->getDs_repuestosusados().'</td><td>'.$oServicio->getDs_mecanicos().'</td></tr><tr><td><B>INSTRUMENTOS DE MEDICION UTILIZADOS</B></td></tr><tr><td>'.$oServicio->getDs_instmedusados().'</td></tr><tr><td><B>TIEMPO MANO DE OBRA: '.$oServicio->getDs_tiempomanoobra().'</B></td></tr></tbody></table>';
		$pdf->WriteHTML($html);
        $pdf->ln();
		$pdf->SetFont('Arial','', 5);
		$pdf->MultiCell(190, 2, 'Dejo expresa constancia que luego de haber sido probada, retiro la unidad antes mencionada con los trabajos de reparaci�n realizados, declarando conocer y aceptar el estado en que se encuentra la misma. La unidad ser� retirada por el titular. En caso de no poder asistir, el responsable deber� acreditar la titularidad de la misma. (Fotocopia de DNI)','LTR');
		$pdf->SetFont('Arial','B', 5);
		$pdf->Cell(190, 6, 'VEHICULO RETIRADO EL', 'LR', 1, 'L');
		$pdf->Cell(190, 4, '', 'LR', 1, 'L');
		$pdf->SetFont('Arial','', 5);
		$pdf->Cell(10, 4, '', 'L', 0, 'L');
		$pdf->Cell(20, 4, '   /    /    ', '', 0, "C");
		$pdf->Cell(160, 4, '', 'R', 1, 'L');
		$pdf->Cell(10, 4, '', 'L', 0, 'L');
		$pdf->Cell(20, 4, FECHA, 'T', 0, "C");
		$pdf->Cell(15, 4, '', '', 0, 'L');
		$pdf->Cell(70, 4, 'FIRMA DEL CLIENTE Y ACLARACI�N', 'T', 0, 'C');
		$pdf->Cell(15, 4, '', '', 0, 'L');
		$pdf->Cell(45, 4, 'FIRMA DEL TECNICO Y LEGAJO', 'T', 0, 'C');
		$pdf->Cell(15, 4, '', 'R', 1, '');
		$pdf->Cell(190, '', '', 'LTBR', 1, 'L');
		/*$pdf->Cell(190, 10, '-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 'LTBR', 1, 'L');
		$pdf->SetFont('Arial','', 8);
		$pdf->Cell(140, 6, 'Estimado Cliente: Presente este comprobante al retirar su veh�culo del Concesionario el d�a', 'LT', 0, 'L');
		$pdf->SetFillColor(210,210,210);
		$pdf->Cell(50, 4, 'Compromiso de entrega: '.$oServicio->getDt_compromisoentrega(), 'LTBR', 1, 'L',1);
		$pdf->Cell(190, 4, '', 'LR', 1, 'L');
		$pdf->Cell(140, 6, 'VEHICULO INGRESADO EL', 'L', 0, 'L');

		$pdf->Cell(50, 6, 'Tel.: 0221-4831746', 'R', 1, 'L');
		$pdf->Cell(140, 4, '', 'LR', 0, 'L');
		$pdf->SetFont('Arial','U', 8);
		$pdf->SetFillColor(210,210,210);
		$pdf->Cell(50, 4, 'ORDEN DE SERVICIO', 'LTR', 1, 'L',1);
		$pdf->SetFont('Arial','', 7);
		$pdf->Cell(10, 4, '', 'L', 0, 'L');
		$pdf->Cell(20, 4, $oServicio->getDt_ingresovehiculo(), '', 0, "C");
		$pdf->Cell(110, 4, '', 'R', 0, 'L');
		$pdf->Cell(50, 4, 'N� '.$oServicio->getCd_servicio(), 'LBR', 1, 'L',1);
		$pdf->Cell(10, 4, '', 'L', 0, 'L');
		$pdf->Cell(20, 4, FECHA, 'T', 0, "C");
		$pdf->Cell(15, 4, '', '', 0, 'L');
		$pdf->Cell(90, 4, 'FIRMA DEL RECEPCIONISTA', 'T', 0, 'C');
		$pdf->Cell(55, 4, '', 'R', 1, '');
		$pdf->Cell(190, 4, '', 'LR', 1, 'L');
		$pdf->MultiCell(190, 3, 'Sr. Cliente: Su veh�culo con su respectiva llave y documentaci�n, permanecer� en el taller del concesionario durante los d�as estimados para efectuar la reparaci�n. Cumplido dicho t�rmino, el Concesionario podr� cobrar estad�a seg�n lo crea conveniente. ','LBR');
		//$this->parseSello($pdf);*/

		return $pdf->y;

	}



	function parseSello($pdf){

		//$pdf->SetXY(75, 150);

		$pdf->SetXY(80, 120);

		$pdf->SetFont('Arial','', 6);

		$pdf->SetTextColor(123, 123, 123);

		$texto = "He Verificado personalmente la autenticidad de los datos que figuran ";

		$texto .= "en el presente formulario y me hago personalmente responsable civil y criminalmente ";

		$texto .= "por los errores u omisiones en que pudiera incurrir sin perjuicio de las que a la empresa ";

		$texto .= "le correspondan";

		$pdf->MultiCell(55, 3, $texto, 0,'J');

	}



}
