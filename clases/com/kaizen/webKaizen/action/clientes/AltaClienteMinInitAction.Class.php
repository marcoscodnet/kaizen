<?php
header("Content-type: text/javascript; charset=iso-8859-1");
/**
 * Acción para inicializar el contexto para dar de alta
 * un cliente.
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 */
class AltaClienteMinInitAction extends EditarClienteInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Alta Venta";
	}

	protected function getXTemplate(){
		return new XTemplate ( APP_PATH. '/clientes/editarcliente_min.html' );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Alta Cliente";
	}


	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oCliente = FormatUtils::ifEmpty($entidad, new Cliente());
		if(isset($_GET['cd_tipodoc'])){
			$oCliente->setCd_tipodoc($_GET['cd_tipodoc']);
		}
		if(isset($_GET['nu_doc'])){
			$oCliente->setNu_doc($_GET['nu_doc']);
		}
		//se muestra el cliente.
		$this->parseCliente( $oCliente , $xtpl);
		$this->parseTiposdocs( $oCliente->getCd_tipodoc(), $xtpl);
		$this->parseComollego( $oCliente->getCd_comollego(), $xtpl);
		$this->parseEstadosciviles( $oCliente->getCd_estadocivil(), $xtpl);
		if($oCliente->getCd_condiva()!= 0 || $oCliente->getCd_condiva() != NULL){
			$cd_condiva = $oCliente->getCd_condiva();
		}else{
			$cd_condiva = 6;
		}
		$this->parseCondsiva( $cd_condiva, $xtpl);
		if($oCliente->getProvincia()->getCd_pais() != 0 || $oCliente->getProvincia()->getCd_pais() != NULL){
			$cd_pais = $oCliente->getProvincia()->getCd_pais();
		}else{
			$cd_pais = 1;
		}
		$this->parsePaises( $cd_pais, $xtpl );
		$this->parseProvincias($cd_pais, $oCliente->getProvincia()->getCd_provincia(), $xtpl );
		$this->parseLocalidades($oCliente->getProvincia()->getCd_provincia(), $oCliente->getLocalidad()->getCd_localidad(), $xtpl );
	}
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "alta_cliente";
	}


	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return false;
	}

	protected function getSecureLayout() {
		$oClass = new ReflectionClass(DEFAULT_POPUP_LAYOUT);
		$oLayout = $oClass->newInstance();

		return $oLayout;
	}
}