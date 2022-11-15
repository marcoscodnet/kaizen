<?php



/**

 * Clase para exportar a PDF una Orden de Servicio.

 *

 * @author Marcos

 *

 */

class PDFPrintOrdenServicio extends PDFPrint {

	private $oServicio;




	function Header(){

		/*$this->SetFont('Arial','', 8);
		$this->Cell(40, 5, 'Registro R 270 rev 00', 'LBTR', 0, 'C');
		$this->SetFont('Arial','B', 10);
		$this->Cell(150, 5, 'KAIZEN', 'LBTR', 1, 'R');
		$this->ln(1);*/
		$this->SetFont('Arial','', 8);
		$this->Cell(40, 5, '', '', 0, 'C');
		$this->SetFont('Arial','B', 10);
		$this->Cell(150, 5, '', '', 1, 'R');
		$this->ln(1);
		$this->SetFont('Arial','B', 12);
		$this->SetFillColor(230,230,230);
		$this->Cell(80, 6, 'KAIZEN', 'LTR', 0, 'L',1);
		$this->SetFont('Arial','U', 8);
		$this->SetFillColor(210,210,210);
		$this->Cell(55, 6, 'ORDEN DE SERVICIO', 'LTR', 0, 'L',1);
		$this->Cell(55, 6, '', 'LTR', 1, 'L');

		$manager = new UnidadManager();




        if ($manager->esHonda($this->oServicio->getVehiculoservicio()->getNu_motor())) {


			$this->Image('img/logo_service.jpg',168,17,30,13);
		}


		$this->SetFont('Arial','', 8);
		$this->SetFillColor(230,230,230);
		$this->Cell(80, 6, 'Direcci�n: '.$this->oServicio->getSucursal()->getDs_domicilio(), 'LR', 0, 'L',1);
		$this->SetFillColor(210,210,210);
		$this->Cell(55, 6, 'N�: '.$this->oServicio->getCd_servicio(), 'LBR', 0, 'L',1);
		$this->Cell(55, 6, '', 'LR', 1, 'L');
		$this->SetFillColor(230,230,230);
		$sucursalManager = new SucursalManager();
		$oSucursal = $sucursalManager->getSucursalPorId($this->oServicio->getCd_sucursal());
		$this->Cell(80, 4, 'CP: '.$oSucursal->getLocalidad()->getDs_cp().' - '.$oSucursal->getLocalidad()->getDs_localidad().' - '.$oSucursal->getDs_provincia(), 'LR', 0, 'L',1);
		$this->SetFillColor(210,210,210);
		$this->Cell(55, 4, '', 'LBR', 0, 'L',1);
		$this->Cell(55, 4, '', 'LR', 1, 'L');
		$this->SetFillColor(230,230,230);
		$this->Cell(80, 4, 'Tel.: '.$this->oServicio->getSucursal()->getDs_telefono(), 'LR', 0, 'L',1);
		$this->Cell(110, 4, '', 'LBR', 1, 'L');
		$this->Cell(80, 6, 'E-mail: '.$oSucursal->getDs_email(), 'LBR', 0, 'L',1);
		$this->SetFont('Arial','B', 8);
		$this->Cell(110, 6, 'Datos del recepcionista: '.$this->oServicio->getUsuario()->getDs_apynom(), 'LTBR', 1, 'L',1);
		$this->Cell(110, 6, 'DATOS DEL CLIENTE', 'LTBR', 0, 'L',1);
		$this->Cell(80, 6, 'DATOS DEL VEHICULO', 'LTBR', 1, 'L',1);
		$this->SetFont('Arial','', 8);
		$this->Cell(110, 4, 'Nombre y apellido: '.$this->oServicio->getDs_apynom(), 'LTBR', 0, 'L',1);
		$this->Cell(80, 4, 'Fecha de venta: '.$this->oServicio->getVehiculoservicio()->getDt_venta(), 'LTBR', 1, 'L',1);

		$manager = new ClienteManager();
		$oCliente = $manager->getClientePorId($this->oServicio->getCd_cliente());
		$this->Cell(60, 4, 'Direcci�n: '.$oCliente->getDs_dircalle()." ".$oCliente->getDs_dirnro()." ".$oCliente->getDs_dirdepto()." ".$oCliente->getDs_dirpiso(), 'LTB', 0, 'L',1);
		$this->Cell(50, 4, 'Localidad: '.$oCliente->getDs_localidad(), 'TBR', 0, 'L',1);
		$this->Cell(80, 4, 'Modelo y A�o: '.$this->oServicio->getVehiculoservicio()->getDs_modelo().' - '.$this->oServicio->getVehiculoservicio()->getNu_anio(), 'LTBR', 1, 'L',1);
		$this->Cell(60, 4, 'C.P.: '.$oCliente->getDs_cp(), 'LTB', 0, 'L',1);
		$this->Cell(50, 4, 'E-mail: '.$oCliente->getDs_email(), 'TBR', 0, 'L',1);
		$this->Cell(80, 4, 'N� de chasis: '.$this->oServicio->getVehiculoservicio()->getNu_chasis(), 'LTBR', 1, 'L',1);
		$this->Cell(60, 4, 'Tel�fono: '.$oCliente->getDs_teparticular(), 'LTB', 0, 'L',1);
		$this->Cell(50, 4, 'Tel. Movil: '.$oCliente->getDs_telaboral(), 'TBR', 0, 'L',1);
		$this->Cell(80, 4, 'N� de motor: '.$this->oServicio->getVehiculoservicio()->getNu_motor(), 'LTBR', 1, 'L',1);
	}


	function setServicio( $oServicio ){

		$this->oServicio = $oServicio;

	}



	/**

	 * (non-PHPdoc)

	 * @see fpdf/FPDF#Footer()

	 */

	function Footer(){

	}

}

