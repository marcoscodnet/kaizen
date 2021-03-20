<?php

/**
 * Acci�n para inicializar el contexto para modificar
 * un servicio.
 *
 * @author Marcos
 * @since 15-05-2012
 *
 */
class ModificarServicioInitAction extends EditarServicioInitAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar Servicio";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Servicio";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_servicio";
	}

	protected function parseEntidad($entidad, XTemplate $xtpl) {
		$oServicio = FormatUtils::ifEmpty($entidad["servicio"], new Servicio());
		
		$xtpl->assign('url_altacliente', WEB_PATH . 'clientes/doAction?action=alta_cliente_min_init');
		$xtpl->assign('url_editarcliente', WEB_PATH . 'clientes/doAction?action=modificar_cliente_min_init&id=');
		 $this->parseServicio($xtpl, $oServicio);

	}

	
 protected function parseTiposServicios(XTemplate $xtpl, $cd_tipo_servicio ="") {
	


	protected function parseServicio($xtpl, Servicio $entidad){
		$xtpl->assign('cd_cliente', $entidad->getCd_cliente());
		$xtpl->assign('funcion_ajax', "Modificar Servicio");
		$xtpl->assign('cd_servicio', $entidad->getCd_servicio());
		$xtpl->assign('cd_usuario', $entidad->getCd_usuario());
		$xtpl->assign('nu_doc', $entidad->getCliente()->getNu_doc());
		$xtpl->assign('nu_monto', addslashes($entidad->getNu_monto()));
		

	}

	protected function parseCliente($xtpl, Cliente $oCliente){
		$xtpl_cliente = new XTemplate(APP_PATH."ventas/ajax/ajax_datoscliente.html");
		$xtpl_cliente->assign( 'ds_apynom', $oCliente->getDs_apynom());
		$xtpl_cliente->assign( 'ds_direccion', $oCliente->getDs_dircalle()." ".$oCliente->getDs_dirnro()." ".$oCliente->getDs_dirdepto()." ".$oCliente->getDs_dirpiso()  );
		$xtpl_cliente->assign( 'ds_telefono', $oCliente->getDs_teparticular());
		$texto = $xtpl_cliente->text('main');
		$xtpl->assign('datosCliente', $texto);
		$xtpl->parse("main.detalle_cliente");
	}



	protected function getEntidad(){
		$oServicio = null;
		if (isset ( $_GET ['id'] )) {
			$cd_servicio = $_GET ['id'];
			$manager = new ServicioManager();
			$oServicio = $manager->getServicioPorId( $cd_servicio );
		}
				
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}
}